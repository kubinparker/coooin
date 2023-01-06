<?php

namespace App\Controller\Component;

use Cake\Controller\Component;
use Cake\ORM\TableRegistry;

/**
 * OutputHtml component
 */
class AdminMenuComponent extends Component
{
    public $menu_list = [];


    public function initialize(array $config): void
    {
        $this->Controller = $this->_registry->getController();
        $this->Session = $this->Controller->getRequest()->getSession();
    }


    public function init()
    {

        if ($this->Session->check('admin_menu.menu_list'))
            $this->menu_list = $this->Session->read('admin_menu.menu_list');
        else {
            $this->menu_list = [
                'main' => [
                    [
                        'title' => 'コンテンツ',
                        'role' => ['role_type' => STAFF],
                        'buttons' => $this->setContent('main'),
                    ],
                    [
                        'title' => __('各種設定'),
                        'role' => ['role_type' => ADMIN],
                        'buttons' => [
                            ['name' => __('コンテンツ設定'), 'link' => '/user_admin/page-configs/', 'role' => ['role_type' => DEVELOP]],
                            ['name' => __('定数管理'), 'link' => '/user_admin/mst-lists/', 'role' => ['role_type' => ADMIN]],
                            ['name' => __('カレンダー'), 'link' => '/user_admin/schedules/', 'role' => ['role_type' => ADMIN]],
                        ]
                    ]
                ],
                'side' => [
                    [
                        'title' => 'コンテンツ',
                        'role' => ['role_type' => STAFF],
                        'buttons' => $this->setContent('main')
                    ],
                    [
                        'title' => __('各種設定'),
                        'role' => ['role_type' => DEVELOP],
                        'buttons' => [
                            ['name' => __('コンテンツ設定'), 'link' => '/user_admin/page-configs/', 'role' => ['role_type' => DEVELOP]],
                            ['name' => __('定数管理'), 'link' => '/user_admin/mst-lists/', 'role' => ['role_type' => DEVELOP]],
                            ['name' => __('カレンダー'), 'link' => '/user_admin/schedules/', 'role' => ['role_type' => ADMIN]],
                            ['name' => 'メニューリロード', 'link' => '/user_admin/menu-reload', 'position' => 'right', 'icon' => 'fas fa-sync-alt']
                        ]
                    ]
                ]
            ];

            $this->Session->write('admin_menu.menu_list', $this->menu_list);
        }
    }


    public function reload()
    {
        $this->Session->delete('admin_menu.menu_list');
        $this->init();
    }


    public function setContent($type = 'main', $append_menus = [])
    {

        $this->PageConfigs = TableRegistry::getTableLocator()->get('PageConfigs');

        $content_buttons = [];
        $cond = [
            'PageConfigs.site_config_id' => $this->Session->read('current_site_id') ?? 0,
            'is_auto_menu' => 1
        ];

        $page_configs = $this->PageConfigs->find()
            ->where($cond)
            ->order(['PageConfigs.position' => 'ASC'])
            ->all()
            ->toArray();

        if (!empty($page_configs) && in_array($type, ['main', 'side'], true)) {

            foreach ($page_configs as $config) {
                $menu = ['name' => $config->page_title];

                if ($type == 'main')
                    $menu['link'] = '/user_admin/infos/?sch_page_id=' . $config->id;
                else
                    $menu['subMenu'] = [
                        ['name' => __('新規登録'), 'link' => '/infos/edit/0?sch_page_id=' . $config->id],
                        ['name' => __('一覧'), 'link' => '/infos/?sch_page_id=' . $config->id]
                    ];

                $content_buttons[] = $menu;
            }
        }

        if (!empty($append_menus))
            foreach ($append_menus as $menu) $content_buttons[] = $menu;

        return $content_buttons;
    }
}
