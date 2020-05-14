<?php

namespace ozerich\admin\widgets;

use yii\base\Widget;

class FormPage extends Widget
{
    public $isCreate;

    public $boxTitle;

    public $backUrl;

    public function init()
    {
        parent::init();

        ob_start();
        ob_implicit_flush(false);
    }

    public function run()
    {
        $content = ob_get_clean();

        echo $this->render('form', [
            'boxTitle' => $this->boxTitle,
            'content' => $content,
            'isCreate' => $this->isCreate,
            'backUrl' => $this->backUrl
        ]);
    }
}