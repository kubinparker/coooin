<?php

namespace App\Controller;

use Cake\Core\Configure;
use Cake\Event\EventInterface;
use Cake\Network\Exception\ForbiddenException;
use Cake\Network\Exception\NotFoundException;
use Cake\View\Exception\MissingTemplateException;
use Cake\Auth\DefaultPasswordHasher;

//use App\Model\Entity\Info;

class HomesController extends AppController
{
    public function initialize(): void
    {

        parent::initialize();

        $this->loadComponent('Cms');

//        $this->InfoStockTables = $this->getTableLocator()->get('InfoStockTables');


    }

    public function beforeFilter(EventInterface $event)
    {

        parent::beforeFilter($event);

        $this->viewBuilder()->setLayout("simple");


    }

    public function index()
    {
        $infos = $this->Cms->findAll('news', ['limit' => '3']);

        $this->set(compact('infos'));

    }


}
