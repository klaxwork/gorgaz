<?php

namespace common\models\ar;

use common\models\models\AppGallery;
use common\models\models\CmsMediaStorage;
use common\models\models\EcmProducts;
use Yii;

/**
 * This is the model class for table "ecm_product_has_gallery".
 *
 * @property int $id
 * @property int $ecm_products_ref
 * @property int $app_gallery_ref
 * @property int $cms_media_storage
 * @property int $on_view_position
 *
 * @property AppGallery $appGalleryRef
 * @property EcmProducts $ecmProductsRef
 * @property CmsMediaStorage $cmsMediaStorageRef
 */
class RArEcmProductHasGallery extends \yii\db\ActiveRecord
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
     * {@inheritdoc}
     */
    public function attributeLabels() {
        return [
            'id' => 'ID',
            'ecm_products_ref' => 'Ecm Products Ref',
            'app_gallery_ref' => 'App Gallery Ref',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAppGalleryRef() {
        return $this->hasOne(AppGallery::className(), ['id' => 'app_gallery_ref']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEcmProductsRef() {
        return $this->hasOne(EcmProducts::className(), ['id' => 'ecm_products_ref']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCmsMediaStorageRef() {
        return $this->hasOne(CmsMediaStorage::className(), ['id' => 'cms_media_storage_ref']);
    }

}
