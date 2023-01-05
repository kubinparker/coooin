<?php

namespace App\Model\Entity;

use Cake\Auth\DefaultPasswordHasher;

class Useradmin extends AppEntity
{

    const ROLE_DEVELOP = 0;
    const ROLE_ADMIN = 1;
    const ROLE_STAFF = 10;
    const ROLE_SHOP = 20;
    const ROLE_USER_REGIST = 80;
    const ROLE_DEMO = 90;

    static $role_list = [
        self::ROLE_DEVELOP => '開発者',
        self::ROLE_ADMIN => '管理者',
        self::ROLE_STAFF => 'スタッフ',
        self::ROLE_USER_REGIST => 'ユーザー登録のみ',
        self::ROLE_DEMO => 'デモ',
    ];

    static $role_key_list = [
        self::ROLE_DEVELOP => 'develop',
        self::ROLE_ADMIN => 'admin',
        self::ROLE_STAFF => 'staff',
        self::ROLE_SHOP => 'shop',
        self::ROLE_USER_REGIST => 'user_regist'
    ];

    static $role_key_values = [
        'develop' => self::ROLE_DEVELOP,
        'admin' => self::ROLE_ADMIN,
        'staff' => self::ROLE_STAFF,
        'cms' => self::ROLE_STAFF,
        'shop' => self::ROLE_SHOP,
        'user_regist' => self::ROLE_USER_REGIST
    ];
    
    protected function _setPassword($password) {
        return (new DefaultPasswordHasher)->hash($password);
    }

    protected function _getListName()
    {
        return "{$this->_properties['name']}({$this->_properties['username']})";
    }
}
