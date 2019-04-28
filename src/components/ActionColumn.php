<?php

namespace ozerich\admin\components;

use Yii;
use yii\helpers\Html;
use yii\helpers\Url;

class ActionColumn extends \yii\grid\ActionColumn
{
    public $template = "{edit} {delete}";

    public $action_prefix = '';

    public $actions = [];

    public $buttonsVisible = [];

    public $headerOptions = ['style' => 'min-width: 80px;'];

    public $buttonOptions = ['style' => 'margin-left: 8px'];

    protected function initDefaultButtons()
    {
        if (!isset($this->buttons['view'])) {
            $this->buttons['view'] = function ($url, $model) {
                return Html::a('<span class="glyphicon glyphicon-eye-open"></span>', $url, [
                    'title' => Yii::t('yii', 'View'),
                    'data-pjax' => '0',
                    'target' => strpos($url, 'http://') !== false ? '_blank' : '',
                    'class' => 'grid-icon'
                ]);
            };
        }

        if (!isset($this->buttons['edit'])) {
            $this->buttons['edit'] = function ($url, $model) {
                return Html::a('<span class="glyphicon glyphicon-pencil"></span>', $url, [
                    'title' => 'Edit',
                    'data-pjax' => '0',
                    'target' => strpos($url, 'http://') !== false ? '_blank' : '',
                    'class' => 'grid-icon'
                ]);
            };
        }
        if (!isset($this->buttons['delete'])) {
            $this->buttons['delete'] = function ($url, $model) {
                return Html::a('<span class="glyphicon glyphicon-trash"></span>', $url, [
                    'title' => 'Delete',
                    'data-confirm' => 'Are you sure?',
                    'data-method' => 'post',
                    'data-pjax' => '0',
                    'target' => strpos($url, 'http://') !== false ? '_blank' : '',
                    'class' => 'grid-icon'
                ]);
            };
        }

        if (!isset($this->buttons['up'])) {
            $this->buttons['up'] = function ($url, $model) {
                return Html::a('<span class="glyphicon glyphicon-arrow-up"></span>', $url, [
                    'title' => 'Move up',
                    'data-pjax' => '0',
                    'target' => strpos($url, 'http://') !== false ? '_blank' : '',
                    'class' => 'grid-icon'
                ]);
            };
        }

        if (!isset($this->buttons['down'])) {
            $this->buttons['down'] = function ($url, $model) {
                return Html::a('<span class="glyphicon glyphicon-arrow-down"></span>', $url, [
                    'title' => 'Move down',
                    'data-pjax' => '0',
                    'target' => strpos($url, 'http://') ? '_blank' : '',
                    'style' => 'display: inline-block; margin-left: 8px;'
                ]);
            };
        }

        if (!isset($this->buttons['copy'])) {
            $this->buttons['copy'] = function ($url, $model) {
                return Html::a('<i class="fa fa-fw fa-copy"></i>', $url, [
                    'title' => 'Copy',
                    'data-pjax' => '0',
                    'target' => strpos($url, 'http://') ? '_blank' : '',
                    'class' => 'grid-icon'
                ]);
            };
        }
    }

    public function createUrl($action, $model, $key, $index)
    {
        if ($this->urlCreator instanceof \Closure) {
            return call_user_func($this->urlCreator, $action, $model, $key, $index);
        } else {
            $params = is_array($key) ? $key : ['id' => (string)$key];
            if ($action == 'up' || $action == 'down') {
                $params[0] = $this->action_prefix . (empty($this->action_prefix) ? '' : '_') . 'move';
                $params['mode'] = $action;
            } else {

                if (isset($this->actions[$action])) {
                    $action = call_user_func($this->actions[$action], $model);
                    if (strpos($action, 'http://') !== false) {
                        return $action;
                    }
                } else if (!empty($this->action_prefix)) {
                    $action = $this->action_prefix . '_' . $action;
                }

                $params[0] = $this->controller ? $this->controller . '/' . $action : $action;
            }
            return Url::toRoute($params);
        }
    }

    protected function renderDataCellContent($model, $key, $index)
    {
        return preg_replace_callback('/\\{([\w\-\/]+)\\}/', function ($matches) use ($model, $key, $index) {
            $name = $matches[1];
            if (isset($this->buttons[$name])) {

                if (isset($this->buttonsVisible[$name])) {
                    if (!call_user_func($this->buttonsVisible[$name], $model)) {
                        return '';
                    }
                }

                $url = $this->createUrl($name, $model, $key, $index);
                return call_user_func($this->buttons[$name], $url, $model, $key);
            } else {
                return '';
            }
        }, $this->template);
    }
}