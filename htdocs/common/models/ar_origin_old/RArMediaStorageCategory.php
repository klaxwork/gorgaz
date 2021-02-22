<?php

namespace common\models\ar_origin;

use Yii;

/**
 * This is the model class for table "media_storage_category".
 *
 * @property int $id
 * @property string|null $category_name
 * @property string|null $dev_key
 * @property string|null $data
 * @property bool|null $is_multiple
 */
class RArMediaStorageCategory extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'media_storage_category';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['data'], 'string'],
            [['is_multiple'], 'boolean'],
            [['category_name', 'dev_key'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'category_name' => 'Category Name',
            'dev_key' => 'Dev Key',
            'data' => 'Data',
            'is_multiple' => 'Is Multiple',
        ];
    }
}
