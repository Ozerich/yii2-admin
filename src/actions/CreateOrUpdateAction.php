<?php

namespace ozerich\admin\actions;

use ozerich\admin\Module;
use yii\base\Action;
use yii\db\ActiveRecord;
use yii\web\MethodNotAllowedHttpException;
use yii\web\NotFoundHttpException;
use yii\web\Response;
use yii\web\UploadedFile;
use yii\widgets\ActiveForm;

class CreateOrUpdateAction extends Action
{
    public $modelClass;

    public $formClass;

    public $formConvertor;

    public $view;

    public $viewParams = [];

    public $redirectUrl;

    public $isCreate;

    public $defaultParams = [];

    public $files = [];

    /**
     * @param $params
     * @return ActiveRecord
     */
    private function getModel($params)
    {
        if (!$this->modelClass) {
            return \Yii::createObject($this->formClass);
        }

        if ($this->isCreate) {
            $model = \Yii::createObject($this->modelClass);

            $defaultParams = is_callable($this->defaultParams) ? call_user_func($this->defaultParams, $params) : $this->defaultParams;

            foreach ($defaultParams as $param => $value) {
                $model->{$param} = $value;
            }

            return $model;
        }

        $className = $this->modelClass;


        return $className::findOne($params['id']);
    }

    private function getRedirectUrl($model)
    {
        if (is_string($this->redirectUrl)) {
            return $this->redirectUrl;
        }

        if (is_callable($this->redirectUrl)) {
            return call_user_func_array($this->redirectUrl, ['model' => $model]);
        }

        return '/';
    }

    public function runWithParams($params)
    {
        if ($this->view === null && \Yii::$app->request->isGet) {
            throw new MethodNotAllowedHttpException();
        }

        $model = $this->getModel($params);


        if (!$model) {
            throw new NotFoundHttpException();
        }

        if ($this->formClass) {
            $formModel = new $this->formClass;

            if (!$this->isCreate) {
                if ($this->formConvertor) {
                    $convertor = new $this->formConvertor;
                    $formModel = $this->modelClass ? $convertor->loadFormFromModel($model) : $convertor->loadForm();
                } else {
                    $formModel = $model;
                }
            }
        } else {
            $formModel = $model;
        }

        /** @var Module $module */
        $module = \Yii::$app->controller->module;
        $filestorage = $module->getFileStorage();


        if ($formModel->load(\Yii::$app->request->post()) || \Yii::$app->request->isPost) {

            if ($filestorage) {
                foreach ($this->files as $attribute => $scenario) {
                    $file = UploadedFile::getInstance($formModel, $attribute);

                    if ($file) {
                        $file_model = $filestorage->createFileFromUploadedFile($file, $scenario);
                        if (!$file_model) {
                            $errors = $filestorage->getLastErrors();
                            $formModel->addError($attribute, $errors ? array_shift($errors) : 'Ошибка загрузки файла');
                        } else {
                            $formModel->{$attribute} = $file_model->id;
                        }
                    } else {
                        if (!isset($_POST[$formModel->formName()][$attribute])) {
                            $formModel->{$attribute} = null;
                        }
                    }
                }
            }

            $formModel->validate(null, false);

            if ($formModel->hasErrors() == false) {
                if ($this->formClass) {
                    if ($this->formConvertor) {
                        $convertor = new $this->formConvertor;

                        $success = $this->modelClass ? $convertor->saveModelFromForm($model, $formModel) : $convertor->saveModelFromForm($formModel);
                    } else {
                        $success = $formModel->save();
                    }

                    if ($success) {
                        return $this->controller->redirect($this->getRedirectUrl($model));
                    }
                } else {
                    if ($formModel->save()) {
                        return $this->controller->redirect($this->getRedirectUrl($model));
                    }
                }
            }
        }

        if ($this->view === null) {
            \Yii::$app->response->format = Response::FORMAT_JSON;
            return ActiveForm::validate($formModel);
        }

        $viewParams = [
            'isCreate' => $this->isCreate,
            'model' => $model,
            'formModel' => $formModel
        ];

        if (!empty($this->viewParams)) {
            if (is_array($this->viewParams)) {
                $viewParams = array_merge($viewParams, $this->viewParams);
            } else if (is_callable($this->viewParams)) {
                $viewParams = array_merge($viewParams, call_user_func_array($this->viewParams, [$params]));
            }
        }

        return $this->controller->render($this->view, $viewParams);
    }
}