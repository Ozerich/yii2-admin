<?php

namespace blakit\admin\components;

class GridView extends \yii\grid\GridView
{
    public $tableOptions = ['class' => 'table table-bordered'];

    public $layout = "{items}\n{pager}";
}