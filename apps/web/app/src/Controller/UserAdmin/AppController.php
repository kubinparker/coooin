<?php

namespace App\Controller\UserAdmin;

use App\Controller\AppController as BaseController;
use Cake\Event\EventInterface;
use App\Model\Entity\Info;
use App\Lib\Util;
use Cake\Datasource\ConnectionManager;

class AppController extends BaseController
{


    public function initialize(): void
    {

        parent::initialize();

        $this->viewBuilder()->setHelpers([
            'Paginator' => ['templates' => 'paginator-user']
        ]);
        $this->SiteConfigs = $this->getTableLocator()->get('SiteConfigs');
        // $this->Session->write(['current_site_id' => 1]);

        $this->loadComponent('AdminMenu');
    }


    public function beforeFilter(EventInterface $event)
    {
    }


    protected function _lists($cond = array(), $options = array())
    {

        $primary_key = $this->{$this->modelName}->getPrimaryKey();
        if (is_array($primary_key)) {
            $primary_key = 'id';
        }

        $this->paginate = array_merge(
            array(
                'order' => $this->modelName . '.' . $primary_key . ' DESC',
                'limit' => 10,
                'contain' => [],
                'paramType' => 'querystring',
                'url' => [
                    'sort' => null,
                    'direction' => null
                ],
                'rand' => null,
                'union' => null,
                'sql_debug' => false,
                'findMethod' => 'all',
                'query_callback' => null,
            ),
            $options
        );
        if (!array_key_exists('contain', $options)) {
            $options['contain'] = [];
        }
        if (!array_key_exists('findMethod', $options)) {
            $options['findMethod'] = 'all';
        }

        try {
            if ($this->paginate['limit'] === null) {
                unset(
                    $options['limit'],
                    $options['paramType']
                );
                if (!empty($options['rand'])) {
                    $options['limit'] = $options['rand'];
                    $options['order'] = 'rand()';
                }
                if ($cond) {
                    $options['conditions'] = $cond;
                }
                // $datas = $this->{$this->modelName}->find('all', $options);
                $query = $this->{$this->modelName}->find($options['findMethod'])->where($cond)->order($options['order']);
                if (!empty($options['limit'])) {
                    $query->limit($options['limit']);
                }
                if ($options['contain']) {
                    $query->contain($options['contain']);
                }
                if (!empty($options['union'])) {
                    $query->unionAll($options['union']);
                }
                if (!empty($options['sql_debug']) && $options['sql_debug'] === true) {
                    dd($query->sql());
                }
                if (!empty($options['query_callback'])) {
                    $query = $options['query_callback']($query);
                }
                $data_query = $query->all();
            } else {
                $query = $this->{$this->modelName}->find($options['findMethod'])->where($cond);
                if (!empty($options['query_callback'])) {
                    $query = $options['query_callback']($query);
                }
                $data_query = $this->paginate($query);
            }
            $datas = $data_query->toArray();
            $count['total'] = $data_query->count();
        } catch (NotFoundException $e) {
            if (
                !empty($this->request->query['page'])
                && 1 < $this->request->query['page']
            ) {
                $this->redirect(array('action' => $this->request->action));
            }
        }
        $q = $this->{$this->modelName}->find()->where($cond);
        if (!empty($options['contain'])) {
            $q->contain($options['contain']);
        }
        $numrows = $q->count();

        $this->set(compact('datas', 'data_query', 'numrows'));
    }


