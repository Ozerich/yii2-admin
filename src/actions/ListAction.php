<?php

namespace ozerich\admin\actions;

use yii\base\Action;
use yii\base\InvalidArgumentException;
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

    public $filterModel;

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
        if ($this->filterModel) {
            $this->filterModel->load(\Yii::$app->request->get());
        }

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
                'query' => $this->filterModel ? $this->filterModel->search($this->query) : $this->query
            ]));
        } else if ($this->models !== null) {
            if (is_callable($this->models)) {
                $this->models = call_user_func($this->models, $params);
            }

            $dataProvider = new ArrayDataProvider($this->getDataProviderParams([
                'allModels' => $this->models
            ]));
        } else {
            throw new InvalidArgumentException('query or models must be set');
        }

        $viewParams = ['dataProvider' => $dataProvider];

        if ($this->viewParams) {
            if (is_callable($this->viewParams)) {
                $this->viewParams = call_user_func($this->viewParams, $params);
            }

            $viewParams = array_merge($this->viewParams, $viewParams);
        }

        $viewParams['filterModel'] = $this->filterModel;

        return $this->controller->render($this->view, $viewParams);
    }
}