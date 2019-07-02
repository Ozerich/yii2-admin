<?php

namespace ozerich\admin\controllers\base;

use ozerich\admin\interfaces\IAdminUser;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

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

    public function beforeAction($action)
    {
        /** @var IAdminUser $user */
        $user = \Yii::$app->user->getIdentity();

        if (!$user) {
            $this->redirect('/admin/auth');
            return false;
        }

        if ($user->checkAdminAccess() == false) {
            throw new NotFoundHttpException();
        }

        return parent::beforeAction($action);
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