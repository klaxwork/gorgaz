<?php

namespace console\controllers;

use common\models\Map;
use common\models\models\CmsTree;
use common\models\models\EcmCustomFieldMeta;
use yii;
use common\models\ElSearch;
use common\models\ElSearchFilter;
use common\models\HyntDataImport;
use common\models\models\SysVars;
use common\models\Scripts;
use yii\console\Controller;
use common\components\M;
use yii\db\Exception;
use yii\elasticsearch\ActiveRecord;

class ServiceController extends Controller
{
    public function init() {
        $_GET['debug'] = 'console';
        //M::printr(Yii::$app->request, 'Yii::$app->request');
    }

    public function actionTest() {
    }

    public function actionIndex() {
        $oMeta = EcmCustomFieldMeta::find()
            ->where(['field_type' => 'radio'])
            ->one();
        M::printr($oMeta->attributes, '$oMeta->attributes');
        M::printr('INDEX');
    }

    public function actionHynt($limit = 500, $offset = 0, $lastupdate = false) {
        if (1) {
            print "Метаданные...\n";
            if (0) {
                M::xlog('', 'metas', 'w');
                $res = HyntDataImport::getHyntMetas();
            } else {
                print "Отключено.\n\n";
            }

            print "Свойства...\n";
            if (0) {
                M::xlog('', 'fields', 'w');
                HyntDataImport::getHyntFields();
            } else {
                print "Отключено.\n\n";
            }

            //НЕ ВКЛЮЧАТЬ!
            print "Категории...\n";
            if (0) {
                M::xlog('', 'categories', 'w');
                HyntDataImport::getHyntTree();
            } else {
                print "Отключено.\n\n";
            }

            print "Товары...\n";
            if (1) {
                M::xlog('', 'products', 'w');
                //$limit = 10;
                //$offset = 0;
                //$lastUpdate = false;
                //$lastUpdate = '2020-01-01';
                HyntDataImport::getHyntProducts($limit, $offset, $lastupdate);
            } else {
                print "Отключено.\n\n";
            }

            print "SysVars...\n";
            if (1) {
                $oVar = SysVars::find()
                    ->where(['variable' => 'LastHyntUpdate'])
                    ->one();
                //M::printr($oVar, '$oVar');
                if (empty($oVar)) {
                    //Дата/время последней синхронизации с Hynt`ом	LastHyntUpdate	2019-02-11 00:00:00	9
                    //M::printr($oVar, '$oVar');
                    $oVar = new SysVars();
                    $oVar->var_name = 'Дата/время последней синхронизации с Hynt`ом';
                    $oVar->variable = 'LastHyntUpdate';
                }
                $oVar->value = strftime('%Y-%m-%d %H:%M:%S');
                $oVar->save();
            } else {
                print "Отключено.\n\n";
            }
        }
    }

    public function actionServices($limit = 500, $offset = 0, $lastUpdate = false) {
        $data = [];
        //синхронизация с хинтом (скачивание метаданных, свойств и товаров с хинта на фишмен)
        if (1) {
            M::printr("Метаданные...");
            if (1) {
                $tm1 = microtime(true);
                M::xlog('', 'metas', 'w');
                $res = HyntDataImport::getHyntMetas();
                $tm = microtime(true) - $tm1;
                $data['HyntDataImport::getHyntMetas()'] = "{$tm} сек.";
            } else {
                M::printr("Отключено.\n");
            }

            M::printr("Свойства...");
            if (1) {
                $tm1 = microtime(true);
                M::xlog('', 'fields', 'w');
                HyntDataImport::getHyntFields();
                $tm = microtime(true) - $tm1;
                $data['HyntDataImport::getHyntFields()'] = "{$tm} сек.";
            } else {
                M::printr("Отключено.\n");
            }

            //НЕ ВКЛЮЧАТЬ!
            M::printr("Категории...");
            if (0) {
                M::xlog('', 'categories', 'w');
                HyntDataImport::getHyntTree();
            } else {
                M::printr("Отключено.\n");
            }

            M::printr("Товары...");
            if (1) {
                $tm1 = microtime(true);
                M::xlog('', 'products', 'w');
                //$limit = 500;
                //$offset = 0;
                //$lastUpdate = false;
                //$lastUpdate = '2019-01-01';
                HyntDataImport::getHyntProducts($limit, $offset, $lastUpdate);
                $tm = microtime(true) - $tm1;
                $data["HyntDataImport::getHyntProducts({$limit}, {$offset}, {$lastUpdate})"] = "{$tm} сек.";
            } else {
                M::printr("Отключено.\n");
            }

            M::printr("SysVars...");
            if (1) {
                $tm1 = microtime(true);
                $oVar = SysVars::find()
                    ->where(['variable' => 'LastHyntUpdate'])
                    ->one();
                //M::printr($oVar, '$oVar');
                if (empty($oVar)) {
                    //Дата/время последней синхронизации с Hynt`ом	LastHyntUpdate	2019-02-11 00:00:00	9
                    //M::printr($oVar, '$oVar');
                    $oVar = new SysVars();
                    $oVar->var_name = 'Дата/время последней синхронизации с Hynt`ом';
                    $oVar->variable = 'LastHyntUpdate';
                }
                $oVar->value = strftime('%Y-%m-%d %H:%M:%S');
                $oVar->save();
                $tm = microtime(true) - $tm1;
                $data["SysVars"] = "{$tm} сек.";
            } else {
                M::printr("Отключено.\n");
            }
        }

        M::printr('создание и заполнение индексов для поиска');
        if (0) {
            //создание и заполнение индексов для поиска
            M::printr('');
            $this->actionGenElasticIndex();
            M::printr('');
        } else {
            M::printr("Отключено.\n");
        }

        //НЕ ВКЛЮЧАТЬ
        M::printr('создание алиасов');
        //TODO проверить, нужно ли это
        if (0) {
            //создание алиасов
            M::printr('');
            $this->actionGenAliases();
            M::printr('');
        } else {
            M::printr("Отключено.\n");
        }

        M::printr('создание min/max для панели фильтра');
        if (0) {
            //создание min/max для панели фильтра
            M::printr('');
            $this->actionIndexGenerate();
            M::printr('');
        } else {
            M::printr("Отключено.\n");
        }

        M::printr('создание и заполнение индексов для фильтра');
        if (1) {
            //создание и заполнение индексов для фильтра
            M::printr();
            M::xlog('Start gen index for filter');
            $tm1 = microtime(true);

            ElSearchFilter::deleteIndex();
            ElSearchFilter::createIndex();

            ElSearchFilter::genFilterProducts();
            $tm = microtime(true) - $tm1;
            $data["ElSearchFilter::genFilterProducts()"] = "Время затраченное на генерацию {$tm} сек";
            M::xlog($data);
            M::xlog('Stop gen index for filter');
        } else {
            M::printr("Отключено.\n");
        }
        M::printr($data, '$data');


    }

