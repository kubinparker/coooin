<?php

namespace App\Model\Entity;

use Cake\Datasource\ModelAwareTrait;
use App\Model\Entity\AppendItem;

class Info extends AppEntity
{
    use ModelAwareTrait;

    const BLOCK_TYPE_TITLE = 1;
    const BLOCK_TYPE_CONTENT = 2;
    const BLOCK_TYPE_IMAGE = 3;
    const BLOCK_TYPE_FILE = 4;
    const BLOCK_TYPE_TITLE_H4 = 5;
    const BLOCK_TYPE_ANCHOR = 6;
    const BLOCK_TYPE_BUTTON = 8;
    const BLOCK_TYPE_LINE = 9;
    const BLOCK_TYPE_SECTION = 10;
    const BLOCK_TYPE_SECTION_WITH_IMAGE = 11;
    const BLOCK_TYPE_SECTION_FILE = 12;
    const BLOCK_TYPE_SECTION_RELATION = 13;
    const BLOCK_TYPE_RELATION = 14;
    
    const BLOCK_TYPE_LIST = [
        self::BLOCK_TYPE_TITLE => '中見出し',
        self::BLOCK_TYPE_TITLE_H4 => '小見出し',
        self::BLOCK_TYPE_CONTENT => '本文',
        self::BLOCK_TYPE_IMAGE => '画像',
        self::BLOCK_TYPE_FILE => 'ファイル添付',
        self::BLOCK_TYPE_BUTTON => 'リンクボタン',
        self::BLOCK_TYPE_LINE => '区切り線',
        self::BLOCK_TYPE_SECTION_WITH_IMAGE => '画像回り込み用',

    ];

    // 枠属性リスト
    const BLOCK_TYPE_WAKU_LIST = [
        self::BLOCK_TYPE_SECTION => '枠',        
        self::BLOCK_TYPE_SECTION_FILE => 'ファイル枠',
        self::BLOCK_TYPE_SECTION_RELATION => '関連記事',
    ];

    static $block_name2number_list = [
        'BLOCK_TYPE_TITLE' => self::BLOCK_TYPE_TITLE,
        'BLOCK_TYPE_TITLE_H4' => self::BLOCK_TYPE_TITLE_H4,
        'BLOCK_TYPE_CONTENT' => self::BLOCK_TYPE_CONTENT,
        'BLOCK_TYPE_IMAGE' => self::BLOCK_TYPE_IMAGE,
        'BLOCK_TYPE_FILE' => self::BLOCK_TYPE_FILE,
        'BLOCK_TYPE_BUTTON' => self::BLOCK_TYPE_BUTTON,
        'BLOCK_TYPE_LINE' => self::BLOCK_TYPE_LINE,
        'BLOCK_TYPE_SECTION' => self::BLOCK_TYPE_SECTION,
        'BLOCK_TYPE_SECTION_WITH_IMAGE' => self::BLOCK_TYPE_SECTION_WITH_IMAGE,
        'BLOCK_TYPE_SECTION_FILE' => self::BLOCK_TYPE_SECTION_FILE,
        'BLOCK_TYPE_SECTION_RELATION' => self::BLOCK_TYPE_SECTION_RELATION,
        'BLOCK_TYPE_RELATION' => self::BLOCK_TYPE_RELATION,
    ];

    static $block_number2key_list = [
        self::BLOCK_TYPE_TITLE => 'TITLE',
        self::BLOCK_TYPE_TITLE_H4 => 'TITLE_H4',
        self::BLOCK_TYPE_CONTENT => 'CONTENT',
        self::BLOCK_TYPE_IMAGE => 'IMAGE',
        self::BLOCK_TYPE_FILE => 'FILE',
        self::BLOCK_TYPE_BUTTON => 'BUTTON',
        self::BLOCK_TYPE_LINE => 'LINE',
        self::BLOCK_TYPE_SECTION => 'SECTION',
        self::BLOCK_TYPE_SECTION_WITH_IMAGE => 'WITH_IMAGE',
        self::BLOCK_TYPE_SECTION_FILE => 'SECTION_FILE',
        self::BLOCK_TYPE_SECTION_RELATION => 'SECTION_RELATION',
        self::BLOCK_TYPE_RELATION => 'RELATION',
    ];

    static $option_default_values = [
        // self::BLOCK_TYPE_SECTION_WITH_IMAGE => ''
    ];

    public $append_fields = [];

