<?php

namespace common\models;

use common\models\ar_inherit\MediaCropped;
use common\models\ar_inherit\MediaFolders;
use common\models\ar_inherit\MediaStorage;
use common\models\ar_inherit\MediaStorageCategory;
use Intervention\Image\ImageManager;
use yii;
use yii\helpers\Json;
use common\components\M;
use Exception;

class CMSH4Storage
{

    public $watermark = false; // || false
    public $to_square = true;
    public $key = '';

    private $dfs_alias = '/private';
    private $dfs_store = '/.rawdata';
    private $dfs_trash = '/.trash';

    public $mode = 'fit'; // [fit, crop]
    public $proportions = true; // [true, false]
    public $side = false; // [false, width, height]

    public $newWidth = false;
    public $newHeight = false;

    private $config = [];

    public function __construct() {
    }

    public function setConfig($config = []) {
        $this->config = $config;
        $this->mode = !empty($config['mode']) ? $config['mode'] : 'fit';
        $this->proportions = !empty($config['proportions']) ? $config['proportions'] : true;
        $this->side = !empty($config['side']) ? $config['side'] : false;
    }

    private function getMetaInfo($file) {
        if (file_exists($file) and ($info = @getimagesize($file))) {
            return ['meta' => $info];
        }
    }

    private function folder($name) {
        $r = MediaFolders::find()
            ->where(['fs_dirname' => $name])
            ->one();
        return $r;
    }

    private function rawDirRandomize() {
        $keys = range(0, 255);
        shuffle($keys);
        return sprintf('/%02x/%02x', array_rand($keys), array_rand($keys));
    }

    public function prepareDir($saveResource) {
        //M::printr($saveResource, '$saveResource');
        $dir = dirname($saveResource);
        //M::printr($dir, '$dir');
        $is_dir = is_dir($dir);
        //M::printr($is_dir, '$is_dir1');
        if (!$is_dir) {
            mkdir($dir, 0777, true);
        }
        $is_dir = is_dir($dir);
        //M::printr($is_dir, '$is_dir2');
        $is_writable = is_writable($dir);
        //M::printr($is_writable, '$is_writable');
        if (!$is_dir or !$is_writable) {
            return false;
        }
        return $dir;
    }

    /*
     * :: Сохранение ресурса ::
     *
     * - валидация ресурса
     * - генерация i8tag
     * - создание каталога h4tree
     * - перемещение ресурса в хранилище
     * - сохранение данных в базу
     *
     */

