<?php

namespace common\models;

use common\models\models\EcmProducts;

class CustomerNode extends \yii\elasticsearch\ActiveRecord
{

	public static function tableName()
	{
		return 'customer_node';
	}

	/**
	 * @return array the list of attributes for this record
	 */
	public function attributes()
	{
		// path mapping for '_id' is setup to field 'id'
		return ['id', 'name', 'address', 'ecm_products_ref'];
	}

	public function rules()
	{
		return [
			//[['edi_bootstrap_ref', 'ecm_products_ref', 'cms_tree_ref', 'app_companies_ref', 'ecm_nomenclature_ref'], 'default', 'value' => null],
			//[['edi_bootstrap_ref', 'ecm_products_ref', 'cms_tree_ref', 'app_companies_ref', 'ecm_nomenclature_ref'], 'integer'],
			//[['admin_comment'], 'string'],
			[['id', 'name', 'address', 'ecm_products_ref'], 'safe'],
			//[['is_active'], 'boolean'],
			//[['app_companies_ref'], 'exist', 'skipOnError' => true, 'targetClass' => AppCompanies::className(), 'targetAttribute' => ['app_companies_ref' => 'id']],
			//[['cms_tree_ref'], 'exist', 'skipOnError' => true, 'targetClass' => CmsTree::className(), 'targetAttribute' => ['cms_tree_ref' => 'id']],
			//[['ecm_nomenclature_ref'], 'exist', 'skipOnError' => true, 'targetClass' => EcmNomenclature::className(), 'targetAttribute' => ['ecm_nomenclature_ref' => 'id']],
			[['ecm_products_ref'], 'exist', 'skipOnError' => true, 'targetClass' => EcmProducts::className(), 'targetAttribute' => ['ecm_products_ref' => 'id']],
			//[['edi_bootstrap_ref'], 'exist', 'skipOnError' => true, 'targetClass' => EdiBootstrap::className(), 'targetAttribute' => ['edi_bootstrap_ref' => 'id']],
		];
	}

	/**
	 * @return ActiveQuery defines a relation to the Order record (can be in other database, e.g. redis or sql)
	 */
	public function getProduct()
	{
		return $this->hasOne(EcmProducts::className(), ['id' => 'ecm_products_ref'])->alias('alias');
	}

	/**
	 * @return ActiveQuery defines a relation to the Order record (can be in other database, e.g. redis or sql)
	 */
	public function getOrders()
	{
		return $this->hasMany(Order::className(), ['customer_id' => 'id'])->orderBy('id');
	}

	/**
     * Defines a scope that modifies the `$query` to return only active(status = 1) customers
     */
    public static function active($query)
    {
        $query->andWhere(['status' => 1]);
    }
}