    // 枠属性への侵入を除外するブロック
    static $out_waku_list = [
        self::BLOCK_TYPE_SECTION => [
            self::BLOCK_TYPE_RELATION,

            self::BLOCK_TYPE_SECTION,
            // self::BLOCK_TYPE_SECTION_WITH_IMAGE,
            self::BLOCK_TYPE_SECTION_FILE,
            self::BLOCK_TYPE_SECTION_RELATION,
        ],
        // self::BLOCK_TYPE_SECTION_WITH_IMAGE => [
        //     self::BLOCK_TYPE_IMAGE,
            
        //     self::BLOCK_TYPE_SECTION,
        //     self::BLOCK_TYPE_SECTION_WITH_IMAGE,
        //     self::BLOCK_TYPE_SECTION_FILE,
        //     self::BLOCK_TYPE_SECTION_RELATION
        // ],
        self::BLOCK_TYPE_SECTION_FILE => [
            self::BLOCK_TYPE_TITLE,
            self::BLOCK_TYPE_TITLE_H4,
            self::BLOCK_TYPE_CONTENT,
            self::BLOCK_TYPE_IMAGE,
            self::BLOCK_TYPE_BUTTON,
            self::BLOCK_TYPE_LINE,

            self::BLOCK_TYPE_SECTION,
            self::BLOCK_TYPE_SECTION_WITH_IMAGE,
            self::BLOCK_TYPE_SECTION_FILE,
            self::BLOCK_TYPE_SECTION_RELATION

        ],
        self::BLOCK_TYPE_SECTION_RELATION => [
            self::BLOCK_TYPE_TITLE,
            self::BLOCK_TYPE_TITLE_H4,
            self::BLOCK_TYPE_CONTENT,
            self::BLOCK_TYPE_IMAGE,
            self::BLOCK_TYPE_FILE,
            self::BLOCK_TYPE_BUTTON,
            self::BLOCK_TYPE_LINE,

            self::BLOCK_TYPE_SECTION,
            self::BLOCK_TYPE_SECTION_WITH_IMAGE,
            self::BLOCK_TYPE_SECTION_FILE,
            self::BLOCK_TYPE_SECTION_RELATION
        ]
    ];

    static function getBlockTypeList($type = 'normal') {
        if ($type == 'normal') {
            return self::BLOCK_TYPE_LIST;
        } elseif ($type == 'waku') {
            return self::BLOCK_TYPE_WAKU_LIST;
        }
    }

    static $font_list = [
        'font_style_1' => 'Noto Serif JP(明朝)',
        'font_style_2' => 'Noto Sans JP(ゴシック)',
        'font_style_3' => 'Kosugi Maru(丸ゴシック)'
    ];

    static $line_style_list = [
        'line_style_1' => '線',
        'line_style_2' => '二重線',
        'line_style_3' => '破線',
        'line_style_4' => '点線'
    ];

    static $line_color_list = [
        'line_color_1' => '赤',
        'line_color_2' => '緑',
        'line_color_3' => 'オレンジ',
        'line_color_4' => '青',
        'line_color_5' => '黒',
        'line_color_6' => 'グレー'
    ];

    static $line_width_list = [
        '1' => '1px',
        '2' => '2px',
        '3' => '3px',
        '4' => '4px',
        '5' => '5px',
        '6' => '6px',
        '7' => '7px',
        '8' => '8px',
        '9' => '9px',
        '10' => '10px'
    ];


    static $waku_color_list = [
        'waku_color_1' => '赤',
        'waku_color_2' => '緑',
        'waku_color_3' => 'オレンジ',
        'waku_color_4' => '青',
        'waku_color_5' => '黒',
        'waku_color_6' => 'グレー',
    ];

    static $waku_bgcolor_list = [
        'waku_bgcolor_1' => '赤',
        'waku_bgcolor_2' => '緑',
        'waku_bgcolor_3' => 'オレンジ',
        'waku_bgcolor_4' => '青',
        'waku_bgcolor_5' => '黒',
        'waku_bgcolor_6' => 'グレー',

    ];

    static $waku_style_list = [
        'waku_style_1' => '線',
        'waku_style_2' => '破線',
        'waku_style_3' => '点線',
        'waku_style_4' => '二重線',
        'waku_style_5' => '上下のみ',
        'waku_style_6' => '影付き'
    ];

    static $button_color_list = [
        'button_color_1' => '赤',
        'button_color_2' => '緑',
        'button_color_3' => 'オレンジ',
        'button_color_4' => '青',
        'button_color_5' => 'グレー',
    ];


