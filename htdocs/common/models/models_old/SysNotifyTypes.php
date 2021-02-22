<?php

namespace common\models\models;

use Yii;
use common\models\ar\RArSysNotifyTypes;

/**
 * This is the model class for table "sys_notify_types".
 *
 * @property int $id
 * @property string $notify_type
 * @property string $description
 *
 * @property SysNotifyTemplates[] $sysNotifyTemplates
 */
class SysNotifyTypes extends RArSysNotifyTypes
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'sys_notify_types';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['notify_type'], 'required'],
            [['notify_type'], 'string', 'max' => 30],
            [['description'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'notify_type' => 'Notify Type',
            'description' => 'Description',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSysNotifyTemplates()
    {
        return $this->hasMany(SysNotifyTemplates::className(), ['sys_notify_types_ref' => 'id']);
    }
}
