<?php

namespace App\Controller\Component;

use Cake\Controller\Component;
use Cake\Controller\ComponentRegistry;
use Cake\Datasource\ModelAwareTrait;
use Cake\Utility\Inflector;
use Cake\Utility\Text;
use Cake\Filesystem\Folder;
use Cake\Core\Configure;

use App\Model\Entity\Info;

/**
 * バイナリイメージを保存できるぞ
 */
class FileAttacheComponent extends Component
{
    public $uploadDirCreate = true;
    public $uploadDirMask = 0777;
    public $uploadFileMask = 0666;

    //ImageMagick configure
    public $convertPath = ''; // initializeで設定しているよ
    public $convertParams = '-thumbnail';

    /**
     * Default configuration.
     *
     * @var array
     */
    protected $_defaultConfig = [];

    use ModelAwareTrait;

    public function initialize(array $config): void
    {

        $this->Controller = $this->_registry->getController();
        $this->Session = $this->Controller->getRequest()->getSession();
        $this->ModelName = $this->Controller->modelName;
        $this->loadModel($this->ModelName);
        $this->Model = $this->{$this->ModelName};

        $this->_config = $config + $this->_defaultConfig;

        $this->uploadDir = UPLOAD_DIR . $this->Model->getAlias();
        $this->wwwUploadDir = '/' . UPLOAD_BASE_URL . '/' . $this->Model->getAlias();

        if (!empty($config['uploadDir'])) {
            $this->uploadDir = $config['uploadDir'];
        }
        if (!empty($config['wwwUploadDir'])) {
            $this->wwwUploadDir = $config['wwwUploadDir'];
        }

        $this->convertPath = Configure::read('convert_path');

    }

    private function setPath()
    {
        if (!empty($this->_config['uploadDir'])) {
            $this->uploadDir = $this->_config['uploadDir'];
        }
        if (!empty($this->_config['wwwUploadDir'])) {
            $this->wwwUploadDir = $this->_config['wwwUploadDir'];
        }
    }

    public function saveBinaryImage($entity, $column, $binary)
    {
        // 一時ディレクトリに画像ファイルとして保存
        $binaries = explode(';base64,', $binary);
        $data = base64_decode($binaries[1]);
        $path = tempnam(sys_get_temp_dir(), '');
        file_put_contents($path, $data);

        $image_name = [
            'tmp_name' => $path,
            'name' => $entity->image_name,
            'error' => UPLOAD_ERR_OK
        ];

        $table = $this->Model;

        $this->checkUploadDirectory($table);

        $uuid = Text::uuid();

        // $table->eventManager()->off('Model.afterSave');

        if (!empty($entity)) {
            $id = $entity->id;
            $query = $table->find()->where([$table->getAlias() . '.' . $table->getPrimaryKey() => $id]);
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
            if (!empty($image_name['tmp_name']) && $image_name['error'] === UPLOAD_ERR_OK) {
                $basedir = $this->uploadDir . DS . 'images' . DS;
                $imageConf = $_att_images[$column];
                $ext = $this->getExtension($image_name['name']);
                $filepattern = $imageConf['file_name'];
                $file = $image_name;
                if ($info = getimagesize($file['tmp_name'])) {
                    //画像 処理方法
                    $convert_method = (!empty($imageConf['method'])) ? $imageConf['method'] : null;

                    if (in_array($ext, $imageConf['extensions'])) {
                        $newname = sprintf($filepattern, $id, $uuid) . '.' . $ext;
                        $this->convert_img($imageConf['width'] . 'x' . $imageConf['height'],
                            $file['tmp_name'],
                            $basedir . $newname,
                            $convert_method);

                        //サムネイル
                        if (!empty($imageConf['thumbnails'])) {
                            foreach ($imageConf['thumbnails'] as $suffix => $val) {
                                //画像処理方法
                                $convert_method = (!empty($val['method'])) ? $val['method'] : null;
                                //ファイル名
                                $prefix = (!empty($val['prefix'])) ? $val['prefix'] : $suffix;
                                $_newname = $prefix . $newname;
                                //変換
                                $this->convert_img($val['width'] . 'x' . $val['height'],
                                    $file['tmp_name'],
                                    $basedir . $_newname,
                                    $convert_method);
                            }
                        }
                        //
                        // $_data[$column] = $newname;
                        $old_entity->set($column, $newname);
                        // $table->patchEntity($entity, $_data, ['validate' => false]);
                        $table->save($old_entity);

                        // 旧ファイルの削除
                        if (!empty($old_data['attaches'][$column])) {
                            foreach ($old_data['attaches'][$column] as $image_path) {
                                if ($image_path && is_file(WWW_ROOT . $image_path)) {
                                    @unlink(WWW_ROOT . $image_path);
                                }
                            }
                        }
                    }
                }

            }

        }
    }

    public function checkUploadDirectory($table)
    {
        $this->setPath();

        $Folder = new Folder();

        if ($this->uploadDirCreate) {
            $dir = $this->uploadDir . DS . 'images';
            if (!is_dir($dir) && !empty($table->attaches['images'])) {
                if (!$Folder->create($this->uploadDir . DS . 'images', $this->uploadDirMask)) {

                }
            }

            $dir = $this->uploadDir . DS . 'files';
            if (!is_dir($dir) && !empty($table->attaches['files'])) {
                if (!$Folder->create($dir, $this->uploadDirMask)) {

                }
            }
        }
    }

    public function getExtension($filename)
    {
        return strtolower(substr(strrchr($filename, '.'), 1));
    }

    public function convert_img($size, $source, $dist, $method = 'fit')
    {
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
                if ($method === 'cover' || $method === 'crop') {
                    //中央切り取り
                    $crop = $size;
                    if (($ow / $oh) <= ($sz[0] / $sz[1])) {
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