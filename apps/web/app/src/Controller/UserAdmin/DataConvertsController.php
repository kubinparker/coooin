<?php

namespace App\Controller\UserAdmin;

use Cake\Core\Configure;
use Cake\Network\Exception\ForbiddenException;
use Cake\Network\Exception\NotFoundException;
use Cake\View\Exception\MissingTemplateException;
use Cake\Event\Event;
use Cake\Datasource\ConnectionManager;

use App\Model\Entity\Info;
/**
 * Static content controller
 *
 * This controller will render views from Template/Pages/
 *
 * @link https://book.cakephp.org/3.0/en/controllers/pages-controller.html
 */
class DataConvertsController extends AppController
{
    private $list = [];

    public function initialize()
    {
        parent::initialize();

        $this->OldSpots = $this->getTableLocator()->get('OldSpots');
        $this->OldCategoriesSpots = $this->getTableLocator()->get('OldCategoriesSpots');
        $this->AppendItems = $this->getTableLocator()->get('AppendItems');
        $this->Infos = $this->getTableLocator()->get('Infos');
        $this->InfoContents = $this->getTableLocator()->get('InfoContents');
        $this->InfosServices = $this->getTableLocator()->get('InfosServices');
        $this->Services = $this->getTableLocator()->get('Services');
        $this->InfoTops = $this->getTableLocator()->get('InfoTops');

        $this->loadComponent('Cms');

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

    public function convertItems() {
        $items = $this->OldSpots->find()->where(['OldSpots.is_converted' => 0])->contain(['OldCategoriesSpots'])->order(['OldSpots.position' => 'ASC'])->all();
        $services = $this->Services->find('list')->order(['Services.position' => 'ASC'])->all();
        if ($services->isEmpty()) {
            $service_list = [];
        } else {
            $service_list = $services->toArray();
        }

        $this->Infos->removeBehavior('Position');
        $this->InfoTops->removeBehavior('Position');
        $info_top_position = 0;

        foreach ($items as $item) {
            $connection = ConnectionManager::get('default');
            $connection->begin();
            try {


                if ($r) {
                    $connection->commit();
                } else {
                    $connection->rollback();
                    // throw new Exception("Error Processing Request", 1);
                }
            } catch (\Exception $e) {
                $r = false;
                $connection->rollback();
            }
        }

        return $this->redirect('/user_admin/');
    }

    private function appendInfoContent($info_id, $block_type, $values) {

        $save = [
            'id' => null,
            'info_id' => $info_id,
            'block_type' => $block_type,
        ];

        $save = array_merge($save, $values);

        $entity = $this->InfoContents->newEntity($save);
        return $this->InfoContents->save($entity);
    }

}
