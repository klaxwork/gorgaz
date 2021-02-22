<?php

namespace common\models;

use common\components\M;
use common\models\models\CmsTree;

class Scripts
{
    public static $node_ids = [];
    public static $product_ids = [];

    public static function generateCats() {
        $oNode = CmsTree::findOne(200);
        $oMap = new Map();
        $oMap->checkNode($oNode, ['is_gen_children' => true, 'is_full_path' => true]);
    }

    public static function generatePages() {
        $oNode = CmsTree::findOne(1);
        $oMap = new Map();
        $oMap->checkNode($oNode, ['is_gen_children' => true, 'is_full_path' => true]);
    }

    public static function generateNews() {
        $oNode = CmsTree::findOne(1105);
        $oMap = new Map();
        $oMap->checkNode($oNode, ['is_gen_children' => true, 'is_full_path' => true]);
    }

    public static function checkPublished($oNode) {

    }

    public static function counts() {
        $oProducts = [];
        //Всего количество товаров
        if (1) {
            $CountAllProducts = EcmProducts::model()->count();
            M::printr($CountAllProducts, 'Всего количество товаров в базе:');
            $oSysVars = SysVars::model()->findByAttributes(['variable' => 'CountAllProducts']);
            if (!empty($oSysVars)) {
                $oSysVars->value = $CountAllProducts;
                $oSysVars->save();
            }
        }

        //Всего количество товаров в базе -закрытые и -удаленные
        if (1) {
            $criteria = new CDbCriteria();
            $criteria->addCondition('t.is_closed IS NOT TRUE');
            $criteria->addCondition('t.is_trash IS NOT TRUE');
            $countProducts = EcmProducts::model()->count($criteria);
            M::printr($countProducts, 'Всего количество товаров в базе -закрытые и -удаленные:');
            $oSysVars = SysVars::model()->findByAttributes(['variable' => 'CountActuallyProducts']);
            if (!empty($oSysVars)) {
                $oSysVars->value = $countProducts;
                $oSysVars->save();
            }
        }

        //Привязанных товаров
        if (1) {
            $tm1 = microtime(true);
            $criteria = new CDbCriteria();
            $criteria->order = 't.id ASC';

            //берем те товары, которые привязаны хотя бы в один каталог
            $criteria->addCondition('"appProducts"."id" IS NOT NULL');
            $criteria->addCondition('t.is_closed IS NOT TRUE');
            $criteria->addCondition('t.is_trash IS NOT TRUE');

            $oProducts = EcmProducts::model()
                ->with(
                    [
                        'appProducts.tree',
                        //'regionSeo.property',
                        //'regionSeo.region'
                    ]
                )
                ->findAll($criteria);
            $BindedProducts = count($oProducts);
            M::printr($BindedProducts, 'Привязанных товаров:');
            $tm2 = microtime(true);
            $r = $tm2 - $tm1;
            M::printr($r, 'Сколько времени выбирали:');
            $oSysVars = SysVars::model()->findByAttributes(['variable' => 'BindedProducts']);
            if (!empty($oSysVars)) {
                $oSysVars->value = $BindedProducts;
                $oSysVars->save();
            }
        }

        //Количество товаров, находящихся хотя бы в одной опубликованной категории
        if (1) {
            $BindedPublishedProducts = 0;
            $tm1 = microtime(true);
            $all = 0;
            foreach ($oProducts as $oProduct) {
                $all++;

                //M::printr("{$oProduct->product_name} [{$oProduct->id}]");
                print "({$BindedPublishedProducts}/{$all}/{$BindedProducts}) {$oProduct->product_name} [{$oProduct->id}]";
                $oAppProducts = $oProduct->appProducts;
                $branches = [];
                $summ = 0;
                //обходим все ветки
                foreach ($oAppProducts as $key1 => $oAppProduct) {
                    $branches[$key1] = 1;
                    $oRoot = $oAppProduct->tree;
                    if (!$oRoot->is_node_published) {
                        $branches[$key1] = 0;
                        print "{$branches[$key1]}";
                    }

                    //идем по ветке вверх
                    if ($branches[$key1]) {
                        $oAncs = $oRoot->ancestors()->findAll();
                        foreach ($oAncs as $key2 => $oAnc) {
                            if (!$oAnc->is_node_published) {
                                $branches[$key1] = 0;
                                break;
                            }
                        }
                        $summ += $branches[$key1];
                        print "{$branches[$key1]}";
                    }
                }
                if ($summ > 0) {
                    $BindedPublishedProducts++;
                }

                //M::printr(count($branches), 'Ко скольким веткам привязан товар:');
                //M::printr(count($summ), 'Сколько опубликованных веток:');
                //print "<hr>";
                print "\n";
            }

            M::printr($BindedPublishedProducts, 'Количество товаров, находящихся хотя бы в одной опубликованной категории:');
            $tm2 = microtime(true);
            $r = $tm2 - $tm1;
            M::printr($r, 'Сколько времени обрабатывали:');

            $oSysVars = SysVars::model()->findByAttributes(['variable' => 'BindedPublishedProducts']);
            if (!empty($oSysVars)) {
                $oSysVars->value = $BindedPublishedProducts;
                $oSysVars->save();
            }
        }
    }

