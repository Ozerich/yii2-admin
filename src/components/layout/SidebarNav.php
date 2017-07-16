<?php

namespace blakit\admin\components\layout;

class SidebarNav extends \yii\base\Widget
{
    public function run()
    {
        $menu = $this->view->context->module->menu;

        $activeMenu = null;

        foreach ($menu as $root_menu => $item) {
            if (isset($item['submenu'])) {
                foreach ($item['submenu'] as $subitem) {
                    $link = '/admin' . $subitem['link'];

                    if (\Yii::$app->request->url == $link) {
                        $activeMenu = $item['id'];
                    }
                }
            }
        }

        return $this->render('nav', [
            'menu' => $menu,
            'activeMenu' => $activeMenu
        ]);
    }
}