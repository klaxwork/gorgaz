<?php

namespace common\models\ar;

use Yii;

/**
 * This is the model class for table "app_redirects".
 *
 * @property int $id
 * @property string $from_url
 * @property string $to_url
 * @property string $dt_created
 * @property string $dt_updated
 * @property bool $is_deprecated
 * @property bool $is_deleted
 */
class RArAppRedirects extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'app_redirects';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['from_url', 'to_url'], 'required'],
            [['from_url', 'to_url'], 'string'],
            [['dt_created', 'dt_updated'], 'safe'],
            [['is_deprecated', 'is_deleted'], 'boolean'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'from_url' => 'From Url',
            'to_url' => 'To Url',
            'dt_created' => 'Dt Created',
            'dt_updated' => 'Dt Updated',
            'is_deprecated' => 'Is Deprecated',
            'is_deleted' => 'Is Deleted',
        ];
    }
}
