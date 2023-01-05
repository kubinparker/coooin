<?php
namespace App\Controller\Component;

use Cake\Controller\Component;
use Cake\Controller\ComponentRegistry;
use Cake\Datasource\ModelAwareTrait;

use App\Lib\CalendarLib;

class CalendarComponent extends Component {
    private $_calendar;

    // public function _createCalendar($now,$mode,$option=array()){

    //     $calendar = new Calendar(array(
    //         'format' => 'Y-m-d',
    //         'weeks' => array('日','月','火','水','木','金','土'),
    //         'start_week' => 0,
    //         'now' => $now,
    //         'mode' => $mode
    //         ));
    //     // 月の1日と月末を取得 yyyy-mm-dd
    //     list($start,$end) = $calendar->span(null,true);


    //     return $calendar;

    // }

    public function getCalendar() {
        return $this->_calendar;
    }
    public function createCalendar($now,$mode,$option=array()){

        $option = array_merge(array(
            'addParams' => []
            ),
                              $option);
        extract($option);

        // モデル
        // $this->loadModel('');

        $this->_calendar = new CalendarLib(array(
            'format' => 'Y-m-d',
            'weeks' => array('日','月','火','水','木','金','土'),
            'start_week' => 0,
            'now' => $now,
            'mode' => $mode,
            ));

        // list($start, $end) = $this->getSpan($calendar);

        if (!empty($addParams)) {
            foreach ($addParams as $date => $args) {
                $this->_calendar->set_data($date, $args);
            }
        }


        return $this;
    }

    public function getSpan(){

        $dt = $this->_calendar->span(null,true);

        return [
            'start' => $dt[0],
            'end' => $dt[1]
        ];
    }

    public function next() {
        return $this->_calendar->next();
    }
    public function prev() {
        return $this->_calendar->prev();
    }
    public function days($plain = false) {
        return $this->_calendar->days($plain);
    }

}