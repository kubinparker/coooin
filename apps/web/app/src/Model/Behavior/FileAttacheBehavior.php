<?php 
namespace App\Model\Behavior;

use ArrayObject;
use Cake\Datasource\EntityInterface;
use Cake\Event\EventInterface;
use Cake\ORM\Behavior;
use Cake\ORM\Entity;
use Cake\ORM\Query;
use Cake\Utility\Text;
use Cake\Filesystem\Folder;
use Cake\Event\EventManager;
use Cake\Core\Configure;

class FileAttacheBehavior extends Behavior 
{
    // true = uploadedFileオブジェクト, false = 従来通りの配列
    const IS_FILE_OBJECT = true;

    public $uploadDirCreate = true;
    public $uploadDirMask = 0777;
    public $uploadFileMask = 0666;

    //ImageMagick configure
    public $convertPath = ''; // Initializeで設定しているよ
    public $convertParams = '-thumbnail';

    protected $_defaultConfig = array(
        'uploadDir' => null,
        'wwwUploadDir' => null,
    );

    public $uploadDir = '';
    public $wwwUploadDir = '';

    public function initialize(array $config) : void
    {
        $Model = $this->getTable();
        $entity = $this->getTable()->newEntity([]);
        $entity->setVirtual(['attaches']);

        $this->_config = $config + $this->_defaultConfig;

        $this->uploadDir = UPLOAD_DIR . $Model->getAlias();
        $this->wwwUploadDir = '/' . UPLOAD_BASE_URL . '/' . $Model->getAlias();

        if (!empty($config['uploadDir'])) {
            $this->uploadDir = $config['uploadDir'];
        }
        if (!empty($config['wwwUploadDir'])) {
            $this->wwwUploadDir = $config['wwwUploadDir'];
        }

        $this->convertPath = Configure::read('convert_path');
    }

    private function setPath() {
        if (!empty($this->_config['uploadDir'])) {
            $this->uploadDir = $this->_config['uploadDir'];
        }
        if (!empty($this->_config['wwwUploadDir'])) {
            $this->wwwUploadDir = $this->_config['wwwUploadDir'];
        }
    }

    public function beforeMarshal(EventInterface $event, ArrayObject $data, ArrayObject $options)
    {
        $this->setPath();

        $table = $event->getSubject();
        // images
        if (array_key_exists('images', $table->attaches)) {
            $attache_image_columns = $table->attaches['images'];
            foreach ($attache_image_columns as $column => $val) {
                if (array_key_exists($column,$data)) {
                    if (is_object($data[$column])) {
                        $data['_'.$column] = clone $data[$column];
                    } else {
                        $data['_'.$column] = null;
                    }
                }
                $data[$column] = '';
                if ((empty($data[$column]) || $data[$column]->getError() != UPLOAD_ERR_OK) && array_key_exists('_old_'.$column,$data) && $data['_old_'.$column] != "") {
                    $data[$column] = $data['_old_'.$column];
                }

            }
        }
        // files
        if (array_key_exists('files', $table->attaches)) {
            $attache_image_columns = $table->attaches['files'];
            foreach ($attache_image_columns as $column => $val) {
                if (array_key_exists($column,$data)) {
                    if (is_object($data[$column])) {
                        $data['_'.$column] = clone $data[$column];
                    } else {
                        $data['_'.$column] = null;
                    }
                }
                $data[$column] = '';
                if ((empty($data[$column]) || $data[$column] != UPLOAD_ERR_OK) && array_key_exists('_old_'.$column,$data) && $data['_old_'.$column] != "") {
                    $data[$column] = $data['_old_'.$column];
                }
            }
        }
    }

    public function beforeFind(EventInterface $event, Query $query, ArrayObject $options, $primary)
    {
        $this->setPath();

        $table = $event->getSubject();
        // afterFindの代わり
        $query->formatResults(function($results) use($table, $primary) {
            return $results->map(function($row) use($table, $primary) {
                if (is_object($row) && !array_key_exists('existing', $row->toArray())) {
                    $results = $this->_attachesFind($table, $row, $primary);
                }
                return $row;
            });
         });
    }

    public function afterSave(EventInterface $event, EntityInterface $entity, ArrayObject $options)
    {   
        $this->setPath();

        //アップロード処理
        $this->_uploadAttaches($event, $entity);
    }

    public function checkUploadDirectory($table) 
    {
        $this->setPath();
        
        $Folder = new Folder();

        if ($this->uploadDirCreate) {
            $dir = $this->uploadDir . DS .'images';
            if (!is_dir($dir) && !empty($table->attaches['images'])) {
                if (!$Folder->create($this->uploadDir . DS .'images', $this->uploadDirMask)) {

                }
            }

            $dir = $this->uploadDir . DS .'files';
            if (!is_dir($dir) && !empty($table->attaches['files'])) {
                if (!$Folder->create($dir, $this->uploadDirMask)) {

                }
            }
        }
    }

