<?php

namespace common\assets;

use yii\web\AssetBundle;
use common\components\M;

/**
 * Main frontend application asset bundle.
 */
class CommonAsset extends AssetBundle
{
    public $sourcePath = '@common/web';

    //public $basePath = '@webroot';
    //public $baseUrl = '@web';

    public $css = [
        '/css/site.css',
        //'assets/css/components.css',
    ];

    public $js = [
        //'vendor/jquery/jquery-1.11.1.min.js',
        //'vendor/jquery/jquery_ui/jquery-ui.min.js',
        //'vendor/jquery/jquery.tmpl.min.js',
        //'assets/js/plugins/notifications/pnotify.min.js',
    ];
    //public $jsOptions = ['position' => \yii\web\View::POS_HEAD];

    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
    ];


//$cs->registerCoreScript('jquery', CClientScript::POS_END);
//$cs->registerCoreScript('jquery.ui', CClientScript::POS_END);

//$cs->registerScriptFile($themePath . '/vendor/jquery/jquery.tmpl.min.js', CClientScript::POS_END);
//$cs->registerScriptFile($themePath . '/assets/js/plugins/notifications/pnotify.min.js', CClientScript::POS_END);

}
