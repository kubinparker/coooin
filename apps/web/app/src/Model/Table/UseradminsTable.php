<?php

namespace App\Model\Table;

use Cake\Validation\Validator;
use Cake\ORM\TableRegistry;

class UseradminsTable extends AppTable
{

    // テーブルの初期値を設定する
    public $defaultValues = ["id" => null];


    public $attaches = [
        'images' =>
        [
            'face_image' => [
                'extensions' => ['jpg', 'jpeg', 'gif', 'png'],
                'width' => 1200,
                'height' => 1200,
                'file_name' => 'img_%d_%s',
                'thumbnails' => [
                    's' => [
                        'prefix' => 's_',
                        'width' => 320,
                        'height' => 320,
                        'method' => 'crop'
                    ]
                ]
                //image_1
            ]
        ],
        'files' => [],
    ];


    // 
    public function initialize(array $config): void
    {
        $this->addBehavior('FileAttache');
        $this->hasMany('UseradminSites')->setDependent(true);
        parent::initialize($config);
    }


    public function validationNew(Validator $validator): Validator
    {
        $validator = $this->validationDefault($validator);
        $validator = $this->validationTmpPassword($validator);
        return $validator;
    }


    public function validationModify(Validator $validator): Validator
    {
        $validator = $this->validationDefault($validator);
        return $validator;
    }


    public function validationModifyIsPass(Validator $validator): Validator
    {
        $validator = $this->validationDefault($validator);
        $validator = $this->validationUserRegist($validator);
        return $validator;
    }


    // Validation
    public function validationDefault(Validator $validator): Validator
    {
        $validator->setProvider('User', 'App\Validator\UserValidation');

        $validator
            ->notEmptyString('name', '入力してください')
            ->add('name', 'maxLength', [
                'rule' => ['maxLength', 50],
                'message' => '50文字以内で入力してください'
            ])

            ->notEmptyString('email')
            ->add('email', 'maxLength', [
                'rule' => ['maxLength', 200],
                'message' => __('200字以内で入力してください')
            ])

            ->add('email', 'custom', [
                'rule' => ['isUnique'],
                'provider' => 'User',
                'message' => 'このメールアドレスは既に登録済みです'
            ])

            ->notEmptyString('username', '入力してください')
            ->add('username', 'chkUserName', [
                'rule' => ['checkUsername'],
                'provider' => 'User',
                'message' => '使えない文字が含まれているか、数字から始まる文字列は指定出来ません'
            ])
            ->add('username', 'Length', [
                'rule' => ['lengthBetween', 3, 30],
                'message' => '3文字以上30文字以内で入力してください'
            ])
            ->add('username', 'unique', [
                'rule' => ['isUnique'],
                'provider' => 'User',
                'message' => 'ご希望のアカウントは既に使われております'
            ]);

        return $validator;
    }


    public function validationTmpPassword(Validator $validator): Validator
    {
        $validator->setProvider('User', 'App\Validator\UserValidation');

        $validator
            ->notEmptyString('temp_password', '入力してください')
            ->add('temp_password', 'maxlength', ['rule' => ['maxLength', 30], 'message' => '30文字以内で入力してください'])
            ->add('temp_password', 'check_password', ['rule' => ['checkPasswordRule'], 'provider' => 'User', 'message' => 'このパスワードは使えません']);

        return $validator;
    }


    public function validationUserRegist(validator $validator): Validator
    {
        $validator->setProvider('User', 'App\Validator\UserValidation');

        $validator
            ->add('password', 'comWith', ['rule' => ['compareWith', 'password_confirm'], 'message' => 'パスワードが一致しません'])
            ->add('password', 'check_password', ['rule' => ['checkPasswordRule'], 'provider' => 'User', 'message' => 'このパスワードは使えません']);

        return $validator;
    }


    public function getList($cond = [])
    {
        $query = $this->find()->where($cond);
        $list = [];

        if ($query->isEmpty()) {
            return $list;
        }

        $datas = $query->toArray();
        foreach ($datas as $val) {
            $list[$val['id']] = $val['list_name'];
        }

        return $list;
    }


    public function getUserSite($user_id)
    {
        $this->UseradminSites = TableRegistry::get('UseradminSites');
        $site_config_ids = [];

        $user_sites = $this->UseradminSites->find()->where(['UseradminSites.useradmin_id' => $user_id])->extract('site_config_id');
        if (!empty($user_sites)) {
            foreach ($user_sites as $val) {
                $site_config_ids[$val] = $val;
            }
        }

        return $site_config_ids;
    }
}
