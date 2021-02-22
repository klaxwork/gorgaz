<?php

namespace common\models\models;

use Yii;
use common\models\ar\RArSysNotifyEvents;

/**
 * This is the model class for table "sys_notify_events".
 *
 * @property int $id
 * @property string $event_name
 * @property string $event_alias
 *
 * @property SysNotifyEventHasTemplates[] $sysNotifyEventHasTemplates
 */
class SysNotifyEvents extends RArSysNotifyEvents
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'sys_notify_events';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['event_name', 'event_alias'], 'required'],
            [['event_name', 'event_alias'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'event_name' => 'Event Name',
            'event_alias' => 'Event Alias',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getHasTemplates()
    {
        return $this->hasMany(SysNotifyEventHasTemplates::className(), ['sys_notify_event_ref' => 'id'])
            ->alias('hasTemplates');
    }
}
