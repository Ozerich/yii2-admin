<?php

namespace blakit\admin\components;

use \Yii;
use yii\helpers\Html;
use yii\helpers\Url;

class ActionColumn extends \yii\grid\ActionColumn
{
    public $template = "{edit} {delete}";

    public $action_prefix = '';

    public $actions = [];

    public $buttons_visible = [];

    protected function initDefaultButtons()
    {
        if (!isset($this->buttons['view'])) {
            $this->buttons['view'] = function ($url, $model) {
                return Html::a('<span class="glyphicon glyphicon-eye-open"></span>', $url, [
                    'title' => Yii::t('yii', 'View'),
                    'data-pjax' => '0',
                    'target' => strpos($url, 'http://') !== false ? '_blank' : ''
                ]);
            };
        }

        if (!isset($this->buttons['edit'])) {
            $this->buttons['edit'] = function ($url, $model) {
                return Html::a('<span class="glyphicon glyphicon-pencil"></span>', $url, [
                    'title' => 'Edit',
                    'data-pjax' => '0',
                    'target' => strpos($url, 'http://') !== false ? '_blank' : ''
                ]);
            };
        }
        if (!isset($this->buttons['delete'])) {
            $this->buttons['delete'] = function ($url, $model) {
                return Html::a('<span class="glyphicon glyphicon-trash"></span>', $url, [
                    'title' => 'Удалить',
                    'data-confirm' => 'Are you sure?',
                    'data-method' => 'post',
                    'data-pjax' => '0',
                    'target' => strpos($url, 'http://') !== false ? '_blank' : ''
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
                    if(strpos($action, 'http://') !== false){
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

                if (isset($this->buttons_visible[$name])) {
                    if (!call_user_func($this->buttons_visible[$name], $model)) {
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