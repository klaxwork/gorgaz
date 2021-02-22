<?php

namespace frontend\modules\product\controllers;

use frontend\components\FrontendController;
use yii\base\Exception;
use yii\helpers\ArrayHelper;
use yii\helpers\Json;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use common\models\ar_inherit\EquipmentTypes;
use common\models\ar_inherit\EquipmentModels;
use common\models\ar_inherit\OrderEquipments;
use common\models\ar_inherit\Orders;
use common\models\ar_inherit\Reasons;
use common\models\ar_inherit\Statuses;
use common\models\Storage;
use common\components\M;

/**
 * Default controller for the `cms` module
 */
class DefaultController extends FrontendController
{
    public function actionIndex() {
        return $this->render('index');
    }

    public function actionForm() {
        $this->layout = '@theme/views/layouts/form_layout';
        $oReasons = Reasons::find()->orderBy('reason_name ASC')->all();

        $oTypes = EquipmentTypes::find()->orderBy('type_name ASC')->all();

        $oType = false;
        $oModels = [];
        if (!empty($oTypes[0])) {
            $oType = $oTypes[0];
        }
        if (!empty($oType)) {
            $oModels = EquipmentModels::find()
                ->alias('models')
                ->where('models.equipment_types_ref = :type')
                ->params([':type' => $oType->id])
                ->orderBy('models.model_name ASC')
                ->all();
        }

        return $this->render('_form', ['oReasons' => $oReasons, 'oTypes' => $oTypes, 'oModels' => $oModels]);
    }

    public function actionGetModelsOfType() {
        $result = [
            'success' => true,
            'message' => '',
            'messages' => [],
            'models' => [],
            'post' => $_POST,
            'get' => $_GET,
        ];
        //M::printr($result, '$result');

        try {
            if (empty($_POST['typeId'])) {
                throw new Exception('TypeId is empty!');
            }
            $typeId = $_POST['typeId'];
            $oModels = EquipmentModels::find()
                ->where('equipment_types_ref = :typeId')
                ->params([':typeId' => $typeId])
                ->orderBy('model_name ASC')
                ->all();
            $models = [];
            foreach ($oModels as $oModel) {
                $model = [
                    'id' => $oModel->id,
                    'model_name' => $oModel->model_name,
                    'equipment_types_ref' => $oModel->equipment_types_ref,
                ];
                $models[] = $model;
            }
            $result['models'] = $models;
        } catch (Exception $e) {
            $result['success'] = false;
            $result['message'] = $e->getMessage();
        }

        return Json::encode($result);
    }

    public function actionSaveOrder() {
        //M::printr($_POST, '$_POST');
        $JS = [
            'success' => true,
            'message' => '',
            'messages' => [],
        ];
        $db = \Yii::$app->db;
        $transaction = $db->beginTransaction();
        try {
            //сохраняем заказ
            $oOrder = new Orders();
            $oOrder->setAttributes($_POST['order']);

            $oOrder->is_declarant_owner = false;
            if (!empty($_POST['order']['is_declarant_owner'])) {
                $oOrder->is_declarant_owner = true;
            }

            $oOrder->reason_ref = $_POST['order']['reason_ref'];
            if ($_POST['order']['reason_ref'] == 'other') {
                $oOrder->reason_ref = '';
            }
            //M::printr($oOrder, '$oOrder');

            if (!$oOrder->save()) {
                $JS['messages'] = $oOrder->getErrors();
                throw new Exception('Can`t save Orders $oOrder');
            }

            //сохраняем оборудование
            if (!empty($_POST['order']['equipment'])) {
                foreach ($_POST['order']['equipment'] as $eq) {
                    //M::printr($eq, '$eq');
                    if (empty($eq['image_ref'])) {
                        //M::printr('Пропустить...');
                        continue;
                    }
                    //M::printr('Сохранить...');
                    $oEquipment = new OrderEquipments();
                    if ($eq['equipment_models_ref'] == 'other') {
                        $eq['equipment_models_ref'] = null;
                    }
                    $oEquipment->setAttributes($eq);
                    $oEquipment->orders_ref = $oOrder->id;
                    if (!$oEquipment->save()) {
                        throw new Exception('Can`t save Equipment');
                    }
                }
            }
            $transaction->commit();
        } catch (Exception $e) {
            $JS['success'] = false;
            $JS['message'] = $e->getMessage();
            $transaction->rollback();
        }

        return Json::encode($JS);
    }

    public function actionSaveImage() {
        //M::printr($_FILES, '$_FILES');
        //M::printr($_POST, '$_POST');
        //M::printr($_GET, '$_GET');
        $JS = [
            'image' => 0,
            'success' => true,
            'message' => '',
            'messages' => [],
        ];

        try {
            if (empty($_FILES)) {
                throw new Exception('Файла нет');
            }
            //Сохранить картинку в таблицу images
            $storage = new Storage();
            $oImage = $storage->store();
            //M::printr($oImage, '$oImage');
            $JS['image'] = $oImage->attributes;
        } catch (Exception $e) {
            $JS['message'] = $e->getMessage();
            $JS['success'] = false;
        }


        return Json::encode($JS);

    }

