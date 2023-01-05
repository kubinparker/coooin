<?php

namespace App\Model\Entity;

class PageConfigExtension extends AppEntity
{

    const TYPE_LIST_BUTTON = '1';
    const TYPE_PAGE_BUTTON = '2';

    static $type_list = [
        self::TYPE_LIST_BUTTON => 'リンクボタン',
        self::TYPE_PAGE_BUTTON => 'ページボタン'
    ];
}
