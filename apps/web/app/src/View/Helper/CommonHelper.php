<?php

namespace App\View\Helper;

use App\Model\Entity\Item;
use Cake\Datasource\ModelAwareTrait;
use App\Model\Entity\EventSchedule;
use App\Model\Entity\Useradmin;
use App\Lib\Util;

class CommonHelper extends AppHelper
{
    use ModelAwareTrait;

    public function session_read($key)
    {
        return $this->getView()->getRequest()->getSession()->read($key);
    }

    public function session_check($key)
    {
        return $this->getView()->getRequest()->getSession()->check($key);
    }

    public function getCategoryEnabled()
    {
        return CATEGORY_FUNCTION_ENABLED;
    }

    public function getCategorySortEnabled()
    {
        return CATEGORY_SORT;
    }

    public function isCategoryEnabled($page_config, $mode = 'category')
    {

        if (!$this->getCategoryEnabled()) {
            return false;
        }

        if (empty($page_config)) {
            return false;
        }

        $mode = 'is_' . $mode;
        if ($page_config->{$mode} === 'Y' || strval($page_config->{$mode}) === '1') {
            return true;
        }

        return false;
    }

    public function isCategorySort($page_config_id)
    {
        $this->modelFactory('Table', ['Cake\ORM\TableRegistry', 'get']);
        $this->loadModel('PageConfigs');

        if (!CATEGORY_SORT) {
            return false;
        }
        $page_config = $this->PageConfigs->find()->where(['PageConfigs.id' => $page_config_id])->first();

        if (empty($page_config)) {
            return false;
        }

        if ($page_config->is_category_sort == 'Y') {
            return true;
        }

        return false;
    }

    public function isViewSort($page_config, $category_id = 0)
    {

        if ($page_config->disable_position_order == 1) {
            return false;
        }

        if ($this->getCategoryEnabled() && $page_config->is_category === 'Y'
            && ($this->isCategorySort($page_config->id)) || (!$this->isCategorySort($page_config->id) && !$category_id)) {
            return true;
        }

        return false;
    }

    public function isViewPreviewBtn($page_config)
    {
        if ($page_config->disable_preview) {
            return false;
        }

        return true;
    }

    public function isUserRole($role_key, $isOnly = false)
    {

        $role = $this->session_read('user_role');

        if (intval($role) === 0) {
            $res = 'develop';
        } elseif ($role < 10) {
            $res = 'admin';
        } elseif ($role < 20) {
            $res = 'staff';
        } elseif ($role < 30) {
            $res = 'shop';
        } elseif ($role == 80) {
            $res = 'user_regist';
        } else if ($role >= 90) {
            $res = 'demo';
        } /** 必要に応じて追加 */
        else {
            $res = 'staff';
        }

        if (!$isOnly) {
            if ($role_key == 'admin') {
                $role_key = array('develop', 'admin');
            } elseif ($role_key == 'staff') {
                $role_key = array('develop', 'admin', 'staff');
            } elseif ($role_key == 'shop') {
                $role_key = array('develop', 'admin', 'staff', 'shop');
            } elseif ($role_key == 'user_regist') {
                $role_key = array('develop', 'admin', 'cms', 'shop', 'user_regist');
            }
        }

        if (in_array($res, (array)$role_key)) {
            return true;
        } else {
            return false;
        }

    }

    public function checkUserPublisher()
    {
        return true;


    }

    public function getAdminMenu()
    {
        return $this->session_read('admin_menu.menu_list');
    }

    public function getAppendFields($info_id)
    {
        $this->modelFactory('Table', ['Cake\ORM\TableRegistry', 'get']);
        $this->loadModel('InfoAppendItems');

        $contain = [
            'AppendItems'
        ];
        $append_items = $this->InfoAppendItems->find()->where(['InfoAppendItems.info_id' => $info_id])->contain($contain)->all();
        if (empty($append_items)) {
            return [];
        }

        $result = [];
        foreach ($append_items as $item) {
            // $_data = $item;
            $result[$item->append_item->slug] = $item;
        }

        return $result;
    }

    public function enabledInfoItem($page_id, $type, $key)
    {
        $this->modelFactory('Table', ['Cake\ORM\TableRegistry', 'get']);
        $this->loadModel('PageConfigItems');

        return $this->PageConfigItems->enabled($page_id, $type, $key);
    }

    public function infoItemTitle($page_id, $type, $key, $col = 'title', $default = '')
    {
        $this->modelFactory('Table', ['Cake\ORM\TableRegistry', 'get']);
        $this->loadModel('PageConfigItems');

        $title = '';
        if ($col == 'title') {
            $title = $this->PageConfigItems->getTitle($page_id, $type, $key, $default);
        } elseif ($col == 'sub_title') {
            $title = $this->PageConfigItems->getSubTitle($page_id, $type, $key, $default);
        } elseif ($col == 'memo') {
            $title = $this->PageConfigItems->getMemo($page_id, $type, $key, $default);
        }

        if (empty($title)) {
            $title = $default;
        }
        return $title;
    }

    public function getInfoCategories($info_id, $result_type = 'entity', $options = [])
    {
        $this->modelFactory('Table', ['Cake\ORM\TableRegistry', 'get']);
        $this->loadModel('Infos');

        return $this->Infos->getCategories($info_id, $result_type, $options);
    }

