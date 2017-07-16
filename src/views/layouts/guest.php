<?php
use yii\helpers\Html;

/* @var $this \yii\web\View */
/* @var $content string */

\blakit\admin\assets\AdminAsset::register($this);
?>

<?php $this->beginPage() ?>
    <!DOCTYPE html>
    <html lang="<?php echo  Yii::$app->language ?>">
    <head>
        <meta charset="<?php echo  Yii::$app->charset ?>"/>
        <?php echo  Html::csrfMetaTags() ?>
        <title><?php echo  Html::encode($this->title) ?></title>
        <?php $this->head() ?>
    </head>
    <body class="skin-blue">
    <?php echo  $content; ?>
    <?php $this->endBody() ?>
    </body>
    </html>
<?php $this->endPage() ?>