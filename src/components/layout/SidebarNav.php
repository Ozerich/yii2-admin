<?php

namespace blakit\admin\components\layout;

class SidebarNav extends \yii\base\Widget
{
    public function run()
    {
        $menu = $this->view->context->module->menu;

        $activeMenu = null;

        $request_url = \Yii::$app->request->url;
        if (stripos($request_url, 'index') !== false) {
            $request_url = str_replace('index', '', $request_url);
            $request_url = explode('&page=', $request_url);
        } else {
            $request_url = explode('?page=', $request_url);
        }

        foreach ($menu as $root_menu => $item) {
            if (isset($item['submenu'])) {

                foreach ($item['submenu'] as $subitem) {
                    $link = '/admin' . $subitem['link'];

                    if ($request_url[0] == $link) {
                        $activeMenu = $item['id'];
                    }
                };
            }

            if (mb_substr($request_url[0], 6, mb_strlen($item['link'])) == $item['link']) {
                $activeMenu = $item['id'];
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