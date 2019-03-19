<?
/**
 * @var \yii\data\ActiveDataProvider $dataProvider
 * @var \yii\db\ActiveRecord $filterModel
 * @var array $headerButtons
 * @var array $columns
 * @var array $actions
 * @var string $baseUrl
 */

?>
<div class="box box-primary">

  <div class="box-header">
    <h3 class="box-title"></h3>
    <div class="box-tools pull-left">
        <? if ($headerButtons && is_array($headerButtons)) foreach ($headerButtons as $headerbutton): ?>
            <?= \yii\helpers\Html::a('<i class="fa fa-' . $headerbutton['icon'] . '"></i> ' . $headerbutton['label'],
                [$headerbutton['action']],
                ['class' => 'btn btn-' . $headerbutton['additionalClass']]
            ); ?>
        <? endforeach; ?>
    </div>
  </div>

    <?

    if (!empty($actions)) {
        $templateActions = [];
        $fixActions = [];

        foreach ($actions as $action => $value) {
            if (is_int($action)) {
                $templateActions[] = $value;
            } else {
                $actionAction = is_array($value) ? $value['action'] : $value;

                if ($action == 'move') {
                    $templateActions[] = 'up';
                    $fixActions['up'] = $actionAction;

                    $templateActions[] = 'down';
                    $fixActions['down'] = $actionAction;
                } else {
                    $templateActions[] = $action;
                    $fixActions[$action] = $actionAction;
                }
            }
        }

        $buttonsVisible = [];
        foreach ($actions as $action => $value) {
            if (is_array($value)) {
                if (isset($value['visible'])) {
                    $buttonsVisible[$action] = $value['visible'];
                }
            }
        }

        $gridColumns = array_merge($columns, [
            [
                'class' => \ozerich\admin\components\ActionColumn::class,
                'template' => implode('', array_map(function ($item) {
                    return '{' . $item . '}';
                }, $templateActions)),
                'header' => 'Действия',
                'buttonsVisible' => $buttonsVisible,
                'urlCreator' => function ($action, $model, $key, $index) use ($fixActions, $baseUrl, $idGetter) {

                    if (isset($fixActions[$action])) {
                        $result = $baseUrl . '/' . $fixActions[$action] . '/' . ($idGetter ? call_user_func($idGetter, $model) : $model->id);
                    } else {
                        $result = $baseUrl . '/' . $action . '/' . ($idGetter ? call_user_func($idGetter, $model) : $model->id);
                    }

                    if ($action == 'up' || $action == 'down') {
                        $result .= '?mode=' . $action;
                    }

                    return $result;
                }
            ]
        ]);

    } else {
        $gridColumns = $columns;
    }
    ?>

  <div class="box-body">
      <?= \yii\grid\GridView::widget([
          'dataProvider' => $dataProvider,
          'filterModel' => $filterModel,
          'layout' => '{items}{pager}',
          'columns' => $gridColumns
      ]); ?>
  </div>
</div>