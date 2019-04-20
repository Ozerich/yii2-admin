<?php

namespace ozerich\admin\actions;

use Yii;
use yii\base\Action;
use yii\base\InvalidArgumentException;
use yii\db\ActiveQuery;
use yii\web\NotFoundHttpException;
use yii\web\Response;

class MoveAction extends Action
{
    public $modelClass;

    /** @var  ActiveQuery */
    public $query = null;

    public $field = 'priority';

    public $conditionAttribute = null;


    public function init()
    {
        if (!$this->query) {
            $model_name = $this->modelClass;
            $this->query = $model_name::find();
        }

        parent::init();
    }

    private function findModel($id)
    {
        $query = clone $this->query;

        $model = $query->andWhere('id=:id', [':id' => $id])->one();

        if (!$model) {
            throw new NotFoundHttpException();
        }

        return $model;
    }

    public function run($id, $mode)
    {
        if (!in_array($mode, array('up', 'down'))) {
            throw new InvalidArgumentException("Param `mode` must be `up` or `down`");
        }
        $model = $this->findModel($id);

        $table_name = $model->tableName();

        $query = clone $this->query;

        $query = $query->select([$this->field, 'id'])->limit(1)->orderBy($this->field . ' ' . ($mode == 'up' ? 'desc' : 'asc'))
            ->andWhere($this->field . ' ' . ($mode == 'up' ? '<' : '>') . ' :field_value', [':field_value' => $model->{$this->field}]);

        if ($this->conditionAttribute) {
            $attributes = is_array($this->conditionAttribute) ? $this->conditionAttribute : [$this->conditionAttribute];
            foreach ($attributes as $ind => $attr) {
                $value = $model->{$attr};
                if ($value === null) {
                    $query->andWhere('`' . $attr . '` is null');
                } else {
                    $key = ':value_' . $ind;
                    $query->andWhere('`' . $attr . '` = ' . $key, [$key => $value]);
                }
            }
        }

        $result = $query->one();

        if ($result) {

            $db = Yii::$app->getDb();

            $db->createCommand('UPDATE ' . $table_name . ' SET ' . $this->field . '=:field WHERE `id` = :id', [
                ':field' => $result['priority'],
                ':id' => $model->id
            ])->execute();

            $db->createCommand('UPDATE ' . $table_name . ' SET ' . $this->field . '=:field WHERE `id` = :id', [
                ':field' => $model->{$this->field},
                ':id' => $result['id']
            ])->execute();
        }

        if (Yii::$app->request->isAjax) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            return ['success' => true];
        }

        return $this->controller->redirect(Yii::$app->request->getReferrer());
    }
}