<?php

use common\components\M;
use common\assets\CommonAsset;

/*/
$cs = Yii::app()->clientScript;
$themePath = Yii::app()->theme->baseUrl;

$cs->registerCoreScript('jquery', CClientScript::POS_END);
$cs->registerCoreScript('jquery.ui', CClientScript::POS_END);

$cs->registerScriptFile($themePath . '/vendor/jquery/jquery.tmpl.min.js', CClientScript::POS_END);
$cs->registerScriptFile($themePath . '/assets/js/plugins/notifications/pnotify.min.js', CClientScript::POS_END);
//*/


//BackAsset::register($this);
//M::printr($this->assetBundles, '$this->assetBundles');
//M::printr(BackAsset::class);

//M::printr($this, '$this');
//exit;

CommonAsset::register($this);
//M::printr($this, '$this');

//$this->registerCssFile('@theme/assets/admin-tools/admin-forms/css/admin-forms.css');
//$this->registerCssFile("@theme/assets/css/core2.css");
//$this->registerJsFile('@webtheme/vendor/jquery/jquery-1.11.1.min.js');
//$this->registerCssFile("@web/css/site.css");

?>
<!DOCTYPE html>
<html lang="en">
<head>
	<title><?php //= $this->pageTitle ?></title>
</head>

<body>

<!-- CONTENT -->
<?php echo $content; ?>
<!-- /CONTENT -->

</body>
</html>
