<?php

namespace common\models\ar;

use Yii;

/**
 * This is the model class for table "sys_notify_templates".
 *
 * @property int $id
 * @property int $sys_notify_services_ref
 * @property int $sys_notify_types_ref
 * @property string $template_name
 * @property string $template_body
 * @property string $render_engine
 * @property string $description
 * @property string $alias
 * @property string $subject
 *
 * @property SysNotifyEventHasTemplates[] $sysNotifyEventHasTemplates
 * @property SysNotifyServices $sysNotifyServicesRef
 * @property SysNotifyTypes $sysNotifyTypesRef
 */
class RArSysNotifyTemplates extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'sys_notify_templates';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['sys_notify_services_ref', 'sys_notify_types_ref', 'template_name'], 'required'],
            [['sys_notify_services_ref', 'sys_notify_types_ref'], 'default', 'value' => null],
            [['sys_notify_services_ref', 'sys_notify_types_ref'], 'integer'],
            [['template_body', 'description'], 'string'],
            [['template_name', 'alias', 'subject'], 'string', 'max' => 255],
            [['render_engine'], 'string', 'max' => 10],
            [['sys_notify_services_ref'], 'exist', 'skipOnError' => true, 'targetClass' => SysNotifyServices::className(), 'targetAttribute' => ['sys_notify_services_ref' => 'id']],
            [['sys_notify_types_ref'], 'exist', 'skipOnError' => true, 'targetClass' => SysNotifyTypes::className(), 'targetAttribute' => ['sys_notify_types_ref' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'sys_notify_services_ref' => 'Sys Notify Services Ref',
            'sys_notify_types_ref' => 'Sys Notify Types Ref',
            'template_name' => 'Template Name',
            'template_body' => 'Template Body',
            'render_engine' => 'Render Engine',
            'description' => 'Description',
            'alias' => 'Alias',
            'subject' => 'Subject',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSysNotifyEventHasTemplates()
    {
        return $this->hasMany(SysNotifyEventHasTemplates::className(), ['sys_notify_template_ref' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSysNotifyServicesRef()
    {
        return $this->hasOne(SysNotifyServices::className(), ['id' => 'sys_notify_services_ref']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSysNotifyTypesRef()
    {
        return $this->hasOne(SysNotifyTypes::className(), ['id' => 'sys_notify_types_ref']);
    }
}
