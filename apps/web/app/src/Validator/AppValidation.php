<?php 
namespace App\Validator;

use Cake\Validation\Validation;
use Cake\Datasource\ConnectionManager;
/**
 * 汎用バリデーション
 */
class AppValidation
{
    public static function isUnique($value, $context) {

        $field = $context['field'];
        $table = $context['providers']['table'];

        $id = 0;
        if (array_key_exists('id', $context['data']) && !empty($context['data']['id'])) {
            $id = $context['data']['id'];
        }
        $alias = $table->alias();
        $cond = [
            "{$alias}.id !=" => $id,
            "{$alias}.{$field}" => $value
        ];

        $count = $table->find()->where($cond)->count();

        if ($count == 0) {
            return true;
        } else {
            return false;
        }
    }

    public static function checkPasswordRule($value, $context) {
        $pattern = '/\A(?=\d{0,99}+[a-zA-Z\-_#\.])(?=[\-_#\.]{0,99}+[a-zA-Z\d])(?=[a-zA-Z]{0,99}+[\d\-_#\.])[a-zA-Z\d\-_#\.]{1,100}+\z/i';
        if (preg_match($pattern, $value)) {
            return true;
        } else {
            return false;
        }
    }

    public static function checkUsername($value, $context)
    {
        if (preg_match('/^[a-zA-Z][a-zA-Z0-9\-_@#]{2,29}$/', $value)) {
            return true;
        } else {
            return false;
        }
    }

    public static function checkEmail($value, $context) {
        $pattern = '/\A[a-zA-Z0-9_-]([a-zA-Z0-9_\!#\$%&~\*\+-\/\=\.]+)*@[a-zA-Z0-9-]+(\.[a-zA-Z0-9-]+)*\.([a-zA-Z]{2,20})\z/';
        if (preg_match($pattern, $value)) {
            return true;
        } else {
            return false;
        }
    }

    public static function checkPostcode($value, $context) {

        return (bool) preg_match('/[0-9]{3}-?[0-9]{4}/', $value);
    }

    public static function checkTel($value, $context) {

        return (bool) preg_match('/^(0\d{1,4}[\s-]?\d{1,4}[\s-]?\d{4})$/', $value);
    }

    public static function notEmptyAnd($value, ...$args) {
        $context = array_pop($args);

        $r = true;
        if (empty($value)) {
            $r = false;
        }
        
        foreach ($args as $col) {
            if (empty($context['data'][$col])) {
                $r = false;
                break;
            }
        }

        return $r;
    }

    public static function comparisonDate($value, ...$args) {
        $context = array_pop($args);

        $operator = $args[0];
        $column = $args[1];
        $format = $args[2];

        $start = $value;
        if (!is_object($value)) {
            $start = new \DateTime($value);
        }
        $end = $context['data'][$column];
        if (!is_object($context['data'][$column])){
            $end = new \DateTime($end);
        }

        $r = false;
        switch($operator) {
            case '>':
                if ($start->format($format) > $end->format($format)) {
                   $r = true; 
                }
                break;
            case '<':
                if ($start->format($format) < $end->format($format)) {
                    $r = true; 
                }
                break;
            case '>=':
                if ($start->format($format) >= $end->format($format)) {
                    $r = true; 
                }
                break;
            case '<=':
                if ($start->format($format) <= $end->format($format)) {
                    $r = true; 
                }
                break;
            case '!=':
                if ($start->format($format) != $end->format($format)) {
                    $r = true; 
                }
                break;
            case '=':
                if ($start->format($format) == $end->format($format)) {
                    $r = true; 
                }
                break;
        }

        return $r;
    }

    public static function checkNgWord($value, $context) {

        $sql = '
        select count(*) as `ngflag` 
        from (select "' . $value . '" as `value`) target
        where exists ( select * from ng_word_strings where target.value like concat("%",ng_word_strings.word, "%")
        )';

        $conn = ConnectionManager::get('default');
        $data = $conn->execute($sql)->fetchAll('assoc');
        $r = true;
        if (!empty($data[0]['ngflag']) && $data[0]['ngflag']) {
            $r = false;
        }

        return $r;

    }

    public function checkKana($value, $context) {
        if(preg_match("/^[ァ-ヶｦ-ﾟー\s]+$/u",$value)){
            return true;
        }else{
            return false;
        }
    }

    public function checkHira($value, $context) {
        if(preg_match("/^[ぁ-ゞー・． 　０-９]+$/u",$value)){
            return true;
        }else{
            return false;
        }
    }
}