    public function store(CMSH4Resource $resource, $dev_key = 'ecm:illustrations') {
        //M::printr('store(CMSH4Resource $resource, $dev_key = \'ecm:illustrations\')');
        //M::printr('public function store(CMSH4Resource $resource)');
        $storage = Yii::getAlias('@storage');
        $store = new MediaStorage();
        $saved = false;

        $transaction = Yii::$app->db->beginTransaction();
        try {
            $i8tag = CMSI8Tag::create();

            $fs_filename = $i8tag->i8tag . '.' . $resource->extension_name;
            $fs_fullname = $this->rawDirRandomize() . '/' . $fs_filename;

            //M::xlog($resource, 'H4Storage');
            $fs_saveto = $this->dfs_store . $fs_fullname;
            //M::xlog(['$resource' => $resource, '$resource->folder' => $resource->folder], 'upload');
            //M::printr($resource, '$resource');
            $fs_alias = '/' . $resource->folder->fs_dirname . $fs_fullname;

            // сохраняем ресурс
            $path = $this->prepareDir($storage . $fs_saveto);
            //M::printr($path, '$path');
            //M::printr($storage . $fs_saveto, '$storage . $fs_saveto');
            $resSave = $resource->save($storage . $fs_saveto);
            //M::printr($resSave, '$resSave');
            if (!empty($path) and $resSave) {
                //M::printr($storage . $fs_alias, '$storage . $fs_alias');

                $path = $this->prepareDir($storage . $fs_alias);
                //M::printr($path, '$path');

                $target = "../../..{$fs_saveto}";
                if (!PRODUCTION_MODE) {
                    $target = "{$storage}{$fs_saveto}";
                }
                //M::printr($target, '$target');

                $link = "{$storage}{$fs_alias}";
                //M::printr($link, '$link');

                //M::printr('../../..' . $fs_saveto, '../../..$fs_saveto');
                //M::printr($storage . $fs_alias, '$storage . $fs_alias');
                $alias = symlink(
                    $target, //'../../..' . $fs_saveto,
                    $link //$storage . $fs_alias
                );
                if (!empty($path) and !empty($alias)) {
                    $saved = true;
                }
            }
            //M::printr($target, '$target');

            // сохраняем данные
            if ($saved) {
                $store->i8tags_ref = $i8tag->id;
                $store->media_folders_ref = $resource->folder->id;
                $store->media_content_types_ref = $resource->type->id;

                if ($resource->type->content->content_name == 'image') {
                    $store->data = Json::encode($this->getMetaInfo($target));
                }

                $md5 = md5_file($target);
                $store->fs_md5hash = $md5;
                $store->filename = $resource->filename;
                $store->fs_saveto = $fs_saveto;
                $store->fs_alias = $fs_alias;
                $store->fs_filename = $fs_filename;
                $store->fs_extension = $resource->extension_name;

                $store->fs_filesize = $resource->size;

                if (!$store->save()) {
                    throw new yii\base\Exception('Can`t save MediaStorage $store');
                }
                //M::printr($store, '$store->save()');
            }
            $transaction->commit();
        } catch (Exception $e) {
            $transaction->rollback();
            throw $e;
        }

        if (!empty($store->id)) {
            return $store;
        }

        if (0) {
            $storage = Yii::getPathOfAlias('storage');
            $store = new CmsMediaStorage;
            $transaction = Yii::app()->db->beginTransaction();
            try {

                $i8tag = CMSI8Tag::create();

                $fs_filename = $i8tag->i8tag . '.' . $resource->extension_name;
                $fs_fullname = $this->rawDirRandomize() . '/' . $fs_filename;

                //M::xlog($resource, 'H4Storage');
                $fs_saveto = $this->dfs_store . $fs_fullname;
                M::xlog(['$resource' => $resource, '$resource->folder' => $resource->folder], 'upload');
                $fs_alias = '/' . $resource
                        ->folder
                        ->fs_dirname . $fs_fullname;


                // сохраняем ресурс
                $path = $this->prepareDir($storage . $fs_saveto);
                if (!empty($path) and $resource->save($storage . $fs_saveto)) {
                    $path = $this->prepareDir($storage . $fs_alias);
                    $alias = symlink('../../..' . $fs_saveto, $storage . $fs_alias);
                    if (!empty($path) and !empty($alias)) {
                        $saved = true;
                    }
                }


                // сохраняем данные
                if (!empty($saved)) {

                    $store->cms_i8tags_ref = $i8tag->id;
                    $store->cms_media_folders_ref = $resource->folder->id;
                    $store->cms_media_content_types_ref = $resource->type->id;

                    if ($resource->type->content->content_name == 'image') {
                        $store->data = json_encode($this->getMetaInfo($storage . $fs_saveto));
                    }

                    $store->filename = $resource->filename;
                    $store->fs_saveto = $fs_saveto;
                    $store->fs_alias = $fs_alias;
                    $store->fs_filename = $fs_filename;
                    $store->fs_extension = $resource->extension_name;

                    $store->fs_filesize = $resource->size;

                    if (!$store->save()) {
                        throw new yii\base\Exception('Can`t save MediaStorage $store');
                    }

                }


                $transaction->commit();

            } catch (Exception $e) {
                $transaction->rollback();
                throw $e;
            }
            if (!empty($store->id)) {
                return $store;
            }
        }
        return false;
    }

    /*
     * :: ресайз ::
     *
     *
     */

