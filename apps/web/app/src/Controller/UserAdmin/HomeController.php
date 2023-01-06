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
use Cake\Event\EventInterface;
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


    public function initialize(): void
    {
        parent::initialize();

        $this->PageConfigs = $this->getTableLocator()->get('PageConfigs');
        $this->Useradmins = $this->getTableLocator()->get('Useradmins');
        $this->UseradminSites = $this->getTableLocator()->get('UseradminSites');

        $this->useradminId = $this->Session->read('useradminId');
    }


    public function beforeFilter(EventInterface $event)
    {
        parent::beforeFilter($event);
        $this->viewBuilder()->setLayout("user");
    }


    public function index()
    {
        $hasher = new DefaultPasswordHasher();

        $view = "login";
        $layout = "plain";

        $admin = new LoginForm();
        $r = null;

        if ($this->request->is(['post', 'put'])) {
            $data = $this->request->getData();

            if (!isset($data['username']) || !isset($data['password']) || empty($data['username']) || empty($data['password'])) goto CHECKSESSION;

            $r = $this->Useradmins->find()
                ->where(['Useradmins.username' => $data['username'], 'Useradmins.status' => 'publish'])
                ->first();

            if (is_null($r)) {
                $this->Flash->warning('アカウント名またはパスワードが違います', [
                    'key' => 'login_fail',
                    'params' => [
                        'username' => $data['username'],
                        'password' => $data['password']
                    ]
                ]);
                goto CHECKSESSION;
            }

            $is_login = ($hasher->check($data['password'], $r->password) && $r->temp_password == '') || $r->temp_password == $data['password'];

            if (!$is_login) goto CHECKSESSION;

            $this->Session->write([
                'useradminId' => $r->id,
                'data' => [
                    'name' => $r->name,
                    'face_image' => $r->face_image ? $r->attaches['face_image']['s'] : ''
                ],
                'user_role' => $r->role
            ]);

            $this->AdminMenu->init();
            return $this->redirect(['action' => 'index']);
        }

        CHECKSESSION:

        $is_login = ($this->Session->check('useradminId') && 0 < $this->Session->read('useradminId'));
        if ($is_login || $this->Session->read('shopId')) {

            $layout = 'user';
            $view = "index";
            $this->setList();

            if ($is_login) {
                if ($this->isUserRole('user_regist', true))
                    return $this->redirect(['prefix' => 'user_regist', 'controller' => 'home', 'action' => 'index']);

                $this->setCommon();
            }
        }

        $this->set('admin', $admin);
        $this->viewBuilder()->setLayout($layout);
        $this->render($view);
    }


    public function logout()
    {
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


    public function setList()
    {

        $list = [];

        if (!empty($list)) $this->set(array_keys($list), $list);

        $this->list = $list;
        return $list;
    }


    public function siteChange()
    {

        $site_id = $this->request->getQuery('site');

        $user_id = $this->getUserId();

        $config = $this->UseradminSites->find()->where(['UseradminSites.useradmin_id' => $user_id, 'UseradminSites.site_config_id' => $site_id])
            ->contain(['SiteConfigs' => function ($q) {
                return $q->select(['slug']);
            }])
            ->first();
        if (!empty($config)) {

            $this->Session->write('current_site_id', $site_id);
            $this->Session->write('current_site_slug', $config->site_config->slug);
        }

        $this->redirect(['prefix' => 'user', 'controller' => 'users', 'action' => 'index']);
    }


    public function menuReload()
    {
        $this->AdminMenu->reload();
        return $this->redirect(['_name' => 'userTop']);
    }
}
