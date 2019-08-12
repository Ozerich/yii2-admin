<?php

use yii\helpers\Html;

/* @var $this \yii\web\View */
/* @var $content string */

\ozerich\admin\assets\AdminAsset::register($this);
?>

<?php $this->beginPage() ?>
  <!DOCTYPE html>
  <html lang="<?php echo Yii::$app->language ?>">
  <head>
    <meta charset="<?php echo Yii::$app->charset ?>" />
      <?php echo Html::csrfMetaTags() ?>
    <title><?= Html::encode(Yii::$app->name) ?></title>
    <link rel="icon" type="image/png" sizes="32x32" href="/favicon.png" />
      <?php $this->head() ?>
  </head>
  <body class="skin-blue">
  <?php echo $content; ?>
  <?php $this->endBody() ?>
  </body>
  </html>
<?php $this->endPage() ?>