<?php

namespace common\models\models;

use common\models\ar\RArEcmProductHasGallery;
use Yii;

/**
 * This is the model class for table "ecm_product_has_gallery".
 *
 * @property int $id
 * @property int $ecm_products_ref
 * @property int $app_gallery_ref
 * @property int $cms_media_storage_ref
 * @property int $on_view_position
 *
 * @property AppGallery $appGalleryRef
 * @property EcmProducts $ecmProductsRef
 * @property CmsMediaStorage $cmsMediaStorageRef
 */
class EcmProductHasGallery extends RArEcmProductHasGallery
{
    /**
     * {@inheritdoc}
     */
    public static function tableName() {
        return 'ecm_product_has_gallery';
    }

    /**
     * {@inheritdoc}
     */
    public function rules() {
        return [
            //[['ecm_products_ref', 'app_gallery_ref'], 'required'],
            [['ecm_products_ref', 'cms_media_storage_ref'], 'default', 'value' => null],
            [['on_view_position'], 'default', 'value' => 100],
            //[['ecm_products_ref', 'app_gallery_ref'], 'integer'],
            //[['app_gallery_ref'], 'exist', 'skipOnError' => true, 'targetClass' => AppGallery::className(), 'targetAttribute' => ['app_gallery_ref' => 'id']],
            //[['ecm_products_ref'], 'exist', 'skipOnError' => true, 'targetClass' => EcmProducts::className(), 'targetAttribute' => ['ecm_products_ref' => 'id']],
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getGallery() {
        return $this->hasOne(AppGallery::className(), ['id' => 'app_gallery_ref'])->alias('gallery');
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProduct() {
        return $this->hasOne(EcmProducts::className(), ['id' => 'ecm_products_ref'])->alias('product');
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getStorage() {
        return $this->hasOne(CmsMediaStorage::className(), ['id' => 'cms_media_storage_ref'])->alias('storage');
    }

}
