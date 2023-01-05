<?php
namespace App\View\Cell;

use Cake\View\Cell;

class AdminMenuCell extends Cell
{
    public function display()
    {

    }

    public function mainMenu()
    {
        $this->Session = $this->request->getSession();
        $menu_list = $this->Session->read('admin_menu.menu_list');

        $this->set(compact('menu_list'));
    }
}