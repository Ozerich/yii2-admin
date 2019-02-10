<?
/**
 * @var string $content
 * $var boolean $isCreate
 */
?>
<div class="box box-primary">
    <div class="box-body">
        <div class="row">
            <?= $content ?>
        </div>
    </div>
    <div class="box-footer">
        <?= \yii\helpers\Html::submitButton($isCreate ? 'Создать' : 'Сохранить', ['class' => 'btn btn-primary']); ?>
    </div>
</div>