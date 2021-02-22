<?php

namespace common\models\ar_origin;

use Yii;
use common\models\ar_inherit\Tree;

/**
 * This is the model class for table "node_content".
 *
 * @property int $id
 * @property int|null $tree_ref
 * @property string|null $title
 * @property string|null $description
 * @property bool|null $is_published
 * @property bool|null $is_default
 * @property string|null $longtitle
 * @property string|null $short_description
 * @property string|null $url_alias
 * @property string|null $dt_created
 * @property string|null $dt_updated
 * @property string|null $seo_title
 * @property string|null $seo_keywords
 * @property string|null $seo_description
 *
 * @property Tree $treeRef
 */
class RArNodeContent extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'node_content';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['tree_ref'], 'default', 'value' => null],
            [['tree_ref'], 'integer'],
            [['description', 'seo_description'], 'string'],
            [['is_published', 'is_default'], 'boolean'],
            [['dt_created', 'dt_updated'], 'safe'],
            [['title', 'longtitle', 'short_description', 'url_alias', 'seo_title', 'seo_keywords'], 'string', 'max' => 255],
            [['tree_ref'], 'exist', 'skipOnError' => true, 'targetClass' => Tree::className(), 'targetAttribute' => ['tree_ref' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'tree_ref' => 'Tree Ref',
            'title' => 'Title',
            'description' => 'Description',
            'is_published' => 'Is Published',
            'is_default' => 'Is Default',
            'longtitle' => 'Longtitle',
            'short_description' => 'Short Description',
            'url_alias' => 'Url Alias',
            'dt_created' => 'Dt Created',
            'dt_updated' => 'Dt Updated',
            'seo_title' => 'Seo Title',
            'seo_keywords' => 'Seo Keywords',
            'seo_description' => 'Seo Description',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTreeRef()
    {
        return $this->hasOne(Tree::className(), ['id' => 'tree_ref']);
    }
}
