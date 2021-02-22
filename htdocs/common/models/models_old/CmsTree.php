<?php

namespace common\models\models;

use Yii;
use common\models\ar\RArCmsTree;
use common\components\M;
use yii\db\Query;
use common\models\models;

/**
 * This is the model class for table "cms_tree".
 *
 * @property int $id
 * @property int $ns_root_ref
 * @property int $ns_left_key
 * @property int $ns_right_key
 * @property int $ns_level
 * @property string $node_name
 * @property string $menu_title
 * @property int $menu_index
 * @property bool $is_menu_visible
 * @property bool $is_node_published
 * @property string $dt_created
 * @property string $dt_updated
 * @property bool $is_trash
 * @property bool $is_node_protected
 * @property string $data_filter
 * @property string $url_alias
 *
 * @property AppBranches[] $appBranches
 * @property AppNomenclature[] $appNomenclatures
 * @property AppProducts[] $appProducts
 * @property AppQuests[] $appQuests
 * @property AppRegionNodeOverrides[] $appRegionNodeOverrides
 * @property CmsAliases[] $cmsAliases
 * @property CmsNodeBinding[] $cmsNodeBindings
 * @property CmsNodeContent[] $cmsNodeContents
 * @property CmsNodeProperties[] $cmsNodeProperties
 * @property CmsNodeTrash[] $cmsNodeTrashes
 * @property CmsSite[] $cmsSites
 * @property CmsTree $nsRootRef
 * @property CmsTree[] $cmsTrees
 */
class CmsTree extends RArCmsTree
{
    public $d_level;