    protected function _attachesFind($table, $results, $primary = false) {
        $this->checkUploadDirectory($table);
        $_att_images = array();
        $_att_files = array();
        if (!empty($table->attaches['images'])) {
            $_att_images = $table->attaches['images'];
        }
        if (!empty($table->attaches['files'])) {
            $_att_files = $table->attaches['files'];
        }
        $entity = $results;
        // foreach ($results as $entity) {
            $columns = null;

            $entity->setVirtual(['attaches']);
            $_ = $entity->toArray();
            $entity_attaches = [];
            //image
            foreach ($_att_images as $columns => $_att) {
                $_attaches = array();
                if (isset($_[$columns])) {
                    $_attaches['0'] = '';
                    $_file = $this->wwwUploadDir . '/images/' . $_[$columns];
                    if (is_file(WWW_ROOT . $_file)) {
                        $_attaches['0'] = $_file;
                    }
                    if (!empty($_att['thumbnails'])) {
                        foreach ($_att['thumbnails'] as $_name => $_val) {
                            $key_name = (!is_int($_name))? $_name: $_val['prefix'];
                            $_attaches[$key_name] = '';
                            $_file = $this->wwwUploadDir . '/images/' . $_val['prefix'] . $_[$columns];
                            if (!empty($_[$columns]) && is_file(WWW_ROOT . $_file)) {
                                $_attaches[$key_name] = $_file;
                            }
                        }
                    }
    // pr($_attaches);
                    $entity_attaches[$columns] = $_attaches;
                }
            }
            //file
            foreach ($_att_files as $columns => $_att) {
                $def = array('0', 'src', 'extention', 'name', 'download');
                $def = array_fill_keys($def, null);

                if (isset($_[$columns])) {
                    $_attaches = $def;
                    $_file = $this->wwwUploadDir . '/files/' . $_[$columns];
                    if (is_file(WWW_ROOT . $_file)) {
                        $_attaches['0'] = $_file;
                        $_attaches['src'] = $_file;
                        $_attaches['extention'] = $this->getExtension($_[$columns . '_name']);
                        $_attaches['name'] = $_[$columns . '_name'];
                        $_attaches['size'] = $_[$columns . '_size'];
                        $download_dir = $table->getAlias();
                        if ($download_dir == 'InfoContents') {
                            $download_dir = 'Contents';
                        }
                        $_attaches['download'] = DS . $download_dir . '/file/' . $_[$table->getPrimaryKey()] . '/' . $columns . '/';
                    }
                    $entity_attaches[$columns] = $_attaches;
                }
            }
            $entity->attaches = $entity_attaches;
        // }
        return $results;
    }

