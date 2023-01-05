<?php

namespace App\Model\Entity;

class PageConfigItem extends AppEntity
{

    const TYPE_MAIN = 'main';
    const TYPE_BLOCK = 'block';
    const TYPE_SECTION = 'section';

    static $type_list = [
        self::TYPE_MAIN => '基本項目',
        self::TYPE_BLOCK => 'コンテンツ',
        self::TYPE_SECTION => '枠'
    ];
}
