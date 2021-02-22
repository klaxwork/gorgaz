<?php

namespace common\models\ar_inherit;

use Yii;
use common\models\ar_origin\RArAclGroups;

/**
 * This is the model class for table "acl_groups".
 *
 * @property int $id
 * @property string $group_key
 * @property string $group_name
 * @property string $description
 * @property int $acl_init_ref
 *
 * @property AclInit $aclInitRef
 * @property AclUsers[] $aclUsers
 */
class AclGroups extends RArAclGroups
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'acl_groups';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['group_key', 'group_name'], 'required'],
            [['acl_init_ref'], 'default', 'value' => null],
            [['acl_init_ref'], 'integer'],
            [['group_key'], 'string', 'max' => 30],
            [['group_name', 'description'], 'string', 'max' => 255],
            [['acl_init_ref'], 'exist', 'skipOnError' => true, 'targetClass' => AclInit::className(), 'targetAttribute' => ['acl_init_ref' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'group_key' => 'Group Key',
            'group_name' => 'Group Name',
            'description' => 'Description',
            'acl_init_ref' => 'Acl Init Ref',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAclInitRef()
    {
        return $this->hasOne(AclInit::className(), ['id' => 'acl_init_ref']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAclUsers()
    {
        return $this->hasMany(AclUsers::className(), ['acl_groups_ref' => 'id']);
    }
}
