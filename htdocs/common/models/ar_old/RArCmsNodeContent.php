<?php

namespace common\models\ar;

use common\models\models\CmsNodeGallery;
use common\models\models\CmsTemplates;
use common\models\models\CmsTree;
use Yii;

/**
 * This is the model class for table "cms_node_content".
 *
 * @property int $id
 * @property int $cms_tree_ref
 * @property int $cms_templates_ref
 * @property string $page_title
 * @property string $page_longtitle
 * @property string $page_teaser
 * @property string $page_body
 * @property int $vcs_revision
 * @property string $dt_created
 * @property string $dt_updated
 * @property string $dt_archived
 * @property string $page_description
 * @property string $seo_title
 * @property string $seo_keywords
 * @property string $seo_description
 * @property bool $is_seo_noindexing
 * @property bool $is_published
 * @property bool $is_in_markets
 * @property bool $is_in_google
 * @property string $url_alias
 *
 * @property CmsTemplates $cmsTemplatesRef
 * @property CmsTree $cmsTreeRef
 * @property CmsNodeGallery[] $cmsNodeGalleries
 */
class RArCmsNodeContent extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'cms_node_content';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['cms_tree_ref', 'cms_templates_ref', 'page_title'], 'required'],
            [['cms_tree_ref', 'cms_templates_ref', 'vcs_revision'], 'default', 'value' => null],
            [['cms_tree_ref', 'cms_templates_ref', 'vcs_revision'], 'integer'],
            [['page_longtitle', 'page_teaser', 'page_body', 'page_description', 'seo_description'], 'string'],
            [['dt_created', 'dt_updated', 'dt_archived'], 'safe'],
            [['is_seo_noindexing', 'is_published', 'is_in_markets', 'is_in_google'], 'boolean'],
            [['page_title', 'seo_title', 'seo_keywords', 'url_alias'], 'string', 'max' => 255],
            [['cms_templates_ref'], 'exist', 'skipOnError' => true, 'targetClass' => CmsTemplates::className(), 'targetAttribute' => ['cms_templates_ref' => 'id']],
            [['cms_tree_ref'], 'exist', 'skipOnError' => true, 'targetClass' => CmsTree::className(), 'targetAttribute' => ['cms_tree_ref' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'cms_tree_ref' => 'Cms Tree Ref',
            'cms_templates_ref' => 'Cms Templates Ref',
            'page_title' => 'Page Title',
            'page_longtitle' => 'Page Longtitle',
            'page_teaser' => 'Page Teaser',
            'page_body' => 'Page Body',
            'vcs_revision' => 'Vcs Revision',
            'dt_created' => 'Dt Created',
            'dt_updated' => 'Dt Updated',
            'dt_archived' => 'Dt Archived',
            'page_description' => 'Page Description',
            'seo_title' => 'Seo Title',
            'seo_keywords' => 'Seo Keywords',
            'seo_description' => 'Seo Description',
            'is_seo_noindexing' => 'Is Seo Noindexing',
            'is_published' => 'Is Published',
            'is_in_markets' => 'Is In Markets',
            'is_in_google' => 'Is In Google',
            'url_alias' => 'Url Alias',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCmsTemplatesRef()
    {
        return $this->hasOne(CmsTemplates::className(), ['id' => 'cms_templates_ref']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTree()
    {
        return $this->hasOne(CmsTree::className(), ['id' => 'cms_tree_ref']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCmsNodeGalleries()
    {
        return $this->hasMany(CmsNodeGallery::className(), ['cms_node_content_ref' => 'id']);
    }
}
