<?php

namespace ozerich\admin\controllers\base;

use yii\web\Controller;
use yii\filters\AccessControl;

class AdminController extends Controller
{
    public $layout = 'main';

    public $active_left_menu = '';

    public $enableCsrfValidation = false;

    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['@']
                    ],
                ],
                'denyCallback' => function () {
                    return $this->redirect('/admin/auth');
                },
            ],
        ];
    }

    public function redirect($url, $statusCode = 302, $force = false)
    {
        if (isset($_POST['only-save']) && !$force) {
            return $this->goBack();
        }

        return parent::redirect($url, $statusCode);
    }

    public function goBack($defaultUrl = null)
    {
        return $this->redirect(\Yii::$app->request->getReferrer(), 302, true);
    }
}