<?php
namespace App\Model\Table;

use Cake\ORM\Table;
use Cake\Filesystem\Folder;
use Cake\Utility\Text;
use Cake\Datasource\ConnectionManager;
use Cake\ORM\Entity;

class AppTable extends Table {

    public function initialize(array $config): void
    {
        // 作成日時と更新日時の自動化
        $this->addBehavior('Timestamp',[
            'events' => [
                'Model.beforeSave' => [
                    'created' => 'new',
                    'modified' => 'always'
                ]
            ]
        ]);
    }

    // cakePHP2と互換性を保つためにcreateを自前で作る
    public function create($data) {

        $entity = $this->createEntity()->toArray();

        return $entity;
    }
    public function createEntity($data=null) {

        if (is_null($data)) {
            $data = $this->defaultValues;
        }
        $entity = $this->newEntity($data);

        return $entity;
    }

    public function toFormData($query) {

        $data = $query->toArray();

        return $data;
    }

    public function copyPreviewAttachement($source_id, $distModel) {
        // コピー元
        $source = $this->find()->where([$this->getAlias() . '.id' => $source_id])->first();

        if (empty($source) ) {
            return false;
        }

        // 画像
        $basedir = UPLOAD_DIR . $this->getAlias() . DS . 'images' . DS;
        $distDir = UPLOAD_DIR . $distModel . DS . 'images' . DS;

        $image_columns = $this->attaches['images'];

        $r = true;

        if (!empty($image_columns)) {
            foreach ($image_columns as $column => $imageConfig) {
                if (empty($source->attaches[$column])) {
                    continue;
                }
                foreach ($source->attaches[$column] as $path) {
                    if (empty($path)) {
                        continue;
                    }
                    $copy = WWW_ROOT . ltrim($path,'/');
                    $dist = str_replace($basedir, $distDir, $copy);
                    copy($copy, $dist);
                }
            }
        }

        // ファイル

        $basedir = UPLOAD_DIR . $this->getAlias() . DS . 'files' . DS;
        $distDir = UPLOAD_DIR . $distModel . DS . 'files' . DS;

        $file_columns = $this->attaches['files'];

        if (!empty($file_columns)) {
            foreach ($file_columns as $column => $config) {
                if (empty($source->attaches[$column])) {
                    continue;
                }
                $src = $source->attaches[$column]['src'];
                if (empty($src)) {
                    continue;
                }
                $copy = WWW_ROOT . ltrim($src,'/');
                $dist = str_replace($basedir, $distDir, $copy);
                copy($copy, $dist);
            }
        }

        return $r;

    }

    // public function copyFile($id) {
    //     $table = str_replace('preview_', '', $this->getTable());
    //     $preview_table = 'preview_' . $table;

    //     $sql = 'select * from ' . $table;
    //     $sql .= ' where id = :id';

    //     $bind = ['id' => $id];
    //     $dataType = ['id' => 'integer'];

    //     $source = $this->_exec($sql, $bind, $dataType);

    //     if (empty($source)) {
    //         return;
    //     }




    // }

    private function _exec($sql, $bind, $dataType) {
        $conn = ConnectionManager::get('default');
        $stmt = $conn->prepare($sql);
        $stmt->bind($bind, $dataType);

        $stmt->execute();
        $datas = $stmt->fetchAll('assoc');

        return $datas;
    }

    public function checkDateFormat($value,$context){
        $date = str_replace('/','-',$value);
        if(preg_match('/\A\d{4}-\d{2}-\d{2}\z/',$date,$match)){
            $nums = explode('-',$match[0]);
            if(checkdate($nums[1],$nums[2],$nums[0])){
                return true;
            }
        }
        return false;
    }
        protected function numericConv(\ArrayObject $data, $col, $options = [])
    {
        $options = array_merge([
            'mul' => 0,
            'empty' => 0,
            'isKeep' => false
        ], $options);
        extract($options);

        if (!empty($data[$col])) {
            $data[$col] = mb_convert_kana($data[$col], 'a');
            if ($mul) {
                $data[$col] = $data[$col] * $mul;
            }
        } else {
            if ($isKeep) {
                return;
            }
            $data[$col] = 0;
        }

        if (empty($data[$col])) {
            $data[$col] = $empty;
        }
    }
    protected function numericConvEntity(Entity $data, $col, $options = [])
    {
        $options = array_merge([
            'mul' => 0,
            'empty' => 0
        ], $options);
        extract($options);

        if (!empty($data->{$col})) {
            $data->{$col} = mb_convert_kana($data->{$col}, 'a');
            if ($mul) {
                $data->{$col} = $data->{$col} * $mul;
            }
        } else {
            $data->{$col} = 0;
        }

        if (empty($data->{$col})) {
            $data->{$col} = $empty;
        }
    }

    protected function optSum($name, \ArrayObject $data, $empty = '', $isHex = false)
    {
        if (!$data->offsetExists($name)) {
            return $empty;
        }
        $bits = (array)$data->offsetGet($name);
        $amount = 0;
        if (!empty($bits)) {
            foreach ($bits as $v) {
                if ($isHex) {
                    $v = hexdec($v);
                }
                $amount += (is_numeric($v) ? $v : 0);
            }
        }
        return $amount;
    }
    protected function _getMultiples($data, $isHex = false) : Array
    {
        $res = [];
        for ($i = 1; $i <= $data; $i = $i * 2) {
            if ($i & $data) {
                $val = $i;
                if ($isHex) {
                    $val = sprintf("0x%0{$isHex}x", $i);
                }
                $res[] = $val;
            }
        }

        return $res;
    }
}