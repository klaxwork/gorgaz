<?php

namespace common\models\ar;

use creocoder\nestedsets\NestedSetsQueryBehavior;

class RArCmsTreeQuery extends \yii\db\ActiveQuery
{
    public function behaviors()
    {
        return [
            NestedSetsQueryBehavior::className(),
        ];
    }
}