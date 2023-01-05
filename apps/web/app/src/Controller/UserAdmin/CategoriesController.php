<?php

namespace App\Controller\UserAdmin;

use Cake\Core\Configure;
use Cake\Network\Exception\ForbiddenException;
use Cake\Network\Exception\NotFoundException;
use Cake\View\Exception\MissingTemplateException;
use Cake\Event\EventInterface;
use Cake\ORM\TableRegistry;
use Cake\Filesystem\Folder;

use App\Model\Entity\Category;
/**
 * Static content controller
 *
 * This controller will render views from Template/Pages/
 *
 * @link https://book.cakephp.org/3.0/en/controllers/pages-controller.html
 */
class CategoriesController extends AppController
{
    private $list = [];

    public function initialize() : void
    {
        parent::initialize();

        $this->Infos = $this->getTableLocator()->get('Infos');
        $this->PageConfigs = $this->getTableLocator()->get('PageConfigs');
        $this->UseradminSites = $this->getTableLocator()->get('UseradminSites');

//        $this->loadComponent('OutputHtml');

    }
    
    public function beforeFilter(EventInterface $event) {

        parent::beforeFilter($event);
        // $this->viewBuilder()->theme('Admin');
        $this->viewBuilder()->setLayout("user");
        $this->viewBuilder()->setClassName('Useradmin');

        $this->setCommon();

        $this->modelName = $this->name;
        $this->set('ModelName', $this->modelName);

    }

    protected function _getQuery() {
        $query = [];

        $query['sch_page_id'] = $this->request->getQuery('sch_page_id');
        $query['parent_id'] = $this->request->getQuery('parent_id');
        if (empty($query['parent_id'])) {
            $query['parent_id'] = 0;
        }
        $query['redirect'] = $this->request->getQuery('redirect');

        return $query;
    }

    protected function _getConditions($query) {
        $cond = [];


        return $cond;
    }

    public function index() {
        $this->checkLogin();
        $this->viewBuilder()->setLayout("index");

        $query = $this->_getQuery();
        $page_config = $this->PageConfigs->find()->where(['PageConfigs.id' => $query['sch_page_id']])->first();
        $this->set(compact('query', 'page_config'));

        if (!$this->isOwnPageByUser($query['sch_page_id'])) {
            $this->Flash->set('不正なアクセスです');
            $this->redirect('/user_admin/');
            return;
        }

        $cond = [
            'Categories.page_config_id' => $query['sch_page_id']
        ];

        $parent_category = [];
        if ($page_config->is_category == 'Y') {
            if ($page_config->is_category_multilevel == 1) {
                $cond['Categories.parent_category_id'] = $query['parent_id'];
                $_parent_id = $query['parent_id'];
                do {

                    $tmp = $this->Categories->find()->where(
                        [
                            'Categories.page_config_id' => $query['sch_page_id'],
                            'Categories.id' => $_parent_id,
                            // 'Categories.parent_category_id >' => 0
                            ])->first();
                    if (!empty($tmp)) {
                        $_parent_id = $tmp->parent_category_id;
                        $parent_category[] = $tmp;
                    }
                    
                }while(!empty($tmp));
            }
        }
        $this->set(compact('parent_category'));

        $this->_lists($cond, ['order' => 'position ASC',
                              'limit' => null]);
    }

