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

        $menu = array_filter($menu, function ($item) {
            if (isset($item['allow_for'])) {
                if (!in_array(\Yii::$app->user->getIdentity()->role, $item['allow_for'])) {
                    return false;
                }
            }
            return true;
        });

        foreach ($menu as &$menu_item) {
            if (isset($menu_item['submenu'])) {
                $menu_item['submenu'] = array_filter($menu_item['submenu'], function ($item) {
                    if (isset($item['allow_for'])) {
                        if (!in_array(\Yii::$app->user->getIdentity()->role, $item['allow_for'])) {
                            return false;
                        }
                    }
                    return true;
                });
            }
        }

        return $this->render('nav', [
            'menu' => $menu,
            'activeMenu' => $activeMenu
        ]);
    }
}