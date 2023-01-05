<?php

namespace App\Controller\UserAdmin;

use App\Controller\Component\CalendarComponent;
use App\Lib\public_holiday_jp;
use Cake\Controller\ComponentRegistry;
use Cake\Core\Configure;
use Cake\Network\Exception\ForbiddenException;
use Cake\Network\Exception\NotFoundException;
use Cake\View\Exception\MissingTemplateException;
use Cake\Event\EventInterface;
use Cake\ORM\TableRegistry;
use Cake\Filesystem\Folder;
use Cake\Routing\RequestActionTrait;


/**
 * Static content controller
 *
 * This controller will render views from Template/Pages/
 *
 * @link https://book.cakephp.org/3.0/en/controllers/pages-controller.html
 */
class SchedulesController extends AppController
{
    private $list = [];

    public function initialize() : void
    {
        parent::initialize();

    }
    
    public function beforeFilter(EventInterface $event) {

        parent::beforeFilter($event);
        $this->viewBuilder()->setLayout("user");
        $this->viewBuilder()->setClassName('Useradmin');

//        $this->loadComponent('Calendar'); // この呼び出し方は複数のインスタンスを作れないので今回はNG

        $this->setCommon();
//        $this->getEventManager()->off($this->Csrf);

        $this->modelName = $this->name;
        $this->set('ModelName', $this->modelName);

    }

    protected function _getQuery() {
        $query = [];

        $query['sch_year'] = $this->request->getQuery('sch_year');
        if (empty($query['sch_year'])) {
            $now = new \DateTime();
            $query['sch_year'] = $now->format('Y');
        }

        return $query;
    }

    protected function _getConditions($query) {
        $cond = [];

        return $cond;
    }

    public function index() {
        $this->checkLogin();
        $this->viewBuilder()->setLayout("index_2");

        $this->setList();

        $query = $this->_getQuery();
        $cond =[];

        $start = $query['sch_year'] . '-01-01';
        $end = $query['sch_year'] . '-12-31';
        $sche_cond = [
            'Schedules.date >=' => $start,
            'Schedules.date <=' => $end
        ];
        // xxxx年のデータがなければ土日・祝を休日設定にする
        $_schedules = $this->Schedules->find()->where($sche_cond)->all();
        if ($_schedules->isEmpty()) {
            $tmp_at = new \DateTime($start);
            do {
                $_dt = $tmp_at->format('Y-m-d');
                $holiday = new public_holiday_jp($tmp_at->format('Y'), $tmp_at->format('m'), $tmp_at->format('d'));
                $holiday->set_public_holiday();
                if ($holiday->is_holiday() && $tmp_at->format('w') != 0) {
                    // 日曜日以外の祝日
                    $entity = $this->Schedules->newEntity([]);
                    $entity->date = $tmp_at->format('Y-m-d');
                    $entity->status = 1;
                    $this->Schedules->save($entity);
                    unset($entity);
                }
                elseif ($tmp_at->format('w') == 0) {
                    // 日曜日
                    $entity = $this->Schedules->newEntity([]);
                    $entity->date = $tmp_at->format('Y-m-d');
                    $entity->status = 1;
                    $this->Schedules->save($entity);
                    unset($entity);
                }
                elseif ($tmp_at->format('w') == 6) {
                    // 日曜日
                    $entity = $this->Schedules->newEntity([]);
                    $entity->date = $tmp_at->format('Y-m-d');
                    $entity->status = 1;
                    $this->Schedules->save($entity);
                    unset($entity);
                }

                $tmp_at->modify('+1 day');
                unset($holiday);
            }while($tmp_at->format('Y') == $query['sch_year']);
        }

        // 休日設定　再取得
        $schedules = [];
        $_schedules = $this->Schedules->find()->where($sche_cond)->all();
        if (!$_schedules->isEmpty()) {
            foreach ($_schedules as $sche) {
                $schedules[$sche->date->format('Y-m-d')] = [
                    'schedule_status' => $sche->status
                ];
            }
        }

        $at = new \DateTime($query['sch_year'] . '-01-01');

        // カレンダー
        for ($i=0; $i<12; $i++) {
            $dt = $at->format('Y-m-01');
            $calendars[$i] = (new CalendarComponent(new ComponentRegistry()))->createCalendar($dt,'calendar', ['addParams' => $schedules]);
            $calendar_title[$i] = $at->format('n月');

            $at->modify('+1 month');
        }

        $this->set('dumy',$calendars[0]->days());

        $this->set(compact('calendars', 'calendar_title', 'query'));
    }

    public function edit($id=0) {
        $this->checkLogin();
        $this->viewBuilder()->setLayout("edit");

        $this->setList();


        if ($this->request->is(['post', 'put'])) {

        }

        $options = [];

        parent::_edit($id, $options);

    }

    public function delete($id, $type, $columns = null) {
        $this->checkLogin();

        
        $options = [];
        // $options['redirect'] = ['action' => 'index'];

        parent::_delete($id, $type, $columns, $options);
    }

    public function position($id, $pos) {
        $this->checkLogin();


        return parent::_position($id, $pos);
    }
    public function enable($id) {
        $this->checkLogin();

        $options = [];

        parent::_enable($id, $options);

    }

    public function setList() {
        
        $list = array();

        $now = new \DateTime();
        $list['year_list'] = [];
        foreach (range($now->format('Y') + 1, 2022) as $y) {
            $list['year_list'][$y] = $y;
        }

        if (!empty($list)) {
            $this->set(array_keys($list),$list);
        }

        $this->list = $list;
        return $list;
    }

}