    public function actionFillbase() {
        $storage = \Yii::getAlias('@storage');
        M::printr($storage, '$storage');

        //занести типы в БД
        if (0) {
            $f = fopen("{$storage}/.preload/types.csv", 'r');
            while (!feof($f)) {
                $type = fgetcsv($f, 1000, ';');
                M::printr($type, '$type');
                $oType = new EquipmentTypes();
                $oType->type_name = trim($type[0]);
                if (!empty($oType->type_name)) {
                    if (!$oType->save()) {
                        throw new Exception("Can`t save type [{$oType->type_name}]");
                    }
                }
            }
            fclose($f);
        }
        //$oTypes = EquipmentTypes::find()->all();
        //M::printr($oTypes, '$oTypes');

        //занести модели в БД
        if (0) {
            $f = fopen("{$storage}/.preload/models.csv", 'r');
            //пройтись по моделям в файле
            while (!feof($f)) {
                $item = fgetcsv($f, 1000, ';');
                M::printr($item, '$item');
                $model = $item[0];
                M::printr($model, '$model');
                $type = $item[1];
                M::printr($type, '$type');
                $oType = EquipmentTypes::find()->where(['type_name' => $type])->one();
                //M::printr($oType, '$oType');
                if (empty($oType)) {
                    $oType = new EquipmentTypes();
                    $oType->type_name = trim($type);
                    if (!empty($oType->type_name)) {
                        if (!$oType->save()) {
                            throw new Exception("Can`t save type [{$oType->type_name}]");
                        }
                    }
                    $oType = EquipmentTypes::find()->where(['type_name' => $type])->one();
                }

                $oModel = new EquipmentModels();
                $oModel->model_name = trim($model);
                $oModel->equipment_types_ref = $oType->id;
                if (!$oModel->save()) {
                    throw new Exception("Can`t save [{$oModel->model_name}]");
                }
            }
            fclose($f);
        }

        //занести причины в БД
        if (0) {
            $f = fopen("{$storage}/.preload/reasons.csv", 'r');
            while (!feof($f)) {
                $reason = fgets($f, 1000);
                M::printr($reason, '$reason');
                $oReason = new Reasons();
                $oReason->reason_name = trim($reason);
                if (!empty($oReason->reason_name)) {
                    if (!$oReason->save()) {
                        throw new Exception("Can`t save reason [{$oReason->reason_name}]");
                    }
                }
            }
            fclose($f);
        }

    }

    //высчитывает, какой процент имеет $dig от $max
    public function percent($dig, $max) {

    }

    public function actionSearch($request = null) {
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

            if (1) {
                $products = [];
                $maxScore = 0;
                $limitPercent = 50;
                foreach ($oItems as $oItem) {
                    if (empty($maxScore)) $maxScore = $oItem->score;
                    $percent = 100 * $oItem / $maxScore;
                    if ($percent > $limitPercent) break;
                    $oProduct = $oItem->product;
                    //M::printr($oProduct, '$oProduct');
                    $product = ArrayHelper::merge($oProduct->attributes, $oItem->attributes);
                    $product['score'] = $oItem->score;
                    $product['percent'] = 100 * $oItem / $maxScore;
                    $product['is_fotos'] = !empty($oProduct->hasStorages) ? 1 : 0;
                    //$product['description'] = htmlspecialchars_decode($oProduct->description);

                    $oStores = $oProduct->getImages();
                    //M::printr($oStores, '$oStores');
                    $crops = [];
                    if (1) {
                        foreach ($oStores as $oStore) {
                            //M::printr($oStore->id, '$oStore->id');
                            $oCrop = $oStore->getCropped('dev:search');
                            //M::printr($oCrop, '$oCrop');
                            //M::printr($oCrop->id, '$oCrop->id');
                            //M::printr($oCrop->fs_alias, '$oCrop->fs_alias');
                            $crops[] = $oCrop->attributes;
                            //M::printr($cropped, '$cropped');
                        }
                        //M::printr($crops, '$crops');
                    }
                    $product['crops'] = $crops;
                    $products[] = $product;
                }
                $JS['products'] = $products;
            }
            $JS['oItems'] = $oItems;

        } catch (Exception $e) {
            //M::printr($e, '$e');
            $JS['success'] = false;
            $JS['message'] = $e->getMessage();
        }
        //$oProducts = Product::find()->orderBy('dt_created ASC')->all();
        //$JS['result'] = $oProducts;
        if (!\Yii::$app->request->isAjax) {
            M::printr($JS, '$JS');
            exit;
        }
        return Json::encode($JS);
    }

    public function actionView($id) {

        $oProduct = Product::find()
            //->alias('product')
            //->joinWith(['productHasStorage.storage.croppeds.cropped'])
            ->where(['id' => $id])
            ->one();
        $oStores = $oProduct->images;
        //M::printr($oStores, '$oStores');
        return $this->render('view', ['oProduct' => $oProduct, 'oStores' => $oStores]);
    }

    public function actionCreate($node_id = false) {
        if (1) {
            $oProduct = new Product();
            //M::printr($oProduct, '$oProduct');
            $oStores = [];
            M::printr($oStores, '$oStores');
            return $this->render('create', ['oProduct' => $oProduct, 'oStores' => $oStores]);
        }
    }

    public function actionEdit($product_id) {
        if (1) {
            $oProduct = Product::find()->where(['id' => $product_id])->one();
            //M::printr($oProduct, '$oProduct');

            return $this->render('edit', ['oProduct' => $oProduct]);
        }
    }

    public function actionSave() {
        //M::printr($_GET, '$_GET');
        //M::printr($_POST, '$_POST');
        return ['$_GET' => $_GET, '$_POST' => $_POST];
    }

    public function actionIndexing($product_id) {

    }
}
