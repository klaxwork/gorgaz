<?php

namespace common\models\models;

use Yii;
use common\models\ar\RArSysNotifyEventHasTemplates;
/**
 * This is the model class for table "sys_notify_event_has_templates".
 *
 * @property int $id
 * @property int $sys_notify_event_ref
 * @property int $sys_notify_template_ref
 *
 * @property SysNotifyEvents $sysNotifyEventRef
 * @property SysNotifyTemplates $sysNotifyTemplateRef
 */
class SysNotifyEventHasTemplates extends RArSysNotifyEventHasTemplates
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'sys_notify_event_has_templates';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['sys_notify_event_ref', 'sys_notify_template_ref'], 'required'],
            [['sys_notify_event_ref', 'sys_notify_template_ref'], 'default', 'value' => null],
            [['sys_notify_event_ref', 'sys_notify_template_ref'], 'integer'],
            [['sys_notify_event_ref'], 'exist', 'skipOnError' => true, 'targetClass' => SysNotifyEvents::className(), 'targetAttribute' => ['sys_notify_event_ref' => 'id']],
            [['sys_notify_template_ref'], 'exist', 'skipOnError' => true, 'targetClass' => SysNotifyTemplates::className(), 'targetAttribute' => ['sys_notify_template_ref' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'sys_notify_event_ref' => 'Sys Notify Event Ref',
            'sys_notify_template_ref' => 'Sys Notify Template Ref',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEvent()
    {
        return $this->hasOne(SysNotifyEvents::className(), ['id' => 'sys_notify_event_ref'])->alias('event');
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTemplate()
    {
        return $this->hasOne(SysNotifyTemplates::className(), ['id' => 'sys_notify_template_ref'])->alias('template');
    }
}
