<?php

namespace backend\modules\images\controllers;

use common\components\M;
use common\models\ar_inherit\MediaStorage;
use common\models\CMSH4Resource;
use common\models\CMSH4Storage;
use common\models\CMSH4UploadFile;
use common\models\models\CmsMediaStorage;
use yii\web\Controller;
use yii;
use yii\helpers\Json;
use yii\web\UploadedFile;

/**
 * Default controller for the `images` module
 */
class DefaultController extends Controller
{
    /**
     * Renders the index view for the module
     * @return string
     */
    public function actionIndex($params = null) {
        //$cs = Yii::$app->clientScript;
        //$themePath = Yii::$app->theme->baseUrl;

        //$cs->registerCssFile($themePath . '/vendor/plugins/dropzone/css/dropzone.css');
        //$cs->registerScriptFile($themePath . '/vendor/plugins/dropzone/dropzone.min.js', CClientScript::POS_END);
        $params = Json::decode($params);
        return $this->renderPartial('index', ['params' => $params]);
    }

    public function actionUpload() {
        $JS = [
            'success' => true,
            'message' => null,
            'messages' => [],
        ];
        $JS['_POST'] = $_POST;
        $JS['_GET'] = $_GET;
        $JS['_FILES'] = $_FILES;

        return Json::encode($JS);
    }

    public function actionStore() {

        if (Yii::$app->request->isPost) {

            //$file = CMSH4UploadFile::handle(); //CMSH4UploadFile::handle();
            $file = UploadedFile::getInstanceByName('file');
            //M::printr($file, '$file');

            //$resource = new CMSH4Resource($file);
            //M::printr($resource, '$resource');
            $resource = (new CMSH4Resource())->uploadedFile($file);
            //M::printr($resource, '$resource');

            $h4 = new CMSH4Storage();
            //M::printr($h4, '$h4');

            $store = $h4->store($resource);
            //M::printr($store, '$store');
            //exit;

            /*
            //получить новые размеры
            $criteria = new CDbCriteria();
            $criteria->addCondition("dev_key LIKE 'ecm:%'");
            $oSizes = AppGalleryCategories::model()->findAll($criteria);
            //M::printr($oSizes, '$oSizes');
            $newSizes = [];
            foreach ($oSizes as $oSize) {
                $data = CJSON::decode($oSize->data);
                //M::printr($data, '$data');
                $h5 = new CMSH4Storage();
                $newSize = $h5->resize($store, $data['size']['width'], $data['size']['height']);
                //M::printr($newSize, '$newSize');
                $newSizes[] = $newSize;
            }
            */

            //M::xlog(['MediaController', '$file' => $file, '$store' => $store]);
            //M::printr($store, '$store');
            return $this->sendResponse($store);

        }


    }

    private function sendResponse(MediaStorage $store) {

        $dimension = null;
        if (!empty($store->data)) {
            $meta = Json::decode($store->data);
            if (!empty($meta->meta)) {
                $dimension = ['width' => $meta->meta->{'0'}, 'height' => $meta->meta->{'1'}];
            }
        }

        if (!empty($store)) {
            if (1) {
                return Json::encode($store);
            }
            if (0) {
                $data = [
                    'id' => $store->id,
                    'i8tag' => $store->i8tag->i8tag,
                    'folder' => $store->folder->fs_dirname,
                    'name' => $store->fs_filename,
                    'size' => $store->fs_filesize,
                    'dimension' => $dimension,
                    'raw' => $store->fs_saveto,
                    'alias' => $store->fs_alias,
                    'title' => $store->title,
                    'description' => $store->description,
                    'tags' => [],
                ];
                return Json::encode($data);
            }
        }
        return false;


    }


}
