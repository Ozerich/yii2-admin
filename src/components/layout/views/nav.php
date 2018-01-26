<ul class="sidebar-menu tree" data-widget="tree">
    <? foreach ($menu as $menu_item): ?>
        <li class="<?= isset($menu_item['submenu']) ? 'treeview' : '' ?> <?= $menu_item['id'] == $activeMenu ? 'active' : '' ?>">
            <a href="/admin<?= $menu_item['link'] ?>">
                <i class="fa fa-<?= ($menu_item['icon'] ?? 'caret-right') ?>"></i> <span><?= $menu_item['label'] ?></span>
            </a>
            <? if (isset($menu_item['submenu'])): ?>
                <ul class="treeview-menu">
                    <? foreach ($menu_item['submenu'] as $submenu_item): ?>
                        <li>
                            <a href="/admin<?= $submenu_item['link'] ?>"><i class="fa fa-<?= ($menu_item['icon'] ?? 'angle-right') ?>"></i><?= $submenu_item['label'] ?></a>
                        </li>
                    <? endforeach; ?>
                </ul>
            <? endif; ?>
        </li>
    <? endforeach; ?>
</ul>