    static $content_liststyle_list = [
        'liststyle_1' => '中点',
        'liststyle_2' => 'チェック',
        'liststyle_3' => '＞',
    ];

    static $link_target_list = [
        '_self' => '現在のウインドウ',
        '_blank' => '新しいウインドウ'
    ];

    static $week_strings = [
        '0' => 'SUN',
        '1' => 'MON',
        '2' => 'TUE',
        '3' => 'WED',
        '4' => 'THU',
        '5' => 'FRI',
        '6' => 'SAT'
    ];

    protected function _setMetaDescription($value) {
        return strip_tags(str_replace("\n", '', $value));
    }

    // protected function _setMetaKeywords($value) {
    //     if (array_key_exists('keywords', $this->_properties)) {
    //         $value = implode(",", array_values($this->properties['keywords']));

    //     }
        
    //     return $value;
    // }

    protected $_virtual = ['keywords'];

    protected function _getKeywords($value) {
        if (!array_key_exists('meta_keywords', (array)$this->_properties)) {
            return '';
        }
        $values = explode(',',$this->_properties['meta_keywords']);

        return $values;

    }

    static function getWeekStr($w) {
        if (array_key_exists($w, self::$week_strings)) {
            return self::$week_strings[$w];
        }

        return '';
    }

    protected function _getIsNew($value) {
        $dt = new \DateTIme();

        $dt->modify('-14 days');

        $date = $this->_properties['start_date'];
        if ($date->format('Ymd') >= $dt->format('Ymd')) {
            return 1;
        }

        return 0;
    }

    public function appendInit() {
        $this->loadModel('InfoAppendItems');
        $info = $this->_properties;

        $contain = [
            'AppendItems'
        ];
        if (empty($info)) {
            return $this->append_fields;
        }
        $data = $this->InfoAppendItems->find()->where(['InfoAppendItems.info_id' => $info['id']])->contain($contain)->all();

        if(!$data->isEmpty()) {
            foreach ($data as $cd) {
                $this->append_fields[$cd->append_item->slug] = $cd;
            }
        }
        
        return $this->append_fields;
        
    }

    public function append($field, $options= []) {
        $value = '';
        $entity = null;

        $options = array_merge([
            'result_type' => null 
        ], $options);

        if (array_key_exists($field, $this->append_fields)) {
            $entity = $this->append_fields[$field];
        }

        if (!empty($entity)) {
            switch ($entity->append_item->value_type) {
                case AppendItem::TYPE_TEXT:
                    $value = $entity->value_text;
                    break;
                case AppendItem::TYPE_TEXTAREA:
                    $value = $entity->value_textarea;
                    break;
                case AppendItem::TYPE_BOOLEAN:
                    $value = $entity->value_decimal;
                    break;
                case AppendItem::TYPE_RADIO:
                    $this->loadModel('MstLists');
                    $ltrl_val = $entity->value_key;
                    if ($options['result_type'] == 'key') {
                        $value = $ltrl_val;
                    } else {
                        $mstlist = $this->MstLists->find()->where(['sys_cd' => '1', 'use_target_id' => $entity->append_item->use_option_list, 'ltrl_val' => $ltrl_val])->first();
                        if (!empty($mstlist)) {
                            $value = $mstlist->ltrl_nm;
                        }
                    }
                    break;
                default:
                    break;
            }
        }
        
        return $value;
    }

    public function imageTag($size) {
        $image = '';
        $html = '';
        if ($this->image) {
            $image = $this->attaches['image'][$size];
        } else {
            $image = '/common/images/sample.png';
        }

        if ($image) {
            $html = '<img src="' . $image . '" alt="">';
        }

        return $html;
    }

    protected function _getSummary($data, $strlen = 0) {
        $this->loadModel('InfoContents');
        $info = $this->_properties;

        $cond = [
            'InfoContents.info_id' => $info['id'],
            'InfoContents.block_type in' => [self::BLOCK_TYPE_CONTENT, self::BLOCK_TYPE_SECTION_WITH_IMAGE, self::BLOCK_TYPE_TITLE, self::BLOCK_TYPE_TITLE_H4],
        ];

        $contents = $this->InfoContents->find()->where($cond)->order(['InfoContents.position' => 'ASC'])->all();
        
        $summary = '';
        if (!$contents->isEmpty()) {
            foreach ($contents as $content) {
                $val = strip_tags(trim($content->title));
                if (!empty($val)) {
                    $summary .= $val;
                }

                $val = strip_tags(trim($content->content));
                if (!empty($val)) {
                    $summary .= $val;
                }
            }
        }
        if ($strlen){
            $summary = mb_strimwidth($summary, 0, $strlen, '…');
        }

        return $summary;
    }

