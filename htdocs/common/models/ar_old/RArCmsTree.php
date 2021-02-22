<?php

namespace common\models\ar;

use Yii;
use creocoder\nestedsets\NestedSetsBehavior;

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
 * @property RArCmsTree $nsRootRef
 * @property RArCmsTree[] $rArCmsTrees
 */
class RArCmsTree extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'cms_tree';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['ns_root_ref', 'ns_left_key', 'ns_right_key', 'ns_level', 'menu_index'], 'default', 'value' => null],
            [['ns_root_ref', 'ns_left_key', 'ns_right_key', 'ns_level', 'menu_index'], 'integer'],
            [['node_name'], 'required'],
            [['is_menu_visible', 'is_node_published', 'is_trash', 'is_node_protected'], 'boolean'],
            [['dt_created', 'dt_updated'], 'safe'],
            [['data_filter'], 'string'],
            [['node_name', 'menu_title'], 'string', 'max' => 255],
            [['ns_root_ref'], 'exist', 'skipOnError' => true, 'targetClass' => RArCmsTree::className(), 'targetAttribute' => ['ns_root_ref' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'ns_root_ref' => 'Ns Root Ref',
            'ns_left_key' => 'Ns Left Key',
            'ns_right_key' => 'Ns Right Key',
            'ns_level' => 'Ns Level',
            'node_name' => 'Node Name',
            'menu_title' => 'Menu Title',
            'menu_index' => 'Menu Index',
            'is_menu_visible' => 'Is Menu Visible',
            'is_node_published' => 'Is Node Published',
            'dt_created' => 'Dt Created',
            'dt_updated' => 'Dt Updated',
            'is_trash' => 'Is Trash',
            'is_node_protected' => 'Is Node Protected',
            'data_filter' => 'Data Filter',
        ];
    }

    public function behaviors()
    {
        return [
            'tree' => [
                'class' => NestedSetsBehavior::className(),
                'treeAttribute' => 'ns_root_ref',
                'leftAttribute' => 'ns_left_key',
                'rightAttribute' => 'ns_right_key',
                'depthAttribute' => 'ns_level',
            ],
        ];
    }

    public function transactions()
    {
        return [
            self::SCENARIO_DEFAULT => self::OP_ALL,
        ];
    }

    public static function find()
    {
        return new RArCmsTreeQuery(get_called_class());
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
    public function getAppNomenclatures()
    {
        return $this->hasMany(AppNomenclature::className(), ['cms_tree_ref' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAppProducts()
    {
        return $this->hasMany(AppProducts::className(), ['cms_tree_ref' => 'id']);
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
    public function getCmsAliases()
    {
        return $this->hasMany(CmsAliases::className(), ['cms_tree_ref' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCmsNodeBindings()
    {
        return $this->hasMany(CmsNodeBinding::className(), ['cms_tree_ref' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCmsNodeContents()
    {
        return $this->hasMany(CmsNodeContent::className(), ['cms_tree_ref' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCmsNodeProperties()
    {
        return $this->hasMany(CmsNodeProperties::className(), ['cms_tree_ref' => 'id']);
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
    public function getNsRootRef()
    {
        return $this->hasOne(RArCmsTree::className(), ['id' => 'ns_root_ref']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRArCmsTrees()
    {
        return $this->hasMany(RArCmsTree::className(), ['ns_root_ref' => 'id']);
    }
}
