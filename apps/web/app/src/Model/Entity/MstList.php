<?php

namespace App\Model\Entity;

class MstList extends AppEntity
{

    const LIST_FOR_ADMIN = 1;
    const LIST_FOR_USER = 2;

    static $sys_list = [
        self::LIST_FOR_ADMIN => '管理用',
        self::LIST_FOR_USER => '通常'
    ];
}
