<?php

namespace common\models;

use common\components\M;
use common\models\ar_inherit\Product;
use common\models\models\AppProducts;
use common\models\models\CmsNodeProperties;
use common\models\models\CmsTree;
use common\models\models\EcmCustomFieldDictionary;
use common\models\models\EcmCustomFields;
use common\models\models\EcmProductFields;
use common\models\models\EcmProducts;
use yii\db\Exception;
use yii\helpers\ArrayHelper;
use yii\helpers\Json;
use yii\elasticsearch\ActiveRecord as ElasticActiveRecord;

class ElSearch extends ElasticActiveRecord
{
    //public $is_price;

    public static function getDb($id = 'elasticsearch') {
        return \Yii::$app->get($id);
    }

    public static function index() {
        return 'test_mem_index';
        //return 'fish_filter_test_filter_products';
        return 'fish5_test_filter';
        return 'fish5_filter_test_filter_products'; //'fish_test_server_products';
    }

    public static function type() {
        return '_doc';
        return 'test_mem_type';
        //return 'products'; //'product';
        return 'filter_products';
        return 'fish5_productFilter'; //'product';
    }

    public function attributes() {
        $ret = [
            'title',
            'description',
            'id',
            'product_id',
        ];
        return $ret;
    }

    public function rules() {
        return [
            [['id', 'product_id', 'title', 'description'], 'safe']
        ];
    }

    public static function setting() {
        return [
            'number_of_shards' => 1,
            'number_of_replicas' => 0,
            'max_ngram_diff' => 25,
            'analysis' => [
                'filter' => [
                    'shingle' => [
                        'type' => 'shingle'
                    ],
                    'app_ngram' => [
                        'type' => "ngram",
                        'min_gram' => 3,
                        'max_gram' => 20,
                    ],
                    'stopwords' => [
                        'type' => 'stop',
                        'stopwords' => ['_french_'],
                        'igrore_case' => true,
                    ]
                ],
                'analyzer' => [
                    'reuters' => [
                        'type' => 'custom',
                        'tokenizer' => 'ngram',
                        'filter' => ['lowercase', 'stop', 'kstem']
                    ],
                    'app_analyzer' => [
                        'type' => 'custom',
                        'tokenizer' => 'ngram',
                        'filter' => ['stopwords', 'app_ngram', 'asciifolding', 'lowercase', 'snowball']
                    ],
                    'app_search_analyzer' => [
                        'type' => 'custom',
                        'tokenizer' => 'standard',
                        'filter' => ['stopwords', 'app_ngram', 'asciifolding', 'lowercase', 'snowball']
                    ]
                ],
                'tokenizer' => [
                    'nGram' => [
                        'type' => "ngram",
                        'min_gram' => 3,
                        'max_gram' => 20
                    ]
                ],
            ]
        ];
    }

    public static function mapping() {
        if (0) {
            return [
                static::type() => Json::decode(
                    '{
    "properties": {
        "title": {
            "type": "text",
            "analyzer": "reuters"
        },
        "description": {
            "type": "text",
            "analyzer": "reuters"
        },
        "id": {
            "type": "long"
        },
        "product_id": {
            "type": "long"
        }
    }
}'
                ),
            ];
        }