    /**
     * Undocumented function
     *
     * @param [type] $entity
     * @param string $resultMode
     * @return void
     */
    public function getSeminarDetailStatus($entity, $resultMode = 'key')
    {
        $this->modelFactory('Table', ['Cake\ORM\TableRegistry', 'get']);
        $this->loadModel('EventSchedules');

        return $this->EventSchedules->getStatus($entity, $resultMode);
    }

    public function getSeminarStatus($info_id, $resultMode = 'key')
    {
        $this->modelFactory('Table', ['Cake\ORM\TableRegistry', 'get']);
        $this->loadModel('EventSchedules');

        $status = EventSchedule::STATUS_CLOSED;
        $details = $this->EventSchedules->find()->where(['EventSchedules.info_id' => $info_id])->all();
        if ($details->isEmpty()) {
            return '';
        }
        foreach ($details as $detail) {
            if ($detail->status == 'draft') {
                continue;
            }
            $_status = $this->EventSchedules->getStatus($detail);
            if ($_status == EventSchedule::STATUS_ENTRY_OPEN) {
                $status = $_status;
                break;
            } elseif ($_status == EventSchedule::STATUS_ENTRY_CLOSED) {
                $status = EventSchedule::STATUS_ENTRY_CLOSED;
            }
        }

        if ($resultMode == 'key') {
            return $status;
        } elseif ($resultMode == 'value') {
            return EventSchedule::$status_list[$status];
        } elseif ($resultMode == 'array') {
            return [$status, EventSchedule::$status_list[$status], EventSchedule::$status_class_list[$status]];
        } elseif ($resultMode == 'array_public') {
            return [$status, EventSchedule::$status_list[$status], EventSchedule::$status_public_class_list[$status]];
        }

        return '';
    }

    public function isSiteUserLogin()
    {

        return $this->session_read('site_user_id');
    }

    public function isSiteCustomerLogin()
    {
        return $this->session_read('site_customer_id');
    }

    public function isSiteLogin()
    {

        return ($this->isSiteUserLogin() || $this->isSiteCustomerLogin());
    }

    public function getSiteRole()
    {
        $role = 'nologin';

        if ($this->isSiteUserLogin()) {
            $role = 'user';
        } elseif ($this->isSiteCustomerLogin()) {
            $role = 'customer';
        }

        return $role;
    }

    public function getUserRole()
    {
        return $this->session_read('user_role');
    }

    public function getUserRoleKey()
    {
        $role = $this->getUserRole();

        $key = Useradmin::$role_key_list[$role];

        return $key;
    }

    public function isMemberLogin()
    {
        return $this->session_read('memberId');
    }

    public function getMemberData($col='')
    {
        if (!$this->isMemberLogin()) {
            return '';
        }

        $data = $this->session_read('data');
        if (empty($col)) {
            return $data;
        }

        if (array_key_exists($col, $data)) {
            return $data[$col];
        }

        return '';
    }

    public function isCartButton($item)
    {
        $r = false;

        if ($item->stage == Item::STAGE_DEBUT || $item->stage == Item::STAGE_RECOMMEND) {
            if ($this->isMemberLogin()) {
                $r = true;
            }
//            $r = true;
        } elseif ($item->stage == Item::STAGE_CHALLENGE) {
            if ($item->challenge_status == Item::CHALLENGE_STATUS_SALE) {
                if ($this->isMemberLogin()) {
                    $r = true;
                } elseif ($item->is_common_sale == 1) {
                    $now = new \DateTime();
                    if ($item->common_sale_start == DATE_ZERO && $item->common_sale_end == DATE_ZERO) {
                        $r = false;
                    } elseif (!Util::dateEmpty($item->common_sale_start) && $now->format('Ymd') > $item->common_sale_start->format('Ymd') && Util::dateEmpty($item->common_sale_end)) {
                        $r = true;
                    } elseif ($item->common_sale_end != DATE_ZERO && Util::dateEmpty($item->common_sale_start) && $now->format('Ymd') < $item->common_sale_end->format('Ymd')) {
                        $r = true;
                    } elseif ($now->format('Ymd') > $item->common_sale_start->format('Ymd') && $now->format('Ymd') < $item->common_sale_end->format('Ymd')) {
                        $r = true;
                    } else {
                        $r = false;
                    }
                }
            }
        }

        // 売価未定
        if ($item->price_pending == 1) {
            $r = false;
        }

        // 配送サイズが未設定
        if (!$item->delivery_size_id) {
            $r = false;
        }

        // 品切れ
        if ($item->sale_status == Item::STATUS_SOLDOUT) {
            $r = false;
        }

        // 在庫管理
        if ($item->inventory_enabled == 'Y') {
            if ($item->stock <= 0) {
                $r = false;
            }
        }

        return $r;
    }

    public function isPricePending($item)
    {
        if ($item->stage == Item::STAGE_CHALLENGE) {
            if ($item->challenge_status == Item::CHALLENGE_STATUS_PLANNING && $item->price_pending == 1) {
                return true;
            }
        }

        return false;
    }

    public function isItemSupport($item)
    {
        if ($item->stage == Item::STAGE_RECOMMEND || $item->stage == Item::STAGE_DEBUT) {
            return false;
        }


        return true;
    }

    public function isBusinessButton($item)
    {
        if ($item->stage == Item::STAGE_AUDITION) {
            return true;
        }

        return false;
    }

    public function isCartForm($item)
    {
        if ($item->stage == Item::STAGE_AUDITION) {
            return false;
        }

        return true;
    }

    public function dateEmpty($value)
    {
        return Util::dateEmpty($value);
    }
}