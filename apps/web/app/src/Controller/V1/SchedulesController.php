<?php

namespace App\Controller\V1;

use App\Form\Address;
use App\Form\SupportForm;
use Cake\Core\Configure;
use Cake\Network\Exception\ForbiddenException;
use Cake\Network\Exception\NotFoundException;
use Cake\View\Exception\MissingTemplateException;
use Cake\Event\EventInterface;
use App\Model\Entity\Customer;
use Cake\Utility\Hash;

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

    public function initialize(): void
    {
        parent::initialize();

        $this->Schedules = $this->getTableLocator()->get('Schedules');

        $this->modelName = 'Schedules';
        $this->set('ModelName', $this->modelName);

    }

    public function beforeFilter(EventInterface $event)
    {
        // $this->viewBuilder()->theme('Admin');
        $this->viewBuilder()->setLayout("plain");


    }

    public function ajaxStatus()
    {
        $this->viewBuilder()->setLayout(false);

        // 日付
        $date = $this->request->getData('date');
        $isDelete = false;

        $at = new \DateTime($date);

        $schedule = $this->Schedules->find()->where(['Schedules.date' => $at->format('Y-m-d')])->first();

        // 新規 → 定休日
        $status = 0;
        if (empty($schedule)) {
            $schedule = $this->Schedules->newEntity([]);
            $status = 1;
        } else {
            $status = ++$schedule->status;
            $status = $status % 2;
        }
        $save = [
            'date' => $date,
            'status' => $status,
            'memo' => ''
        ];
        $entity = $this->Schedules->patchEntity($schedule, $save);
        $this->Schedules->save($entity);

        $data = array(
            "status" => $status,
            "date" => $date
        );

        $this->rest_success($data);
    }
}
