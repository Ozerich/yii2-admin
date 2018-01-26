<?php
use yii\helpers\Html;

/* @var $this \yii\web\View */
/* @var $content string */
\blakit\admin\assets\AdminAsset::register($this);

/** @var \blakit\admin\interfaces\IAdminUser $user */
$user = Yii::$app->user->getIdentity();
?>

<?php $this->beginPage() ?>
    <!DOCTYPE html>
    <html lang="<?php echo Yii::$app->language ?>">
    <head>
        <meta charset="<?php echo Yii::$app->charset ?>"/>
        <?php echo Html::csrfMetaTags() ?>
        <title><?= Html::encode(Yii::$app->name . ($this->title ? ' - ' . ($this->title[0]=='#' ? substr($this->title, 1) : $this->title) : '')) ?></title>
        <?php $this->head() ?>
    </head>
    <body class="<?= \dmstr\helpers\AdminLteHelper::skinClass() . ' sidebar-mini' . (Yii::$app->request->cookies->getValue('sidebar')==='collapse' ? ' sidebar-collapse' : '') ?>">
    <div class="wrapper">
        <header class="main-header">
            <a href="/admin" class="logo" target="_blank"><?= Yii::$app->name ?></a>
            <nav class="navbar navbar-static-top">
                <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button" onclick="toggleSidebar()">
                </a>
                <div class="navbar-custom-menu">
                    <ul class="nav navbar-nav">
                        <li class="dropdown user user-menu">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                <span class="hidden-xs"><?= $user->getDashboardName() ?></span>
                            </a>
                            <ul class="dropdown-menu">
                                <li class="user-header">
                                    <p>
                                        <?= $user->getDashboardName() ?>
                                    </p>
                                </li>
                                <li class="user-footer">
                                    <div class="pull-right">
                                        <a href="/admin/auth/logout" class="btn btn-default btn-flat">Exit</a>
                                    </div>
                                </li>
                            </ul>
                        </li>
                    </ul>
                </div>
            </nav>
        </header>
        <aside class="main-sidebar">
            <section class="sidebar">
                <? echo \blakit\admin\components\layout\SidebarNav::widget(); ?>
            </section>
        </aside>
        <div class="content-wrapper">
            <section class="content-header">
                <?php if ($notice = Yii::$app->session->getFlash('notice_text')): ?>
                    <div class="callout callout-<?= (($noticeClass = Yii::$app->session->getFlash('notice_level')) ? $noticeClass : 'default') ?>">
                        <?= $notice ?>
                    </div>
                <?php endif; ?>
                <?php if ($this->title[0] != '#'): ?>
                    <h1><?= $this->title ?></h1>
                <?php endif; ?>
                <div class="page-buttons">
                    <? if (isset($this->params['buttons'])): ?>
                        <? foreach ($this->params['buttons'] as $button): ?>
                            <a href="<?= $button['url'] ?>" class="btn btn-mini btn-success"><?= $button['label'] ?></a>
                        <? endforeach; ?>
                    <? endif; ?>
                </div>
            </section>
            <section class="content">
                <?= $content ?>
            </section>
        </div>
    </div>
    <?php $this->endBody() ?>
    </body>
    </html>
<?php $this->endPage() ?>