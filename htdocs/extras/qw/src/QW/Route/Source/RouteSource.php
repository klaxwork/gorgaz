<?php

namespace QW\Route\Source;

use QW\Route\Model\RouteModel;


class RouteSource
{

    public function criteria()
    {
        $criteria = new \CDbCriteria();
        $criteria->addCondition(
            [
                '"tree"."is_trash" IS FALSE',
            ]
        );
        $criteria->order = '"tree"."ns_left_key", "t"."dt_created" ASC';
        return $criteria;
    }

    public function make()
    {
        $model = \CmsAliases::model()
            // дополнительны выгрузить данные по региону и ноде
            ->with(
                [
                    'tree',
                    'tree.product.hasRegion.region',
                ]
            )
            ;
        $model->getDbCriteria()->mergeWith($this->criteria());
        return $model;
    }


    private function createRoute(\CActiveRecord $item)
    {
        $model = (new RouteModel)->load($item);
        if (!empty($item->tree)) {
            $model->load($item->tree)
                ->setAttr('root_id', $item->tree->ns_root_ref)
                ->setAttr('node_id', $item->tree->id)
            ;
        }
        if (!empty($item->tree->product->hasRegion->region)) {
            $model->load($item->tree->product->hasRegion->region);
        }

        return $model;
    }

    public function getCollection()
    {
        $collection = array();
        $allRecords = $this->make()->findAll();
        if (!empty($allRecords)) {
            foreach ($allRecords as $item) {
                // create model and load data
                $collection[] = $this->createRoute($item);
            }
        }
        return $collection;
    }

    public function getNode($id)
    {
        $item = $this->make()
            ->alive() // >> выгружать только "живые" url
            ->findByAttributes(['cms_tree_ref' => $id])
            ;

        if (!empty($item)) {
            return $this->createRoute($item);
        }
    }

}
