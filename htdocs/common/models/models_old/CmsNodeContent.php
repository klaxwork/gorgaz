<?php

namespace common\models\models;

use common\components\M;
use Yii;
use common\models\ar\RArCmsNodeContent;
use common\models\models\CmsTree;
use yii\helpers\Url;

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
class CmsNodeContent extends RArCmsNodeContent
{
    public function rules()
    {
        $safe = [
            'cms_tree_ref',
            'cms_templates_ref',
            'page_title',
            'page_longtitle',
            'page_teaser',
            'page_body',
            'vcs_revision',
            'dt_updated',
            'dt_archived',
            'page_description',
            'seo_title',
            'seo_keywords',
            'seo_description',
            'is_seo_noindexing',
            'is_published',
            'is_in_markets',
            'is_in_google',
            'url_alias',
        ];
        return [
            [['cms_tree_ref', 'cms_templates_ref', 'page_title'], 'required'],
            [['cms_tree_ref', 'cms_templates_ref', 'vcs_revision'], 'default', 'value' => null],
            [['cms_tree_ref', 'cms_templates_ref', 'vcs_revision'], 'integer'],
            [['page_longtitle', 'page_teaser', 'page_body', 'page_description', 'seo_description'], 'string'],
            [$safe, 'safe'],
            //[['is_seo_noindexing', 'is_published', 'is_in_markets', 'is_in_google'], 'boolean'],
            [['page_title', 'seo_title', 'seo_keywords', 'url_alias'], 'string', 'max' => 255],
            //[['cms_templates_ref'], 'exist', 'skipOnError' => true, 'targetClass' => CmsTemplates::className(), 'targetAttribute' => ['cms_templates_ref' => 'id']],
            [['cms_tree_ref'], 'exist', 'skipOnError' => true, 'targetClass' => CmsTree::className(), 'targetAttribute' => ['cms_tree_ref' => 'id']],
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTemplate()
    {
        return $this->hasOne(CmsTemplates::className(), ['id' => 'cms_templates_ref'])->alias('template');
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
    public function getHasGallery()
    {
        return $this->hasOne(CmsNodeGallery::className(), ['cms_node_content_ref' => 'id'])->alias('hasGallery');
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getHasGalleries()
    {
        return $this->hasMany(CmsNodeGallery::className(), ['cms_node_content_ref' => 'id'])->alias('hasGalleries');
    }

    //получить все доступные нужные картинки из базы
    public function getImages()
    {
        $query = CmsNodeGallery::find()
            ->alias('hasGalleries')
            ->where('cms_node_content_ref = :id', [':id' => $this->id])
            ->joinWith(
                [
                    'gallery.storage.croppeds.cropped',
                    'gallery.category',
                ]
            )
            ->orderBy(['on_view_position' => SORT_ASC]);

        //выбираем все картинки данного контента
        $query = CmsNodeGallery::find()
            ->alias('hasGalleries')
            ->where('cms_node_content_ref = :id', [':id' => $this->id])
            ->joinWith(
                [
                    'storage', //.croppeds.cropped.category',
                ]
            )
            ->orderBy(['on_view_position' => SORT_ASC]);

        $oHasGalleries = $query->all();
        //M::printr($oHasGalleries, '$oHasGalleries');

        if (empty($oHasGalleries)) {
            return false;
        }

        //вносим их в один массив
        $images = [];
        foreach ($oHasGalleries as $oHasGallery) {
            //M::printr($oHasGallery, '$oHasGallery');
            if (empty($oHasGallery->cms_media_storage_ref) && !empty($oHasGallery->gallery)) {
                $oGal = $oHasGallery->gallery;
                $oHasGallery->cms_media_storage_ref = $oGal->cms_media_storage_ref;
                if (!$oHasGallery->save()) {
                    M::printr($oHasGallery, '$oHasGallery');
                }
            }
            $oStorage = $oHasGallery->storage;
            $images[] = $oStorage;
            //M::printr($oStorage, '$oStorage');
        }

        return $images;
    }

    public function getBreadcrumbs()
    {
        $oNode = $this->tree;

        $breadcrumbs = $oNode->getBreadcrumbs();
        return $breadcrumbs;
    }

}
