<?php

namespace common\models\models;

use Yii;
use common\models\ar\RArAppGallery;
use yii\base\Exception;

/**
 * This is the model class for table "app_gallery".
 *
 * @property int $id
 * @property int $edi_bootstrap_ref
 * @property int $cms_media_storage_ref
 * @property int $app_gallery_categories_ref
 * @property string $dev_key
 * @property string $tags
 * @property string $dt_created
 * @property string $dt_updated
 * @property int $on_view_position
 *
 * @property AppGalleryCategories $appGalleryCategoriesRef
 * @property CmsMediaStorage $cmsMediaStorageRef
 * @property EdiBootstrap $ediBootstrapRef
 * //* @property AppProductHasGallery[] $appProductHasGalleries
 * //* @property AppQuestHasGallery[] $appQuestHasGalleries
 * @property CmsNodeGallery[] $cmsNodeGalleries
 * @property EcmProductHasGallery[] $ecmProductHasGalleries
 */
class AppGallery extends RArAppGallery
{
    /**
     * {@inheritdoc}
     */
    public static function tableName() {
        return 'app_gallery';
    }

    /**
     * {@inheritdoc}
     */
    public function rules() {
        return [
            [['edi_bootstrap_ref', 'cms_media_storage_ref'], 'required'],
            [['edi_bootstrap_ref', 'cms_media_storage_ref', 'app_gallery_categories_ref', 'on_view_position'], 'default', 'value' => null],
            [['edi_bootstrap_ref', 'cms_media_storage_ref', 'app_gallery_categories_ref', 'on_view_position'], 'integer'],
            [['tags'], 'string'],
            [['dt_created', 'dt_updated'], 'safe'],
            [['dev_key'], 'string', 'max' => 255],
            [['app_gallery_categories_ref'], 'exist', 'skipOnError' => true, 'targetClass' => AppGalleryCategories::className(), 'targetAttribute' => ['app_gallery_categories_ref' => 'id']],
            [['cms_media_storage_ref'], 'exist', 'skipOnError' => true, 'targetClass' => CmsMediaStorage::className(), 'targetAttribute' => ['cms_media_storage_ref' => 'id']],
            [['edi_bootstrap_ref'], 'exist', 'skipOnError' => true, 'targetClass' => EdiBootstrap::className(), 'targetAttribute' => ['edi_bootstrap_ref' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels() {
        return [
            'id' => 'ID',
            'edi_bootstrap_ref' => 'Edi Bootstrap Ref',
            'cms_media_storage_ref' => 'Cms Media Storage Ref',
            'app_gallery_categories_ref' => 'App Gallery Categories Ref',
            'dev_key' => 'Dev Key',
            'tags' => 'Tags',
            'dt_created' => 'Dt Created',
            'dt_updated' => 'Dt Updated',
            'on_view_position' => 'On View Position',
        ];
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
    public function getStorage() {
        return $this->hasOne(CmsMediaStorage::className(), ['id' => 'cms_media_storage_ref'])->alias('storage');
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEdiBootstrapRef() {
        return $this->hasOne(EdiBootstrap::className(), ['id' => 'edi_bootstrap_ref']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAppProductHasGalleries() {
        return $this->hasMany(AppProductHasGallery::className(), ['app_gallery_ref' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAppQuestHasGalleries() {
        return $this->hasMany(AppQuestHasGallery::className(), ['app_gallery_ref' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCmsNodeGalleries() {
        return $this->hasMany(CmsNodeGallery::className(), ['app_gallery_ref' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProductHasGallery() {
        return $this->hasMany(EcmProductHasGallery::className(), ['app_gallery_ref' => 'id'])->alias('productHasGallery');
    }

    public function getCropped($size = false) {
        if (!empty($this->storage->croppeds)) {
            if (!$size) {
                return $this->storage->croppeds;
            } else {
                foreach ($this->storage->croppeds as $oCropped) {
                    //M::printr($oCropped, '$oCropped');
                    if ($oCropped->image_width == $size) {
                        return $oCropped->cropped;
                    }
                }
            }
        }
    }

    public static function addImage($oStorage, $dev_key) {
        $oAppGalleryCategories = AppGalleryCategories::find()->where(['dev_key' => $dev_key])->one();

        $oAppGallery = new AppGallery();
        $oAppGallery->edi_bootstrap_ref = EdiBootstrap::getDefaultBootstrap()->id;
        $oAppGallery->cms_media_storage_ref = $oStorage->id;
        $oAppGallery->app_gallery_categories_ref = $oAppGalleryCategories->id;
        $oAppGallery->on_view_position = 1;
        if (!$oAppGallery->save()) {
            return false;
            //throw new Exception('Can`t save AppGallery');
        }
        return $oAppGallery;
    }

}
