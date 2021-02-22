<?php

namespace common\models\models;

use Yii;
use common\models\ar\RArCmsAliases;

//use common\models\ar\RArCmsSite;

/**
 * This is the model class for table "cms_aliases".
 *
 * @property int $id
 * @property int $cms_site_ref
 * @property int $cms_tree_ref
 * @property string $url_md5hash
 * @property string $url_path
 * @property string $dt_created
 * @property string $dt_updated
 * @property bool $is_deprecated - ресурс устарел 304
 * @property bool $is_deleted - ресурс удален 404
 *
 * @property CmsSite $cmsSiteRef
 * @property CmsTree $cmsTreeRef
 */
class CmsAliases extends RArCmsAliases
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['cms_site_ref', 'cms_tree_ref'], 'required'],
            [['cms_site_ref', 'cms_tree_ref'], 'default', 'value' => null],
            [['cms_site_ref', 'cms_tree_ref'], 'integer'],
            [['dt_created', 'dt_updated'], 'safe'],
            [['is_deprecated', 'is_deleted'], 'boolean'],
            [['url_md5hash'], 'string', 'max' => 32],
            [['url_path'], 'string', 'max' => 255],
            //[['cms_site_ref'], 'exist', 'skipOnError' => true, 'targetClass' => CmsSite::className(), 'targetAttribute' => ['cms_site_ref' => 'id']],
            [['cms_tree_ref'], 'exist', 'skipOnError' => true, 'targetClass' => CmsTree::className(), 'targetAttribute' => ['cms_tree_ref' => 'id']],
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSite()
    {
        return $this->hasOne(CmsSite::className(), ['id' => 'cms_site_ref'])->alias('site');
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTree()
    {
        return $this->hasOne(CmsTree::className(), ['id' => 'cms_tree_ref'])->alias('tree');
    }
}
