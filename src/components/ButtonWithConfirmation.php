<?php

namespace blakit\admin\components;

use yii\helpers\Html;

class ButtonWithConfirmation extends \yii\base\Widget
{
    public $label;

    public $link;

    public $cssClass;

    public $confirm = 'Вы уверены, что хотите удалить пользователя?';

    public function run()
    {
        return Html::a($this->label, $this->link, [
            'class' => $this->cssClass,
            'onclick' => 'return confirm("' . $this->confirm . '")'
        ]);
    }
}