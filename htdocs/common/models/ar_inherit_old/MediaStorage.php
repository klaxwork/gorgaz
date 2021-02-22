<?php

namespace common\models\ar_inherit;

use common\components\M;
use common\models\CMSH4Storage;
use Yii;
use common\models\ar_inherit\I8tags;
use common\models\ar_origin\RArMediaStorage;
use yii\base\Exception;
use yii\helpers\Json;

/**
 * This is the model class for table "media_storage".
 *
 * @property int $id
 * @property int|null $media_folders_ref
 * @property int|null $media_content_types_ref
 * @property string|null $title
 * @property string|null $description
 * @property string|null $data
 * @property string $fs_saveto
 * @property string $fs_alias
 * @property string $fs_filename
 * @property string $fs_md5hash
 * @property int $fs_filesize
 * @property string|null $dt_created
 * @property string|null $dt_updated
 * @property string|null $fs_extension
 * @property string|null $filename
 * @property int|null $app_gallery_categories_ref
 * @property int|null $edi_bootstrap_ref
 * @property bool|null $is_trash
 * @property int|null $i8tags_ref
 * @property int|null $storage_category_ref
 *
 * @property MediaCropped[] $mediaCroppeds
 * @property MediaCropped[] $mediaCroppeds0
 * @property I8tags $i8tagsRef
 * @property MediaContentTypes $mediaContentTypesRef
 * @property MediaFolders $mediaFoldersRef
 * @property MediaStorageCategory $storageCategoryRef
 * @property NodeContentHasStorage[] $nodeContentHasStorages
 * @property NodeHasStorage[] $nodeHasStorages
 * @property ProductHasStorage[] $productHasStorages
 */
class MediaStorage extends RArMediaStorage
{
    /**
     * {@inheritdoc}
     */
    public static function tableName() {
        return 'media_storage';
    }

