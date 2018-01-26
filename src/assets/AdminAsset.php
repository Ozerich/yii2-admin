<?php

namespace blakit\admin\assets;

use yii\web\AssetBundle;
use yii\web\View;

class AdminAsset extends AssetBundle
{
    public $sourcePath = '@vendor/blakit/yii2-admin/src/static';

    public $css = [
        'css/admin.css',
    ];

    public $js = [
        'js/admin.js',
    ];

    public $jsOptions = [
        'position' => View::POS_HEAD,
    ];

    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
        'yii\bootstrap\BootstrapPluginAsset',
        'dmstr\web\AdminLteAsset'
    ];
}