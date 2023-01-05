<?php
namespace App\Controller\Component;

use Cake\Controller\Component;
use Cake\Controller\ComponentRegistry;
use Cake\Datasource\ModelAwareTrait;
use Cake\Utility\Inflector;
use Cake\ORM\TableRegistry;
use Cake\Utility\Text;

use App\Model\Entity\User;
/**
 * OutputHtml component
 */
class AdminMenuComponent extends Component
{
    public $menu_list = [];

    public function initialize(array $config) :void {

        $this->Controller = $this->_registry->getController();
        $this->Session = $this->Controller->getRequest()->getSession();

    }

    public function init() {

        if ($this->Session->check('admin_menu.menu_list')) {
            $this->menu_list = $this->Session->read('admin_menu.menu_list');
        } else {
            $this->menu_list = [
                'main' => [
                    [
                       'title' => 'コンテンツ',
                       'role' => [ 'role_type' => 'staff'],
                       'buttons' => $this->setContent('main', [
                           ['name' => '追加コンテンツ', 'link' => '/user_admin/sample'],
                       ]),
                    ],
                    [
                        'title' => __('各種設定'),
                        'role' => [ 'role_type' => 'admin'],
                        'buttons' => [
                            ['name' => __('コンテンツ設定'), 'link' => '/user_admin/page-configs/', 'role' => ['role_type' => 'develop']],
                            ['name' => __('定数管理'), 'link' => '/user_admin/mst-lists/', 'role' => ['role_type' => 'admin']],
                            ['name' => __('カレンダー'), 'link' => '/user_admin/schedules/', 'role' => ['role_type' => 'admin']],
                        ]
                    ]
                ],
                'side' => [
                    [
                         'title' => 'コンテンツ',
                         'role' => [ 'role_type' => 'staff' ],
                         'buttons' => $this->setContent('main', [['name' => '追加コンテンツ', 'link' => '/user_admin/sample']])
                    ],
                    [
                        'title' => __('各種設定'),
                        'role' => ['role_type' => 'develop'],
                        'buttons' => [
                            ['name' => __('コンテンツ設定'), 'link' => '/user_admin/page-configs/', 'role' => ['role_type' => 'develop']],
                            ['name' => __('定数管理'), 'link' => '/user_admin/mst-lists/', 'role' => ['role_type' => 'develop']],
                            ['name' => __('カレンダー'), 'link' => '/user_admin/schedules/', 'role' => ['role_type' => 'admin']],
                            ['name' => 'メニューリロード', 'link' => '/user_admin/menu-reload', '']
                        ]
                    ],
//                    [
//                        'title' => __('各種設定'),
//                        'role' => ['role_type' => 'admin', 'role_only' => true],
//                        'buttons' => [
//                            ['name' => __('カレンダー'), 'link' => '/user_admin/schedules/', 'role' => ['role_type' => 'admin']],
//                        ]
//                    ]
                ]

            ];

            $this->Session->write('admin_menu.menu_list', $this->menu_list);
        }
    }

    public function reload() {
        $this->Session->delete('admin_menu.menu_list');
        $this->init();
    }

    public function setContent($type = 'main', $append_menus = []) {
        $this->PageConfigs = TableRegistry::get('PageConfigs');

        $content_buttons = [];
        $user_configs = [];
        $cond = [
            'is_auto_menu' => 1
        ];

        // dd($cond);
        $page_configs = $this->PageConfigs->find()
                                          // ->where(['PageConfigs.site_config_id' => $current_site_id])
                                          ->where($cond)
                                          ->order(['PageConfigs.position' => 'ASC'])
                                          ->all();
        if (!empty($page_configs)) {
            $page_configs = $page_configs->toArray();
            if ($type == 'main') {
//                $configs = array_chunk($page_configs, 3);

                foreach ($page_configs as $config) {
                    $menu = [
                        'name' => $config->page_title,
                        'link' => '/user_admin/infos/?sch_page_id=' . $config->id
                    ];
                    $content_buttons[] = $menu;
                }
            } elseif ($type == 'side') {
                foreach ($page_configs as $config) {
                    $menu = [
                        'name' => $config->page_title,
                        'subMenu' => [
                            ['name' => __('新規登録'), 'link' => '/infos/edit/0?sch_page_id=' . $config->id],
                            ['name' => __('一覧'), 'link' => '/infos/?sch_page_id=' . $config->id],
                        ]
                    ];
                    $content_buttons[] = $menu;
                }
            }
        }

        if (!empty($append_menus)) {
            foreach ($append_menus as $menu) {
                $content_buttons[] = $menu;
            }
        }
//dd($content_buttons);

        return $content_buttons;
    }

}

