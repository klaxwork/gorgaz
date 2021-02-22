<?php

namespace common\models\models;

use common\components\M;
use common\models\CMSH4Resource;
use common\models\CMSH4Storage;
use common\models\ar\RArCmsMediaStorage;
use common\models\models\EdiBootstrap;
use common\models\models\AppGallery;
use common\models\models\EcmProductHasGallery;
use Yii;
use yii\base\Exception;
use yii\helpers\Json;

/**
 * This is the model class for table "cms_media_storage".
 *
 * @property int $id
 * @property int $cms_i8tags_ref
 * @property int $cms_media_folders_ref
 * @property int $cms_media_content_types_ref
 * @property string $title
 * @property string $description
 * @property string $data
 * @property string $fs_saveto
 * @property string $fs_alias
 * @property string $fs_filename
 * @property string $fs_md5hash
 * @property int $fs_filesize
 * @property string $dt_created
 * @property string $dt_updated
 * @property bool $is_trash
 * @property string $fs_extension
 * @property string $filename
 * @property int $app_gallery_categories_ref
 * @property int $edi_bootstrap_ref
 *
 * @property AppGallery[] $appGalleries
 * @property CmsMediaCropped[] $cmsMediaCroppeds
 * @property CmsMediaCropped[] $cmsMediaCroppeds0
 * @property AppGalleryCategories $appGalleryCategoriesRef
 * @property CmsI8tags $cmsI8tagsRef
 * @property CmsMediaContentTypes $cmsMediaContentTypesRef
 * @property CmsMediaFolders $cmsMediaFoldersRef
 * @property EdiBootstrap $ediBootstrapRef
 * @property CmsNodeGallery[] $cmsNodeGalleries
 */
class CmsMediaStorage extends RArCmsMediaStorage
{

