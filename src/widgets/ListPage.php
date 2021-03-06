<?php

namespace ozerich\admin\widgets;

use yii\base\Widget;

class ListPage extends Widget
{
    public $dataProvider;

    public $headerButtons;

    public $columns;

    public $actions;

    public $filterModel;

    public $idGetter;

    public function run()
    {
        $this->dataProvider->sort = false;

        return $this->render('list', [
            'filterModel' => $this->filterModel,
            'dataProvider' => $this->dataProvider,
            'headerButtons' => $this->headerButtons,
            'columns' => $this->columns,
            'actions' => $this->actions,
            'idGetter' => $this->idGetter,
            'baseUrl' => '/admin/'.$this->view->context->id
        ]);
    }
}