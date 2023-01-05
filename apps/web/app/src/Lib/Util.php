<?php

namespace App\Lib;

class Util
{

    // public function __construct()
    // {
    //     $this->loadModel('Taxes');
    // }
    /**
     * 端数処理
     * @param [type] $value [description]
     */
    static function Round($number, $decimal = 0, $type = 1)
    {

        $res = $number;
        // 四捨五入
        if ($type == 0) {
            $res = round($number, $decimal);
            // 切り捨て
        } elseif ($type == 1) {
            $rate = 1;
            if ($decimal > 0) {
                for ($i = 0; $i < $decimal; $i++) {
                    $rate = $rate * 10;
                }
                $number = $number * $rate;
            }
            $res = floor($number);

            if ($decimal > 0) {
                $rate = 1;
                for ($i = 0; $i < $decimal; $i++) {
                    $rate = $rate * 0.1;
                }
                $res = $res * $rate;
            }
            // 切り上げ
        } elseif ($type == 2) {
            $rate = 1;
            if ($decimal > 0) {
                for ($i = 0; $i < $decimal; $i++) {
                    $rate = $rate * 10;
                }
                $number = $number * $rate;
            }
            $res = ceil($number);

            if ($decimal > 0) {
                $rate = 1;
                for ($i = 0; $i < $decimal; $i++) {
                    $rate = $rate * 0.1;
                }
                $res = $res * $rate;
            }
        }

        return $res;

    }

    static function wareki($date)
    {
        $ymd = (new \DateTime($date))->format('Ymd');
        $y = (new \DateTime($date))->format('Y');

        if ($ymd >= '20190501') {
            $ret = array(
                'era' => '令和',
                'short' => '令',
                'alphabet' => 'R',
                'year' => $y - 2019 + 1
            );
        } elseif ($ymd >= '19890108') {
            $ret = array(
                'era' => '平成',
                'short' => '平',
                'alphabet' => 'H',
                'year' => $y - 1989 + 1
            );
        } else {
            $ret = array(
                'era' => '昭和',
                'short' => '昭',
                'alphabet' => 'S',
                'year' => $y - 1926 + 1
            );
        }

        if ($ret['year'] == 1) {
            $ret['year'] = '元';
        }

        return $ret;
    }

    /**
     * 割り算
     * @param $value1
     * @param $value2
     * @param $decimal
     * @return false|float|int|mixed
     */
    static function calcDiv($value1, $value2, $decimal = 0)
    {

        if (empty($value1)) {
            $value1 = 0;
        }
        if (empty($value2)) {
            $value2 = 0;
        }

        //
        if (function_exists('bcdiv')) {

            $result = bcdiv(strval($value1), strval($value2), 6);
        } else {
            $result = (float)$value1 / (float)$value2;
        }
        $result = self::Round($result, $decimal);

        return $result;
    }

    static function calcMul($value1, $value2, $decimal = 0)
    {

        if (empty($value1)) {
            $value1 = 0;
        }
        if (empty($value2)) {
            $value2 = 0;
        }

        // 消費税
        if (function_exists('bcmul')) {
            $result = bcmul(strval($value1), strval($value2), 6);
        } else {
            $result = (float)$value1 * (float)$value2;
        }
        $result = self::Round($result, $decimal);

        return $result;
    }

    static function calcTax($price, $tax_rate = 0, $decimal = 0)
    {

        // 消費税
        if (function_exists('bcmul')) {
            $rate = bcmul(strval($tax_rate), '0.01', 2);
            $tax = bcmul(strval($price), strval($rate), 2);
        } else {
            $rate = (float)$tax_rate * 0.01;
            $tax = (float)$price * $rate;
        }
        $tax = self::Round($tax, $decimal);

        return $tax;
    }

    static function getPrice($item, $tax_rate = 0, $is_sale = false, $resultType = 'price_in_tax', $include_shipping = true)
    {

        $result = 0;
        if (!empty($item->shop_items)) {
            foreach ($item->shop_items as $val) {
                $result = $val->price;
                break;
            }
        } else {
            $result = $item->price;
        }

        if ($is_sale && $result && $item->is_sales && $item->sale_discount) {
            $rate = self::calcMul(strval(0.01), strval($item->sale_discount), 2);
            $tmp = self::calcMul(strval($result), strval($rate));
            $result = $result - $tmp;
        }

        if ($resultType == 'price_in_tax') {
            $in_tax = self::calcTax($result, $tax_rate);
            $result = $result + $in_tax;
        } elseif ($resultType == 'in_tax') {
            $in_tax = self::calcTax($result, $tax_rate);
            $result = $in_tax;
        } else {

        }

        if ($include_shipping) {
            $result = $result + $item->shipping;
        }

        return $result;
    }

    static function dateEmpty($value)
    {
        $r = false;

        if ( $value == DATE_ZERO) {
            $r = true;
        }

        if (empty($value)) {
            $r = true;
        }

        return $r;

    }

    static function addressZenkaku($prefecture, $address)
    {
        $text = '';

        if (!empty($prefecture)) {
            $text = $prefecture;
        }
        $text .= mb_convert_kana($address, 'SKHVA');

        return $text;
    }
}