    //скрипт ставит в товары is_closed
    //#ecm_products.is_closed
    public static function updates() {
        if (1) {
            $criteria = new CDbCriteria();
            $criteria->addCondition('139124 <= "tree"."ns_left_key" AND "tree"."ns_left_key" <= 144013');
            $criteria->order = 't.id asc';
            $oProducts = EcmProducts::model()->with(
                [
                    'appProduct.tree'
                ]
            )->findAll($criteria);

            M::printr(count($oProducts), 'count($oProducts)');

            $str = '';
            foreach ($oProducts as $oProduct) {
                M::printr("{$oProduct->id} {$oProduct->product_name}");
                $str .= "{$oProduct->id}\t{$oProduct->product_name}\t{$oProduct->is_closed}\n";
                $oProduct->is_closed = true;
                $oProduct->save();
            }
            M::xlog($str, 'updates');
            print "\n";


        }
    }

    public static function aliases() {
        //категории
        if (1) {
            $oRoot = CmsTree::model()->findByPk(200);
            M::printr($oRoot->attributes, '$oRoot->attributes');
        }

        //Товары
        if (1) {
            $oProducts = [];
            if (1) {
                $criteria = new CDbCriteria();
                $criteria->order = 't.id ASC';

                //берем те товары, которые привязаны хотя бы в один каталог
                $criteria->addCondition('"appProducts"."id" IS NOT NULL');
                $criteria->addCondition('t.is_closed IS NOT TRUE');
                $criteria->addCondition('t.is_trash IS NOT TRUE');

                $oProducts = EcmProducts::model()
                    ->with(
                        [
                            'appProducts.tree',
                        ]
                    )
                    ->findAll($criteria);
                $binded = count($oProducts);
            }

            if (1) {
                //отбрасываем неопубликованные
                $published = 0;
                $all = 0;
                foreach ($oProducts as $oProduct) {
                    $all++;

                    //M::printr("{$oProduct->product_name} [{$oProduct->id}]");
                    print "({$published}/{$all}/{$binded}) {$oProduct->product_name} [{$oProduct->id}]";
                    $oAppProducts = $oProduct->appProducts;
                    $branches = [];
                    $summ = 0;
                    //обходим все ветки
                    foreach ($oAppProducts as $key1 => $oAppProduct) {
                        $branches[$key1] = 1;
                        $oRoot = $oAppProduct->tree;
                        if (!$oRoot->is_node_published) {
                            $branches[$key1] = 0;
                            print "{$branches[$key1]}";
                        }

                        //идем по ветке вверх
                        if ($branches[$key1]) {
                            $oAncs = $oRoot->ancestors()->findAll();
                            foreach ($oAncs as $key2 => $oAnc) {
                                if (!$oAnc->is_node_published) {
                                    $branches[$key1] = 0;
                                    break;
                                }
                            }
                            $summ += $branches[$key1];
                            print "{$branches[$key1]}";
                        }
                    }
                    if ($summ > 0) {
                        $published++;
                    }
                    if ($published) {
                        //Проверить его в EcmAliases
                        (new Map())->checkProduct($oProduct);
                    }
                    //M::printr(count($branches), 'Ко скольким веткам привязан товар:');
                    //M::printr(count($summ), 'Сколько опубликованных веток:');
                    //print "<hr>";
                    print "\n";
                }
            }
        }
    }

