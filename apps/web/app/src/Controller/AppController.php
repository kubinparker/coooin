<?php

declare(strict_types=1);

/**
 * CakePHP(tm) : Rapid Development Framework (https://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 * @link      https://cakephp.org CakePHP(tm) Project
 * @since     0.2.9
 * @license   https://opensource.org/licenses/mit-license.php MIT License
 */

namespace App\Controller;

use Cake\Controller\Controller;
use Cake\Event\EventInterface;

/**
 * Application Controller
 *
 * Add your application-wide methods in the class below, your controllers
 * will inherit them.
 *
 * @link https://book.cakephp.org/4/en/controllers.html#the-app-controller
 */
class AppController extends Controller
{
    public $Session = null;
    public $error_messages;

    public $head_description = '在庫管理システム、WMS（倉庫管理システム）ならアトムエンジニアリング。物流・製造業の現場を改善し続けて30年の実績と確かなソリューションでお客様の業務改善を強力にサポート。';

    /**
     * Initialization hook method.
     *
     * Use this method to add common initialization code like loading components.
     *
     * e.g. `$this->loadComponent('FormProtection');`
     *
     * @return void
     */
    public function initialize(): void
    {
        parent::initialize();

        $this->loadComponent('RequestHandler');
        $this->loadComponent('Flash');
        $this->setHeadTitle();
        $this->Session = $this->getRequest()->getSession();

        $this->viewBuilder()->setLayout(null);

        $this->is_preview = $this->isUserLogin() && $this->request->getQuery('preview') == 'on';

        $this->set('__description__', $this->head_description);
        $this->set('body_class', '');

        /*
         * Enable the following component for recommended CakePHP form protection settings.
         * see https://book.cakephp.org/4/en/controllers/components/form-protection.html
         */
        //$this->loadComponent('FormProtection');
    }


    /**
     * Before render callback.
     *
     * @param \Cake\Event\Event $event The beforeRender event.
     * @return \Cake\Http\Response|null|void
     */
    public function beforeRender(EventInterface $event)
    {
        // Note: These defaults are just to get started quickly with development
        // and should not be used in production. You should instead set "_serialize"
        // in each action as required.
        //        if (!array_key_exists('_serialize', (array)$this->viewVars) &&
        //            in_array($this->response->getType(), ['application/json', 'application/xml'])
        //        ) {
        //            $this->set('_serialize', true);
        //        }

        $this->set('error_messages', $this->error_messages);

        //        if ($this->getRequest()->getParam('prefix') === 'smt') {
        //            $this->viewBuilder()->theme('Sp');
        //        }
        //
        //        $this->getRequest()->addDetector('mob', array('env' => 'HTTP_USER_AGENT',
        //                                                 'options' => array(
        //                                                     'Android', 'AvantGo', 'BlackBerry', 'DoCoMo', 'Fennec', 'iPod', 'iPhone', 'iPad',
        //                                                     'J2ME', 'MIDP', 'NetFront', 'Nokia', 'Opera Mini', 'Opera Mobi', 'PalmOS', 'PalmSource',
        //                                                     'portalmmm', 'Plucker', 'ReqwirelessWeb', 'SonyEricsson', 'Symbian', 'UP\\.Browser',
        //                                                     'webOS', 'Windows CE', 'Windows Phone OS', 'Xiino'
        //                                                     )
        //                                                 )
        //                                    );
        //
        //        //Theme 設定
        //        $this->set('isMobile', $this->request->is('mob'));
    }


    protected function _setView($lists)
    {
        $this->set(array_keys($lists), $lists);
    }


    public function isAdminLogin()
    {
        $id = $this->Session->read('uid');
        return $id;
    }


    public function isUserLogin()
    {
        $userid = $this->Session->read('useradminId');
        return $userid;
    }


    public function checkLogin()
    {
        if (!$this->isAdminLogin()) {
            return $this->redirectWithException('/admin/');
        }
    }


    public function checkUserLogin()
    {
        if (!$this->isUserLogin()) {
            return $this->redirectWithException('/user_admin/');
        }
    }


    /**
     * ハイアラーキゼーションと読む！（階層化という意味だ！）
     * １次元のentityデータを階層化した状態の構造にする
     */
    public function toHierarchization($id, $entity, $options = [])
    {
        // $options = array_merge([
        //     'section_block_ids' => [10]
        // ], $options);
        $data = $this->request->getData();
        $content_count = 0;
        $contents = [
            'contents' => []
        ];

        $contents_table = $this->{$this->modelName}->useHierarchization['contents_table'];
        $contents_id_name = $this->{$this->modelName}->useHierarchization['contents_id_name'];

        $sequence_table = $this->{$this->modelName}->useHierarchization['sequence_table'];
        $sequence_id_name = $this->{$this->modelName}->useHierarchization['sequence_id_name'];
        // if ($id && $entity->has($contents_table)) {
        if (!empty($entity->{$contents_table})) {
            $content_count = count($entity->{$contents_table});
            $block_count = 0;
            foreach ($entity->{$contents_table} as $k => $val) {
                $v = $val->toArray();

                // 枠ブロックの中にあるブロック以外　（枠ブロックも対象）
                if (!$v[$sequence_id_name] || ($v[$sequence_id_name] > 0 && in_array($v['block_type'], $options['section_block_ids']))) {
                    $contents["contents"][$block_count] = $v;
                    $contents["contents"][$block_count]['_block_no'] = $block_count;
                } else {
                    // 枠ブロックの中身
                    if (!array_key_exists($sequence_table, $v)) {
                        continue;
                    }
                    $sequence_id = $v[$sequence_id_name];
                    // if (!array_key_exists($block_count, $contents['contents'])) {
                    //     continue;
                    // }
                    $waku_number = false;
                    foreach ($contents['contents'] as $_no => $_v) {
                        if (in_array($_v['block_type'], $options['section_block_ids']) && $sequence_id == $_v[$sequence_id_name]) {
                            $waku_number = $_no;
                            break;
                        }
                    }
                    if ($waku_number === false) {
                        continue;
                    }

                    if (!array_key_exists('sub_contents', $contents["contents"][$waku_number])) {
                        $contents["contents"][$waku_number]['sub_contents'] = null;
                    }
                    $contents["contents"][$waku_number]['sub_contents'][$block_count] = $v;
                    $contents["contents"][$waku_number]['sub_contents'][$block_count]['_block_no'] = $block_count;
                }
                $block_count++;
            }
        }
        //  else {
        //     if (array_key_exists($contents_table, $data)) {
        //         $contents['contents'] = $data[$contents_table];
        //         $content_count = count($data[$contents_table]);
        //     }
        // }
        return [
            'contents' => $contents,
            'content_count' => $content_count
        ];
    }


