<?php

use yii\helpers\Html;

/* @var $this \yii\web\View */
/* @var $content string */
\ozerich\admin\assets\AdminAsset::register($this);

/** @var \ozerich\admin\interfaces\IAdminUser $user */
$user = Yii::$app->user->getIdentity();

/** @var \ozerich\admin\Module $module */
$module = $this->context->module;

$body_classes = [\dmstr\helpers\AdminLteHelper::skinClass(), 'sidebar-mini'];
if ($module->isBoxedLayout) {
    $body_classes[] = 'layout-boxed';
}
if (Yii::$app->request->cookies->getValue('sidebar') === 'collapse') {
    $body_classes[] = 'sidebar-collapsed';
}

$logoUrl = $module->logoUrl ? $module->logoUrl : '/admin';
?>

<?php $this->beginPage() ?>
  <!DOCTYPE html>
  <html lang="<?php echo Yii::$app->language ?>">
  <head>
    <meta charset="<?php echo Yii::$app->charset ?>" />
      <?php echo Html::csrfMetaTags() ?>
    <title><?= Html::encode(Yii::$app->name . ($this->title ? ' - ' . ($this->title[0] == '#' ? substr($this->title, 1) : $this->title) : '')) ?></title>
    <link rel="icon" type="image/png" sizes="32x32" href="/favicon.png" />
      <?php $this->head() ?>
  </head>
  <body class="<?= implode(' ', $body_classes) ?>">
  <div class="wrapper">
    <header class="main-header">

      <a href="<?= $logoUrl ?>" class="logo">
          <? if ($module->logoSrc): ?>
            <div class="logo-lg">
              <img src="<?= $module->logoSrc ?>" style="max-width: 200px; max-height: 50px" />
            </div>
          <? else: ?>
            <span class="logo-lg"><?= preg_replace('#\*(.+?)\*#si', '<b>$1</b>', $module->fullName) ?></span>
          <? endif; ?>
        <span class="logo-sm"><?= $module->shortName ?></span>
      </a>

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
                    <a href="/admin/auth/logout" class="btn btn-default btn-flat"><?= \Yii::t('admin', 'Log out') ?></a>
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
          <? echo \ozerich\admin\components\layout\SidebarNav::widget(); ?>
      </section>
    </aside>

    <div class="content-wrapper">
      <section class="content-header">
          <?php if ($notice = Yii::$app->session->getFlash('notice_text')): ?>
            <div
                class="callout callout-<?= (($noticeClass = Yii::$app->session->getFlash('notice_level')) ? $noticeClass : 'default') ?>">
                <?= $notice ?>
            </div>
          <?php endif; ?>
          <?php if ($this->title[0] != '#'): ?>
            <h1><?= $this->title ?></h1>
          <?php endif; ?>

          <? if (isset($this->params['breadcrumbs']) && !empty($this->params['breadcrumbs'])): ?>
            <ol class="breadcrumb">
                <? foreach ($this->params['breadcrumbs'] as $breadcrumb): ?>
                  <li><a href="/admin<?= $breadcrumb['link'] ?>"><?= $breadcrumb['label'] ?></a></li>
                <? endforeach; ?>

              <li class="active"><?= $this->title ?></li>
            </ol>
          <? endif; ?>

        <div class="page-buttons">
            <? if (isset($this->params['buttons'])): ?>
                <? foreach ($this->params['buttons'] as $button): ?>
                <a href="<?= $button['url'] ?>"
                   class="btn btn-mini btn-success" <?= isset($button['target']) ? 'target="' . $button['target'] . '"' : '' ?>><?= $button['label'] ?></a>
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