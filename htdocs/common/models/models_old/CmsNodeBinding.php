<?php

namespace common\models\models;

use Yii;
use common\models\ar\RArCmsNodeBinding;

/**
 * This is the model class for table "cms_node_binding".
 *
 * @property int $id
 * @property int $cms_tree_ref
 * @property string $dev_key
 * @property string $bind_key
 * @property string $data
 * @property string $mode - modes: HANDLER,WORKER, ROUTER, BRANCH, MODULE
 * @property string $description
 *
 * @property CmsTree $cmsTreeRef
 */
class CmsNodeBinding extends RArCmsNodeBinding
{
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTree()
    {
        return $this->hasOne(CmsTree::className(), ['id' => 'cms_tree_ref'])->alias('Tree');
    }
}