    public function getCategoryEnabled()
    {
        return CATEGORY_FUNCTION_ENABLED;
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


    /**
     * 記事がユーザーに権限のあるものかどうか
     * @param  [type]  $info_id [description]
     * @return boolean          [description]
     */
    public function isOwnInfoByUser($info_id)
    {
        $user_id = $this->isUserLogin();

        $info = $this->Infos->find()
            ->where(['Infos.id' => $info_id])
            ->contain([
                'PageConfigs' => function ($q) {
                    return $q->select(['site_config_id']);
                }
            ])
            ->first();
        if (empty($info)) {
            return false;
        }

        $user_site = $this->UseradminSites->find()->where(['UseradminSites.useradmin_id' => $user_id, 'UseradminSites.site_config_id' => $info->page_config->site_config_id])->first();
        if (empty($user_site)) {
            return false;
        }

        return true;
    }


    /**
     * ページがユーザーに権限のあるものかどうか
     * @param  [type]  $page_config_id [description]
     * @return boolean                 [description]
     */
    public function isOwnPageByUser($page_config_id)
    {
        $user_id = $this->isUserLogin();

        $page_config = $this->PageConfigs->find()->where(['PageConfigs.id' => $page_config_id])->first();
        if (empty($page_config)) {
            return false;
        }

        $user_site = $this->UseradminSites->find()->where(['UseradminSites.useradmin_id' => $user_id, 'UseradminSites.site_config_id' => $page_config->site_config_id])->first();
        if (empty($user_site)) {
            return false;
        }

        return true;
    }


    public function isOwnCategoryByUser($category_id)
    {
        $user_id = $this->isUserLogin();

        $category = $this->Categories->find()
            ->where(['Categories.id' => $category_id])
            ->contain([
                'PageConfigs' => function ($q) {
                    return $q->select(['site_config_id']);
                }
            ])
            ->first();
        if (empty($category)) {
            return false;
        }

        $user_site = $this->UseradminSites->find()->where(['UseradminSites.useradmin_id' => $user_id, 'UseradminSites.site_config_id' => $category->page_config->site_config_id])->first();
        if (empty($user_site)) {
            return false;
        }

        return true;
    }


    protected function getPrefectureList()
    {
        $prefectures = [
            '北海道' => '北海道', '青森県' => '青森県', '岩手県' => '岩手県', '宮城県' => '宮城県', '秋田県' => '秋田県', '山形県' => '山形県', '福島県' => '福島県', '茨城県' => '茨城県', '栃木県' => '栃木県', '群馬県' => '群馬県', '埼玉県' => '埼玉県', '千葉県' => '千葉県', '東京都' => '東京都', '神奈川県' => '神奈川県', '新潟県' => '新潟県', '富山県' => '富山県', '石川県' => '石川県', '福井県' => '福井県', '山梨県' => '山梨県', '長野県' => '長野県', '岐阜県' => '岐阜県', '静岡県' => '静岡県', '愛知県' => '愛知県', '三重県' => '三重県', '滋賀県' => '滋賀県', '京都府' => '京都府', '大阪府' => '大阪府', '兵庫県' => '兵庫県', '奈良県' => '奈良県', '和歌山県' => '和歌山県', '鳥取県' => '鳥取県', '島根県' => '島根県', '岡山県' => '岡山県', '広島県' => '広島県', '山口県' => '山口県', '徳島県' => '徳島県', '香川県' => '香川県', '愛媛県' => '愛媛県', '高知県' => '高知県', '福岡県' => '福岡県', '佐賀県' => '佐賀県', '長崎県' => '長崎県', '熊本県' => '熊本県', '大分県' => '大分県', '宮崎県' => '宮崎県', '鹿児島県' => '鹿児島県', '沖縄県' => '沖縄県'
        ];

        return $prefectures;
    }


    protected function token($len)
    {
        if ($len > 0) {
            $TOKEN_LENGTH = $len;
            $bytes = openssl_random_pseudo_bytes($TOKEN_LENGTH);
            return bin2hex($bytes);
        } else {
            return '';
        }
    }


    protected function setHeadTitle($title = Null, $isFull = False)
    {
        $_title = \Cake\Core\Configure::read('App.headTitle');
        if ($title) {
            $title = is_array($title) ? implode(' | ', $title) : $title;
            $_title = $isFull ? $title : __('{0} | {1}', [$title, $_title]);
        }
        $this->set('__title__', $_title);
        return $_title;
    }


    protected function checkLang()
    {
        $url = $this->request->getRequestTarget();
        $split_url = explode('/', $url);
        $this->set('is_en', isset($split_url[1]) && $split_url[1] == 'en');
        return isset($split_url[1]) && $split_url[1] == 'en';
    }
}
