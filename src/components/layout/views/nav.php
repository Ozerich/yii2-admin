<ul class="sidebar-menu">
    <li class="header">Control panel</li>
    <? foreach ($menu as $menu_item): ?>
        <li class="<?= isset($menu_item['submenu']) ? 'treeview' : '' ?> <?= $menu_item['id'] == $activeMenu ? 'active' : '' ?>">
            <a href="/admin<?= $menu_item['link'] ?>">
                <i class="fa fa-dashboard"></i> <span><?= $menu_item['label'] ?></span>
            </a>
            <? if (isset($menu_item['submenu'])): ?>
                <ul class="treeview-menu">
                    <? foreach ($menu_item['submenu'] as $submenu_item): ?>
                        <li>
                            <a href="/admin<?= $submenu_item['link'] ?>"><?= $submenu_item['label'] ?></a>
                        </li>
                    <? endforeach; ?>
                </ul>
            <? endif; ?>
        </li>
    <? endforeach; ?>
</ul>