    protected function _get_schedules($data) {
        return $this->eventSchedules();
    }
    public function eventSchedules($options = []) {
        $options = array_merge([
            'before' => '<p>',
            'after' => '</p>',
            'separator' => "\n",
            'smt_br' => '<br class="show_sp">'
        ], $options);
        extract($options);

        $this->loadModel('EventSchedules');
        $info = $this->_properties;

        $cond = [
            'EventSchedules.info_id' => $info['id'],
            'EventSchedules.status' => 'publish',
        ];
        $order = ['EventSchedules.open_at' => 'ASC'];

        $schedules = $this->EventSchedules->find()->where($cond)->order($order)->all();

        $events = [];
        if (!$schedules->isEmpty()) {
            foreach ($schedules as $sche) {
                $events[] = $before . $this->_viewDate($sche->open_at,'Y年m月d日（w）') . $smt_br . $sche->open_at->format('H:i') . ' ～ ' . $sche->open_end_at->format('H:i') . $after;
            }
        }
        return implode($separator, $events);

    }

    protected function _get_startAtDate($value) {
        if (!array_key_exists('start_at', (array)$this->_properties)) {
            return '';
        }

        if (empty($this->_properties['start_at'])) {
            $dt = new \DateTime();
        } else {
            if (property_exists($this->_properties['start_at'], 'format')) {
                $dt = new \DateTime($this->_properties['start_at']->format('Y-m-d H:i:s'));
            } else {
                $dt = new \DateTime();
            }
        }

        return $dt->format('Y-m-d');
    }

    protected function _get_startAtTime($value) {
        if (!array_key_exists('start_at', (array)$this->_properties)) {
            return '';
        }

        if (empty($this->_properties['start_at'])) {
            $dt = new \DateTime();
        } else {
            if (property_exists($this->_properties['start_at'], 'format')) {
                $dt = new \DateTime($this->_properties['start_at']->format('Y-m-d H:i:s'));
            } else {
                $dt = new \DateTime();
            }
        }

        return $dt->format('H:i');   
    }

    private function _viewDate($datetime, $format = 'Y-m-d') {
        if (!is_object($datetime)) {
            $datetime = new \DateTime($datetime);
        }

        if (preg_match('/w/', $format)) {
            $weeks = [
                '0' => '日',
                '1' => '月',
                '2' => '火',
                '3' => '水',
                '4' => '木',
                '5' => '金',
                '6' => '土',
            ];
            $w = $datetime->format('w');
            $format = preg_replace('/(w)/', $weeks[$w], $format);
        }

        return $datetime->format($format);
    }

    public function getAttacheFirstImage($size = '0', $no_image='') {
        $image = $this->image;
        if (empty($image)) {
            foreach ($this->info_contents as $content) {
                if ($content->block_type == self::BLOCK_TYPE_IMAGE) {
                    $image = $content->attaches['image'][$size];
                    break;
                }
            }
        } else {
            $image = $this->attaches['image'][$size];
        }

        if (empty($image)) {
            $image = $no_image;
        }
        return $image;
    }
    public function getSummary($strlen = 0)
    {
        $this->loadModel('InfoContents');

        $cond = [
            'InfoContents.info_id' => $this->id,
            'InfoContents.block_type in' => [self::BLOCK_TYPE_CONTENT, self::BLOCK_TYPE_SECTION_WITH_IMAGE, self::BLOCK_TYPE_TITLE, self::BLOCK_TYPE_TITLE_H4],
        ];

        $contents = $this->InfoContents->find()->where($cond)->order(['InfoContents.position' => 'ASC'])->all();

        $summary = '';
        if (!$contents->isEmpty()) {
            foreach ($contents as $content) {
                $val = strip_tags(trim($content->title));
                if (!empty($val)) {
                    $summary .= $val;
                }

                $val = strip_tags(trim($content->content));
                if (!empty($val)) {
                    $summary .= $val;
                }
            }
        }
        if ($strlen){
            $summary = mb_strimwidth($summary, 0, $strlen, '…');
        }

        return $summary;
    }
}
