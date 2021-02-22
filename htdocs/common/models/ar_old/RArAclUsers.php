<?php

namespace common\models\ar;

use Yii;

/**
 * This is the model class for table "acl_users".
 *
 * @property int $id
 * @property int $acl_groups_ref
 * @property string $username
 * @property string $password
 * @property string $data
 * @property bool $is_edi
 * @property bool $is_active
 * @property string $dt_created
 * @property string $dt_updated
 *
 * @property AclGroups $aclGroupsRef
 * @property AppEmployeeHasUsers[] $appEmployeeHasUsers
 */
class RArAclUsers extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'acl_users';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['acl_groups_ref', 'username'], 'required'],
            [['acl_groups_ref'], 'default', 'value' => null],
            [['acl_groups_ref'], 'integer'],
            [['data'], 'string'],
            [['is_edi', 'is_active'], 'boolean'],
            [['dt_created', 'dt_updated'], 'safe'],
            [['username'], 'string', 'max' => 50],
            [['password'], 'string', 'max' => 128],
            [['username'], 'unique'],
            [['acl_groups_ref'], 'exist', 'skipOnError' => true, 'targetClass' => AclGroups::className(), 'targetAttribute' => ['acl_groups_ref' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'acl_groups_ref' => 'Acl Groups Ref',
            'username' => 'Username',
            'password' => 'Password',
            'data' => 'Data',
            'is_edi' => 'Is Edi',
            'is_active' => 'Is Active',
            'dt_created' => 'Dt Created',
            'dt_updated' => 'Dt Updated',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAclGroupsRef()
    {
        return $this->hasOne(AclGroups::className(), ['id' => 'acl_groups_ref']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAppEmployeeHasUsers()
    {
        return $this->hasMany(AppEmployeeHasUsers::className(), ['acl_users_ref' => 'id']);
    }
}
