<?php

namespace common\models\ar;

use Yii;

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
class RArCmsAliases extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'cms_aliases';
    }

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
            [['cms_site_ref'], 'exist', 'skipOnError' => true, 'targetClass' => CmsSite::className(), 'targetAttribute' => ['cms_site_ref' => 'id']],
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
            'cms_site_ref' => 'Cms Site Ref',
            'cms_tree_ref' => 'Cms Tree Ref',
            'url_md5hash' => 'Url Md5hash',
            'url_path' => 'Url Path',
            'dt_created' => 'Dt Created',
            'dt_updated' => 'Dt Updated',
            'is_deprecated' => 'Is Deprecated',
            'is_deleted' => 'Is Deleted',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCmsSiteRef()
    {
        return $this->hasOne(CmsSite::className(), ['id' => 'cms_site_ref']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCmsTreeRef()
    {
        return $this->hasOne(CmsTree::className(), ['id' => 'cms_tree_ref']);
    }
}