    /**
     * {@inheritdoc}
     */
    public function rules() {
        return [
            //[['media_folders_ref', 'media_content_types_ref', 'fs_filesize', 'app_gallery_categories_ref', 'edi_bootstrap_ref', 'i8tags_ref'], 'default', 'value' => null],
            //[['media_folders_ref', 'media_content_types_ref', 'fs_filesize', 'app_gallery_categories_ref', 'edi_bootstrap_ref', 'i8tags_ref'], 'integer'],
            //[['description', 'data'], 'string'],
            //[['fs_saveto', 'fs_alias', 'fs_filename', 'fs_md5hash', 'fs_filesize'], 'required'],
            //[['dt_created', 'dt_updated'], 'safe'],
            //[['is_trash'], 'boolean'],
            //[['title', 'fs_saveto', 'fs_alias', 'fs_filename', 'fs_md5hash', 'fs_extension', 'filename'], 'string', 'max' => 255],
            //[['i8tags_ref'], 'exist', 'skipOnError' => true, 'targetClass' => I8tags::className(), 'targetAttribute' => ['i8tags_ref' => 'id']],
            //[['media_content_types_ref'], 'exist', 'skipOnError' => true, 'targetClass' => MediaContentTypes::className(), 'targetAttribute' => ['media_content_types_ref' => 'id']],
            //[['media_folders_ref'], 'exist', 'skipOnError' => true, 'targetClass' => MediaFolders::className(), 'targetAttribute' => ['media_folders_ref' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels() {
        return [
            'id' => 'ID',
            'media_folders_ref' => 'Media Folders Ref',
            'media_content_types_ref' => 'Media Content Types Ref',
            'title' => 'Title',
            'description' => 'Description',
            'data' => 'Data',
            'fs_saveto' => 'Fs Saveto',
            'fs_alias' => 'Fs Alias',
            'fs_filename' => 'Fs Filename',
            'fs_md5hash' => 'Fs Md5hash',
            'fs_filesize' => 'Fs Filesize',
            'dt_created' => 'Dt Created',
            'dt_updated' => 'Dt Updated',
            'fs_extension' => 'Fs Extension',
            'filename' => 'Filename',
            'app_gallery_categories_ref' => 'App Gallery Categories Ref',
            'edi_bootstrap_ref' => 'Edi Bootstrap Ref',
            'is_trash' => 'Is Trash',
            'i8tags_ref' => 'I8tags Ref',
            'storage_category_ref' => 'Categories Ref',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCroppeds() {
        return $this->hasMany(MediaCropped::className(), ['media_storage_original_ref' => 'id'])->alias('croppeds');
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMediaStorageCroppedRef() {
        return $this->hasMany(MediaCropped::className(), ['media_storage_cropped_ref' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getI8() {
        return $this->hasOne(I8tags::className(), ['id' => 'i8tags_ref'])->alias('i8');
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getContentType() {
        return $this->hasOne(MediaContentTypes::className(), ['id' => 'media_content_types_ref'])->alias('contentType');
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getFolders() {
        return $this->hasOne(MediaFolders::className(), ['id' => 'media_folders_ref'])->alias('folders');
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getNodeContentHasStorages() {
        return $this->hasMany(NodeContentHasStorage::className(), ['media_storage_ref' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getNodeHasStorages() {
        return $this->hasMany(NodeHasStorage::className(), ['media_storage_ref' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProductHasStorages() {
        return $this->hasMany(ProductHasStorage::className(), ['media_storage_ref' => 'id'])->alias('productHasStorages');
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProductHasStorage() {
        return $this->hasOne(ProductHasStorage::className(), ['media_storage_ref' => 'id'])->alias('productHasStorage');
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCategory() {
        return $this->hasOne(MediaStorageCategory::className(), ['id' => 'storage_category_ref'])->alias('category');
    }

    public function bindToProduct($product_id, $on_position_view = 0) {
        //проверить, привязан ли storage к этому product
        $oProductHasStorage = ProductHasStorage::find()->where(['products_ref' => $product_id, 'media_storage_ref' => $this->id])->one();
        //если нет, то создать запись в ProductHasStorage
        if (empty($oProductHasStorage)) {
            $oProductHasStorage = new ProductHasStorage();
            $oProductHasStorage->products_ref = $product_id;
            $oProductHasStorage->media_storage_ref = $this->id;
        }
        if ($on_position_view == 0) {
            $on_position_view = 100000 + $this->id;
        }
        $oProductHasStorage->on_view_position = $on_position_view;

        if (!$oProductHasStorage->save()) {
            throw new Exception('Can`t save $oProductHasStorage, product_id => ' . $product_id . '; media_storage_ref => ' . $this->id);
        }
        return $oProductHasStorage;
    }

    public function bindToNode($node_content_id) {
        //проверить, привязан ли storage к этому product
        $oNodeContentHasStorage = NodeContentHasStorage::find()->where(['node_content_ref' => $node_content_id, 'media_storage_ref' => $this->id])->one();
        //если нет, то создать запись в ProductHasStorage
        if (empty($oNodeContentHasStorage)) {
            $oNodeContentHasStorage = new NodeContentHasStorage();
            $oNodeContentHasStorage->node_content_ref = $node_content_id;
            $oNodeContentHasStorage->media_storage_ref = $this->id;
            $oNodeContentHasStorage->on_view_position = 10000 + $this->id;
            if (!$oNodeContentHasStorage->save()) {
                throw new Exception('Can`t save $oNodeContentHasStorage, node_content_id => ' . $node_content_id . '; media_storage_ref => ' . $this->id);
            }
        }
        return $oNodeContentHasStorage;
    }

    public function unbindFromProduct($product_id = null) {
        //проверить, привязан ли storage к этому product
        $oProductHasStorage = ProductHasStorage::find()
            ->where(
                [
                    //'products_ref' => $product_id,
                    'media_storage_ref' => $this->id,
                ]
            )
            ->one();
        //если да, то удалить
        if (!empty($oProductHasStorage)) {
            $oProductHasStorage->delete();
            //$this->delete();
        }
        return true;
    }

    public function unbindFromNode($node_content_id) {
        //проверить, привязан ли storage к этому product
        $oNodeContentHasStorage = NodeContentHasStorage::find()
            ->where(
                [
                    'node_content_ref' => $node_content_id,
                    'media_storage_ref' => $this->id
                ]
            )
            ->one();
        //если нет, то создать запись в ProductHasStorage
        if (!empty($oNodeContentHasStorage)) {
            $oNodeContentHasStorage->delete();
            //$this->delete();
        }
        return true;
    }

    public function getCropped($key = "dev:main") {
        //M::printr('getCropped($key)');

        //Берем данные о категории по $key
        $oStorageCategory = MediaStorageCategory::find()
            ->where(['dev_key' => $key])
            ->one();

        $data = Json::decode($oStorageCategory->data);
        //M::printr($oStorageCategory, '$oStorageCategory');

        if (empty($oStorageCategory)) {
            throw new Exception('StorageCategory not found');
        }
        $data = Json::decode($oStorageCategory->data);
        $width = $data['size']['width'];
        $height = $data['size']['height'];

        $config['mode'] = !empty($data['mode']) ? $data['mode'] : 'fit';
        $config['proportions'] = !empty($data['proportions']) ? $data['proportions'] : true;
        $config['side'] = !empty($data['side']) ? $data['side'] : false;
        //M::printr($config, '$config');

        //M::printr($this->croppeds, '$this->croppeds');

        //$height = $height ?: $width;
        if (1) {
            foreach ($this->croppeds as $oHasCropped) {
                //M::printr($oHasCropped, '$oHasCropped');
                $oCropped = $oHasCropped->cropped;
                //M::printr($oCropped, '1 $oCropped');
                //M::printr($oCropped->storage_category_ref, '$oCropped->storage_category_ref');
                //M::printr($oStorageCategory->id, '$oStorageCategory->id ');
                if ($oCropped->storage_category_ref == $oStorageCategory->id) {
                    //M::printr($oCropped, 'return $oCropped');
                    return $oCropped;
                }
            }
        }
        //M::printr('Cropped image not found');

        //если в базе такого размера нет, то сгенерировать и вернуть
        //M::printr($data, '$data');
        $h5 = new CMSH4Storage();
        $h5->setConfig($config);
        $h5->key = $key;
        if (0) {
            //если картинка большая или иллюстрация, то задать минимальные размеры и указать водяной знак
            //if ($h5->watermark) {
            if ($width >= 396) {
                $h5->watermark = '/images/watermark_396.png';
            }
            if ($width >= 600) {
                $h5->watermark = '/images/watermark_big.png';
            }
        }
        if (0) {
            if ($key == 'ecm:teaser_big') {
                $h5->watermark = '/images/watermark_396.png';
            } elseif ($key == 'ecm:illustrations') {
                $h5->watermark = '/images/watermark_big.png';
            }
        }
        //если картинка для категории, то не приводить к квадрату
        if (0) {
            if ($key == 'gkm:schema') {
                $h5->to_square = false;
                $h5->watermark = '/images/watermark_big.png';
            }
        }
        //M::printr($this, '$this');
        $newSize = $h5->resize($this, $oStorageCategory);
        //M::printr($newSize, '$newSize');
        return $newSize;

    }

}