    protected function _edit($id = 0, $option = array())
    {
        $option = array_merge(
            array(
                'saveAll' => false,
                'saveMany' => false,
                'create' => null,
                'callback' => null,
                'redirect' => array('action' => 'index'),
                'contain' => [],
                'success_message' => '保存しました',
                'validate' => 'default',
                'associated' => null,
                'append_validate' => null,
                'get_callback' => null,
                'error_get_callback' => null,
                'beforeFindFilter' => null,
                'is_save' => true
            ),
            $option
        );
        extract($option);

        $primary_key = $this->{$this->modelName}->getPrimaryKey();

        if (empty($contain) && !empty($associated)) {
            $contain = $associated;
        }

        $isValid = true;

        if (
            $this->request->is(array('post', 'put'))
            && $this->request->getData() //post_max_sizeを越えた場合の対応(空になる)
        ) {


            $entity_options = [];
            if (!empty($associated)) {
                $entity_options['associated'] = $associated;
            }
            if (!empty($validate)) {
                $entity_options['validate'] = $validate;
            }

            $entity = $this->{$this->modelName}->newEntity($this->request->getData(), $entity_options);
            if ($entity->getErrors()) {
                $data = $this->request->getData();
                if (!array_key_exists('id', $data)) {
                    $data['id'] = $id;
                }
                if (property_exists($this->{$this->modelName}, 'useHierarchization') && !empty($this->{$this->modelName}->useHierarchization)) {
                    $vals = $this->{$this->modelName}->useHierarchization;
                    $_model = $vals['sequence_model'];
                    if (!empty($entity[$vals['contents_table']])) {
                        // if (array_key_exists($vals['contents_table'], $entity)) {
                        foreach ($entity[$vals['contents_table']] as $k => $v) {
                            if (empty($v['id'])) {
                                $entity[$vals['contents_table']][$k]['id'] = null;
                            }
                            if ($v[$vals['sequence_id_name']]) {
                                $seq = $this->{$_model}->find()->where([$_model . '.id' => $v[$vals['sequence_id_name']]])->first();
                                $entity[$vals['contents_table']][$k][$vals['sequence_table']] = $seq;
                            }
                        }
                    }
                }
                // pr($entity);exit;

                // TODO::
                // $this->redirect($this->referer());

                //                $request = $this->getRequest()->withParsedBody($this->{$this->modelName}->toFormData($entity));

                //                $this->setRequest($data);
                $this->set('data', $data);
                $isValid = false;
            }

            // 追加項目バリデーション
            if ($append_validate) {
                $isValid = $append_validate($isValid, $entity);
            }
            if ($isValid) {
                $r = false;
                $cn = ConnectionManager::get('default');
                $cn->begin();

                try {
                    if ($is_save) {
                        $r = $this->{$this->modelName}->save($entity);
                    }
                    if ($r) {
                        if ($callback) {
                            $r = $callback($entity->id);
                        }
                    }
                    if ($r) {
                        $cn->commit();
                        if ($success_message) {
                            $this->Flash->success($success_message);
                        }
                    }
                } catch (\Exception $e) {
                    $r = false;
                    $cn->rollback();

                    debug($e);
                }
                if ($r) {
                    // exit;
                    if ($redirect) {
                        return $this->redirect($redirect);
                    }
                }
            } else {
                $data = $this->request->getData();
                if (!is_null($error_get_callback)) {
                    $data = $error_get_callback($data);
                    $request = $this->getRequest()->withParsedBody($data);
                    $this->setRequest($request);
                }

                if (!array_key_exists('id', $data)) {
                    $data['id'] = $id;
                }
                $this->set('data', $data);
                $this->Flash->error('正しく入力されていない項目があります');
            }
        } else {

            $query = $this->{$this->modelName}->find()->where([$this->modelName . '.' . $primary_key => $id])->contain($contain);
            if ($option['beforeFindFilter']) {
                $query = $option['beforeFindFilter']($query);
            }
            if ($create) {
                if (property_exists($this->{$this->modelName}, 'defaultValues')) {
                    $create = array_merge($this->{$this->modelName}->defaultValues, $create);
                }
                $request = $this->getRequest()->withParsedBody($create);
                $this->setRequest($request);
                $entity = $this->{$this->modelName}->newEntity($create);
            } elseif (!empty($query->first())) {
                $entity = $query->first();
                $request = $this->getRequest()->withParsedBody($this->{$this->modelName}->toFormData($entity));
                $this->setRequest($request);
            } else {
                $default_values = [];
                if (property_exists($this->{$this->modelName}, 'defaultValues')) {
                    $default_values = $this->{$this->modelName}->defaultValues;
                }
                $entity = $this->{$this->modelName}->newEntity($default_values);
                $entity->{$this->{$this->modelName}->getPrimaryKey()} = null;
                $request = $this->getRequest()->withParsedBody($this->{$this->modelName}->toFormData($entity));
                $this->setRequest($request);
            }

            if ($get_callback) {
                $request = $this->getRequest()->withParsedBody($get_callback($this->request->getData()));
                $this->setRequest($request);
            }


            $this->set('data', $this->request->getData());
        }

        if (property_exists($this->{$this->modelName}, 'useHierarchization') && !empty($this->{$this->modelName}->useHierarchization)) {
            $block_waku_list = array_keys(Info::BLOCK_TYPE_WAKU_LIST);
            $contents = $this->toHierarchization($id, $entity, ['section_block_ids' => $block_waku_list]);
            $this->set(array_keys($contents), $contents);
            // pr($contents);exit;
        }

        $this->set('entity', $entity);

        return $isValid;
    }