    public static function countProducts() {
        //Товары
        if (1) {
            $oProducts = [];

            //Всего количество товаров
            if (1) {
                $CountAllProducts = EcmProducts::model()->count();
                M::printr($CountAllProducts, 'Всего количество товаров в базе:');
                $oSysVars = SysVars::model()->findByAttributes(['variable' => 'CountAllProducts']);
                if (!empty($oSysVars)) {
                    $oSysVars->value = $CountAllProducts;
                    $oSysVars->save();
                }
            }

            //Всего количество товаров в базе -закрытые и -удаленные
            if (1) {
                $criteria = new CDbCriteria();
                $criteria->addCondition('t.is_closed IS NOT TRUE');
                $criteria->addCondition('t.is_trash IS NOT TRUE');
                $CountActuallyProducts = EcmProducts::model()->count($criteria);
                M::printr($CountActuallyProducts, 'Всего количество товаров в базе -закрытые и -удаленные:');
                $oSysVars = SysVars::model()->findByAttributes(['variable' => 'CountActuallyProducts']);
                if (!empty($oSysVars)) {
                    $oSysVars->value = $CountActuallyProducts;
                    $oSysVars->save();
                }
            }

            if (1) {
                $criteria = new CDbCriteria();
                $criteria->order = 't.id ASC';

                //берем те товары, которые привязаны хотя бы в один каталог
                $criteria->addCondition('"appProducts"."id" IS NOT NULL');
                $criteria->addCondition('t.is_closed IS NOT TRUE');
                $criteria->addCondition('t.is_trash IS NOT TRUE');

                $oProducts = EcmProducts::model()
                    ->with(
                        [
                            'appProducts.tree',
                        ]
                    )
                    ->findAll($criteria);
                $BindedProducts = count($oProducts);
                $oSysVars = SysVars::model()->findByAttributes(['variable' => 'BindedProducts']);
                if (!empty($oSysVars)) {
                    $oSysVars->value = $BindedProducts;
                    $oSysVars->save();
                }
            }

            if (1) {
                //отбрасываем неопубликованные
                $BindedPublishedProducts = 0;
                $all = 0;
                $ids = [];
                foreach ($oProducts as $oProduct) {
                    $all++;

                    //M::printr("{$oProduct->product_name} [{$oProduct->id}]");
                    print "({$BindedPublishedProducts}/{$all}/{$BindedProducts}) {$oProduct->product_name} [{$oProduct->id}]";
                    $oAppProducts = $oProduct->appProducts;
                    $branches = [];
                    $summ = 0;
                    //обходим все ветки
                    foreach ($oAppProducts as $key1 => $oAppProduct) {
                        $branches[$key1] = 1;
                        $oRoot = $oAppProduct->tree;
                        if (!$oRoot->is_node_published) {
                            $branches[$key1] = 0;
                            print "{$branches[$key1]}";
                        }

                        //идем по ветке вверх
                        if ($branches[$key1]) {
                            $oAncs = $oRoot->ancestors()->findAll();
                            foreach ($oAncs as $key2 => $oAnc) {
                                if (!$oAnc->is_node_published) {
                                    $branches[$key1] = 0;
                                    break;
                                }
                            }
                            $summ += $branches[$key1];
                            print "{$branches[$key1]}";
                        }
                    }
                    if ($summ > 0) {
                        $BindedPublishedProducts++;
                        self::$product_ids[] = $oProduct->id;
                        //Проверить его в EcmAliases
                        (new Map())->checkProduct($oProduct);
                    }
                    //M::printr(count($branches), 'Ко скольким веткам привязан товар:');
                    //M::printr(count($summ), 'Сколько опубликованных веток:');
                    //print "<hr>";
                    print "\n";
                }

                $oSysVars = SysVars::model()->findByAttributes(['variable' => 'BindedPublishedProducts']);
                if (!empty($oSysVars)) {
                    $oSysVars->value = $BindedPublishedProducts;
                    $oSysVars->save();
                }
            }
        }
    }

