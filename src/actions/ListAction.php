<?php

namespace ozerich\admin\actions;

use yii\base\Action;
use yii\data\ActiveDataProvider;
use yii\data\ArrayDataProvider;

class ListAction extends Action
{
    public $query;

    public $models;

    public $view;

    public $viewParams = [];

    public $dataProviderParams = [];

    public $pageSize;

    public $breadcrumbs;

    private function getDataProviderParams($base = [])
    {
        $params = array_merge($this->dataProviderParams, $base);
        if ($this->pageSize) {
            $params['pagination']['pageSize'] = $this->pageSize;
        }
        return $params;
    }

    public function runWithParams($params)
    {
        if ($this->breadcrumbs) {
            if (is_callable($this->breadcrumbs)) {
                $this->breadcrumbs = call_user_func($this->breadcrumbs, $params);
            }

            if ($this->breadcrumbs !== null) {
                $this->controller->view->params['breadcrumbs'] = $this->breadcrumbs;
            }
        }

        if ($this->query) {
            if (is_callable($this->query)) {
                $this->query = call_user_func($this->query, $params);
            }

            $dataProvider = new ActiveDataProvider($this->getDataProviderParams([
                'query' => $this->query
            ]));
        } else {
            $dataProvider = new ArrayDataProvider($this->getDataProviderParams([
                'allModels' => $this->models
            ]));
        }

        $viewParams = ['dataProvider' => $dataProvider];

        if ($this->viewParams) {
            if (is_callable($this->viewParams)) {
                $this->viewParams = call_user_func($this->viewParams, $params);
            }

            $viewParams = array_merge($this->viewParams, $viewParams);
        }

        return $this->controller->render($this->view, $viewParams);
    }
}