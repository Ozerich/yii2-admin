<?php

use yii\widgets\ActiveForm;

?>
<div class="login-box">
  <div class="login-logo">
  </div>
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