    public function resize(MediaStorage $store, MediaStorageCategory $oStorageCategory) {
        //M::printr('resize(MediaStorage $store, MediaStorageCategory $oStorageCategory)');
        $storage = Yii::getAlias('@storage'); //getPathOfAlias('storage');
        //M::printr($store, '$store');
        if (empty($store->id)) {
            throw new Exception('Unable to load store resource');
        }

        $data = Json::decode($oStorageCategory->data);
        $width = $data['size']['width'];
        $height = $data['size']['height'];
        //M::printr([$width, $height], '$width, $height');

        //найти cropped от текущей картинки $store
        $cr = MediaCropped::find()
            ->joinWith(['cropped'])
            ->where(
                [
                    'media_storage_original_ref' => $store->id,
                    'cropped.storage_category_ref' => $oStorageCategory->id,
                ]
            )
            ->one();

        //M::printr($cr, '$cr');

        #todo отключено на время теста
        if (1) {
            if (!empty($cr->id)) {
                return $cr->cropped;
            }
        }
        $new = new MediaStorage();

        $transaction = Yii::$app->db->beginTransaction();

        try {
            $i8tag = CMSI8Tag::create();
            $fs_filename = $i8tag->i8tag . '.' . $store->fs_extension;
            $fs_fullname = $this->rawDirRandomize() . '/' . $fs_filename;

            //куда сохранить отресайзенную картинку
            $fs_saveto = $this->dfs_store . $fs_fullname;
            //M::printr($fs_saveto, '$fs_saveto');
            $fs_alias = '/th/' . $fs_filename;
            //M::printr($fs_alias, '$fs_alias');

            //Подготовить папку для файла
            $path = $this->prepareDir($storage . $fs_saveto);
            if (!empty($path) and file_exists($storage . $store->fs_saveto)) {

                //ресайз картинки новым методом
                $manager = new ImageManager(['driver' => 'imagick']);

                $iImage = $manager->make($storage . $store->fs_saveto);

                $newImage = clone $iImage;
                if ($this->mode == 'fit') {
                    //уместить картинку в холст [$width X $height]
                    $newImage = $this->fit($iImage, $width, $height);
                }
                if ($this->mode == 'none') {
                    //смасштабировать до ширины $width
                    if ($iImage->width() < $width) {
                        //если ширина изображения меньше новой ширины
                        $newCanvas = $manager->canvas($width, $iImage->height(), '#ffffff');
                        $newImage = $newCanvas->insert($iImage, 'center');
                    } else {
                        //если ширина изображения больше новой ширины
                        //коэффициент ширины изображения к новой ширине.
                        $k = $iImage->width() / $width;
                        //высота пропорционально ширине
                        $height = $iImage->height() / $k;
                        //новый холст с белым фоном
                        $newCanvas = $manager->canvas($width, $height, '#ffffff');
                        $newImage = $iImage->resize($width, $height);
                    }
                }

                //накладываем водяной знак
                if ($this->watermark) {
                    //M::printr(Yii::getAlias('@backend') . '/web' . $this->watermark, 'Yii::getAlias(\'backend\') . \'/web\' . $this->watermark');
                    //exit;
                    $newImage->insert(Yii::getAlias('@backend') . '/web' . $this->watermark, 'center');
                }

                //сохраняем картинку
                $newImage->save($storage . $fs_saveto);
                $path = $this->prepareDir($storage . $fs_alias);
                $target = "../../..{$fs_saveto}";
                if (!PRODUCTION_MODE) {
                    $target = "{$storage}{$fs_saveto}";
                }
                //M::printr($target, '$target');

                $link = "{$storage}{$fs_alias}";
                //M::printr($link, '$link');

                //M::printr('../../..' . $fs_saveto, '../../..$fs_saveto');
                //M::printr($storage . $fs_alias, '$storage . $fs_alias');
                $saved = symlink(
                    $target, //'../../..' . $fs_saveto,
                    $link //$storage . $fs_alias
                );
            }
            //M::printr($saved, '$saved');

            // сохраняем данные
            if (!empty($saved)) {
                $new->i8tags_ref = $i8tag->id;
                $new->media_folders_ref = $this->folder('th')->id;
                $new->media_content_types_ref = $store->media_content_types_ref;

                if ($store->contentType->content->content_name == 'image') {
                    $new->data = Json::encode($this->getMetaInfo($storage . $fs_saveto));
                }
                $new->fs_saveto = $fs_saveto;
                $new->fs_alias = $fs_alias;
                $new->fs_filename = $fs_filename;
                $new->fs_extension = $store->fs_extension;
                $new->filename = $store->filename;

                $md5 = md5_file($storage . $fs_saveto);
                $new->fs_md5hash = $md5;

                $new->fs_filesize = filesize($storage . $fs_saveto);
                $new->storage_category_ref = $oStorageCategory->id;
                //$new->edi_bootstrap_ref = 49;
                //M::printr($new, '$new');

                if (!$new->save()) {
                    M::printr($new->getErrors(), '$new->getErrors()');
                    throw new yii\base\Exception('Can`t save MediaStorage $new');
                }
                //$new->save();

                $cmcrop = new MediaCropped();
                $cmcrop->media_storage_original_ref = $store->id;
                $cmcrop->media_storage_cropped_ref = $new->id;
                $cmcrop->image_width = $width;
                $cmcrop->image_height = $height;
                $cmcrop->data = '{}';

                if (!$cmcrop->save()) {
                    throw new yii\base\Exception('Can`t save MediaCropped $cmcrop');
                }
            }

            $transaction->commit();

        } catch (\Exception $e) {
            $transaction->rollback();
            throw $e;
        }

        if (!empty($new->id)) {
            return $new;
        }

    }

    public function fit($srcImage, $width, $height) {
        //создаем новый холст
        $manager = new ImageManager(['driver' => 'imagick']);
        $newCanvas = $manager->canvas($width, $height, '#ffffff');

        $k = 1;
        //если ширина больше новой, то уменьшить до вместимости
        $newImage = clone $srcImage;
        if ($srcImage->width() > $width) {
            $k = $srcImage->width() / $width;
            $newWidth = $width;
            //посчитать высоту с таким же коэффициентом
            $newHeight = $srcImage->height() / $k;
            $newImage = $srcImage->resize($newWidth, $newHeight);
        }

        //если после этого высота больше новой, то уменьшить до вместимости
        if ($srcImage->height() > $height) {
            $k = $srcImage->height() / $height;
            $newHeight = $height;
            //посчитать высоту с таким же коэффициентом
            $newWidth = $srcImage->width() / $k;
            $newImage = $srcImage->resize($newWidth, $newHeight);
        }

        $newCanvas->insert($newImage, 'center');
        return $newCanvas;
    }

    public function crop($srcImage, $width, $height) {
        //увеличить картинку, чтоб заполнить холст с сохранением пропорций, лишку отрезать

        return $srcImage;
    }

}