        if (1) {
            return [
                'properties' => [
                    'title' => [
                        'type' => 'text',
                        'analyzer' => 'reuters',
                    ],
                    'description' => [
                        'type' => 'text',
                        'analyzer' => 'reuters',
                    ],
                    'id' => [
                        'type' => 'long',
                    ],
                    'product_id' => [
                        'type' => 'long',
                    ],
                ],
            ];
        }
    }

    public static function updateMapping() {
        $db = static::getDb();
        $command = $db->createCommand();
        $command->setMapping(static::index(), static::type(), static::mapping());
    }

    public static function createIndex() {
        M::printr('Создание индекса');
        $db = static::getDb('elasticsearch');
        //M::printr($db, '$db');
        $command = $db->createCommand();
        $index = static::index();
        M::printr($index, '$index');
        $type = static::type();
        M::printr($type, '$type');
        //exit;
        $command->createIndex(
            static::index(), [
                'settings' => static::setting(),
                'mappings' => static::mapping(),
//'warmers' => [ /* ... */ ],
//'aliases' => [ /* ... */ ],
//'creation_date' => '...'
            ]
        );
    }

    public static function deleteIndex($indexForDel = false) {
        M::printr('Удаление индекса');
        $db = static::getDb('elasticsearch');
        //M::printr($db, '$db');
        $command = $db->createCommand();
        $index = static::index();
        M::printr($index, '$index');
        if ($indexForDel) {
            $index = $indexForDel;
        }
        $command->deleteIndex($index, static::type());
    }

    public function getProduct() {
        return $this->hasOne(Product::className(), ['id' => 'product_id'])->orderBy('id')->alias('product');
    }

    public function getCategory() {
        return $this->hasOne(CmsTree::className(), ['id' => 'category_id'])->orderBy('id')->alias('category');
    }

    public function getCatalog() {
        return $this->hasOne(CmsTree::className(), ['id' => 'category_id'])->orderBy('id')->alias('catalog');
    }

    /**
     * Defines a scope that modifies the `$query` to return only active(status = 1) customers
     */
    public static function active($query) {
        $query->andWhere(['status' => 1]);
    }

    public static function getConfig($postConfig = []) {
        $FilterForm = 'FilterForm';
        $first_page_limit = 40;
        $limit_page = 20;
        if (empty($_POST[$FilterForm])) {
            $_POST[$FilterForm] = [];
        }
        $defaultConfig = [
            'limit' => 40,
            'offset' => 0,
            'order' => 'price_up',
            'sort' => 'ASC',
            'countProducts' => 0,
            'countAll' => 0,
        ];

        //привели $_POST в нужный вид
        foreach ($_POST[$FilterForm] as $key => $postLine) {
            $minmax = $postLine;
            if (!is_array($postLine)) {
                $minmax = [];
                if (strpos($postLine, ';') !== false) {
                    $explode = explode(';', $postLine);
                    $minmax['min'] = $explode[0];
                    $minmax['max'] = $explode[1];
                } else {
                    $minmax = $postLine;
                }
            }
            $_POST[$FilterForm][$key] = $minmax;
        }

        //M::printr($_POST, 'Filter.php $_POST');

        $config = array_merge([], $defaultConfig, $_POST[$FilterForm], $postConfig);
        //M::printr($config, '$config END');
        return $config;
    }

    public static function getFilterData($categoryId = 200) {
        $formName = 'FilterForm';
        $filter = [];
        //M::printr($categoryId, '$categoryId');
        $param = CmsNodeProperties::find()
            ->where(
                [
                    'cms_tree_ref' => $categoryId,
                    'cms_node_properties_fields_ref' => 5,
                ]
            )->one();
        //M::printr($param, '$param');

        if (empty($param)) {
            $array_id = [];
        } else {
            $array_id = Json::decode($param->property_value, true);
        }
        //M::printr($array_id, '$array_id');

        $array_ecm_custom_fields_id = [];
        foreach ($array_id as $pole_type => $pole_array) {
            if ($pole_type != 'price') {
                $array_ecm_custom_fields_id = array_merge($array_ecm_custom_fields_id, array_keys($pole_array));
            }
        }
        //M::printr($array_ecm_custom_fields_id, '$array_ecm_custom_fields_id');

        $properties = EcmCustomFields::find()
            ->indexBy('id')
            ->where(['in', 'id', $array_ecm_custom_fields_id])
            ->all();
        //M::printr($properties, '$properties');
        foreach ($array_id as $type_pole => $type_array_id) {
            switch ($type_pole) {
                case 'price' :
                    $filter['price']['meta'] = (object)[
                        'id' => 'price',
                        'ecm_custom_field_meta_ref' => 'price',
                        'field_key' => 'price',
                        'field_name' => 'Цена',
                        'field_unit' => 'руб.',
                    ];
                    $filter['price']['min'] = $type_array_id['min'];
                    $filter['price']['max'] = $type_array_id['max'];
                    $filter['price']['scale'] = 1;
                    //M::printr($filter['price'], '$filter[\'price\']');
                    break;
                case 'range' :
                    //M::printr($type_pole, '$type_pole');
                    //M::printr($type_array_id, '$type_array_id');
                    //M::printr($properties, '$properties');
                    foreach ($type_array_id as $ecm_custom_field_id => $ecm_product_field_id) {
                        //M::printr($ecm_custom_field_id, '$ecm_custom_field_id');
                        //M::printr($ecm_product_field_id, '$ecm_product_field_id');
                        //$isset = isset($properties[$ecm_custom_field_id]);
                        //M::printr($isset, '$isset');
                        //continue;
                        if ($type_array_id[$ecm_custom_field_id]['min'] == $type_array_id[$ecm_custom_field_id]['max']) {
                            continue;
                        }
                        $filter[$ecm_custom_field_id]['meta'] = (object)$properties[$ecm_custom_field_id]->getAttributes();
                        $filter[$ecm_custom_field_id]['min'] = $type_array_id[$ecm_custom_field_id]['min'];
                        $filter[$ecm_custom_field_id]['max'] = $type_array_id[$ecm_custom_field_id]['max'];
                        //var_dump(json_decode($properties[$ecm_custom_field_id]->field_data, true)['scale']);
                        $field_data = Json::decode($properties[$ecm_custom_field_id]->field_data, true);
                        $filter[$ecm_custom_field_id]['scale'] = empty($field_data['scale']) ? 0.1 : $field_data['scale'];
                    }
                    break;
                case 'list' :
                    foreach ($type_array_id as $ecm_custom_field_id => $ecm_product_field_id) {
                        if (count($ecm_product_field_id) < 2) {
                            continue;
                        }
                        $filter[$ecm_custom_field_id]['meta'] = (object)$properties[$ecm_custom_field_id]->getAttributes();
                    }
                    break;
                case 'range2' :
                    foreach ($type_array_id as $ecm_custom_field_id => $ecm_product_field_id) {
                        //$filter[$ecm_custom_field_id]['meta'] = (object)$properties[$ecm_custom_field_id]->getAttributes();
                    }
                    break;
            }
        }

        if (0) {
            $criteria = new CDbCriteria();
            $criteria->addInCondition('t.id', $array_ecm_custom_fields_id);
            $criteria->index = "id";
            $properties = EcmCustomFields::model()->findAll($criteria);

            foreach ($array_id as $type_pole => $type_array_id) {
                switch ($type_pole) {
                    case 'price' :
                        $filter['price']['meta'] = (object)array(
                            'id' => 'price',
                            'ecm_custom_field_meta_ref' => 'price',
                            'field_key' => 'price',
                            'field_name' => 'Цена',
                            'field_unit' => 'руб.',
                        );
                        $filter['price']['min'] = $type_array_id['min'];
                        $filter['price']['max'] = $type_array_id['max'];
                        $filter['price']['scale'] = 1;
                        //M::printr($filter['price'], '$filter[\'price\']');
                        break;
                    case 'range' :
                        foreach ($type_array_id as $ecm_custom_field_id => $ecm_product_field_id) {
                            if ($type_array_id[$ecm_custom_field_id]['min'] == $type_array_id[$ecm_custom_field_id]['max']) {
                                continue;
                            }
                            $filter[$ecm_custom_field_id]['meta'] = (object)$properties[$ecm_custom_field_id]->getAttributes();
                            $filter[$ecm_custom_field_id]['min'] = $type_array_id[$ecm_custom_field_id]['min'];
                            $filter[$ecm_custom_field_id]['max'] = $type_array_id[$ecm_custom_field_id]['max'];
                            //var_dump(json_decode($properties[$ecm_custom_field_id]->field_data, true)['scale']);
                            $field_data = json_decode($properties[$ecm_custom_field_id]->field_data, true);
                            $filter[$ecm_custom_field_id]['scale'] = empty($field_data['scale']) ? 0.1 : $field_data['scale'];
                        }
                        break;
                    case 'list' :
                        foreach ($type_array_id as $ecm_custom_field_id => $ecm_product_field_id) {
                            if (count($ecm_product_field_id) < 2) {
                                continue;
                            }
                            $filter[$ecm_custom_field_id]['meta'] = (object)$properties[$ecm_custom_field_id]->getAttributes();
                        }
                        break;
                    case 'range2' :
                        foreach ($type_array_id as $ecm_custom_field_id => $ecm_product_field_id) {
                            //$filter[$ecm_custom_field_id]['meta'] = (object)$properties[$ecm_custom_field_id]->getAttributes();
                        }
                        break;
                }
            }
        }


        if (!empty($array_id['list'])) {
            $array_all_id = [];
            foreach ($array_id['list'] as $id_field => $array_id_dictionary) {
                if (count($array_id_dictionary) < 2) {
                    continue;
                }
                $array_all_id = ArrayHelper::merge($array_all_id, $array_id_dictionary);
            }

            $dictionary = EcmCustomFieldDictionary::find()
                ->indexBy('id')
                ->where(['in', 'id', $array_all_id])
                ->orderBy('field_value_view ASC')
                ->all();

            foreach ($dictionary as $entity) {
                $filter[$entity->ecm_custom_fields_ref][$entity->id] = $entity->field_value_view;
            }
        }
        //M::printr($filter, '$filter');
        return $filter;
    }

    public static function getElasticItems($categoryId = 200, $postConfig = []) {
        $config = self::getConfig($postConfig);
        //M::printr($config, '$config');

        $oCategory = CmsTree::find()->where(['id' => $categoryId])->one();
        //M::printr($oCategory, '$oCategory');
        $left_key = [];
        $left_key['gt'] = $oCategory->ns_left_key;
        $left_key['lt'] = $oCategory->ns_right_key;

        $filter = self::getFilterData($categoryId); //$Filter->getFilterData();
        //M::printr($filter, '$filter');

        $price['gte'] = 0;
        if (!empty($config['price'])) {
            if ($config['price']['min'] != $filter['price']['min']) {
                $price['gte'] = $config['price']['min'];
            }
            if ($config['price']['max'] != $filter['price']['max']) {
                $price['lte'] = $config['price']['max'];
            }
        }
        $query = [
            'bool' => [
                'filter' => [
                    [
                        'range' => [
                            'price' => $price,
                        ]
                    ],
                    [
                        'range' => [
                            'ns_left_key' => $left_key,
                        ],
                    ],
                ]
            ],
        ];

        if (!empty($config['check_in_stock'])) {
            $query['bool']['filter'][] = [
                'range' => [
                    'count' => [
                        'gt' => 0,
                    ]
                ]
            ];
        }

        if (!empty($config['check_new'])) {
            $query['bool']['filter'][] = [
                'range' => [
                    'labels.is_new' => [
                        'gt' => 0,
                    ]
                ]
            ];
        }

        if (!empty($config['check_sale'])) {
            $query['bool']['filter'][] = [
                'range' => [
                    'labels.is_sale' => [
                        'gt' => 0,
                    ]
                ]
            ];
        }

        $forFilter = [];
        $forMust = [];

        foreach ($filter as $key => $item) {
            if ($key == 'price') continue;
            if (!is_array($item)) continue;
            $key = $item['meta']->field_key;

            $oField = EcmCustomFields::findOne(['field_key' => $key]);
            switch ($oField->customFieldMeta->field_type) {
                case 'text':
                    //M::printr($oField->customFieldMeta->field_type, '$oField->customFieldMeta->field_type');
                    $value = [];
                    //M::printr($config[$key], '$config[$key]');
                    //M::printr($filter[$oField->id], '$filter[$oField->id]');
                    if (!empty($config[$key])) {
                        if ($config[$key]['min'] != $filter[$oField->id]['min']) {
                            $value['gte'] = $config[$key]['min'];
                        }
                        if ($config[$key]['max'] != $filter[$oField->id]['max']) {
                            $value['lte'] = $item['max'];
                        }
                    }

                    if (!empty($value)) {
                        $forFilter = [
                            'range' => [
                                $key => $value
                            ]
                        ];
                    }
                    //M::printr($forFilter, '$forFilter');
                    break;
                case 'range':
                    $value = [];
                    if (!empty($config[$key])) {
                        if ($config[$key]['min'] != $filter[$oField->id]['min']) {
                            //если поменяли минимум
                            $value['gte'] = $config[$key]['min'];
                            $query['bool']['filter'][] = [
                                'range' => [
                                    $key . '.max' => $value
                                ]
                            ];
                            $value = [];
                        }
                        if ($config[$key]['max'] != $filter[$oField->id]['max']) {
                            //если поменяли максимум
                            $value['lte'] = $config[$key]['max'];
                            $query['bool']['filter'][] = [
                                'range' => [
                                    $key . '.min' => $value
                                ]
                            ];
                            $value = [];
                        }
                    }
                    break;
                case 'ecm:dictionary_select':
                    $arr = [];
                    if (!empty($config[$key])) {
                        foreach ($config[$key] as $key2 => $value) {
                            if ($key2 == 'meta') continue;
                            $arr[] = $key2;
                        }
                        $forMust = [
                            'terms' => [
                                $oField->field_key => $arr,
                            ]
                        ];
                    }
                    break;
                case 'ecm:dictionary_enum':
                    if (empty($config[$key])) break;
                    if ($config[$key] !== 'any') {
                        if (!empty($config[$key])) {
                            $arr = $config[$key];
                            $forMust = [
                                'term' => [
                                    $oField->field_key => $arr,
                                ]
                            ];
                        }
                    }
                    break;
                default:
                    break;
            }

            if (!empty($forFilter)) {
                $query['bool']['filter'][] = $forFilter;
                $forFilter = [];
            }
            if (!empty($forMust)) {
                $query['bool']['must'][] = $forMust;
                $forMust = [];
            }
        }

        M::xlog(Json::encode($query), 'queryFilter');
        $config['query'] = $query;
        //M::printr($config, '$config');
        //$params['body']['query']['multi_match']['fields'] = ['vendor', 'name', 'long_name', 'description'];
        try {
            //получаем результаты из ElasticSearch`а
            //M::printr($config, '$config');

            $oQuery = ElSearch::find();
            $oQuery->index = ElSearch::index();
            $oQuery->type = ElSearch::type();
            $oQuery->query($query);
            $oQuery->limit(10000);
            //$oQuery->offset($config['offset']);
            $sort = 'is_price DESC, price ASC, category_name.keyword ASC';
            if ($config['order'] == 'price_down') {
                $sort = 'is_price DESC, price DESC, category_name.keyword ASC';
            }
            if ($config['order'] == 'name') {
                $sort = 'category_name.keyword ASC, price ASC';
            }
            $oQuery->orderBy("{$sort}");
            //$oQuery->asArray();
            //M::printr($oQuery, '$oQuery');

            $result = [];
            if (0) {
                $result = [];
                $tmf1 = microtime(1);
                $result = $oQuery->all();
                $tmf2 = microtime(1);
                //M::printr(count($result), 'count($result)');
                //M::printr($tmf2 - $tmf1, 'Сама выборка из базы данных, $tmf2 - $tmf1');
                $i = 0;
                foreach ($result as $item) {
                    //M::printr($item->price, "{$i} - {$item->category_name}");
                    //$i++;
                }
                $result = ElSearch::groupCategories($result);
                foreach ($result as $item) {
                    //M::printr($item->price, "{$i} - {$item->category_name}");
                    $i++;
                }

            }
            if (0) {
                $result = [];
                $tmf1 = microtime(1);
                $x = 0;
                $tmfe1 = microtime(1);
                foreach ($oQuery->each() as $item) {
                    $tmfe2 = microtime(true);
                    //M::printr($tmfe2 - $tmfe1, '$tmfe2 - $tmfe1');
                    $tmfe1 = $tmfe2;
                    if (!isset($items[$item->category_id])) {
                        $result[$item->category_id] = $item;
                    }
                    if (0 < $item->price && $item->price < $result[$item->category_id]->price) {
                        $result[$item->category_id] = $item;
                    }
                    if (count($result) >= ($config['limit'] + $config['offset'])) break;
                    $x++;
                }
                $tmf2 = microtime(1);
                //M::printr(count($result), 'count($result)');
                //M::printr($tmf2 - $tmf1, '??? Сама выборка из базы данных, $tmf2 - $tmf1');
                if (0) {
                    $i = 0;
                    foreach ($result as $item) {
                        M::printr($item->price, "{$i} - {$item->category_name}");
                        $i++;
                    }
                }
            }
            if (1) {
                $result = [];
                $tmf1 = microtime(1);

                $items = $oQuery
                    ->asArray()
                    ->all();
                //exit;
                $countAll = count($items);
                //print "<!-- - ->";
                //M::printr(count($items), 'count($items)');
                if (0) {
                    $ccc = 0;
                    foreach ($items as $item) {
                        M::printr($item, '$item');
                        $ccc++;
                        if ($ccc > 10) break;
                    }
                }
                //print "<!-- -->";
                //M::xlog(['count($items)' => count($items)]);

                $tmfe1 = microtime(1);

                //берем уникальные категории
                $category_ids = [];
                foreach ($items as $item) {
                    $category_ids['x' . $item['_source']['category_id']] = $item['_source']['category_id'];
                    if (count($category_ids) >= ($config['limit'] + $config['offset'])) break;
                }
                $category_ids = array_slice($category_ids, $config['offset'], $config['limit']);
                //M::printr($category_ids, '$category_ids');

                $products = [];
                foreach ($items as $item) {
                    if (!in_array($item['_source']['category_id'], $category_ids)) continue;
                    //M::printr($item, '$item');
                    //$products[] = $item['_source'];
                    //M::printr($item['_source'], '$item[\'_source\']');
                    $category_id = $item['_source']['category_id'];
                    $price = $item['_source']['price'];
                    $count = $item['_source']['count'];
                    //M::printr($price, '$price');
                    $tmfe2 = microtime(true);
                    //M::printr($tmfe2 - $tmfe1, '$tmfe2 - $tmfe1');
                    $tmfe1 = $tmfe2;

                    if (!isset($result[$category_id])) {
                        $result[$category_id] = $item['_source'];
                    }
                    if (0 < $price && $price < $result[$category_id]['price']) {
                        $result[$category_id] = $item['_source'];
                    }
                    if (!$result[$category_id]['is_price']) {
                        if ($price > 0) {
                            $result[$category_id]['is_price'] = true;
                        }
                    }
                    $result[$category_id]['count'] += $count;
                    if (!$result[$category_id]['is_count']) {
                        if ($count > 0) {
                            $result[$category_id]['is_count'] = true;
                        }
                    }

                    //M::printr($result[$category_id], '$result[$category_id]');
                    //if (count($result) >= ($config['limit'] + $config['offset'])) break;
                }
                $tmf2 = microtime(1);
                //M::printr(count($result), 'count($result)');
                //M::printr($tmf2 - $tmf1, '??? Сама выборка из базы данных, $tmf2 - $tmf1');

                $all = [];
                foreach ($items as $item) {
                    $all[$item['_source']['category_id']] = 1;
                }
                if (0) {
                    $i = 0;
                    foreach ($result as $item) {
                        M::printr($item->price, "{$i} - {$item->category_name}");
                        $i++;
                    }
                }
            }
            //M::printr(count($result), 'count($result)');

            $oQuery->limit(10000);
            $tx1 = microtime(true);
            //$all = []; //$oQuery->asArray()->all();
            $tx2 = microtime(true);
            M::xlog(['$tx2 - $tx1' => $tx2 - $tx1], 'queryFilter');
            //M::xlog(['countAll' => count($all)], 'queryFilter');

            $response = [
                'categories' => $result,
                'config' => $config,
                'countAll' => count($all),
                //'products' => $products,
            ];
            //$config['countAll'] = count($result);
            //M::printr($response, '$response');

            return $response;
        } catch (\Exception $e) {
            $messages = $e->getMessage();
            M::printr($messages, '$messages');
            M::printr($oQuery, '$oQuery');
            return false;
        }


    }

    public static function groupCategories($res = []) {
        //сгруппировать по категориям
        $categories = [];
        foreach ($res as $row) {
            if (empty($categories[$row->category_id])) {
                $categories[$row->category_id] = $row;
            }
            if ($row->price > 0 && $row->price < $categories[$row->category_id]->price) {
                $categories[$row->category_id] = $row;
            }
        }
        return $categories;
    }

    public static function checkPublish($oNode) {
        if (!$oNode->is_node_published) {
            return false;
        }

        $oAncestors = $oNode->parents()->all();
        foreach ($oAncestors as $oAncestor) {
            if (!$oAncestor->is_node_published) {
                return false;
            }
        }
        return true;
    }

    public static function genFilterProducts() {
        if (0) {
            $oCategory = CmsTree::findOne(200); // 339, 908
            M::printr($oCategory->attributes, '$oCategory->attributes');
            $oProducts = EcmProducts::find()
                ->alias('t')
                ->joinWith(['appProduct.tree'])
                ->where(
                    [
                        't.is_trash' => false,
                        't.is_closed' => false,
                    ]
                )
                ->andOnCondition(':ns_left <= tree.ns_left_key AND tree.ns_left_key <= :ns_right')
                ->andOnCondition('tree.ns_root_ref = 200')
                ->andOnCondition('tree.is_node_published IS NOT FALSE')
                ->params(
                    [
                        ':ns_left' => $oCategory->ns_left_key,
                        ':ns_right' => $oCategory->ns_right_key,
                    ]
                )
                ->all();
            if (empty($oProducts)) {
                $oProducts = [];
            }
            //M::printr($products, '$products');
            M::printr(count($oProducts), 'Найдено товаров');

            $i = 0;
            $percents100 = count($oProducts);
            foreach ($oProducts as $oProduct) {
                if (empty($oProduct->appProduct)) continue;
                if (empty($oProduct->appProduct->tree)) continue;
                if (!self::checkPublish($oProduct->appProduct->tree)) continue;

                $item = new ElSearch();
                $item->primaryKey = $oProduct->id;
                $item->product_id = $oProduct->id;
                M::printr(">>>>>>>>>>>>>>>>>>>>>>>>>>>> [{$oProduct->id}] {$oProduct->product_name}");

                //заполняем для поиска (search)
                if (1) {
                    $oVendor = $oProduct->getField('1c_product_vendor');
                    $item->vendor = $oVendor->field_value;
                    $item->name = $oProduct->product_name;
                    $item->long_name = $oProduct->product_long_name;
                    $item->description = $oProduct->product_description;
                }

                $oAppProduct = $oProduct->appProduct;
                $oTree = $oAppProduct->tree;
                $oContent = $oTree->content;

                $urlImg = '/images/noimg.jpg';
                $oImages = $oTree->content->getImages();
                if (!empty($oImages[0])) {
                    $oImage = $oImages[0]->getCropped('ecm:teaser_small');
                    M::printr($oImage->attributes, '$oImage->attributes');
                    $urlImg = '/store' . $oImage->fs_alias;
                }

                if (1) {
                    //если у товара есть картинка, то поставить картинку из товара
                    $oImages = $oProduct->getImages();
                    if (!empty($oImages[0])) {
                        $oImage = $oImages[0]->getCropped('ecm:teaser_small');
                        M::printr($oImage->attributes, '$oImage->attributes');
                        $urlImg = '/store' . $oImage->fs_alias;
                    }
                }


                //$item->category = $oTree->id;
                $item->category_id = $oTree->id;
                $item->category_name = !empty($oContent->page_longtitle) ? $oContent->page_longtitle : $oContent->page_title;
                $item->ns_left_key = $oTree->ns_left_key;
                $item->img = $urlImg;

                $oLabels = $oProduct->getLabels();
                $item->labels = [
                    'is_new' => (int)!empty($oLabels['is_new']),
                    'is_sale' => (int)!empty($oLabels['is_sale']),
                ];

                $count = (int)$oProduct->getProductCount();
                $item->count = $count;
                M::printr($count, '(int)$oProduct->getProductCount()');
                $item->is_count = $count > 0;

                $oFields = $oProduct->getProductFields();
                //M::printr($oFields, '$oFields');
                $exit = false;
                foreach ($oFields as $oField) {
                    M::printr($oField->customField->customFieldMeta->field_meta, $oField->customField->customFieldMeta->field_type);
                    M::printr($oField->customField->field_key, '$oField->customField->field_key');
                    switch ($oField->customField->customFieldMeta->field_meta) {
                        case 'dictionary/list':
                            if (empty($oField->customFieldDict)) continue 2;
                            M::printr($oField->customFieldDict->id, $oField->customField->field_name);
                            $item->{$oField->customField->field_key} = (float)$oField->customFieldDict->id;
                            //$body[$oField->customField->field_key] = (float)$oField->customFieldDict->id;
                            break;
                        case 'variable/range':
                            $value = trim($oField->field_value);
                            if (empty($value)) continue 2;

                            M::printr($value, '$value');
                            $vals = explode(':', $value);
                            if (!empty($vals[1])) {
                                $item->{$oField->customField->field_key} = [
                                    'max' => (float)$vals[1],
                                    'min' => (float)$vals[0],
                                ];
                            } else {
                                $item->{$oField->customField->field_key} = [
                                    'max' => (float)$oField->field_value,
                                    'min' => (float)$oField->field_value,
                                ];
                            }
                            break;
                        case 'variable/string':
                            if (empty($oField->field_value)) continue 2;
                            M::printr($oField->field_value, $oField->customField->field_name);
                            $item->{$oField->customField->field_key} = (float)$oField->field_value;
                            break;
                        default:
                            break;
                    }

                    if (strpos($oField->field_value, ':') !== false) $exit = true;
                    M::printr('');
                }

                $i++;
                //if ($i > 100 || $exit) exit;

                $price = $oProduct->countProductPrice();
                //M::printr($price, '$price');
                if (empty($price)) {
                    $price = 0;
                }
                $item->is_price = (int)$price > 0;
                $item->price = (int)$price;
                M::printr($item->attributes, '$item->attributes');

                if (!$item->save()) {
                    throw new Exception('Can`t save $item in ElSearch');
                }

                //M::printr($response, '$response');
                $p = $i * 100 / $percents100;
                M::printr("{$p}%");
                M::printr('');
                M::printr('');
            }
        }

    }

    public static function gen2() {
        M::printr('');
        $index = '_filter_products';
        $type = 'productFilter';
        $index_product = Yii::app()->params['elasticsearchFilter']['nameDB'] . $index;
        $client = \Elasticsearch\ClientBuilder::create()->setHosts(
            [
                'host' => Yii::app()->params['elasticsearchFilter']['host'],
                'port' => Yii::app()->params['elasticsearchFilter']['port'],
            ]
        )->build();

        //delete
        if (1) {
            M::printr('DELETE');
            $is_exist = $client->indices()->exists(['index' => $index_product]);
            M::printr($is_exist, '$is_exist');

            if ($is_exist) {
                try {
                    $params['index'] = $index_product;
                    M::printr($params['index'], '$params[\'index\']');
                    $response = $client->indices()->delete($params);
                    M::printr($response, '$response');
                } catch (Exception $e) {
                    M::printr('error!');
                    $error = CJSON::decode($e->getMessage());
                    M::printr($error, '$error');
                }
            }
        }

        //create
        if (1) {
            if (0) {
                $params = [
                    'index' => $index_product,
                    'body' => [
                        'settings' => [
                            'number_of_shards' => 1,
                            'number_of_replicas' => 0,
                            'analysis' => [
                                'filter' => [
                                    'shingle' => [
                                        'type' => 'shingle'
                                    ],
                                    'app_ngram' => [
                                        'type' => "nGram",
                                        'min_gram' => 3,
                                        'max_gram' => 20
                                    ],
                                    'stopwords' => [
                                        'type' => 'stop',
                                        'stopwords' => ['_french_'],
                                        'igrore_case' => true,
                                    ]
                                ],
                                'analyzer' => [
                                    'reuters' => [
                                        'type' => 'custom',
                                        'tokenizer' => 'nGram',
                                        'filter' => ['lowercase', 'stop', 'kstem']
                                    ],
                                    'app_analyzer' => [
                                        'type' => 'custom',
                                        'tokenizer' => 'nGram',
                                        'filter' => ['stopwords', 'app_ngram', 'asciifolding', 'lowercase', 'snowball']

                                    ],
                                    'app_search_analyzer' => [
                                        'type' => 'custom',
                                        'tokenizer' => 'standard',
                                        'filter' => ['stopwords', 'app_ngram', 'asciifolding', 'lowercase', 'snowball']
                                    ]
                                ],
                                'tokenizer' => [
                                    'nGram' => [
                                        'type' => "nGram",
                                        'min_gram' => 3,
                                        'max_gram' => 20
                                    ]
                                ],
                            ]
                        ],

                        'mappings' => [
                            '_default_' => [
                                'properties' => [

                                ]
                            ],

                            $type => [
                                'properties' => [
                                    'dlina_sm' => ['type' => 'float'],
                                    'brand' => ['type' => 'string'],
                                ]
                            ]
                        ]
                    ]
                ];
            }
            if (1) {
                $params = [
                    'index' => $index_product,
                    'body' => [
                        'settings' => [
                            'number_of_shards' => 1,
                            'number_of_replicas' => 0,
                        ],
                    ],
                ];
            }

            M::printr($params, '$params');

            M::printr('CREATE');
            try {
                //$params['index'] = Yii::app()->params['elasticsearchFilter']['nameDB'] . $index;
                M::printr($params['index'], '$params[\'index\']');
                $response = $client->indices()->create($params);
                M::printr($response, '$response');
            } catch (Exception $e) {
                M::printr('error!');
                $error = CJSON::decode($e->getMessage());
                M::printr($error, '$error');
            }
        }

        //индексирование
        if (1) {
            M::printr('INDEXING');

            //берем категорию
            $oCategory = CmsTree::model()->findByPk(200); // 339, 908
            M::printr($oCategory->attributes, '$oCategory->attributes');

            //и товары из нее
            $criteria = new CDbCriteria();
            $criteria->addCondition('"t"."is_trash" IS FALSE AND "t"."is_closed" IS FALSE');
            $criteria->addCondition('"tree"."is_node_published" IS TRUE');
            $criteria->addCondition(':ns_left <= "tree"."ns_left_key" AND "tree"."ns_left_key" <= :ns_right AND "tree"."ns_root_ref" = 200');
            $criteria->params['ns_left'] = $oCategory->ns_left_key;
            $criteria->params['ns_right'] = $oCategory->ns_right_key;

            $products = EcmProducts::model()->with(['appProduct.tree'])->findAll($criteria);
            if (empty($products)) {
                $products = [];
            }
            //M::printr($products, '$products');
            M::printr(count($products), 'Найдено товаров');

            $i = 0;
            $percents100 = count($products);
            foreach ($products as $product) {
                if (empty($product->appProduct)) continue;
                if (empty($product->appProduct->tree)) continue;
                $body = [
                    'id' => $product->id,
                ];
                M::printr($product->product_name, '$product->product_name');
                $oAppProduct = $product->appProduct;
                $oTree = $oAppProduct->tree;
                $oContent = $oTree->content;

                $urlImg = '/images/noimg.jpg';
                $oImages = $oTree->getImages();
                if (!empty($oImages)) {
                    $oImage = $oImages[0]->getCropped('ecm:teaser_small');
                    $urlImg = '/store' . $oImage->fs_alias;
                }
                $body['category'] = $oTree->id;
                $body['category_name'] = !empty($oContent->page_longtitle) ? $oContent->page_longtitle : $oContent->page_title;
                $body['ns_left_key'] = $oTree->ns_left_key;
                $body['img'] = $urlImg;

                $oLabels = $product->getLabels();
                $body['labels'] = [
                    'is_new' => (int)!empty($oLabels['is_new']),
                    'is_sale' => (int)!empty($oLabels['is_new']),
                ];

                $count = (int)$product->getProductCount();
                $body['count'] = $count;
                $body['is_count'] = $count > 0;

                //$oField = $product->getField('dlina_sm');
                //M::printr($oField->field_value, '$oField->field_value');

                $oFields = $product->getFields();
                //M::printr($oFields, '$oFields');
                $exit = false;
                foreach ($oFields as $oField) {
                    M::printr($oField->customField->customFieldMeta->field_meta, $oField->customField->customFieldMeta->field_type);
                    M::printr($oField->customField->field_key, '$oField->customField->field_key');
                    switch ($oField->customField->customFieldMeta->field_meta) {
                        case 'dictionary/list':
                            if (empty($oField->customFieldDict)) continue 2;
                            M::printr($oField->customFieldDict->id, $oField->customField->field_name);
                            $body[$oField->customField->field_key] = (float)$oField->customFieldDict->id;
                            break;
                        case 'variable/range':
                            $value = trim($oField->field_value);
                            if (empty($value)) continue 2;

                            M::printr($value, '$value');
                            $vals = explode(':', $value);
                            if (!empty($vals[1])) {
                                $body[$oField->customField->field_key]['max'] = (float)$vals[1];
                                $body[$oField->customField->field_key]['min'] = (float)$vals[0];
                            } else {
                                $body[$oField->customField->field_key]['max'] = (float)$oField->field_value;
                                $body[$oField->customField->field_key]['min'] = (float)$oField->field_value;
                            }
                            break;
                        case 'variable/string':
                            if (empty($oField->field_value)) continue 2;
                            M::printr($oField->field_value, $oField->customField->field_name);
                            $body[$oField->customField->field_key] = (float)$oField->field_value;
                            break;
                        default:
                            break;
                    }

                    if (strpos($oField->field_value, ':') !== false) $exit = true;
                    M::printr('');
                }

                $i++;
                //if ($i > 100 || $exit) exit;
                M::printr('');
                //continue;

                $price = $product->product_new_price > 0 ? $product->product_new_price : $product->product_price;
                M::printr($price, '$price');
                if (empty($price)) {
                    $price = 0;
                }
                $body['is_price'] = (int)$price > 0;
                $body['price'] = (int)$price;
                M::printr($body, '$body');

                $params = [
                    'index' => $index_product,
                    'type' => $type,
                    'body' => $body,
                ];
                $response = $client->index($params);
                //M::printr($response, '$response');
                $p = $i * 100 / $percents100;
                M::printr("{$p}%");
            }


            if (0) {
                foreach ($products as $product) {
                    if (empty($product->appProduct)) continue;
                    if (empty($product->appProduct->tree)) continue;
                    M::printr($product->product_name, '$product->product_name');
                    $oAppProduct = $product->appProduct;
                    $oTree = $oAppProduct->tree;

                    $urlImg = '/images/noimg.jpg';
                    $oImages = $oTree->getImages();
                    if (!empty($oImgs)) {
                        $oImage = $oImages[0]->getCropped('ecm:teaser_small');
                        $urlImg = $oImage->fs_alias;
                    }

                    //$oField = $product->getField('dlina_sm');
                    //M::printr($oField->field_value, '$oField->field_value');
                    $price = (int)($product->product_new_price > 0 ? $product->product_new_price : $product->product_price);
                    M::printr($price, '$price');
                    if (is_null($price)) {
                        exit;
                    }
                    $params = [
                        'index' => $index_product,
                        'type' => $type,
                        'body' => [
                            'id' => $product->id,
                            'price' => $price,
                            'category' => $oTree->id,
                            'category_name' => $oTree->node_name,
                            'ns_left_key' => $oTree->ns_left_key,
                            'img' => $urlImg,
                        ],
                    ];
                    $response = $client->index($params);
                    //M::printr($response, '$response');
                }
            }
        }
    }

    public static function IndexGenerate() {
        //echo '<pre>';
        $time_begin = microtime(true);

        if (1) {
            $treeCatalog = CmsTree::find()
                ->where(
                    [
                        'is_trash' => false,
                        'is_node_published' => true,
                        'ns_root_ref' => 200,
                    ]
                )
                ->orderBy('ns_right_key ASC')
                ->all();

            $i = 0;
            $percent = 0;
            $all = count($treeCatalog);
            //перебор узлов дерева (категорий)
            foreach ($treeCatalog as $node) {
                $properties = [];
                M::printr($node->attributes, '$node->attributes');
                if ($node->ns_left_key + 1 == $node->ns_right_key) {
                    //в этой ветке IF обрабатываются листья дерева (конечные категории)
                    //var_dump($node);
                    //создаём заготовку полей
                    //заготовка для цен
                    $properties['price']['min'] = null;
                    $properties['price']['max'] = null;

                    //заготовки для остальных полей
                    $oFields = EcmProductFields::find()
                        ->joinWith(
                            [
                                'customField',
                                'product.appProduct',
                            ]
                        )
                        ->where(
                            [
                                'appProduct.cms_tree_ref' => $node->id
                            ]
                        )
                        ->all();

                    foreach ($oFields as $field) {
                        if (!$field->customField->is_use_filter) continue;

                        switch ($field->customField->ecm_custom_field_meta_ref) {
                            case 3 :
                                //$properties[$field->ecm_custom_fields_ref]['type'] = 3;
                                $properties['range'][$field->ecm_custom_fields_ref]['max'] = false;
                                $properties['range'][$field->ecm_custom_fields_ref]['min'] = false;
                                break;
                            case 10 : //no break;
                            case 13 :
                                $properties['list'][$field->ecm_custom_fields_ref] = array();
                                break;
                            case 12 :
                                $properties['range2'][$field->ecm_custom_fields_ref]['max'] = false;
                                $properties['range2'][$field->ecm_custom_fields_ref]['min'] = false;
                                break;
                        }
                        //echo $node->id.'<br>';
                    }

                    $appProducts = AppProducts::find()
                        ->joinWith('product')
                        ->where(
                            [
                                'product.is_trash' => false,
                                'product.is_closed' => false,
                                'cms_tree_ref' => $node->id,
                            ]
                        )
                        ->all();

                    $array_ecm_custom_fields_id = array();
                    foreach ($properties as $pole_type => $pole_array) {
                        if ($pole_type == 'price') {
                            continue;
                        }
                        $array_ecm_custom_fields_id = array_merge($array_ecm_custom_fields_id, array_keys($pole_array));
                    }

                    //var_dump($array_ecm_custom_fields_id);

                    //перебор продуктов
                    foreach ($appProducts as $appProduct) {
                        //var_dump($criteria);
                        //var_dump($appProduct);
                        $oProduct = $appProduct->product;
                        $oLabels = $oProduct->getLabels();

                        $property_fields = EcmProductFields::find()
                            ->joinWith(['customField', 'customField.customFieldMeta'])
                            ->where(['in', 'ecm_custom_fields_ref', $array_ecm_custom_fields_id])
                            ->andWhere(['ecm_products_ref' => $oProduct->id])
                            ->all();

                        //выбираем цены
                        $price = $oProduct->product_price;
                        if ($oProduct->product_new_price) {
                            $price = $oProduct->product_new_price;
                        }
                        //if (!empty($oLabels['is_sale'])) {
                        //$price = $oProduct->product_new_price;
                        //}

                        if (is_null($properties['price']['max'])) {
                            $properties['price']['max'] = $price > 0 ? $price : null;
                            $properties['price']['min'] = $price > 0 ? $price : null;
                        } elseif ($properties['price']['max'] < $price) {
                            $properties['price']['max'] = $price > 0 ? $price : null;
                        } elseif ($properties['price']['min'] > $price && !empty($price)) {
                            $properties['price']['min'] = $price > 0 ? $price : null;
                        }
                        if (empty($properties['price']['min'])) {
                            $properties['price']['min'] = $properties['price']['max'];
                        }
                        //M::printr($properties['price'], '$properties[\'price\']');

                        //перебор свойств продукта
                        foreach ($property_fields as $field) {
                            switch ($field->customField->ecm_custom_field_meta_ref) {
                                case 3 :
                                    if ($properties['range'][$field->ecm_custom_fields_ref]['max'] === false) {
                                        $properties['range'][$field->ecm_custom_fields_ref]['max'] = (float)$field->field_value;
                                        $properties['range'][$field->ecm_custom_fields_ref]['min'] = (float)$field->field_value;
                                    } elseif ($properties['range'][$field->ecm_custom_fields_ref]['max'] < (float)$field->field_value) {
                                        $properties['range'][$field->ecm_custom_fields_ref]['max'] = (float)$field->field_value;
                                    } elseif ($properties['range'][$field->ecm_custom_fields_ref]['min'] > (float)$field->field_value) {
                                        $properties['range'][$field->ecm_custom_fields_ref]['min'] = (float)$field->field_value;
                                    }
                                    break;
                                case 10 ://no break;
                                case 13 :
                                    //var_dump($properties);
                                    if (!in_array($field->ecm_custom_field_dictionary_ref, $properties['list'][$field->ecm_custom_fields_ref])) {
                                        $properties['list'][$field->ecm_custom_fields_ref][] = $field->ecm_custom_field_dictionary_ref;
                                        //var_dump($field->customField->ecm_custom_field_meta_ref);
                                    }
                                    break;
                                case 12 :
                                    if (empty($field->field_value)) break;
                                    $x = explode(':', $field->field_value);
                                    if (empty($properties['range'][$field->ecm_custom_fields_ref]['max'])) {
                                        //если данных нет
                                        $properties['range'][$field->ecm_custom_fields_ref]['max'] = (float)$x[0];
                                        $properties['range'][$field->ecm_custom_fields_ref]['min'] = (float)$x[1];
                                    } elseif ($properties['range'][$field->ecm_custom_fields_ref]['max'] < (float)$x[1]) {
                                        //если новое значение больше старого максимума
                                        $properties['range'][$field->ecm_custom_fields_ref]['max'] = (float)$x[1];
                                    } elseif ($properties['range'][$field->ecm_custom_fields_ref]['min'] > (float)$x[0]) {
                                        //если новое значение меньше старого минимума
                                        $properties['range'][$field->ecm_custom_fields_ref]['min'] = (float)$x[0];
                                    }
                                    break;
                            }
                        }
                    }
                    /*if ($properties['price']['min'] != $properties['price']['max']) {
                        print_r($node->node_name);
                        var_dump($properties['price']);
                    }*/
                } else {
                    //в этой ветке IF обрабатываются НЕ конечные узлы дерева
                    //var_dump($node);
                    $subCategories = $node->find()
                        ->alias('tree')
                        ->joinWith('properties')
                        ->where(
                            [
                                'is_trash' => false,
                                'is_node_published' => true,
                                'ns_root_ref' => 200,
                                'properties.cms_node_properties_fields_ref' => 5,
                            ]
                        )
                        ->andOnCondition(':left_key < ns_left_key AND ns_left_key < :right_key AND ns_level = :level')
                        ->params(
                            [
                                ':left_key' => $node->ns_left_key,
                                ':right_key' => $node->ns_right_key,
                                ':level' => $node->ns_level + 1,
                            ]
                        )
                        ->all();

                    // перебираем ветки (подкатегории) данного узла
                    foreach ($subCategories as $subCategory) {
                        if (!empty($subCategory->properties[0]->property_value)) {
                            //получаем свойства подкатегории
                            //$add = json_decode($subCategory->properties[0]->property_value, true);
                            $oProp = $subCategory->getProperty('filter_data');
                            $add = Json::decode($oProp->property_value);
                            //var_dump($add);
                            if (isset($add['price'])) {
                                if (empty($properties['price']['min'])) {
                                    $properties['price']['min'] = $add['price']['min'];
                                }
                                if (empty($properties['price']['max'])) {
                                    $properties['price']['max'] = $add['price']['max'];
                                }
                                if ($add['price']['min'] && $add['price']['min'] < $properties['price']['min']) {
                                    $properties['price']['min'] = $add['price']['min'];
                                }
                                if ($add['price']['max'] && $add['price']['max'] > $properties['price']['max']) {
                                    $properties['price']['max'] = $add['price']['max'];
                                }
                                if (0) {
                                    if (empty($properties['price']['min']) && empty($properties['price']['max'])) {
                                        $properties['price']['min'] = $add['price']['min'];
                                        $properties['price']['max'] = $add['price']['max'];
                                    } else {
                                        if ($add['price']['min'] < $properties['price']['min']) {
                                            $properties['price']['min'] = $add['price']['min'];
                                        }
                                        if ($add['price']['max'] > $properties['price']['max']) {
                                            $properties['price']['max'] = $add['price']['max'];
                                        }
                                    }
                                }
                            }
                            if (isset($add['range'])) {
                                //var_dump($add['range']);
                                foreach ($add['range'] as $id_property => $add_data) {
                                    if (empty($add_data['min']) && empty($add_data['max'])) {
                                        continue;
                                    }
                                    if (empty($properties['range'][$id_property]['min']) && empty($properties['range'][$id_property]['max'])) {
                                        //$properties['range'][$id_property]['type'] = 3;
                                        $properties['range'][$id_property]['min'] = $add_data['min'];
                                        $properties['range'][$id_property]['max'] = $add_data['max'];
                                    } else {
                                        if ($add_data['min'] < $properties['range'][$id_property]['min']) {
                                            $properties['range'][$id_property]['min'] = $add_data['min'];
                                        }
                                        if ($add_data['max'] > $properties['range'][$id_property]['max']) {
                                            $properties['range'][$id_property]['max'] = $add_data['max'];
                                        }
                                    }
                                }
                            }
                            if (isset($add['range2'])) {
                                //var_dump($add['range']);
                                foreach ($add['range2'] as $id_property => $add_data) {
                                    if (empty($add_data['min']) && empty($add_data['max'])) {
                                        continue;
                                    }
                                    if (empty($properties['range2'][$id_property]['min']) && empty($properties['range2'][$id_property]['max'])) {
                                        //$properties['range'][$id_property]['type'] = 3;
                                        $properties['range2'][$id_property]['min'] = $add_data['min'];
                                        $properties['range2'][$id_property]['max'] = $add_data['max'];
                                    } else {
                                        if ($add_data['min'] < $properties['range2'][$id_property]['min']) {
                                            $properties['range2'][$id_property]['min'] = $add_data['min'];
                                        }
                                        if ($add_data['max'] > $properties['range2'][$id_property]['max']) {
                                            $properties['range2'][$id_property]['max'] = $add_data['max'];
                                        }
                                    }
                                }
                            }
                            if (isset($add['list'])) {
                                foreach ($add['list'] as $id_property => $add_data) {
                                    if (empty($properties['list'][$id_property])) {
                                        $properties['list'][$id_property] = $add_data;
                                    } else {
                                        foreach ($add_data as $id_dictionary) {
                                            if (!in_array($id_dictionary, $properties['list'][$id_property])) {
                                                $properties['list'][$id_property][] = $id_dictionary;
                                            }
                                        }
                                    }
                                }
                            }
                        }
                    }
                }
                if (!empty($properties)) {
                    //$json_str = json_encode($properties);
                    $json_str = Json::encode($properties);
                    $oNodeProp = $node->getProperty('filter_data');
                    $oNodeProp->property_value = $json_str;
                    $oNodeProp->save();

                    if (0) {
                        $criteria = new CDbCriteria();
                        $criteria->addCondition('cms_tree_ref = :id_category');
                        $criteria->addCondition('cms_node_properties_fields_ref = :id_data_filter');
                        $criteria->params = array(':id_category' => $node->id, ':id_data_filter' => 5);
                        $node_properties = CmsNodeProperties::model()->find($criteria);
                        if (empty($node_properties)) {
                            $node_properties = new CmsNodeProperties();
                            $node_properties->cms_tree_ref = $node->id;
                            $node_properties->cms_node_properties_fields_ref = 5;
                        }
                        $node_properties->property_value = $json_str;
                        $node_properties->save();
                    }
                }

                $percent = (100 * $i) / $all;
                M::printr("{$percent}%");
                M::printr('');
                M::printr('');
                $i++;
            }
            /** перебор дерева снизу вверх END*/
        }

        $time_end = microtime(true);
        M::printr(strftime('%Y-%m-%d %H:%M:%S', $time_begin), 'Время начала');
        M::printr(strftime('%Y-%m-%d %H:%M:%S', $time_begin), 'Время окончания');
        M::printr($time_end - $time_begin, 'Время работы');
    }

    public static function gen3() {
        //удалить индекс
        M::printr('DELETE');
        static::deleteIndex();

        //создать индекс
        M::printr('CREATE');
        static::createIndex();

        M::printr('FILL INDEX');
        //заполнить индекс
        if (1) {
            $oProducts = Product::find()->orderBy('id ASC')->all();
            //M::printr($oProducts, '$oProducts');

            foreach ($oProducts as $oProduct) {
                M::printr($oProduct, '$oProduct');
                $model = new ElSearch();
                $model->attributes = [
                    'id' => $oProduct->id,
                    'product_id' => $oProduct->id,
                    'title' => strip_tags($oProduct->title),
                    'description' => strip_tags($oProduct->description),
                ];
                $model->save();

            }
        }
    }
}

?>