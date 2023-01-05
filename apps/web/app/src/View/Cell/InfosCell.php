<?php
namespace App\View\Cell;

use App\Model\Entity\Item;
use Cake\View\Cell;

class InfosCell extends Cell
{

    public function display()
    {
//        $this->loadModel('Messages');
//        $unread = $this->Messages->find('unread');
//        $this->set('unread_count', $unread->count());
    }

    public function preview_url($page_slug, $data, $args = [])
    {
      $preview_url = "/{$page_slug}/{$data->id}?preview=on";

      $this->set(compact('preview_url'));
    }
}