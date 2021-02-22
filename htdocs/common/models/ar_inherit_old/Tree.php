<?php

namespace common\models\ar_inherit;

use Yii;
use common\models\ar_origin\RArTree;

/**
 * This is the model class for table "tree".
 *
 * @property int $id
 * @property int|null $ns_root_ref
 * @property int|null $ns_left_key
 * @property int|null $ns_right_key
 * @property int|null $ns_level
 * @property string|null $title
 * @property string|null $dt_created
 * @property string|null $dt_updated
 * @property bool|null $is_node_published
 * @property bool|null $is_trash
 * @property bool|null $is_protected
 * @property string|null $seo_title
 * @property string|null $seo_keywords
 * @property string|null $seo_description
 * @property string|null $menu_title
 * @property int|null $menu_index
 * @property bool|null $is_menu_visible
 * @property bool|null $is_seo_noindexing
 * @property string|null $long_title
 * @property string|null $url_alias
 * @property string|null $description
 *
 * @property NodeContent[] $nodeContents
 * @property RArTree $nsRootRef
 * @property RArTree[] $rArTrees
 */
class Tree extends RArTree
{
    /**
     * {@inheritdoc}
     */
    public static function tableName() {
        return 'tree';
    }

    /**
     * {@inheritdoc}
     */
    public function rules() {
        return [
            //[['ns_root_ref', 'ns_left_key', 'ns_right_key', 'ns_level', 'menu_index'], 'default', 'value' => null],
            //[['ns_root_ref', 'ns_left_key', 'ns_right_key', 'ns_level', 'menu_index'], 'integer'],
            [['ns_root_ref', 'ns_left_key', 'ns_right_key', 'ns_level', 'title', 'dt_created', 'dt_updated', 'is_node_published', 'is_trash', 'is_protected', 'seo_title', 'seo_keywords', 'seo_description', 'menu_title', 'menu_index', 'is_menu_visible', 'is_seo_noindexing', 'long_title', 'url_alias', 'description',], 'safe'],
            //[['is_node_published', 'is_trash', 'is_protected', 'is_menu_visible', 'is_seo_noindexing'], 'boolean'],
            //[['seo_description', 'description'], 'string'],
            //[['title', 'seo_title', 'seo_keywords', 'menu_title', 'long_title', 'url_alias'], 'string', 'max' => 255],
            //[['ns_root_ref'], 'exist', 'skipOnError' => true, 'targetClass' => RArTree::className(), 'targetAttribute' => ['ns_root_ref' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels() {
        return [
            'id' => 'ID',
            'ns_root_ref' => 'Ns Root Ref',
            'ns_left_key' => 'Ns Left Key',
            'ns_right_key' => 'Ns Right Key',
            'ns_level' => 'Ns Level',
            'title' => 'Title',
            'dt_created' => 'Dt Created',
            'dt_updated' => 'Dt Updated',
            'is_node_published' => 'Is Node Published',
            'is_trash' => 'Is Trash',
            'is_protected' => 'Is Protected',
            'seo_title' => 'Seo Title',
            'seo_keywords' => 'Seo Keywords',
            'seo_description' => 'Seo Description',
            'menu_title' => 'Menu Title',
            'menu_index' => 'Menu Index',
            'is_menu_visible' => 'Is Menu Visible',
            'is_seo_noindexing' => 'Is Seo Noindexing',
            'long_title' => 'Long Title',
            'url_alias' => 'Url Alias',
            'description' => 'Description',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getContents() {
        return $this->hasMany(NodeContent::className(), ['tree_ref' => 'id'])->alias('contents');
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getNsRoot() {
        return $this->hasOne(RArTree::className(), ['id' => 'ns_root_ref'])->alias('nsRoot');
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRArTrees() {
        return $this->hasMany(RArTree::className(), ['ns_root_ref' => 'id']);
    }
}
