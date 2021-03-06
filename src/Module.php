<?php

namespace ozerich\admin;

use ozerich\filestorage\FileStorage;
use yii\web\AssetManager;
use yii\web\ErrorHandler;
use yii\web\Response;

class Module extends \yii\base\Module
{
    public $isBoxedLayout = true;

    public $shortName = 'B*IT*';

    public $fullName = 'BLAK*IT*';

    public $layoutPath = '@vendor/ozerich/yii2-admin/src/views/layouts';

    public $menu = [];

    public $userIdentityClass = 'app\models\User';

    public $controllerMap = [
        'auth' => 'ozerich\admin\controllers\AuthController',
    ];

    public $fileStorageComponent = 'media';

    public $logoUrl = null;

    public $loginLogoSrc = null;

    public $logoSrc = null;

    public $loginDuration = 0;

    public function init()
    {
        parent::init();

        $this->registerTranslations();

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


    private function registerTranslations()
    {
        \Yii::$app->i18n->translations['admin'] = [
            'class' => 'yii\i18n\PhpMessageSource',
            'sourceLanguage' => 'en-US',
            'basePath' => '@vendor/ozerich/yii2-admin/src/messages'
        ];
    }

    /**
     * @return FileStorage|null
     */
    public function getFileStorage()
    {
        if ($this->fileStorageComponent) {
            return \Yii::$app->{$this->fileStorageComponent};
        } else {
            return null;
        }
    }
}