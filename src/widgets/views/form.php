<?
/**
 * @var string $content
 * $var boolean $isCreate
 * $var string $boxTitle
 */
?>
<div class="box box-primary">
    <? if (!empty($boxTitle)): ?>
        <div class="box-header with-border">
            <h3 class="box-title"><?= $boxTitle ?></h3>
        </div>
    <? endif; ?>
    <div class="box-body">
        <div class="row">
            <?= $content ?>
        </div>
    </div>
    <div class="box-footer">
        <? if (!empty($backUrl)): ?>
            <?= \yii\helpers\Html::a('Назад', '/admin' . $backUrl, [
                'class' => 'btn btn-danger pull-left'
            ]); ?>
        <? endif; ?>
        <?= \yii\helpers\Html::submitButton($isCreate ? \Yii::t('admin', 'Create') : \Yii::t('admin', 'Save'), [
            'class' => 'btn btn-primary pull-' . (empty($backUrl) ? 'left' : 'right')
        ]); ?>
    </div>
</div>