    public function rules()
    {
        $safe = [
            'node_name',
            'menu_title',
            'menu_index',
            'is_menu_visible',
            'is_node_published',
            'is_trash',
            'is_node_protected',
            'data_filter',
            'url_alias',
        ];

        return [
            [['ns_root_ref', 'ns_left_key', 'ns_right_key', 'ns_level', 'menu_index'], 'default', 'value' => null],
            [['ns_root_ref', 'ns_left_key', 'ns_right_key', 'ns_level', 'menu_index'], 'integer'],
            [['node_name'], 'required'],
            //[['is_menu_visible', 'is_node_published', 'is_trash', 'is_node_protected'], 'boolean'],
            [$safe, 'safe'],
            [['data_filter'], 'string'],
            [['node_name', 'menu_title'], 'string', 'max' => 255],
            [['ns_root_ref'], 'exist', 'skipOnError' => true, 'targetClass' => RArCmsTree::className(), 'targetAttribute' => ['ns_root_ref' => 'id']],
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'ns_root_ref' => 'Корень',
            'ns_left_key' => 'Левый ключ',
            'ns_right_key' => 'Правый ключ',
            'ns_level' => 'Уровень вложенности',
            'node_name' => 'Имя узла',
            'menu_title' => 'Menu Title',
            'menu_index' => 'Menu Index',
            'is_menu_visible' => 'Is Menu Visible',
            'is_node_published' => 'Опубликовано',
            'dt_created' => 'Дата создания',
            'dt_updated' => 'Дата обновления',
            'is_trash' => 'Удалено',
            'is_node_protected' => 'Защищено',
            'data_filter' => 'Данные для фильтра',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAppBranches()
    {
        return $this->hasMany(AppBranches::className(), ['cms_tree_ref' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    /*/
    public function getAppNomenclatures()
    {
        return $this->hasMany(AppNomenclature::className(), ['cms_tree_ref' => 'id']);
    }
    //*/

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAppProduct()
    {
        return $this->hasOne(AppProducts::className(), ['cms_tree_ref' => 'id'])->alias('appProduct');
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAppProducts()
    {
        return $this->hasMany(AppProducts::className(), ['cms_tree_ref' => 'id'])->alias('appProducts');
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAppQuests()
    {
        return $this->hasMany(AppQuests::className(), ['cms_tree_ref' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAppRegionNodeOverrides()
    {
        return $this->hasMany(AppRegionNodeOverrides::className(), ['cms_tree_ref' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAlias()
    {
        return $this->hasOne(CmsAliases::className(), ['cms_tree_ref' => 'id'])->onCondition(['is_deprecated' => false])->alias('alias');
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAliases()
    {
        return $this->hasMany(CmsAliases::className(), ['cms_tree_ref' => 'id'])->alias('aliases');
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getBindings()
    {
        return $this->hasMany(CmsNodeBinding::className(), ['cms_tree_ref' => 'id'])->alias('bindings');
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getContent()
    {
        return $this->hasOne(CmsNodeContent::className(), ['cms_tree_ref' => 'id'])->alias('content');
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getContents()
    {
        return $this->hasMany(CmsNodeContent::className(), ['cms_tree_ref' => 'id'])->alias('contents');
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProperties()
    {
        return $this->hasMany(CmsNodeProperties::className(), ['cms_tree_ref' => 'id'])->alias('properties');
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCmsNodeTrashes()
    {
        return $this->hasMany(CmsNodeTrash::className(), ['cms_tree_ref' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCmsSites()
    {
        return $this->hasMany(CmsSite::className(), ['cms_tree_ref' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRoot()
    {
        return $this->hasOne(CmsTree::className(), ['id' => 'ns_root_ref'])->alias('root');
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCmsTrees()
    {
        return $this->hasMany(CmsTree::className(), ['ns_root_ref' => 'id']);
    }

    public function getRootCategory()
    {
        //$query = Query::find()->with(['properties'])->where(['properties.property_value' => ':val'])->params(['val' => 'CATALOG']);


        $criteria = new CDbCriteria();
        $criteria->addCondition('"properties"."property_value" = :val');
        $criteria->params = [':val' => 'CATALOG'];
        $oCategory = CmsTree::model()->with(['properties'])->find($criteria);
        return $oCategory;
    }

    public function getCategoryProducts($id = false)
    {
        if (!$id) {
            $id = $this->id;
        }

        $oParent = CmsTree::findOne($id);
        //M::printr($oParent->attributes, '$oParent->attributes');
        $oProducts = EcmProducts::find()
            ->joinWith(
                [
                    'appProduct.tree',
                    'productStore.warehouse',
                ]
            )
            ->andOnCondition('"tree"."ns_root_ref" = :cat_root AND (:cat_left <= "tree"."ns_left_key" AND "tree"."ns_left_key" <= :cat_right) AND is_closed IS FALSE')
            ->params(
                [
                    'cat_root' => $oParent->ns_root_ref,
                    'cat_left' => $oParent->ns_left_key,
                    'cat_right' => $oParent->ns_right_key,
                ]
            )
            ->orderBy('product_name ASC')
            ->all();
        //M::printr(count($oProducts), 'count($oProducts)');

        $response = [];
        foreach ($oProducts as $oProduct) {
            $response[$oProduct->id] = $oProduct;
        }

        /*
        $root = $this->getRootCategory();
        $criteria = new CDbCriteria();
        $criteria->addCondition('"tree"."ns_root_ref" = :cat_root');
        $criteria->addCondition('"tree"."ns_left_key" >= :cat_left');
        $criteria->addCondition('"tree"."ns_right_key" <= :cat_right');
        $criteria->addCondition('"tree"."is_trash" IS FALSE');
        $criteria->addCondition('"t"."is_trash" IS FALSE');
        $criteria->addCondition('"t"."is_closed" IS FALSE');
        $criteria->params = [':cat_left' => $this->ns_left_key, ':cat_right' => $this->ns_right_key, ':cat_root' => $root->ns_root_ref];

        $criteria->order = '"productStore"."quantity" DESC, "t"."product_price" ASC, "t"."product_name" ASC';
        $oProducts = EcmProducts::model()
            ->with(
                [
                    'appProduct.tree',
                    'productStore.warehouse',
                ]
            )
            ->findAll($criteria);
        */
        return $response;
        return $oProducts;
    }

    public function getBreadcrumbs()
    {
        //получить узел
        //получить всех родителей до корня
        //создать пути от каждого родителя до корня

        //M::printr($this, '$this');
        $oNode = CmsTree::findOne(['id' => $this->id]);
        $oParents = $oNode
            ->parents()
            ->joinWith(['alias'])
            ->andWhere(['alias.is_deprecated' => false])
            ->all();
        //M::printr($oParents, '$oParents');

        $arr = [];
        if ($oNode->ns_root_ref == 200) {
            //$arr[] = ['label' => 'Каталог', 'url' => '/catalog/'];
            $arr['Каталог'] = '/catalog/';
        }
        foreach ($oParents as $oParent) {
            //M::printr($oParent, '$oParent');
            $alias = $oParent->alias;
            if (empty($alias)) {
                continue;
            }
            $arr[$oParent->node_name] = $alias->url_path . '/';
        }

        //M::printr($oNode->alias, '$oNode->alias');
        if (!empty($oNode->alias)) {
            $arr[$oNode->node_name] = $oNode->alias->url_path . '/';
        }
        //M::printr($arr, '$arr');

        if (0) {
            $arr = [];
            if ($this->id == '200') {
                $arr[$this->node_name] = Url::to('/catalog/default/view', ['id' => 200]); //"/front/catalog/index/category_id/200";
                //$arr[$this->node_name] = Yii::app()->createUrl($route, ['id' => 200]);
            }

            $news_root = 1105;
            if (PRODUCTION_MODE) {
                $news_root = 1105;
            }

            if ($this->ns_root_ref == $news_root) {
                $route = 'page/news';
            }
            //получить полный путь от корня до категории товара
            $oParents = $this->ancestors()->findAll();
            foreach ($oParents as $oParent) {
                if (empty($oParent->url_alias)) {
                    continue;
                }
                $arr[$oParent->node_name] = Yii::app()->createUrl('page/catalog', ['id' => $oParent->id]); //"/front/catalog/index/category_id/{$oParent->id}";
                //$arr[$oParent->node_name] = Yii::app()->createUrl($route, ['id' => $oParent->id]);//'alias' => $oParent->url_alias
            }
            $arr[$this->node_name] = Yii::app()->createUrl('page/catalog', ['id' => $this->id]); //"/front/catalog/index/category_id/{$this->id}";//'alias' => $oParent->url_alias
            //$arr[$this->node_name] = Yii::app()->createUrl($route, ['id' => $this->id]);//'alias' => $oParent->url_alias
            //M::printr($arr, '$arr');
        }
        return $arr;
    }

    public function getPath()
    {
        //получить полный путь от корня до категории товара
        $oCategory = $this->find()
            ->alias('t')
            ->joinWith('alias')
            ->where(['t.id' => $this->id, 'alias.is_deprecated' => false])
            ->one();
        $path = '';
        if (!empty($oCategory->alias)) {
            $path = $oCategory->alias->url_path;
        }
        return substr($path, 1) . "/";
    }

    public function getProperty($property_name)
    {
        $oProps = $this->getNodeProperties();
        foreach ($oProps as $oProp) {
            if ($oProp->field->property_name == $property_name) {
                return $oProp;
            }
        }
        $oPropertyField = CmsNodePropertiesFields::getFieldByKey($property_name);
        if (empty($oPropertyField)) {
            return false;
        }
        $oProp = new CmsNodeProperties();
        $oProp->cms_tree_ref = $this->id;
        $oProp->cms_node_properties_fields_ref = $oPropertyField->id;
        $oProp->save();
        return CmsNodeProperties::findOne($oProp->id);
    }

    public function getNodeProperties($pk = false)
    {
        if (empty($pk)) {
            return $this->properties;
        }
        $props = CmsTree::find()
            ->joinWith(['properties.field'])
            ->where(['id' => $pk])
            ->one();
        return $props->properties;
    }

    /**
     * @param $alias
     * @return CmsNodeContent|mixed
     */
    public static function getBlock($alias)
    {
        //$oBlock = CmsTree::model()->with(['content'])->find('url_alias = :alias', [':alias' => $alias]);
        $oBlock = CmsTree::find()
            ->joinWith(['content'])
            ->where(['content.url_alias' => $alias])
            ->one();
        if (!empty($oBlock) && !empty($oBlock->content)) {
            $oContent = $oBlock->content;
        } else {
            $oContent = new CmsNodeContent();
        }
        return $oContent;
    }

    public static function getCategoryByAlias($alias)
    {
        $oCategory = self::find()
            ->joinWith(['content'])
            ->where(['content.url_alias' => $alias])
            ->one();
        if (empty($oCategory)) {
            return false;
        }
        return $oCategory;
    }

}