    /**
     * {@inheritdoc}
     */
    public function rules() {
        return [
            [['cms_i8tags_ref', 'cms_media_folders_ref', 'cms_media_content_types_ref', 'fs_saveto', 'fs_alias', 'fs_filename'], 'required'],
            [['cms_i8tags_ref', 'cms_media_folders_ref', 'cms_media_content_types_ref', 'fs_filesize', 'app_gallery_categories_ref', 'edi_bootstrap_ref'], 'default', 'value' => null],
            [['cms_i8tags_ref', 'cms_media_folders_ref', 'cms_media_content_types_ref', 'fs_filesize', 'app_gallery_categories_ref', 'edi_bootstrap_ref'], 'integer'],
            [['description', 'data'], 'string'],
            [['dt_created', 'dt_updated'], 'safe'],
            [['is_trash'], 'boolean'],
            [['title', 'fs_saveto', 'fs_alias', 'fs_filename', 'filename'], 'string', 'max' => 255],
            [['fs_md5hash'], 'string', 'max' => 32],
            [['fs_extension'], 'string', 'max' => 10],
            [['app_gallery_categories_ref'], 'exist', 'skipOnError' => true, 'targetClass' => AppGalleryCategories::className(), 'targetAttribute' => ['app_gallery_categories_ref' => 'id']],
            [['cms_i8tags_ref'], 'exist', 'skipOnError' => true, 'targetClass' => CmsI8tags::className(), 'targetAttribute' => ['cms_i8tags_ref' => 'id']],
            [['cms_media_content_types_ref'], 'exist', 'skipOnError' => true, 'targetClass' => CmsMediaContentTypes::className(), 'targetAttribute' => ['cms_media_content_types_ref' => 'id']],
            [['cms_media_folders_ref'], 'exist', 'skipOnError' => true, 'targetClass' => CmsMediaFolders::className(), 'targetAttribute' => ['cms_media_folders_ref' => 'id']],
            //[['edi_bootstrap_ref'], 'exist', 'skipOnError' => true, 'targetClass' => EdiBootstrap::className(), 'targetAttribute' => ['edi_bootstrap_ref' => 'id']],
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAppGalleries() {
        return $this->hasMany(AppGallery::className(), ['cms_media_storage_ref' => 'id'])->alias('appGalleries');
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getGallery() {
        return $this->hasOne(AppGallery::className(), ['cms_media_storage_ref' => 'id'])->alias('gallery');
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCroppeds() {
        return $this->hasMany(CmsMediaCropped::className(), ['cms_media_storage_original_ref' => 'id'])->alias('croppeds');
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCmsMediaCroppeds0() {
        return $this->hasMany(CmsMediaCropped::className(), ['cms_media_storage_cropped_ref' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAppGalleryCategoriesRef() {
        return $this->hasOne(AppGalleryCategories::className(), ['id' => 'app_gallery_categories_ref']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCategory() {
        return $this->hasOne(AppGalleryCategories::className(), ['id' => 'app_gallery_categories_ref'])->alias('category');
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getI8tag() {
        return $this->hasOne(CmsI8tags::className(), ['id' => 'cms_i8tags_ref'])->alias('i8tag');
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getContentType() {
        return $this->hasOne(CmsMediaContentTypes::className(), ['id' => 'cms_media_content_types_ref'])->alias('contentType');
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getFolder() {
        return $this->hasOne(CmsMediaFolders::className(), ['id' => 'cms_media_folders_ref'])->alias('folder');
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getBootstrap() {
        return $this->hasOne(EdiBootstrap::className(), ['id' => 'edi_bootstrap_ref'])->alias('bootstrap');
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getNodeGallery() {
        return $this->hasOne(CmsNodeGallery::className(), ['cms_media_storage_ref' => 'id'])->alias('nodeGallery');
    }

    public function getCropped($key) {
        //M::printr('function getCropped($key)');

        //Берем данные о категории по $key
        $oGalleryCategory = AppGalleryCategories::find()
            ->where(['dev_key' => $key])
            ->one();

        if (empty($oGalleryCategory)) {
            throw new Exception('GalleryCategory not found');
        }
        $data = Json::decode($oGalleryCategory->data);
        $width = $data['size']['width'];
        $height = $data['size']['height'];
        //M::printr([$width, $height], '[$width, $height]');

        $config['mode'] = !empty($data['mode']) ? $data['mode'] : 'fit';
        $config['proportions'] = !empty($data['proportions']) ? $data['proportions'] : true;
        $config['side'] = !empty($data['side']) ? $data['side'] : false;
        //M::printr($config, '$config');

        //M::printr($this->croppeds, '$this->croppeds');

        $height = $height ?: $width;
        if (1) {
            foreach ($this->croppeds as $oHasCropped) {
                $oCropped = $oHasCropped->cropped;
                //M::printr($oCropped, '1 $oCropped');
                if ($oCropped->app_gallery_categories_ref == $oGalleryCategory->id) {
                    //M::printr($oCropped, 'return $oCropped');
                    return $oCropped;
                }
            }
        }

        //если в базе такого размера нет, то сгенерировать и вернуть
        //M::printr($data, '$data');
        $h5 = new CMSH4Storage();
        $h5->setConfig($config);
        $h5->key = $key;
        //если картинка большая или иллюстрация, то задать минимальные размеры и указать водяной знак
        //if ($h5->watermark) {
        if ($width >= 396) {
            $h5->watermark = '/images/watermark_396.png';
        }
        if ($width >= 600) {
            $h5->watermark = '/images/watermark_big.png';
        }
        /*
        if ($key == 'ecm:teaser_big') {
            $h5->watermark = '/images/watermark_396.png';
        } elseif ($key == 'ecm:illustrations') {
            $h5->watermark = '/images/watermark_big.png';
        }
        */
        //}
        //если картинка для категории, то не приводить к квадрату
        if ($key == 'gkm:schema') {
            $h5->to_square = false;
            $h5->watermark = '/images/watermark_big.png';
        }
        //M::printr($this, '$this');
        //M::printr([$width, $height], '$width, $height');
        $newSize = $h5->resize($this, $oGalleryCategory);
        //M::printr($newSize, '$newSize');
        return $newSize;

    }

    public static function addImage($url, $dev_key = 'ecm:illustrations') {
        /*
        $storage = Yii::getPathOfAlias('storage');

        //скачивание картинки из инета и сохранение в базе
        $srcContent = file_get_contents($src);
        $dir = $storage . '/tmp';
        $pathInfo = pathinfo($src);
        $filename = "{$dir}/{$pathInfo['basename']}"; //"{$dir}/{$pathInfo['basename']}";
        $f = fopen($filename, 'w');
        fputs($f, $srcContent);
        fclose($f);
        */
        //M::xlog(['$url', $url], 'products');

        if (substr(strtolower($url), 0, 4) == 'http') {
            //скачивать из инета
        } else {
            //файл сохранен локально
        }


        try {
            //$url = 'http://data.konsulavto.ru/acat_iron/data/jmz/238be/0000000';
            //$url = 'http://data.konsulavto.ru/acat_iron//picture/jmz/240.png';
            $client = new \GuzzleHttp\Client();
            $res = $client->request('GET', $url);
            $filename = false;
            if ($res->getStatusCode() == '200') {
                $srcContent = $res->getBody();
                $storage = Yii::getAlias('@storage');
                $dir = $storage . '/tmp';
                if (!is_dir($dir)) {
                    mkdir($dir, 0777, true);
                }
                $pathInfo = pathinfo($url);
                $filename = "{$dir}/{$pathInfo['basename']}"; //"{$dir}/{$pathInfo['basename']}";
                M::printr($filename, '$filename');
                //M::xlog(['$filename', $filename], 'products');
                $f = fopen($filename, 'w');
                fputs($f, $srcContent);
                fclose($f);
                if (!is_file($filename)) {
                    M::printr("FILE {$filename} NOT SAVED");
                    throw new \Exception('FILE NOT SAVED');
                }
            } else {
                $code = $res->getStatusCode();
                //M::xlog(['$code', $code], 'products');
                //M::xlog(['URI' => $url, "Код {$code}'"], 'Konav');
            }
        } catch (Exception $e) {
            M::xlog(['$e->getMessage()', $e->getMessage()], 'products');
            //$code = $res->getStatusCode();
            //M::xlog(['URI' => $url, 'Не найдено'], 'Konav');
            return false;
        }


        $file = [
            'name' => $pathInfo['filename'],
            'type' => mime_content_type($filename),
            'tmp_name' => $filename,
            'error' => 0,
            'size' => filesize($filename),
        ];
        //M::xlog(['$file', $file], 'products');
        $resource = new CMSH4Resource($file);
        //M::printr($resource, '$resource');
        $h4 = new CMSH4Storage();
        //M::printr($h4, '$h4');
        $oStorage = $h4->store($resource);
        M::printr($oStorage->attributes, '$oStorage->attributes');
        //M::xlog(['$oStorage->attributes', $oStorage->attributes], 'products');
        //@unlink($filename);

        $oGallery = AppGallery::addImage($oStorage, $dev_key);
        $oStorage = CmsMediaStorage::find()
            ->alias('storage')
            ->joinWith(['gallery'])
            ->where('storage.id = :id', [':id' => $oStorage->id])
            ->one();
        return $oStorage;
    }

    public function bindToProduct($oProduct, $dev_key = 'ecm:illustrations') {
        //привязать картинку к товару
        if (1) {
            $oGallery = $this->gallery;
            if (empty($oGallery)) {
                $oGallery = AppGallery::find()
                    ->where('cms_media_storage_ref = :id', [':id' => $this->id])
                    ->all();
            }
            if (empty($oGallery)) {
                $oGallery = AppGallery::addImage($this, $dev_key);
            }
        }

        $oProductHasGallery = new EcmProductHasGallery();
        $oProductHasGallery->app_gallery_ref = $oGallery->id;
        $oProductHasGallery->ecm_products_ref = $oProduct->id;
        $oProductHasGallery->cms_media_storage_ref = $this->id;
        $oProductHasGallery->on_view_position = 1;
        if (!$oProductHasGallery->save()) {
            throw new Exception('Не могу создать связку товар-картинка');
        }

    }

}