    public function actionGenFilterProducts() {
        M::printr('Start gen filter products');
        $tm1 = microtime(true);
        ElSearchFilter::deleteIndex();
        ElSearchFilter::createIndex();

        ElSearchFilter::genFilterProducts();
        $tm2 = microtime(true);
        $data = [
            'Время затраченное на генерацию' => $tm2 - $tm1,
        ];
        M::printr($data, '$data');
        M::printr('Stop gen filter products');
    }

    public function actionGenElasticIndex() {
        try {
            $t1 = microtime(true);
            M::printr('Start GenElasticIndex');
            M::xlog("Start GenElasticIndex", 'elastic');
            //Запуск генерации
            (new ElSearch)->generate();
            M::xlog("Stop GenElasticIndex", 'elastic');
            M::printr('Stop GenElasticIndex');
            $t2 = microtime(true);
            M::xlog(["Время работы" => $t2 - $t1], 'elastic');
            M::printr($t2 - $t1, "Время работы");
        } catch (Exception $e) {
            M::xlog(
                [
                    'ERROR',
                    'Tracing' => $e->getTraceAsString(),
                    'Message' => $e->getMessage(),
                    'Code' => $e->getCode(),
                    'File' => $e->getFile(),
                    'Line' => $e->getLine()
                ],
                'elastic'
            );
        }
    }

    //создаем максимальные/минимальные значения для панели фильтра
    public function actionIndexGenerate() {
        try {
            $t1 = microtime(true);
            M::printr('Start IndexGenerate');
            M::xlog("Start IndexGenerate", 'filter');
            //Запуск генерации
            ElSearchFilter::IndexGenerate();
            M::xlog("Stop IndexGenerate", 'filter');
            M::printr('Stop IndexGenerate');
            $t2 = microtime(true);
            M::xlog(["Время работы" => $t2 - $t1], 'filter');
            M::printr($t2 - $t1, "Время работы");
        } catch (Exception $e) {
            M::xlog(
                [
                    'ERROR',
                    'Tracing' => $e->getTraceAsString(),
                    'Message' => $e->getMessage(),
                    'Code' => $e->getCode(),
                    'File' => $e->getFile(),
                    'Line' => $e->getLine()
                ],
                'filter'
            );
        }
    }

    public function actionGenSitemap() {
        //пройти по всем категориям
        if (1) {
            $this->genCats();
        }

        //пройти по всем страницам
        if (1) {
            $this->genPages();
        }

        //пройти по всем новостям
        if (1) {
            $this->genNews();
        }

    }

    public function genCats() {
        $tm1 = microtime(true);
        Scripts::generateCats();
        $tm2 = microtime(true);
        M::printr($tm2 - $tm1, '$tm2 - $tm1');
    }

    public function genPages() {
        $tm1 = microtime(true);
        Scripts::generatePages();
        $tm2 = microtime(true);
        M::printr($tm2 - $tm1, '$tm2 - $tm1');
    }

    public function genNews() {
        $tm1 = microtime(true);
        Scripts::generateNews();
        $tm2 = microtime(true);
        M::printr($tm2 - $tm1, '$tm2 - $tm1');
    }

    public function actionRemap($id = 200) {
        //$id = 1105; //938 1119
        $oNode = CmsTree::findOne(['id' => $id]);
        (new Map())->checkNode($oNode, ['is_gen_children' => true, 'is_full_path' => true]);

    }
}