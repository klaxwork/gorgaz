<?php

namespace common\models\models;

use Yii;
use common\models\ar\RArAppProducts;

/**
 * This is the model class for table "app_products".
 *
 * @property int $id
 * @property int $edi_bootstrap_ref
 * @property int $ecm_products_ref
 * @property int $cms_tree_ref
 * @property string $admin_comment
 * @property string $dt_created
 * @property string $dt_updated
 * @property bool $is_active
 * @property int $app_companies_ref
 * @property int $ecm_nomenclature_ref
 *
 * @property AppProductHasGallery[] $appProductHasGalleries
 * @property AppProductHasRegions[] $appProductHasRegions
 * @property AppProductUseWebhooks[] $appProductUseWebhooks
 * @property AppCompanies $appCompaniesRef
 * @property CmsTree $cmsTreeRef
 * @property EcmNomenclature $ecmNomenclatureRef
 * @property EcmProducts $ecmProductsRef
 * @property EdiBootstrap $ediBootstrapRef
 */
class AppProducts extends RArAppProducts
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'app_products';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['edi_bootstrap_ref', 'ecm_products_ref'], 'required'],
            [['edi_bootstrap_ref', 'ecm_products_ref', 'cms_tree_ref', 'app_companies_ref', 'ecm_nomenclature_ref'], 'default', 'value' => null],
            [['edi_bootstrap_ref', 'ecm_products_ref', 'cms_tree_ref', 'app_companies_ref', 'ecm_nomenclature_ref'], 'integer'],
            [['admin_comment'], 'string'],
            [['dt_created', 'dt_updated'], 'safe'],
            [['is_active'], 'boolean'],
            //[['app_companies_ref'], 'exist', 'skipOnError' => true, 'targetClass' => AppCompanies::className(), 'targetAttribute' => ['app_companies_ref' => 'id']],
            [['cms_tree_ref'], 'exist', 'skipOnError' => true, 'targetClass' => CmsTree::className(), 'targetAttribute' => ['cms_tree_ref' => 'id']],
            //[['ecm_nomenclature_ref'], 'exist', 'skipOnError' => true, 'targetClass' => EcmNomenclature::className(), 'targetAttribute' => ['ecm_nomenclature_ref' => 'id']],
            [['ecm_products_ref'], 'exist', 'skipOnError' => true, 'targetClass' => EcmProducts::className(), 'targetAttribute' => ['ecm_products_ref' => 'id']],
            //[['edi_bootstrap_ref'], 'exist', 'skipOnError' => true, 'targetClass' => EdiBootstrap::className(), 'targetAttribute' => ['edi_bootstrap_ref' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'edi_bootstrap_ref' => 'Edi Bootstrap Ref',
            'ecm_products_ref' => 'Ecm Products Ref',
            'cms_tree_ref' => 'Cms Tree Ref',
            'admin_comment' => 'Admin Comment',
            'dt_created' => 'Dt Created',
            'dt_updated' => 'Dt Updated',
            'is_active' => 'Is Active',
            'app_companies_ref' => 'App Companies Ref',
            'ecm_nomenclature_ref' => 'Ecm Nomenclature Ref',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAppProductHasGalleries()
    {
        return $this->hasMany(AppProductHasGallery::className(), ['app_products_ref' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAppProductHasRegions()
    {
        return $this->hasMany(AppProductHasRegions::className(), ['app_products_ref' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAppProductUseWebhooks()
    {
        return $this->hasMany(AppProductUseWebhooks::className(), ['app_products_ref' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAppCompaniesRef()
    {
        return $this->hasOne(AppCompanies::className(), ['id' => 'app_companies_ref']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTree()
    {
        return $this->hasOne(CmsTree::className(), ['id' => 'cms_tree_ref'])->alias('tree');
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEcmNomenclatureRef()
    {
        return $this->hasOne(EcmNomenclature::className(), ['id' => 'ecm_nomenclature_ref']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProduct()
    {
        return $this->hasOne(EcmProducts::className(), ['id' => 'ecm_products_ref'])->alias('product');
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEdiBootstrapRef()
    {
        return $this->hasOne(EdiBootstrap::className(), ['id' => 'edi_bootstrap_ref']);
    }
}