    public function _uploadAttaches(EventInterface $event, EntityInterface $entity) {
        $table = $event->getSubject();
        $this->checkUploadDirectory($table);

        $uuid = Text::uuid();

        // $table->eventManager()->off('Model.afterSave');

        if (!empty($entity)) {
            $_data = $entity->toArray();
            $id = $entity->id;
            $query = $table->find()->where([$table->getAlias().'.'.$table->getPrimaryKey() => $id]);
            $old_entity = $query->first();
            $old_data = $old_entity->toArray();

            $_att_images = array();
            $_att_files = array();
            if (!empty($table->attaches['images'])) {
                $_att_images = $table->attaches['images'];
            }
            if (!empty($table->attaches['files'])) {
                $_att_files = $table->attaches['files'];
            }
            //upload images
            foreach ($_att_images as $columns => $val) {
                $image_name = null;
                if (!empty($_data['_'.$columns])) {
                    $image_name = clone $_data['_'.$columns];
                }
                if (empty($image_name)) {
                    continue;
                }

                if ($image_name->getError() == UPLOAD_ERR_OK) {
                    $basedir = $this->uploadDir . DS . 'images' . DS;
                    $imageConf = $_att_images[$columns];
                    $ext = $this->getExtension($image_name->getClientFilename());
                    $filepattern = $imageConf['file_name'];
                    if ($image_name->getSize()){
                        //画像 処理方法
                        $convert_method = (!empty($imageConf['method']))? $imageConf['method']: null;
                        
                        if (in_array($ext, $imageConf['extensions'])) {
                            $newname = sprintf($filepattern, $id, $uuid) . '.' . $ext;
                            $this->convert_img($imageConf['width'].'x'.$imageConf['height'],
                                               $image_name->getStream()->getMetadata('uri'),
                                               $basedir . $newname,
                                               $convert_method);

                            //サムネイル
                            if (!empty($imageConf['thumbnails'])) {
                                foreach ($imageConf['thumbnails'] as $suffix => $val) {
                                    //画像処理方法
                                    $convert_method = (!empty($val['method']))? $val['method']: null;
                                    //ファイル名
                                    $prefix = (!empty($val['prefix']))? $val['prefix']: $suffix;
                                    $_newname = $prefix.$newname;
                                    //変換
                                    $this->convert_img($val['width'].'x'.$val['height'],
                                                       $image_name->getStream()->getMetadata('uri'),
                                                       $basedir . $_newname,
                                                       $convert_method);
                                }
                            }
                            //
                            // $_data[$columns] = $newname;
                            $old_entity->set($columns, $newname);
                            // $table->patchEntity($entity, $_data, ['validate' => false]);
                            $table->save($old_entity);

                            // 旧ファイルの削除
                            if (!empty($old_data['attaches'][$columns])) {
                                foreach ($old_data['attaches'][$columns] as $image_path) {
                                    if ($image_path && is_file(WWW_ROOT . $image_path)) {
                                        @unlink(WWW_ROOT . $image_path);
                                    }
                                }
                            }
                        }
                    }
                }
            }
            if (!empty($_att_files)) {
                //upload files
                foreach ($_att_files as $columns => $val) {
                    $file_name = null;
                    if (!empty($_data['_'.$columns])) {
                        $file_name = clone $_data['_'.$columns];
                    }
                    if (empty($file_name)) {
                        continue;
                    }
                    if ($file_name->getError() === UPLOAD_ERR_OK) {
                        $basedir = $this->uploadDir . DS . 'files' . DS;
                        $fileConf = $_att_files[$columns];
                        $ext = $this->getExtension($file_name->getClientFilename());
                        $filepattern = $fileConf['file_name'];

                        if (in_array($ext, $fileConf['extensions'])) {
                            $newname = sprintf($filepattern, $id, $uuid) . '.' . $ext;
                            move_uploaded_file($file_name->getStream()->getMetadata('uri'), $basedir . $newname);
                            chmod($basedir . $newname, $this->uploadFileMask);

                            // $_data[$columns] = $newname;
                            // $_data[$columns.'_name'] = $file_name['name'];
                            // $_data[$columns.'_size'] = $file_name['size'];
                            $old_entity->set($columns, $newname);
                            $old_entity->set($columns.'_name', $this->getFileName($file_name->getClientFilename(), $ext));
                            $old_entity->set($columns.'_size', $file_name->getSize());
                            $old_entity->set($columns.'_extension', $ext);
                            // $table->patchEntity($entity, $_data, ['validate' => false]);
                            $table->save($old_entity);

                            // 旧ファイルの削除
                            if (!empty($old_data['attaches'][$columns])) {
                                foreach ($old_data['attaches'][$columns] as $file_path) {
                                    if ($file_path && is_file(WWW_ROOT . $file_path)) {
                                        @unlink(WWW_ROOT . $file_path);
                                    }
                                }
                            }
                        }

                    }
                }

            }
            // $table->addBehavior('Position');
        }
    }

    /**
     * 拡張子の取得
     * */
    public function getExtension($filename) {
        return strtolower(substr(strrchr($filename, '.'), 1));
    }
    public function getFileName($filename, $ext) {
        return str_replace('.' . $ext, '', $filename);
    }

    /**
     * ファイルアップロード
     * @param $size [width]x[height]
     * @param $source アップロード元ファイル(フルパス)
     * @param $dist 変換後のファイルパス（フルパス）
     * @param $method 処理方法
     *        - fit     $size内に収まるように縮小
     *        - cover   $sizeの短い方に合わせて縮小
     *        - crop    cover 変換後、中心$sizeでトリミング
     * */
    public function convert_img($size, $source, $dist, $method = 'fit') {
        list($ow, $oh, $info) = getimagesize($source);
        $sz = explode('x', $size);
        $cmdline = $this->convertPath;
        //サイズ指定ありなら
        if (0 < $sz[0] && 0 < $sz[1]) {
            if ($ow <= $sz[0] && $oh <= $sz[1]) {
                //枠より完全に小さければ、ただのコピー
                $size = $ow . 'x' . $oh;
                $option = $this->convertParams . ' ' . $size . '>';
            } else {
                //枠をはみ出していれば、縮小
                if($method === 'cover' || $method === 'crop'){
                    //中央切り取り
                    $crop = $size;
                    if(($ow / $oh) <= ($sz[0] / $sz[1])){
                        //横を基準
                        $size = $sz[0] . 'x';
                    } else {
                        //縦を基準
                        $size = 'x' . $sz[1];
                    }

                    //cover
                    $option = '-thumbnail ' . $size . '>';

                    //crop
                    if ($method === 'crop') {
                        $option .= ' -gravity center -crop ' . $crop . '+0+0';
                    }
                } else {
                    //通常の縮小 拡大なし
                    $option = $this->convertParams . ' ' . $size . '>';
                }
            }
        } else {
            //サイズ指定なしなら 単なるコピー
            $size = $ow . 'x' . $oh;
            $option = $this->convertParams . ' ' . $size . '>';
        }
        $a = system(escapeshellcmd($cmdline . ' ' . $option . ' ' . $source . ' ' . $dist));
        @chmod($dist, $this->uploadFileMask);
        return $a;
    }
}