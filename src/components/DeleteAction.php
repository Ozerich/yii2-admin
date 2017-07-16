<?php

namespace blakit\admin\components;

use \Yii;
use yii\base\Action;
use yii\db\ActiveRecord;
use yii\web\NotFoundHttpException;

class DeleteAction extends Action
{
    public $model_class;

    public function run($id)
    {
        /** @var ActiveRecord $model_name */
        $model_name = $this->model_class;

        $model = $model_name::findOne($id);
        if (!$model) {
            throw new NotFoundHttpException();
        }

        if (!$model->delete()) {

        }

        return $this->controller->redirect(Yii::$app->request->getReferrer());
    }
}