<?php
//use \Sunra\PhpSimple\HtmlDomParser;

class HyntCommand extends CConsoleCommand
{
    public $i = 0;
    public $countCategories = 0;
    public $countProducts = 0;

    public function actionSync($limit = 500, $offset = 0, $lastUpdate = false)
    {
        $_GET['debug'] = 'console';
        print "Метаданные...\n";
        if (1) {
            M::xlog('', 'metas', 'w');
            HyntDataImport::getHyntMetas();
        } else {
            print "Отключено.\n\n";
        }

        print "Свойства...\n";
        if (1) {
            M::xlog('', 'fields', 'w');
            HyntDataImport::getHyntFields();
        } else {
            print "Отключено.\n\n";
        }

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
            HyntDataImport::getHyntProducts($limit, $offset, $lastUpdate);
        } else {
            print "Отключено.\n\n";
        }

        $oVar = SysVars::model()->findByAttributes(['variable' => 'LastHyntUpdate']);
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

    }


    public function actionSyncProductProperties()
    {
        $tm_start = microtime(true);
        $domain = 'http://hnt4adm.vh.nays.ru';
        $domain = 'http://cabinet.hynt.ru';
        $products = file_get_contents($domain . '/api/default/productsFields');
        $products = json_decode($products);
        $countProducts = count($products);
        print "Количество товаров: {$countProducts}\n";
        //print_r($products);
        //exit;
        $JS = [
            'success' => true,
            'message' => null,
            'messages' => [],
        ];
        //$transaction2 = Yii::app()->db->beginTransaction();
        try {
            $c = 0;
            foreach ($products as $product) {
                $c++;
                //M::printr($product, '$product');
                //print $product->product_name . "\n";
                //найти или создать EcmProducts
                $oProduct = EcmProducts::model()
                    ->with(
                        [
                            'fields.customField',
                            'appProduct.hasGallery.gallery.storage',
                        ]
                    )
                    ->findByPk($product->id);
                $oAppProduct = $oProduct->appProduct;
                if (empty($oProduct)) {
                    print "Товар не найден!!!\n";
                    print_r($product);
                    M::xlog(['Товар не найден!!!', $product], 'products');
                    exit;
                }
                if (empty($oProduct)) {
                    $oProduct = new EcmProducts();
                    $oProduct->url_alias = \QW\Translit::text($product->product_name);
                    $oProduct->product_price = $product->retail_price;
                }

                //свойства
                if (1) {
                    foreach ($product->fields as $field) {
                        //print_r($field);
                        $oField = $oProduct->getField($field->field_key);
                        $oField->field_value = $field->field_value;
                        $oField->ecm_custom_field_dictionary_ref = $field->ecm_custom_field_dictionary_ref;
                        //print_r($oField->attributes);

                        if (!$oField->save()) {
                            print_r($oField->getErrors());
                            exit;
                        }
                    }
                }

                //картинки
                if (1) {
                    $oImages = $oProduct->getImages();
                    foreach ($oImages as $oImage) {
                        $oImage->delete();
                    }
                    //залить
                    foreach ($product->images as $image) {
                        //print_r($image);
                        //print_r($domain . '/store' . $image->fs_alias . "\n");
                        $oStorage = CmsMediaStorage::addImage($domain . '/store' . $image->fs_alias);
                        if (!empty($oStorage)) {
                            //M::xlog(["Для товара {$oParent->node_name} не найдена картинка"], 'Konav');
                            $appGallery = AppGallery::addImage($oStorage->id); //создали галерею с картинкой
                            $oAppProductHasGallery = new AppProductHasGallery();
                            $oAppProductHasGallery->app_products_ref = $oAppProduct->id;
                            $oAppProductHasGallery->app_gallery_ref = $appGallery->id;
                            $oAppProductHasGallery->save();
                        }
                    }
                }
                if (!($c % 500)) {
                    print "Обработано {$c}/{$countProducts} товаров.\n";
                }

            }
            //$transaction->rollback();
            //$transaction2->commit();
        } catch (Exception $e) {
            $JS['success'] = false;
            $JS['message'] = $e->getMessage();
            //$transaction2->rollback();
        }
        $tm_stop = microtime(true);
        M::xlog($tm_stop, 'products');
        $time = $tm_stop - $tm_start;
        $JS['time'] = "{$time} сек.";
        //M::printr($JS, '$JS');
        //M::xlog($JS, 'products');
        Yii::app()->end();


    }

}