    public static function countPages() {
        //CountAllPages
        if (1) {
            $criteria = new CDbCriteria();
            $criteria->addColumnCondition(['ns_root_ref' => 1]);
            $CountAllPages = CmsTree::model()->count($criteria);
            M::printr($CountAllPages, 'Сколько всего страниц:');
            $oSysVars = SysVars::model()->findByAttributes(['variable' => 'CountAllPages']);
            if (!empty($oSysVars)) {
                $oSysVars->value = $CountAllPages;
                $oSysVars->save();
            }
        }

        //CountActuallyPages
        if (1) {

            $criteria = new CDbCriteria();
            $criteria->addColumnCondition(['ns_root_ref' => 1]);
            $criteria->order = 'ns_left_key ASC';
            $oNodes = CmsTree::model()->findAll($criteria);
            M::printr(count($oNodes), 'count($oNodes)');

            $is_published = true;
            $node_ids = [];
            $rkey = false;
            $i = 1;
            $c = 1;
            //убираем все неопубликованные страницы
            foreach ($oNodes as $key => $oNode) {
                if ($rkey && $oNode->ns_left_key > $rkey) {
                    $is_published = true;
                    $rkey = false;
                }

                if ($is_published && !$oNode->is_node_published) {
                    $is_published = false;
                    $rkey = $oNode->ns_right_key;
                }

                if ($is_published) {
                    $nodes[$oNode->id] = $oNode;
                    //собираем id опубликованных категорий
                    $node_ids[] = $oNode->id;
                    M::printr("{$c}\t{$i}\t{$oNode->id}\t{$CountAllPages}\t{$oNode->node_name}");
                    (new Map())->checkNode($oNode);
                    $c++;
                }
                $i++;
            }
            $oNodes = $nodes;

            $CountActuallyPages = count($oNodes);
            M::printr($CountActuallyPages, 'Сколько актуальных страниц:');
            $oSysVars = SysVars::model()->findByAttributes(['variable' => 'CountActuallyPages']);
            if (!empty($oSysVars)) {
                $oSysVars->value = $CountActuallyPages;
                $oSysVars->save();
            }
        }
    }

    public static function countNews() {
        //CountAllNews
        if (1) {
            $criteria = new CDbCriteria();
            $criteria->addColumnCondition(['ns_root_ref' => 1105]);
            $CountAllNews = CmsTree::model()->count($criteria);
            M::printr($CountAllNews, 'Сколько всего новостей:');
            $oSysVars = SysVars::model()->findByAttributes(['variable' => 'CountAllNews']);
            if (!empty($oSysVars)) {
                $oSysVars->value = $CountAllNews;
                $oSysVars->save();
            }
        }

        //CountActuallyNews
        if (1) {
            $criteria = new CDbCriteria();
            $criteria->addColumnCondition(['ns_root_ref' => 1105]);
            $criteria->order = 'ns_left_key ASC';
            $oNodes = CmsTree::model()->findAll($criteria);
            M::printr(count($oNodes), 'count($oNodes)');

            $is_published = true;
            $node_ids = [];
            $rkey = false;
            $i = 1;
            $c = 1;
            //убираем все неопубликованные страницы
            foreach ($oNodes as $key => $oNode) {
                if ($rkey && $oNode->ns_left_key > $rkey) {
                    $is_published = true;
                    $rkey = false;
                }

                if ($is_published && !$oNode->is_node_published) {
                    $is_published = false;
                    $rkey = $oNode->ns_right_key;
                }

                if ($is_published) {
                    $nodes[$oNode->id] = $oNode;
                    //собираем id опубликованных категорий
                    $node_ids[] = $oNode->id;
                    M::printr("{$c}\t{$i}\t{$oNode->id}\t{$CountAllNews}\t{$oNode->node_name}");
                    (new Map())->checkNode($oNode);
                    $c++;
                }
                $i++;
            }
            $oNodes = $nodes;

            $CountActuallyNews = count($oNodes);
            M::printr($CountActuallyNews, 'Сколько актуальных новостей:');
            $oSysVars = SysVars::model()->findByAttributes(['variable' => 'CountActuallyNews']);
            if (!empty($oSysVars)) {
                $oSysVars->value = $CountActuallyNews;
                $oSysVars->save();
            }
        }
    }

