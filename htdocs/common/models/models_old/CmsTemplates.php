<?php

namespace common\models\models;

use Yii;
use common\models\ar\RArCmsTemplates;

/**
 * This is the model class for table "cms_templates".
 *
 * @property int $id
 * @property string $template_name
 * @property string $template_body
 * @property string $render_layout
 * @property string $render_engine
 * @property string $description
 * @property bool $is_default
 * @property string $dt_created
 * @property string $dt_updated
 * @property string $render_view
 *
 * @property CmsNodeContent[] $cmsNodeContents
 */
class CmsTemplates extends RArCmsTemplates
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'cms_templates';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['template_name'], 'required'],
            [['template_body', 'description'], 'string'],
            [['is_default'], 'boolean'],
            [['dt_created', 'dt_updated'], 'safe'],
            [['template_name', 'render_layout', 'render_view'], 'string', 'max' => 255],
            [['render_engine'], 'string', 'max' => 10],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'template_name' => 'Template Name',
            'template_body' => 'Template Body',
            'render_layout' => 'Render Layout',
            'render_engine' => 'Render Engine',
            'description' => 'Description',
            'is_default' => 'Is Default',
            'dt_created' => 'Dt Created',
            'dt_updated' => 'Dt Updated',
            'render_view' => 'Render View',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCmsNodeContents()
    {
        return $this->hasMany(CmsNodeContent::className(), ['cms_templates_ref' => 'id']);
    }
}
