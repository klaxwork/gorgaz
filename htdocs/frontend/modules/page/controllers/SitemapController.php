<?php

namespace frontend\modules\page\controllers;

use common\components\M;
use common\models\Cart;
use common\models\Clients;
use common\models\models\CmsAliases;
use common\models\models\EcmProducts;
use common\models\models\EdiBootstrap;
use common\models\OrderManager;
use common\models\TwigNotify;
use yii;
use frontend\components\FrontendController;
use yii\helpers\Json;
use yii\base\Exception;
use yii\web\HttpException;

class SitemapController extends FrontendController
{

    public $layout = false;

    public $cache_opts = array(
        'duration' => 82800, // 23hours
        'dependency' => [
            'class' => 'CDbCacheDependency',
            'sql' => 'SELECT MAX(dt_created) FROM sys_cache_resets', //cms_tree
        ],
    );


    public function actionIndex()
    {
        $this->layout = false;

        Yii::$app->response->format = \yii\web\Response::FORMAT_RAW;
        Yii::$app->response->headers->add('Content-Type', 'text/xml');


        $oCmsAliases = CmsAliases::find()->joinWith(['tree.content'])->where(['is_deprecated' => false])->orderBy('url_path ASC')->all();
        //M::printr(count($oCmsAliases), 'count($oCmsAliases)');
        $i = 0;
        foreach ($oCmsAliases as $oCmsAlias) {
            //M::printr($oCmsAlias->tree->attributes, '$oCmsAlias->tree->attributes');
            //M::printr($oCmsAlias->url_path, '$oCmsAlias->url_path');
            if ($i >= 10) break; else $i++;
        }
        //exit;

        $i = 1;
        $sitemap = [];
        foreach ($oCmsAliases as $oAlias) {
            $url = 'https://fishmen.ru' . ($oAlias->url_path !== '/' ? $oAlias->url_path : '') . '/';
            $item = [
                'loc' => $url,
                'lastmod' => strftime("%Y-%m-%d", strtotime($oAlias->tree->dt_updated)),
                'frequency' => 'weekly',
                'priority' => '0.5',
            ];
            $sitemap[] = $item;
            if ($i >= 5000) break; else $i++;
        }
        return $this->renderPartial('sitemap', ['sitemap' => $sitemap]);

    }

}
