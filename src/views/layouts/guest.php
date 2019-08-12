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
    <title><?php echo Html::encode($this->title) ?></title>
    <link rel="icon" type="image/png" sizes="32x32" href="/favicon.png" />
      <?php $this->head() ?>
  </head>
  <body class="skin-blue" style="background: #f1f1f1">
  <?php echo $content; ?>
  <?php $this->endBody() ?>
  </body>
  </html>
<?php $this->endPage() ?>