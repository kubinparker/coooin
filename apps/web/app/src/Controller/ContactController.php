<?php

namespace App\Controller;

use Cake\Core\Configure;
use Cake\Network\Exception\ForbiddenException;
use Cake\Network\Exception\NotFoundException;
use Cake\View\Exception\MissingTemplateException;
use Cake\Event\EventInterface;
use Cake\ORM\TableRegistry;
use Cake\Utility\Hash;
use Cake\Mailer\Mailer;
use Cake\Datasource\ConnectionManager;

use App\Form\ContactForm;

/**
 * Static content controller
 *
 * This controller will render views from Template/Pages/
 *
 * @link https://book.cakephp.org/3.0/en/controllers/pages-controller.html
 */
class ContactController extends AppController
{
    private $list = [];

    public function initialize(): void
    {


        $this->formSession = "contact";

        parent::initialize();

    }

    public function beforeFilter(EventInterface $event)
    {

        $this->viewBuilder()->setClassName('Contact');
        $this->viewBuilder()->setLayout("simple");

        $this->loadComponent('Cms');

    }

    public function index()
    {
        $list = $this->setList();

        $view = 'index';
        $contact_form = new ContactForm();
        $form_data = [];

        $action = '';
        if (!empty($this->request->getData("action"))) {
            $action = $this->request->getData("action");
        }

        $valid = array();

        if ($this->request->is(['post', 'put'])) {
            $valid = $this->_checkForm($contact_form, []);
            $form_data = $valid['form'];

            //不要なカラムを削除
            // $white_list = ['email'];
            // foreach ($form_data as $col => $col_data) {
            //     if (!in_array($col, $white_list)) {
            //         unset($form_data[$col]);
            //     }
            // }

            if ($valid['is_valid'] == 1) {

                if ($action == "confirm") {
                    $this->Session->write($this->formSession . '.form_data', $this->request->getData());
                    $this->Session->write($this->formSession . '.token', $valid['token']);
                    $view = 'confirm';
                }

                if ($action == "post") {
                    $r = true;

                    if ($this->request->getData('token') != $this->Session->read($this->formSession . '.token')) {
                        $this->redirect('/');
                        return;
                    }
                    // $connection = ConnectionManager::get('default');
                    // $connection->begin();

                    try {
                        // $entity = $this->_saveMail($form_data);
                        // if ($entity === false) {
                        //     $r = false;
                        // }

                        if ($r) {
                            $r = $this->_sendmail($form_data);
                        }
                        if ($r) {
                            // $connection->commit();
                        } else {
                            throw new Exception("Error Processing Request", 1);
                        }
                    } catch (\Exception $e) {
                        $r = false;
                        dd($e->getMessage());
                        // $connection->rollback();
                    }

                    if ($r) {
                        if (Configure::read('debug')) {
                            $view = 'complete';
                        } else {
                            return $this->redirect(array('action' => "complete"));
                        }
                    } else {
                        //pr("送信できませんでした");
                        return $this->redirect(array('action' => "index"));
                    }
                }

            }
        } else {
            //リクエストデータ読み出し、破棄
            if ($this->Session->check($this->formSession)) {
                $this->Session->delete($this->formSession);
            }
            $this->request = $this->request->withData('prefecture', '栃木県');
        }

        $this->set(compact('valid', 'contact_form', 'form_data'));
        $this->render($view);
    }

    public function _checkForm($contact_form, $form_data = [], $options = [])
    {
        $is_valid = 1;

        $options = array_merge([
            'validate' => 'default'
        ], $options);

        if (empty($form_data)) {
            $form_data = $this->request->getData();
        }

        // $model = $contact_form->source();
        $columns = $contact_form->schema()->fields(); // Formの場合
        // $columns = $this->{$model}->getSchema()->columns(); // Entityの場合
        $isValid = $contact_form->validate($form_data);
        // $entity = $this->{$model}->patchEntity($contact_form, $form_data, ['validate' => $options['validate']]);
        // $isValid = !$entity->hasErrors();
        $token = '';
        $form = [];
        if ($isValid) {
            $token = $this->token(64);
            foreach ($columns as $col) {
                if (array_key_exists($col, $form_data)) {
                    $value = $form_data[$col];
                } else {
                    $value = '';
                }
                $form[$col] = [
                    'error' => 0,
                    'value' => $value
                ];
            }
        } else {
            // $errors = $entity->errors();
            $errors = $contact_form->getErrors();
            foreach ($columns as $col) {
                if (array_key_exists($col, $form_data)) {
                    $value = $form_data[$col];
                } else {
                    $value = '';
                }
                if (array_key_exists($col, $errors)) {
                    $errArgs = [];
                    foreach ($errors[$col] as $err) {
                        $errArgs[] = $err;
                    }

                    $form[$col] = [
                        'error' => 1,
                        'message' => implode('、', $errArgs),
                        'value' => $value
                    ];
                    $is_valid = 0;
                } else {
                    $form[$col] = [
                        'error' => 0,
                        'value' => $value
                    ];
                }
            }
        }

        $data = [
            'is_valid' => $is_valid,
            'token' => $token,
            'form' => $form
        ];

        return $data;
    }

    private function _saveMail($form)
    {
        return true;
    }

    /**
     * メール送信
     * @return [type] [description]
     */
    private function _sendmail($form)
    {
        $r = true;

        // debug=true時にメール送信したい時は下記の設定を入れる
        // Email::dropTransport('default');
        // Email::configTransport('default', [
        //     'className' => 'Mail',
        // ]);

        // 管理者へメール
        $email = new Mailer('default');
        if (!Configure::read('debug')) {
            $email->setCharset('ISO-2022-JP');
        }
        $email->setFrom([ContactForm::getMailFrom() => 'サンプル'])
            ->setTo(ContactForm::getMailTo())
            ->setSubject(ContactForm::MAIL_SUBJECT_ADMIN)
            ->viewBuilder()->setTemplate('contact_admin');

//            ->setSender() // 元の送り主
        $r = $email->setViewVars(['form' => $form])
            ->deliver();

        // ユーザーへメール
        if ($r) {
            $email = new Mailer('default');
            if (!Configure::read('debug')) {
                $email->setCharset('ISO-2022-JP');
            }
            $email->setFrom([ContactForm::getMailFrom() => 'サンプル'])
                ->setTo($form['email']['value'])
                ->setSubject(ContactForm::MAIL_SUBJECT_USER)
                ->viewBuilder()->setTemplate('contact_user');
            $r = $email->setViewVars(['form' => $form])
                ->deliver();
        }


        return $r;
    }

    public function complete()
    {
        $this->Session->delete($this->formSession);
    }

    public function setList()
    {

        $list = array();

        $list['prefecture_list'] = $this->getPrefectureList();

        if (!empty($list)) {
            $this->set(array_keys($list), $list);
        }

        $this->list = $list;
        return $list;
    }

}
