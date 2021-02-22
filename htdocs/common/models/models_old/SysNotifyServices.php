<?php

namespace common\models\models;

use Yii;
use common\models\ar\RArSysNotifyServices;

/**
 * This is the model class for table "sys_notify_services".
 *
 * @property int $id
 * @property string $notify_service
 * @property string $description
 *
 * @property SysNotifyTemplates[] $sysNotifyTemplates
 */
class SysNotifyServices extends RArSysNotifyServices
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'sys_notify_services';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['notify_service'], 'required'],
            [['notify_service', 'description'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'notify_service' => 'Notify Service',
            'description' => 'Description',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSysNotifyTemplates()
    {
        return $this->hasMany(SysNotifyTemplates::className(), ['sys_notify_services_ref' => 'id']);
    }
}
