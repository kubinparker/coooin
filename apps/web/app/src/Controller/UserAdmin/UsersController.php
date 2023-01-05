<?php

namespace App\Controller\UserAdmin;

use Cake\Core\Configure;
use Cake\Network\Exception\ForbiddenException;
use Cake\Network\Exception\NotFoundException;
use Cake\View\Exception\MissingTemplateException;
use Cake\Event\Event;

use App\Model\Entity\User;

/**
 * Static content controller
 *
 * This controller will render views from Template/Pages/
 *
 * @link https://book.cakephp.org/3.0/en/controllers/pages-controller.html
 */
class UsersController extends AppController
{
    private $list = [];

    public function initialize()
    {
        parent::initialize();

    }
    
    public function beforeFilter(Event $event) {

        parent::beforeFilter($event);
        // $this->viewBuilder()->theme('Admin');
        $this->viewBuilder()->setLayout("user");

        $this->setCommon();
        $this->getEventManager()->off($this->Csrf);

        $this->modelName = $this->name;
        $this->set('ModelName', $this->modelName);

    }

    protected function _getQuery() {
        $query = [];

        return $query;
    }

    protected function _getConditions($query) {
        $cond = [];

        return $cond;
    }

    public function index() {
        $this->checkLogin();

        $query = $this->_getQuery();
        $this->set(compact('query'));

        $this->setList();

        $cond = $this->_getConditions($query);


        $this->_lists($cond, ['order' => ['id' => 'DESC'],
                              'limit' => null]);
    }

    public function edit($id=0) {
        $this->checkLogin();

        $query = $this->_getQuery();
        $this->set(compact('query'));

        $this->setList();

        $redirect = ['action' => 'index', '?' => $query];
        $callback = null;
        $validate = 'default';

        if ($this->request->is(['post', 'put'])) {
            if ($id) {
                if ($this->request->getData('_password')) {
                    $this->request->data['password'] = $this->request->getData('_password');
                    $this->request->data['temp_password'] = '';
                    $validate = 'modifyIsPass';
                } else {
                    $validate = 'modify';
                }
            } else {
                $validate = 'new';
            }
        }

        $options['redirect'] = $redirect;
        $options['callback'] = $callback;
        $options['validate'] = $validate;

        parent::_edit($id, $options);

    }

    public function position($id, $pos) {
        $this->checkLogin();

        $options = [];

        $data = $this->{$this->modelName}->find()->where([$this->modelName . '.id' => $id])->first();
        if (empty($data)) {
            $this->redirect('/user_admin/');
            return;
        }

        $options['redirect'] = ['action' => 'index', '?' => [], '#' => 'content-' . $id];

        return parent::_position($id, $pos, $options);
    }

    public function enable($id) {
        $this->checkLogin();

        $options = [];

        $data = $this->{$this->modelName}->find()->where([$this->modelName . '.id' => $id])->first();
        if (empty($data)) {
            $this->redirect('/user_admin/');
            return;
        }

        $options['redirect'] = ['action' => 'index', '?' => [], '#' => 'content-' . $id];
        
        parent::_enable($id, $options);

    }

    public function delete($id, $type, $columns = null) {
        $this->checkLogin();

        $data = $this->{$this->modelName}->find()->where([$this->modelName . '.id' => $id])->first();
        if (empty($data)) {
            $this->redirect('/user_admin/');
            return;
        }
        
        $options = ['redirect' => ['action' => 'index', '?' => []]];

        parent::_delete($id, $type, $columns, $options);
    }


    public function setList() {
        
        $list = array();

        $list['gender_list'] = User::$gender_list;

        if (!empty($list)) {
            $this->set(array_keys($list),$list);
        }

        $this->list = $list;
        return $list;
    }


}