    public function edit($id=0) {
        $this->checkLogin();
        $this->viewBuilder()->setLayout("edit");

        $query = $this->_getQuery();
        $page_config = $this->PageConfigs->find()->where(['PageConfigs.id' => $query['sch_page_id']])->first();
        $this->set(compact('query', 'page_config'));

        if ($id && !$this->isOwnCategoryByUser($id)) {
            $this->Flash->set('不正なアクセスです');
            $this->redirect('/user_admin/');
            return;
        }

        $this->setList();

        $redirect = ['action' => 'index', '?' => $query];

        if ($this->request->is(['post', 'put'])) {
            if ($this->request->getQuery('redirect') == 'infos') {
                $redirect = [
                    'controller' => 'infos',
                    'action' => 'index',
                    '?' => ['sch_page_id' => $this->request->getData('page_config_id'), 'sch_category_id' => $this->request->getData('parent_category_id')]
                ];
            } else {
                $redirect = ['action' => 'index', '?' => ['sch_page_id' => $this->request->getData('page_config_id'), 'parent_id' => $this->request->getData('parent_category_id')]];
            }
        }

        $callback = function($id) {
            // $data = $this->Categories->find()->where(['Categories.id' => $id])->first();
            // $entity = $this->Categories->patchEntity($data, ['identifier' => Category::IDENTIFIER . $data->position]);
            // $this->Categories->save($entity);
            return true;
        };

        $parent_category = [];
        if ($page_config->is_category == 'Y') {
            if ($page_config->is_category_multilevel == 1) {
                $parent_category = $this->Categories->find()->where(
                    [
                        'Categories.page_config_id' => $query['sch_page_id'],
                        'Categories.id' => $query['parent_id'],
                    ])->first();
            }
        }
        $this->set(compact('parent_category'));

        $options['redirect'] = $redirect;
        $options['callback'] = $callback;

        parent::_edit($id, $options);

    }

    public function position($id, $pos) {
        $this->checkLogin();

        if ($id && !$this->isOwnCategoryByUser($id)) {
            $this->Flash->set('不正なアクセスです');
            $this->redirect('/user_admin/');
            return;
        }

        $options = [];

        $data = $this->Categories->find()->where(['Categories.id' => $id])->first();
        if (empty($data)) {
            $this->redirect('/user_admin/');
            return;
        }

        $options['redirect'] = ['action' => 'index', '?' => ['sch_page_id' => $data->page_config_id, 'parent_id' => $data->parent_category_id], '#' => 'content-' . $id];

        return parent::_position($id, $pos, $options);
    }

    public function enable($id) {
        $this->checkLogin();

        if ($id && !$this->isOwnCategoryByUser($id)) {
            $this->Flash->set('不正なアクセスです');
            $this->redirect('/user_admin/');
            return;
        }

        $options = [];

        $data = $this->Categories->find()->where(['Categories.id' => $id])->first();
        if (empty($data)) {
            $this->redirect('/user_admin/');
            return;
        }

        $options['redirect'] = ['action' => 'index', '?' => ['sch_page_id' => $data->page_config_id, 'parent_id' => $data->parent_category_id], '#' => 'content-' . $id];
        
        parent::_enable($id, $options);

    }

    public function delete($id, $type, $columns = null) {
        $this->checkLogin();

        if ($id && !$this->isOwnCategoryByUser($id)) {
            $this->Flash->set('不正なアクセスです');
            $this->redirect('/user_admin/');
            return;
        }

        $data = $this->Categories->find()->where(['Categories.id' => $id])->first();
        if (empty($data)) {
            $this->redirect('/user_admin/');
            return;
        }

        $redirect = ['action' => 'index', '?' => ['sch_page_id' => $data->page_config_id]];
        if ($this->request->getQuery('redirect') == 'infos') {
            $redirect = [
                'controller' => 'infos',
                'action' => 'index',
                '?' => ['sch_page_id' => $data->page_config_id, 'sch_category_id' => $data->parent_category_id]
            ];
        }
        
        $options = ['redirect' => $redirect];

        $result = parent::_delete($id, $type, $columns, $options);
        if (!$result) {
            $this->Infos->updateAll(['category_id' => 0, 'status' => 'draft'], ['Infos.category_id' => $data->id]);
        }
    }


    public function setList() {
        
        $list = array();

        if (!empty($list)) {
            $this->set(array_keys($list),$list);
        }

        $this->list = $list;
        return $list;
    }


}
