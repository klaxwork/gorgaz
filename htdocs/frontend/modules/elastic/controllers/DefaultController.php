<?php

namespace frontend\modules\elastic\controllers;

use common\models\ElSearch;
use common\models\ElSearchFilter;
use yii\base\Exception;
use yii\helpers\Json;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use frontend\components\FrontendController;
use common\models\models\CmsTree;
use common\components\M;
use yii\elasticsearch;

/**
 * Default controller for the `cms` module
 */
class DefaultController extends FrontendController
{
    public function actionIndex() {
        return $this->render('index');
    }

    public function actionView($id = 200) {
        $oCategory = CmsTree::find()
            ->alias('tree')
            ->joinWith(['content'])
            ->where('tree.id = :id', [':id' => $id])
            ->one();
        $oChs = $oCategory
            ->children(1)
            ->with('content')
            ->all();
        return $this->render('view', ['oCategory' => $oCategory, 'oChs' => $oChs]);
    }

    public function actionSearch($request = 'test') {
        $index = 'fish_test_server_products';
        M::printr($index, '$index');
        $type = 'product';
        M::printr($type, '$type');

        exit;

        //$request = '#016 Blue Mint';
        $request = str_replace(['.', ',', '-', ' '], '', strtolower($request));

        //M::printr($request, '$request');

        $index = ElSearchFilter::index();
        $type = ElSearchFilter::type();
        $query = ElSearchFilter::find();
        $query->index = $index;
        $query->type = $type;
        $query->limit(100);
        $query->with(['category.content']);
        $query->query([
            "multi_match" => [
                'query' => $request,
                'fields' => [
                    'vendor',
                    'name^2',
                    'long_name^3',
                    'description^4',
                ],
            ],
        ]
        );

        //M::printr($query, '$query');

        $resAll = $query->all();
        //M::printr($resAll, '$resAll');
        //M::printr(count($resAll), 'count($resAll)');
        $cats = [];
        foreach ($resAll as $res) {
            //M::printr($res, '$res');
            //M::printr($res->attributes, '$res->attributes');
            //M::printr($res->getScore(), '$res->getScore()');
            //print "<br>";
            $cats[$res->category_id] = $res;
        }
        //M::printr($resAll, '$resAll');
        $data = [];
        $data['resAll'] = $resAll;
        $data['cats'] = $cats;

        return $this->render('search', $data);
        if (0) {
            $client = \Elasticsearch\ClientBuilder::create()->setHosts([
                'host' => Yii::$app->params['elasticsearch']['host'],
                'port' => Yii::$app->params['elasticsearch']['port'],
            ]
            )->build();
            $product = array();
            /** поиск */
            $params = array();
            $params["scroll"] = "30s";
            $params['size'] = 100;
            $params['body']['query']['multi_match']['query'] = str_replace(['.', ',', '-', ' '], '', strtolower($request));

            $params['type'] = 'product';
            $params['body']['query']['multi_match']['fields'] = ['vendor', 'name^2', 'long_name^3', 'description^4'];
            $params['index'] = Yii::$app->params['elasticsearch']['nameDB'] . "_products";
            $result_product = $client->search($params);
            //M::printr($result_product, '$result_product');

            $params['type'] = 'category';
            $params['body']['query']['multi_match']['fields'] = ['name', 'long_name^2', 'description^3'];
            $params['index'] = Yii::$app->params['elasticsearch']['nameDB'] . "_categories";
            $result_categories = $client->search($params);

            M::printr($result_product, '$result_product');
            M::printr($result_categories, '$result_categories');
            return '';
        }

    }

    public function actionSearchProduct($request) {
        //M::printr($request, '$request');
        $JS = [
            'success' => true,
            'message' => '',
            'messages' => [],
        ];

        try {
            $query = ElSearch::find();
            $query->index = ElSearch::index();
            $query->type = ElSearch::type();
            //M::printr($query, '$query');
            //$query->limit(100);
            //$query->with(['category.content']);
            $query->query([
                    'bool' => [
                        'must' => [
                            'multi_match' => [
                                'query' => $request,
                                'fields' => [
                                    'title',
                                    'description^2',
                                    //'id^3',
                                    //'product_id^4',
                                ],
                            ],
                        ],
                    ],
                ]
            );
            //M::printr($query, '$query');
            $JS['query'] = $query;

            $oItems = $query->all();
            //M::printr($oItems, '$oItems');
            $JS['oItems'] = $oItems;

            if (1) {
                $products = [];
                foreach ($oItems as $oItem) {
                    $score = $oItem->getScore();
                    //M::printr($score, '$score');
                    $oProduct = $oItem->product;
                    //M::printr($oProduct, '$oProduct');
                    $product = $oItem->product->attributes;
                    $product['score'] = $oItem->getScore();
                    $product['is_fotos'] = !empty($oItem->product->hasStorages) ? 1 : 0;
                    $products[] = $product;
                }
                $JS['products'] = $products;
            }


        } catch (Exception $e) {
            //M::printr($e, '$e');
            $JS['success'] = false;
            $JS['message'] = $e->getMessage();
        }
        //$oProducts = Product::find()->orderBy('dt_created ASC')->all();
        //$JS['result'] = $oProducts;

        return Json::encode($JS);
    }

}
