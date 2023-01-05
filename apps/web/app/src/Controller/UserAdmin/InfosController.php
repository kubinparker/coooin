<?php

namespace App\Controller\UserAdmin;

use Cake\Core\Configure;
use Cake\Network\Exception\ForbiddenException;
use Cake\Network\Exception\NotFoundException;
use Cake\Utility\Inflector;
use Cake\View\Exception\MissingTemplateException;
use Cake\Event\EventInterface;
use Cake\ORM\TableRegistry;
use Cake\Filesystem\Folder;
use Cake\Utility\Hash;

use App\Model\Entity\Info;
use App\Model\Entity\PageConfig;
use App\Model\Entity\PageConfigItem;
use App\Model\Entity\AppendItem;
use App\Model\Entity\PageConfigExtension;

/**
 * Static content controller
 *
 * This controller will render views from Template/Pages/
 *
 * @link https://book.cakephp.org/3.0/en/controllers/pages-controller.html
 */
class InfosController extends BaseInfosController
{
    private $list = [];
    private $GQuery = [];

    public function initialize() : void
    {
        parent::initialize();

        $this->modelName = 'Infos';
        $this->set('ModelName', $this->modelName);
        $this->InfoTops = $this->getTableLocator()->get('InfoTops');
    }
    /**
     * 共通
     */
    protected function _savedItem($info_id, $formData, $slug)
    {
        if (!empty($formData['id'])) {
            return true;
        }
        $this->Items = $this->getTableLocator()->get('Items');
        $this->InfoStockTables = $this->getTableLocator()->get('InfoStockTables');
        $item_id = $formData['item_id'];

        $item = $this->Items->find()->where(['Items.id' => $item_id])->first();
        if (empty($item)) {
            return false;
        }

        $entity = $this->InfoStockTables->newEntity();
        $entity->info_id = $info_id;
        $entity->page_slug = $slug;
        $entity->model_name = 'Items';
        $entity->model_id = $item->id;
        $r = $this->InfoStockTables->save($entity);

        return true;
    }
    protected function _readItem($page_config)
    {
        $this->Items = $this->getTableLocator()->get('Items');

        $item_id = $this->request->getQuery('item_id');
        $item = $this->Items->find()->where(['Items.id' => $item_id])->first();
        if (empty($item)) {
            $this->redirect('/user_admin/items');
            return;
        }

        $this->set(compact('item'));

        return $item;
    }

    /**
     * item
     */
    protected function savedHookItem($info_id, $formData)
    {
        return $this->_savedItem($info_id, $formData, 'item');
    }

    protected function savingHookItem($page_config, $data)
    {
        $this->Items = $this->getTableLocator()->get('Items');
        $item = $this->Items->find()->where(['Items.id' => $data['item_id']])->first();
        if (empty($item)) {
            return $data;
        }
        $data['title'] = $item->name;

        return $data;
    }

    protected function prependEditHookItem($page_config, &$options)
    {
        $item = $this->_readItem($page_config);

        $this->request->data['title'] = $item->name;

        $options['redirect'] = ['controller' => 'items', 'action' => 'index'];
    }
    protected function deletedRedirectHookItem()
    {
        return ['controller' => 'items', 'action' => 'index'];
    }

    /**
     * item_report
     */
    protected function savedHookItemReport($info_id, $formData)
    {
        return $this->_savedItem($info_id, $formData, 'item_report');
    }

    protected function prependEditHookItemReport($page_config, &$options)
    {
        $item = $this->_readItem($page_config);

        $options['redirect'] = ['controller' => 'infos', 'action' => 'index', '?' => ['page_slug' => $page_config->slug, 'item_id' => $item->id]];
    }

    protected function readingConditionsHookItemReport($query, &$cond, &$contain)
    {
        $InfoStockTables = $this->getTableLocator()->get('InfoStockTables');
        $item_id = $this->request->getQuery('item_id');

        $_cond = [
            'InfoStockTables.page_slug' => 'item_report',
            'InfoStockTables.model_name' => 'Items',
            'InfoStockTables.model_id' => $item_id
        ];
        $stocks = $InfoStockTables->find()->where($_cond)->all();
        $stock_ids = [0];
        if (!$stocks->isEmpty()) {
            $stock_ids = $stocks->extract('info_id')->toArray();
        }
        $cond[count($cond)]['Infos.id in'] = $stock_ids;

        $contain[] = 'InfoStockTables';

    }

    protected function readedIndexHookItemReport()
    {
        $this->Items = $this->getTableLocator()->get('Items');

        $item_id = $this->request->getQuery('item_id');
        $item = $this->Items->find()->where(['Items.id' => $item_id])->first();
        if (empty($item)) {
            return $this->redirect('/user_admin/items');
        }

        $query = $this->viewVars['query'];
        $query['item_id'] = $item_id;

        $this->set(compact('item', 'query'));
    }

    protected function prependListsHookItemReport($query, &$options)
    {
        $options['order'] = ['Infos.start_date' => 'DESC', 'Infos.id' => 'DESC'];
    }

    protected function prependEnableHookItemReport($data, &$options) {
        $item_id = $this->request->getQuery('item_id');

        $options['redirect'] = ['action' => 'index', 'page_slug' => 'item_report', 'item_id' => $item_id];
    }

    protected function savedHookNews($id, $post_data) : bool
    {
        return $this->_savedTop($id, $post_data);
    }
    protected function savedHookPickup($id, $post_date) : bool
    {
        return $this->_savedTop($id, $post_date);
    }
    protected function changedStatusHookNews($data) : void
    {
        $this->_savedTop($data->id, []);
    }

    private function _savedTop($id,  $post_data)
    {
        $r = true;
        $info = $this->Infos->find()->where(['Infos.id' => $id])->first();
        $top = $this->InfoTops->find()->where(['InfoTops.info_id' => $id, 'InfoTops.page_config_id' => $info->page_config_id])->first();

        if ($info->status == 'publish' && $info->index_type == 1) {
            if (empty($top)) {
                $entity = $this->InfoTops->newEntity();
                $entity->id = null;
                $entity->page_config_id = $info->page_config_id;
                $entity->info_id = $info->id;
                $r = $this->InfoTops->save($entity);
            }
        } else {
            if (!empty($top)) {
                $r = $this->InfoTops->delete($top);
            }
        }

        return (bool)$r;
    }
}