    public function _detail($id, $option = [])
    {
        $option = array_merge(
            array(
                'callback' => null,
                'redirect' => array('action' => 'index'),
                'contain' => []
            ),
            $option
        );
        extract($option);

        $primary_key = $this->{$this->modelName}->getPrimaryKey();



        $query = $this->{$this->modelName}->find()->where([$this->modelName . '.' . $primary_key => $id])->contain($contain);

        if (!$query->isEmpty()) {
            $entity = $query->first();
            $request = $this->getRequest()->withParsedBody($this->{$this->modelName}->toFormData($entity));
            $this->setRequest($request);
        } else {
            $entity = $this->{$this->modelName}->newEntity();
            $entity->{$this->{$this->modelName}->getPrimaryKey()} = null;
            $request = $this->getRequest()->withParsedBody($this->{$this->modelName}->toFormData($entity));
            $this->setRequest($request);
            if (property_exists($this->{$this->modelName}, 'defaultValues')) {
                $request = $this->getRequest()->withParsedBody(array_merge($this->request->data, $this->{$this->modelName}->defaultValues));
                $this->setRequest($request);
            }
        }


        $this->set('data', $this->request->getData());


        if (property_exists($this->{$this->modelName}, 'useHierarchization') && !empty($this->{$this->modelName}->useHierarchization)) {
            $block_waku_list = array_keys(Info::BLOCK_TYPE_WAKU_LIST);
            $contents = $this->toHierarchization($id, $entity, ['section_block_ids' => $block_waku_list]);
            $this->set(array_keys($contents), $contents);
        }

        $this->set('entity', $entity);
    }


    public function checkLogin($role = '')
    {
        if ($role == SHOP) {
            if ($this->isShopLogin()) {
                return parent::checkShopLogin();
            }
        }
        return parent::checkUserLogin();
    }


    /**
     * 順番並び替え
     * */
    protected function _position($id, $pos, $options = array())
    {
        $options = array_merge(array(
            'redirect' => array('action' => 'index', '#' => 'content-' . $id)
        ), $options);
        extract($options);

        $primary_key = $this->{$this->modelName}->getPrimaryKey();
        $query = $this->{$this->modelName}->find()->where([$this->modelName . '.' . $primary_key => $id]);

        if (!$query->isEmpty()) {
            // $entity = $this->{$this->modelName}->get($id);
            $this->{$this->modelName}->movePosition($id, $pos);
        }
        if ($redirect) {
            $this->redirect($redirect);
        }

        // $this->OutputHtml->index($this->getUsername());

    }


