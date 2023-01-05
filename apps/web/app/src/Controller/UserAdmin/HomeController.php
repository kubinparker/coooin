<?php
/**
 * CakePHP(tm) : Rapid Development Framework (https://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 * @link      https://cakephp.org CakePHP(tm) Project
 * @since     0.2.9
 * @license   https://opensource.org/licenses/mit-license.php MIT License
 */
namespace App\Controller\UserAdmin;

use App\Form\LoginForm;
use App\Model\Entity\Useradmin;
use Cake\Core\Configure;
use Cake\Network\Exception\ForbiddenException;
use Cake\Network\Exception\NotFoundException;
use Cake\View\Exception\MissingTemplateException;
use Cake\Event\c;
use Cake\ORM\TableRegistry;

use Cake\Auth\DefaultPasswordHasher;
/**
 * Static content controller
 *
 * This controller will render views from Template/Pages/
 *
 * @link https://book.cakephp.org/3.0/en/controllers/pages-controller.html
 */
class HomeController extends AppController
{
    public function initialize() : void
    {
        parent::initialize();

        $this->PageConfigs = $this->getTableLocator()->get('PageConfigs');
        $this->Useradmins = $this->getTableLocator()->get('Useradmins');
        $this->UseradminSites = $this->getTableLocator()->get('UseradminSites');

        $this->useradminId = $this->Session->read('useradminId');

    }
    
    public function beforeFilter(EventInterface $event) {
        parent::beforeFilter($event);
        // $this->viewBuilder()->theme('Admin');
        $this->viewBuilder()->setLayout("user");

        $this->setCommon();

    }

 

    public function index() {

        // $this->Users = $this->getTableLocator()->get('Users');
        $this->viewBuilder()->setLayout("plain");
        $view = "login";

        $admin = new LoginForm();

        $r = array();
        $user_type = 'user';
        if ($this->request->is('post') || $this->request->is('put')) {
            $data = $this->request->getData();
            if (!empty($data['username']) && !empty($data['password'])) {
                // $query = $this->User->find('all', array('conditions' => array('username' => $data['username'],
                //                                                               'status' => 'publish'
                //                                                              ),
                //                                          'limit' => 1));
                $query = $this->Useradmins->find()->where(['Useradmins.username' => $data['username'], 'Useradmins.status' => 'publish']);
                $r = $query->first();
                $is_login = false;
                if ($r) {
                    
                    $hasher = new DefaultPasswordHasher();
                    if ($hasher->check($data['password'], $r->password) && $r->temp_password == '') {
                        $is_login = true;
                        
                    } elseif ($r->temp_password == $data['password'] ) {
                        if ($r->temp_pass_expired == DATETIME_ZERO || $r->temp_pass_expired == '') {
                            $is_login = true;
                        } else {
                            $is_login = true;
                        }
                    }
                }

                if ($r && $is_login) {
                    $face_image = '';
                    if ($r->face_image) {
                        $face_image = $r->attaches['face_image']['s'];
                    }
                    $this->Session->write(array('useradminId' => $r->id,
                        'data' => array(
                            'name' => $r->name,
                            'face_image' => $face_image
                        ),
                        'user_role' => $r->role
                    ));
                    $this->AdminMenu->init();
                    $this->redirect(['action' => 'index']);

                } else {
                    $r = false;
                }
            }
            if (empty($r)) {
                $this->Flash->set('アカウント名またはパスワードが違います');
            }
        }
        if (0 < $this->Session->read('useradminId')) {
            $this->viewBuilder()->setLayout("user");
            $view = "index";

            if ($this->isUserRole('user_regist', true)) {
                return $this->redirect(['prefix' => 'user_regist', 'controller' => 'home', 'action' => 'index']);
            }

            $this->setCommon();

            $this->setList();
        } elseif ($this->Session->read('shopId')) {
            $this->viewBuilder()->setLayout('user');
            $view = 'index';
            $this->setList();
        }

        $this->set(compact('admin'));

        $this->render($view);
    }

    public function logout() {
        if (0 < $this->Session->read('useradminId')) {
            $this->Session->delete('useradminId');
            $this->Session->delete('role');
            $this->Session->delete('current_site_id');
            $this->Session->delete('current_site_slug');
            $this->Session->delete('admin_menu');
            $this->Session->destroy();

        }

        $this->redirect('/user_admin/');
    }

    public function setList() {

        $current_site_id = $this->Session->read('current_site_id');
        if (!$current_site_id) {
            $this->Flash->set('サイト権限がありません');
            $this->logout();
        }

        
        $list = array();

        $page_configs = $this->PageConfigs->find()
                                          ->where(['PageConfigs.site_config_id' => $current_site_id])
                                          ->order(['PageConfigs.position' => 'ASC'])
                                          ->all()
                                          ->toArray();
        $list['user_menu_list'] = [
            'コンテンツ' => []
        ];
        if ($this->isUserRole('admin')) {
            $list['user_menu_list']['設定'] = [['コンテンツ設定' => '/user_admin/page-configs']];
        }
        if (!empty($page_configs)) {
            $configs = array_chunk($page_configs, 3);

            foreach ($configs as $_) {
                $menu = [];
                foreach ($_ as $config) {
                    $menu[$config->page_title] = '/user_admin/infos/?sch_page_id=' . $config->id;
                }
                $list['user_menu_list']['コンテンツ'][] = $menu;
            }

        }
        

        if (!empty($list)) {
            $this->set(array_keys($list),$list);
        }

        $this->list = $list;
        return $list;
    }

    public function siteChange() {

        $site_id = $this->request->getQuery('site');

        $user_id = $this->isLogin();

        $config = $this->UseradminSites->find()->where(['UseradminSites.useradmin_id' => $user_id, 'UseradminSites.site_config_id' => $site_id])
                                    ->contain(['SiteConfigs' => function($q) {
                                        return $q->select(['slug']);
                                    }])
                                    ->first();
        if (!empty($config)) {

            $this->Session->write('current_site_id', $site_id);
            $this->Session->write('current_site_slug', $config->site_config->slug);
        }

        $this->redirect(['prefix' => 'user', 'controller' => 'users', 'action' => 'index']);
    }

    public function menuReload() {
        $this->AdminMenu->reload();
        return $this->redirect(['_name' => 'userTop']);
    }
}
