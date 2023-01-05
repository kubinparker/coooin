<?php 
namespace App\Model\Behavior;

use ArrayObject;
use Cake\Datasource\EntityInterface;
use Cake\Event\Event;
use Cake\ORM\Behavior;
use Cake\ORM\Entity;
use Cake\ORM\Query;
use Cake\Utility\Text;
use Cake\Filesystem\Folder;
use Cake\Event\EventManager;

class LogicalDeleteBehavior extends Behavior
{

    protected $_defaultConfig = array(

    );
    public $include_flag = false;

    public function initialize(array $config)
    {
        $Model = $this->getTable();
        $this->settings[$Model->getAlias()] = $config + $this->_defaultConfig;
    }
//    public function findAll(Query $query, $options = [])
//    {
//        dd('aaa');
//    }
    public function beforeFind(Event $event, Query $query, ArrayObject $options, $primary)
    {
        $table = $event->getSubject();
        $Model = $table->getAlias();

        if ($this->include_flag === false) {
            $query->where([$Model . '.deleted !=' => 1]);
        }

        return $query;

    }
    public function findIncludeDelete(Query $query, array $options = [])
    {
        $this->include_flag = true;
        return $query;
    }

//    public function beforeDelete(Event $event, EntityInterface $entity)
//    {
//        $table = $event->getSubject();
//        $Model = $table->getAlias();
//
//        $data = $table->find()->where(['id' => $entity->id])->first();
//        $update = [
//            'deleted' => 1
//        ];
//
//        $data->set('deleted', 1);
//        $r = $table->save($data);
//
//        return false;
//    }
//
//    public function find($table, Query $query, $type = 'all', $options = [])
//    {
////        $query = $this->query();
//        $query->select();
//
//        // 追加
//        $cond = ['deleted !=' => 1];
//        if ($type == 'includeDelete') {
//            unset($cond['deleted !=']);
//        }
//        if (!empty($cond)) {
//            $query->where();
//        }
//
//        return $table->callFinder($type, $query, $options);
//    }
}