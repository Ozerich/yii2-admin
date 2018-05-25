<?php

namespace blakit\admin;

use yii\web\AssetManager;
use yii\web\ErrorHandler;
use yii\web\Response;

class Module extends \yii\base\Module
{
    public $isBoxedLayout = true;

    public $shortName = 'B*IT*';

    public $fullName = 'BLAK*IT*';

    public $layoutPath = '@vendor/blakit/yii2-admin/src/views/layouts';

    public $menu = [];

    public $userIdentityClass = 'app\models\User';

    public $controllerMap = [
        'auth' => 'blakit\admin\controllers\AuthController',
    ];

    public function init()
    {
        parent::init();

        $this->setLayoutPath($this->layoutPath);

        $handler = new ErrorHandler();
        \Yii::$app->set('errorHandler', $handler);
        $handler->register();

        $components = [
            'response' => [
                'class' => Response::className()
            ],
            'assetManager' => [
                'class' => AssetManager::className(),
                'bundles' => [
                    'dmstr\web\AdminLteAsset' => [
                        'skin' => 'skin-red',
                    ],
                ],
            ]
        ];

        if ($this->userIdentityClass) {
            $components['user'] = [
                'class' => \yii\web\User::className(),
                'identityClass' => $this->userIdentityClass,
                'enableAutoLogin' => true,
                'loginUrl' => ['/admin']
            ];
        }

        \Yii::$app->setComponents($components);
    }
}