<?php

namespace ozerich\admin\controllers\base;

use yii\web\Controller;
use yii\filters\AccessControl;

class AdminController extends Controller
{
    public $layout = 'main';

    public $active_left_menu = '';

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

    public function goBack($defaultUrl = null)
    {
        return $this->redirect(\Yii::$app->request->getReferrer());
    }
}