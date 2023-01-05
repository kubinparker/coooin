<?php
namespace App\View\Helper;

use Cake\View\Helper\HtmlHelper;
use App\Lib\Util;

class MyHtmlHelper extends HtmlHelper
{
    public function getFullUrl($url) {
        $host = $this->Url->build('/', true);

        if (substr($url, 0, 1) == '/') {
            $url = substr($url, 1);
        }

        return $host . $url;
    }

    public function questionView($content) {
        $content = nl2br(h($content));

        $pattern = '/((?:https?|ftp):\/\/[-_.!~*\'()a-zA-Z0-9;\/?:@&=+$,%#]+)/';
        $replace = '<a href="$1">$1</a>';
        $content = preg_replace( $pattern, $replace, $content);

        return $content;
    }

    public function view($val, $options = array()) {

        $options = array_merge(array('before' => '',
                               'after' => '',
                               'default' => '',
                               'empty' => '',
                               'nl2br' => false,
                               'h' => true,
                               'emptyIsZero' => false,
                               'price_format' => false,
                               'decimal' => 0 //price_format=true時の小数点以下桁数
                           ),
                               $options);
        extract($options);

        if ($emptyIsZero && intval($val) === 0) {
            $val = "";
        }

        if ($val && $price_format) {
            $cost = $val;
            $cost = number_format($cost, $decimal);  // 1,234.50
            $cost = (preg_match('/\./', $cost)) ? preg_replace('/\.?0+$/', '', $cost) : $cost; // 末尾の０は消す
            $val = $cost;
            if (empty($val) && !$emptyIsZero) {
                $val = '0';
            }
        }

        if ($val != "") {
            if (!$price_format) {
                if ($h) {
                    $val = h($val);
                }
                if ($nl2br) {
                    $val = nl2br($val);
                }
            }
            return $before.$val.$after;
        }

        return $default.$empty;
    }

    public function viewDate($datetime, $format = 'Y-m-d') {
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

    public function exUrl($url, $args = []) {

        if (empty($args)) {
            return $url;
        }

        foreach ($args as $key => $value) {
            $url = str_replace('[%' . $key . '%]', $value, $url);
        }

        return $url;

    }
    public function free_space() {
      $free = disk_free_space('/');

      return $this->filesize($free);
    }

    public function filesize($size) {
      $size = max(0, (int)$size);
      $units = array( 'B', 'KB', 'MB', 'GB', 'TB', 'PB', 'EB', 'ZB', 'YB');
      $power = $size > 0 ? floor(log($size, 1024)) : 0;
      return number_format($size / pow(1024, $power), 2, '.', ',') . $units[$power];
    }

    public function getPrice($item, $tax_rate = 0, $is_sale=false, $resultType='price_in_tax') {

      return Util::getPrice($item, $tax_rate, $is_sale, $resultType);
    }

    public function getPriceInTax($price, $tax_rate) {
      $tax = Util::calcTax($price, $tax_rate);
      return $price + $tax;
    }

    public function postcode($postcode)
    {
      $zip = str_replace('-', '', $postcode);
      return substr($zip ,0,3) . "-" . substr($zip ,3);
    }
}