    /**
     * 掲載中/下書き トグル
     * */
    protected function _enable($id, $options = array())
    {
        $options = array_merge(array(
            'redirect' => array('action' => 'index', '#' => 'content-' . $id),
            'column' => 'status',
            'status_true' => 'publish',
            'status_false' => 'draft'
        ), $options);
        extract($options);
        $r = false;

        $primary_key = $this->{$this->modelName}->getPrimaryKey();
        $query = $this->{$this->modelName}->find()->where([$this->modelName . '.' . $primary_key => $id]);

        if (!$query->isEmpty()) {
            $entity = $query->first();
            $status = ($entity->get($column) == $status_true) ? $status_false : $status_true;
            $r = $this->{$this->modelName}->updateAll(array($column => $status), array($this->{$this->modelName}->getPrimaryKey() => $id));
        }
        if ($redirect) {
            $this->redirect($redirect);
        }

        if ($r) {
            return $status;
        }
        return ($status == $status_true) ? $status_false : $status_true;
    }


    /**
     * ファイル/記事削除
     *
     * */
    protected function _delete($id, $type, $columns = null, $option = array())
    {
        $option = array_merge(
            array('redirect' => null),
            $option
        );
        extract($option);

        $primary_key = $this->{$this->modelName}->getPrimaryKey();
        $query = $this->{$this->modelName}->find()->where([$this->modelName . '.' . $primary_key => $id]);

        if (!$query->isEmpty() && in_array($type, array('image', 'file', 'content'))) {
            $entity = $query->first();
            $data = $entity->toArray();

            if ($type === 'image' && isset($this->{$this->modelName}->attaches['images'][$columns])) {
                if (!empty($data['attaches'][$columns])) {
                    foreach ($data['attaches'][$columns] as $_) {
                        $_file = WWW_ROOT . $_;
                        if (is_file($_file)) {
                            @unlink($_file);
                        }
                    }
                }
                $this->{$this->modelName}->updateAll(
                    array($columns => ''),
                    array($this->modelName . '.' . $this->{$this->modelName}->getPrimaryKey() => $id)
                );
            } else if ($type === 'file' && isset($this->{$this->modelName}->attaches['files'][$columns])) {
                if (!empty($data['attaches'][$columns][0])) {
                    $_file = WWW_ROOT . $data['attaches'][$columns][0];
                    if (is_file($_file)) {
                        @unlink($_file);
                    }

                    $this->{$this->modelName}->updateAll(
                        array(
                            $columns => '',
                            $columns . '_name' => '',
                            $columns . '_size' => 0,
                        ),
                        array($this->modelName . '.' . $this->{$this->modelName}->getPrimaryKey() => $id)
                    );
                }
            } else if ($type === 'content') {
                $image_index = array_keys($this->{$this->modelName}->attaches['images']);
                $file_index = array_keys($this->{$this->modelName}->attaches['files']);

                foreach ($image_index as $idx) {
                    foreach ($data['attaches'][$idx] as $_) {
                        $_file = WWW_ROOT . $_;
                        if (is_file($_file)) {
                            @unlink($_file);
                        }
                    }
                }

                foreach ($file_index as $idx) {
                    $_file = WWW_ROOT . $data['attaches'][$idx][0];
                    if (is_file($_file)) {
                        @unlink($_file);
                    }
                }

                $this->{$this->modelName}->delete($entity);

                $id = 0;
            }
        }

        if ($redirect) {
            return $this->redirect($redirect);
        }

        if ($redirect !== false) {
            if ($id) {
                $this->redirect(array('action' => 'edit', $id));
            } else {
                $this->redirect(array('action' => 'index'));
            }
        }

        return;
    }


    /**
     * 中身は各コントローラに書く
     * @param  [type] $info_id [description]
     * @return [type]          [description]
     */
    protected function _htmlUpdate($info_id)
    {
    }


    protected function getUsername()
    {
        return $this->Session->read('data.username');
    }


    public function getUserId($role = )
    {
        return $this->isUserLogin($role);
    }


    public function array_asso_chunk($datas, $num)
    {
        $res = [];
        $max = count($datas);

        $count = 0;
        $i = 0;
        foreach ($datas as $k => $v) {
            $res[$i][$k] = $v;
            $count++;
            if (!($count % $num)) {
                $i++;
            }
        }

        return $res;
    }


