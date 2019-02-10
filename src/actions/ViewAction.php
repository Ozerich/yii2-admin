<?php

namespace ozerich\admin\actions;

use yii\base\Action;
use yii\db\ActiveRecord;
use yii\web\NotFoundHttpException;

class ViewAction extends Action
{
    public $modelClass;

    public $view;

    public function runWithParams($params)
    {
        $id = isset($params['id']) ? (int)$params['id'] : null;

        /** @var ActiveRecord $modelClass */
        $modelClass = $this->modelClass;

        $model = $modelClass::findOne($id);
        if (!$model) {
            throw new NotFoundHttpException();
        }

        return $this->controller->render($this->view, [
            'model' => $model
        ]);
    }
}