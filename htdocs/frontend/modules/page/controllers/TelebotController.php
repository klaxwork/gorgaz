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
use Longman\TelegramBot\Request;
use Longman\TelegramBot\Telegram;
use Longman\TelegramBot\Exception\TelegramException;

class TelebotController extends FrontendController
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
        $bot_api_key = '954447452:AAEn9wq2Gpzj1S9jsE8umZKxlSiIlIhLxds';
        $bot_username = 'fishmen_dev_bot';

        $bot_api_key = '886148082:AAFQHba5UWhAuA5vrWh3ERDTcdS2mXQdLTk';
        $bot_username = 'klax_test_bot';

        $bot_api_key = '611105391:AAFH4pj2OKH6J81M3ks-VuvAHC6_ocZx9fs';
        $bot_username = '@KlaxworkBot';
        try {

            // Create Telegram API object
            $telegram = new Telegram($bot_api_key, $bot_username);
            M::printr($telegram, '1 $telegram');

            $chat_id = 'fishmen_dev_bot';
            $result = Request::sendMessage([
                'chat_id' => $chat_id,
                'text' => 'testMessage',
            ]);
            M::printr($result, '$result');

            // Handle telegram webhook request
            $telegram->handle();
            M::printr($telegram, '2 $telegram');
        } catch (TelegramException $e) {
            // Silence is golden!
            // log telegram errors
            M::printr($e->getMessage(), '$e->getMessage()');
            //echo $e->getMessage();
        }
    }

}