    public static function countCats() {
        //CountAllCats
        if (1) {
            $criteria = new CDbCriteria();
            $criteria->addColumnCondition(['ns_root_ref' => 200]);
            $CountAllCats = CmsTree::model()->count($criteria);
            M::printr($CountAllCats, 'Сколько всего категорий:');
            $oSysVars = SysVars::model()->findByAttributes(['variable' => 'CountAllCats']);
            if (!empty($oSysVars)) {
                $oSysVars->value = $CountAllCats;
                $oSysVars->save();
            }
        }

        //CountActuallyCats
        if (1) {
            $criteria = new CDbCriteria();
            $criteria->addColumnCondition(['ns_root_ref' => 200]);
            $criteria->order = 'ns_left_key ASC';
            $oNodes = CmsTree::model()->findAll($criteria);
            M::printr(count($oNodes), 'count($oNodes)');

            $is_published = true;
            $node_ids = [];
            $rkey = false;
            $i = 1;
            $c = 1;
            $ends = 0;
            //убираем все неопубликованные страницы
            foreach ($oNodes as $key => $oNode) {
                if ($rkey && $oNode->ns_left_key > $rkey) {
                    $is_published = true;
                    $rkey = false;
                }

                if ($is_published && !$oNode->is_node_published) {
                    $is_published = false;
                    $rkey = $oNode->ns_right_key;
                }

                if ($is_published) {
                    $nodes[$oNode->id] = $oNode;
                    //собираем id опубликованных категорий
                    $node_ids[] = $oNode->id;
                    M::printr("{$c}\t{$i}\t{$oNode->id}\t{$CountAllCats}\t{$oNode->node_name}");
                    (new Map())->checkNode($oNode);
                    if ($oNode->ns_left_key == $oNode->ns_right_key - 1) {
                        $ends++;
                    }
                    $c++;
                }

                //M::printr("{$i}/{$CountAllCats} {$oNode->node_name} [{$oNode->id}]");
                //(new Map())->checkNode($oNode);
                //print "\n\n";
                $i++;
                if ($i >= 200000) break;
            }
            M::printr("Конечных категорий: {$ends}");
            $oNodes = $nodes;

            $CountActuallyCats = count($oNodes);
            M::printr($CountActuallyCats, 'Сколько актуальных категорий:');
            $oSysVars = SysVars::model()->findByAttributes(['variable' => 'CountActuallyCats']);
            if (!empty($oSysVars)) {
                $oSysVars->value = $CountActuallyCats;
                $oSysVars->save();
            }

            $CountActuallyNotEndsCats = $CountActuallyCats - $ends;
            $oSysVars = SysVars::model()->findByAttributes(['variable' => 'CountActuallyNotEndsCats']);
            if (!empty($oSysVars)) {
                $oSysVars->value = $CountActuallyNotEndsCats;
                $oSysVars->save();
            }


        }
    }
}

?>