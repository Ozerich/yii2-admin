<?php
/** @var \ozerich\admin\Module $module */
$module = $this->context->module;

$this->title = Yii::$app->name;

use yii\widgets\ActiveForm;

?>

<style>
  .login-box {
    height: 100vh;
    display: flex;
    align-items: center;
    justify-content: center;
    flex-direction: column;
    margin: 0 auto;
  }

  .login-inner{
    min-width: 320px;
    margin-top: -50px;
  }

  .login-logo, .register-logo{
    font-size: 0;
  }

  .login-box-body, .register-box-body {
    width: 100%;
    max-width: 100%;
  }
</style>
<div class="login-box">
  <div class="login-inner">
      <? if (!empty($module->loginLogoSrc)): ?>
        <div class="login-logo" style="margin-bottom: 0">
          <img src="<?= $module->loginLogoSrc ?>">
        </div>
      <? endif; ?>
    <div class="login-box-body">

        <?php $form = ActiveForm::begin([
            'enableAjaxValidation' => true,
            'enableClientValidation' => false,
            'id' => 'login-form',
            'fieldConfig' => [
                'template' => '{input}{error}',
            ],
        ]); ?>

        <?= $form->field($model, 'login', [
            'template' => '{input}<span class="glyphicon glyphicon-envelope form-control-feedback"></span>{error}',
            'options' => [
                'class' => 'has-feedback',
            ],
            'inputOptions' => [
                'placeholder' => \Yii::t('admin', 'Login'),
                'class' => 'form-control'
            ]
        ]); ?>

        <?= $form->field($model, 'password', [
            'template' => '{input}<span class="glyphicon glyphicon-lock form-control-feedback"></span>{error}',
            'options' => [
                'class' => 'has-feedback',
            ],
            'inputOptions' => [
                'placeholder' => \Yii::t('admin', 'Password'),
                'class' => 'form-control'
            ]
        ])->passwordInput(); ?>

      <div class="row">
        <div class="col-xs-12">
          <button type="submit"
                  class="btn btn-primary btn-block btn-flat"><?= Yii::t('admin', 'Authenticate') ?></button>
        </div>
      </div>

        <?php ActiveForm::end(); ?>
    </div>
  </div>
</div>