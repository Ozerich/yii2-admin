<?php

namespace ozerich\admin\actions;

use ozerich\admin\Module;
use yii\base\Action;
use yii\db\ActiveRecord;
use yii\web\NotFoundHttpException;
use yii\web\UploadedFile;

class CreateOrUpdateAction extends Action
{
    public $modelClass;

    public $formClass;

    public $formConvertor;

    public $view;

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

            foreach ($this->defaultParams as $param => $value) {
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
        $model = $this->getModel($params);

        if (!$model) {
            throw new NotFoundHttpException();
        }

        if ($this->formClass) {
            $formModel = new $this->formClass;

            if (!$this->isCreate) {
                $convertor = new $this->formConvertor;
                $formModel = $this->modelClass ? $convertor->loadFormFromModel($model) : $convertor->loadForm();
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
                        $formModel->{$attribute} = $file_model ? $file_model->id : null;
                    } else {
                        if (!isset($_POST[$formModel->formName()][$attribute])) {
                            $formModel->{$attribute} = null;
                        }
                    }
                }
            }

            if ($this->formClass) {
                $convertor = new $this->formConvertor;

                $success = $this->modelClass ? $convertor->saveModelFromForm($model, $formModel) : $convertor->saveModelFromForm($formModel);

                if ($success) {
                    return $this->controller->redirect($this->getRedirectUrl($model));
                }
            } else {
                if ($formModel->save()) {
                    return $this->controller->redirect($this->getRedirectUrl($model));
                }
            }
        }

        return $this->controller->render($this->view, [
            'isCreate' => $this->isCreate,
            'model' => $model,
            'formModel' => $formModel
        ]);
    }
}