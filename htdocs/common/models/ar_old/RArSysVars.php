<?php

namespace common\models\ar;

use Yii;

/**
 * This is the model class for table "sys_vars".
 *
 * @property int $id
 * @property string $var_name
 * @property string $variable
 * @property string $value
 * @property int $ecm_custom_field_meta_ref
 */
class RArSysVars extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'sys_vars';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['value'], 'string'],
            [['ecm_custom_field_meta_ref'], 'default', 'value' => null],
            [['ecm_custom_field_meta_ref'], 'integer'],
            [['var_name', 'variable'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'var_name' => 'Var Name',
            'variable' => 'Variable',
            'value' => 'Value',
            'ecm_custom_field_meta_ref' => 'Ecm Custom Field Meta Ref',
        ];
    }
}
