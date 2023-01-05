<?php
namespace App\Form;

use Cake\Form\Form;
use Cake\Form\Schema;
use Cake\Validation\Validator;

class ContactForm extends AppForm
{

    const MAIL_SUBJECT_ADMIN = '【カテル】お問い合わせがありました';
    const MAIL_SUBJECT_USER = '【カテル】お問い合わせ受付完了';


    protected function _buildSchema(Schema $schema) : Schema
    {
        return $schema
            ->addField('name', 'string')
            ->addField('kana', 'string')
            ->addField('postcode', 'string')
            ->addField('prefecture', 'string')
            ->addField('address1', 'string')
            ->addField('address2', 'string')
            ->addField('tel', 'string')
            ->addField('email', 'string')
            ->addField('content', 'string')
            ->addField('chk_privacy', 'integer')
            ;
    }

    public function validationDefault(Validator $validator): Validator
    {
        $validator->setProvider('App', 'App\Validator\AppValidation');

        $validator
            ->notBlank('name', '※必須項目です(お名前/企業名)')
            ->add('name', 'length', ['rule' => ['maxLength', 40], 'message' => '※40字以内で入力してください'])

            ->notBlank('kana', '※必須項目です(フリガナ)')
            ->add('kana', 'length', ['rule' => ['maxLength', 40], 'message' => '※40字以内で入力してください'])
            ->add('kana', 'checkKana', ['rule' => ['checkKana'], 'provider' => 'App', 'message' => '全角カタカナで入力してください'])

            ->notBlank('postcode', '入力してください')
            ->add('postcode', 'checkPostcode', ['rule' => ['checkPostcode'], 'provider' => 'App', 'message' => '郵便番号の形式が正しくありません'])

            ->notBlank('prefecture', '選択してください')

            ->notBlank('address1', '入力してください')
            ->add('address1', 'maxlength', ['rule' => ['maxLength', 50], 'message' => '50字以内で入力してください'])

            ->allowEmpty('address2')
            ->add('address2', 'maxlength', ['rule' => ['maxLength', 50], 'message' => '50字以内で入力してください'])

            ->notBlank('email', '※必須項目です(メールアドレス)')
            ->add('email', 'custom', ['rule' => [$this, 'checkEmail'], 'message' => '※メールアドレスの形式が正しくありません　全て半角で入力してください'])

            ->notBlank('tel', '※必須項目です(電話番号)')
            ->add('tel', 'checkTel', ['rule' => ['checkTel'], 'provider' => 'App', 'message' => '電話番号の形式が正しくありません'])

            ->notBlank('content', '※必須項目です(お問い合わせ内容)')

            ->notBlank('chk_privacy', '※同意してください')
            ->add('chk_privacy', 'custom', ['rule' => [$this, 'checkIsPrivacy'], 'message' => '※同意してください']);

        return $validator;
    }

    public function getMailFrom()
    {
        $mail = '';

        if (env('SITE_MODE') == 'develop' || strpos(env('HTTP_HOST'), 'test') !== false || strpos(env('HTTP_HOST'), 'caters') !== false) {
            $mail = 'test+from@caters.co.jp';
        } else {
            $mail = '';
        }

        return $mail;
    }

    public function getMailTo()
    {
        $mail = '';

        if (env('SITE_MODE') == 'develop' || strpos(env('HTTP_HOST'), 'test') !== false || strpos(env('HTTP_HOST'), 'caters') !== false) {
            $mail = 'test+to@caters.co.jp';
        } else {
            $mail = '';
        }

        return $mail;
    }

    public function getAdminSubject()
    {
        return self::MAIL_SUBJECT_ADMIN;
    }

    public function getUserSubject()
    {
        return self::MAIL_SUBJECT_USER;
    }
}
