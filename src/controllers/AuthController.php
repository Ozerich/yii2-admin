<?php

namespace ozerich\admin\controllers;

use ozerich\admin\forms\LoginForm;
use ozerich\admin\interfaces\IAdminUser;
use ozerich\admin\Module;
use yii\web\Controller;
use yii\web\Response;
use yii\widgets\ActiveForm;

class AuthController extends Controller
{
    public $layout = 'guest';

    public function actionIndex()
    {
        $this->setViewPath('@vendor/ozerich/yii2-admin/src/views/auth');

        $form = new LoginForm();

        if ($form->load(\Yii::$app->request->post())) {
            if (\Yii::$app->request->isAjax) {
                \Yii::$app->response->format = Response::FORMAT_JSON;
                return ActiveForm::validate($form);
            }

            if ($form->validate()) {

                /** @var Module $module */
                $module = \Yii::$app->controller->module;
                $userClass = $module->userIdentityClass;

                /** @var IAdminUser $model */
                $model = \Yii::createObject($userClass);
                $user = $model->checkAdminLogin($form->login, $form->password);

                if ($user) {
                    \Yii::$app->user->login($user);

                    return $this->redirect('/admin');
                }
            }
        }

        return $this->render('login', [
            'model' => $form
        ]);
    }

    public function actionLogout()
    {
        \Yii::$app->user->logout();

        return $this->redirect('/admin');
    }
}