    public function setCommon()
    {
        $user_site_list = $this->_getUserSite();
        $current_site_id = $this->Session->read('current_site_id');
        $this->set(compact('user_site_list', 'current_site_id'));
    }


    public function _getUserSite($user_id = 0)
    {
        $user_id = $user_id == 0 ? $this->Session->read('useradminId') : $user_id;

        $user_sites = $this->UseradminSites->find()
            ->where(['UseradminSites.useradmin_id' => $user_id])
            ->contain(['SiteConfigs', 'Useradmins'])
            ->all()
            ->toArray();

        $user_site_list = [];
        foreach ($user_sites as $site)
            $user_site_list[$site->site_config->id] = $site->site_config->site_name;

        if (!$this->Session->check('current_site_id') && !empty($user_site_list)) {
            $site_id = array_keys($user_site_list)[0];

            $this->Session->write('current_site_id', $site_id);
            $this->Session->write('current_site_slug', $user_site_list[$site_id]);
        }

        return $user_site_list;
    }


    protected function isUserRole($role_key, $isOnly = false)
    {
        $role = $this->Session->read('user_role');

        if (intval($role) === 0) $res = DEVELOP;
        elseif ($role < 10) $res = ADMIN;
        elseif ($role < 20) $res = STAFF;
        elseif ($role < 30) $res = SHOP;
        elseif ($role == 80) $res = USER_REGIST;
        else if ($role >= 90) $res = DEMO;
        /** 必要に応じて追加 */
        else $res = STAFF;

        if (!$isOnly) {
            if ($role_key == ADMIN) $role_key = [DEVELOP, ADMIN];
            elseif ($role_key == STAFF) $role_key = [DEVELOP, ADMIN, STAFF];
            elseif ($role_key == SHOP) $role_key = [DEVELOP, ADMIN, STAFF, SHOP];
            elseif ($role_key == USER_REGIST) $role_key = [DEVELOP, ADMIN, STAFF, SHOP, USER_REGIST];
        }

        return (in_array($res, (array)$role_key));
    }


    /**
     * 端数処理
     * @param [type] $value [description]
     */
    protected function Round($number, $decimal = 0, $type = 1)
    {

        return Util::Round($number, $decimal, $type);
    }


    protected function wareki($date)
    {
        return Util::wareki($date);
    }


    public function getData()
    {

        $this->viewBuilder()->setLayout(false);

        $id = $this->request->getData('id');
        $columns = $this->request->getData('columns');
        $append_columns = $this->request->getData('append_columns');
        $contain = $this->request->getData('contain');

        $primaryKeyColumn = 'id';
        if ($this->request->getQuery('primaryKeyColumn')) {
            $primaryKeyColumn = $this->request->getQuery('primaryKeyColumn');
        }

        $columns = str_replace(' ', '', $columns);
        $cols = explode(",", $columns);
        if (!empty($contain)) {
            $contain = explode(",", $contain);
        }


        $query = $this->{$this->modelName}->find()->where([$this->modelName . '.' . $primaryKeyColumn => $id]);
        if (!empty($contain)) {
            $query->contain($contain);
        }
        if (method_exists(get_class($this), '_getDataBeforeFind')) {
            $query = $this->{'_getDataBeforeFind'}($query);
        }
        $data = $query->select($cols)->first();

        if (!empty($append_columns)) {
            $append_columns = str_replace(' ', '', $append_columns);
            $cols = explode(",", $append_columns);
            foreach ($cols as $col) {
                $data[$col] = $data->{$col};
            }
        }

        $this->rest_success($data);
    }


    protected function _csvOutput($th, $data, $filename)
    {

        $_serialize = ['data'];
        $_header = $th;
        $_footer = [];


        /**
         * Windows対応
         */
        $_csvEncoding = 'CP932';
        $_newline = "\r\n";
        $_eol = "\r\n";

        $this->response->download($filename);
        $this->viewBuilder()->className('CsvView.Csv');
        $this->set(compact('data', '_serialize', '_header', '_footer', '_csvEncoding', '_newline', '_eol'));
    }
}
