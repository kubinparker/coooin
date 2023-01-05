<?php

namespace App\Controller\UserAdmin;

use Cake\Core\Configure;
use Cake\Network\Exception\ForbiddenException;
use Cake\Network\Exception\NotFoundException;
use Cake\View\Exception\MissingTemplateException;
use Cake\Event\EventInterface;
use Cake\ORM\TableRegistry;
use Cake\Filesystem\Folder;
use Cake\Routing\RequestActionTrait;

use App\Model\Entity\Useradmin;
use App\Model\Entity\PageConfig;


/**
 * Static content controller
 *
 * This controller will render views from Template/Pages/
 *
 * @link https://book.cakephp.org/3.0/en/controllers/pages-controller.html
 */
class PageConfigsController extends AppController
{
    private $list = [];

    public function initialize() : void
    {
        parent::initialize();

        $this->Infos = $this->getTableLocator()->get('Infos');
        $this->SiteConfigs = $this->getTableLocator()->get('SiteConfigs');
        $this->UseradminSites = $this->getTableLocator()->get('UseradminSites');

//        $this->loadComponent('OutputHtml');

    }
    
    public function beforeFilter(EventInterface $event) {

        parent::beforeFilter($event);
        // $this->viewBuilder()->theme('Admin');
        $this->viewBuilder()->setLayout("user");
        $this->viewBuilder()->setClassName('Useradmin');

        $this->setCommon();
//        $this->getEventManager()->off($this->Csrf);

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
        $this->viewBuilder()->setLayout("index");

        $this->setList();


        $current_site_id = $this->Session->read('current_site_id');
        $site_config = $this->SiteConfigs->find()->where(['SiteConfigs.id' => $current_site_id])->first();
        $this->set(compact('site_config'));

        $cond =['PageConfigs.site_config_id' => $current_site_id];

        $this->_lists($cond, ['order' => 'PageConfigs.position ASC',
                              'limit' => null]);
    }

    public function edit($id=0) {
        $this->checkLogin();
        $this->viewBuilder()->setLayout("edit");

        if ($id && !$this->isOwnPageByUser($id)) {
            $this->Flash->set('不正なアクセスです');
            $this->redirect('/user_admin/');
            return;
        }

        $this->setList();

        if ($id) {
            unset($this->list['page_config_list'][$id]);
            $this->set('page_config_list', $this->list['page_config_list']);
        }

        if ($this->request->is(['post', 'put'])) {
            if ($this->request->getData('is_category') == 'N') {
                 $this->request = $this->request->withData('is_category_sort','N');
//                $this->request->data['is_category_sort'] = 'N';
            }
        }

        $current_site_id = $this->Session->read('current_site_id');
        $site_config = $this->SiteConfigs->find()->where(['SiteConfigs.id' => $current_site_id])->first();

        $old_data = null;
        if ($id) {
            $old_data = $this->PageConfigs->find()->where(['PageConfigs.id' => $id])->first();
        }

        $this->set(compact('site_config'));

        $options = [];

        parent::_edit($id, $options);

    }
    public function reCreateDetail($page_config_id, $dir) {
        $infos = $this->Infos->find()->where(['Infos.page_config_id' => $page_config_id])->all();
        if (empty($infos)) {
            return;
        }

        foreach ($infos as $info) {
            $this->OutputHtml->detail('Infos', $info->id, $dir);
        }
        return;
    }
    public function writeIndex($slug) {
        $dir = USER_PAGES_DIR . $slug;
        $file = $dir . DS . "index.html";

        $params = explode('/', $slug); // [0]=site_name [1]=page_name

        if (count($params) < 2) {
            $params[] = '';
        }
        $html = $this->requestAction(
            ['controller' => 'Contents', 'action' => 'index', 'pass' => ['site_slug' => $params[0], 'slug' => $params[1]]],
            ['return', 'bare' => false]);

        file_put_contents($file, $html);

        chmod($file, 0666);

    }

    public function delete($id, $type, $columns = null) {
        $this->checkLogin();

        if (!$this->isOwnPageByUser($id)) {
            $this->Flash->set('不正なアクセスです');
            $this->redirect('/user_admin/');
            return;
        }
        
        $options = [];
        // $options['redirect'] = ['action' => 'index'];

        parent::_delete($id, $type, $columns, $options);
    }

    public function position($id, $pos) {
        $this->checkLogin();

        if (!$this->isOwnPageByUser($id)) {
            $this->Flash->set('不正なアクセスです');
            $this->redirect('/user_admin/');
            return;
        }

        return parent::_position($id, $pos);
    }


    public function setList() {
        
        $list = array();

        $list['template_list'] = ['1' => 'デフォルト'];

        $list['list_style_list'] = PageConfig::$list_styles;

        $list['role_type_list'] = Useradmin::$role_list;

        $list['page_config_list'] = [];
        $page_config_list = $this->PageConfigs->find('list', ['keyField' => 'id', 'valueField' => 'page_title'])->all();
        if (!$page_config_list->isEmpty()) {
            $list['page_config_list'] = $page_config_list->toArray();
        }

        if (!empty($list)) {
            $this->set(array_keys($list),$list);
        }

        $this->list = $list;
        return $list;
    }


}
