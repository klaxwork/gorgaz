<?php

use \common\components\M;

$themePath = $this->theme->baseUrl;
//M::printr($themePath, '$themePath');
M::printr($themePath, 'layout index of $themePath');

?>

<!-- CONTENT START index -->
<?php echo $content; ?>
<!-- CONTENT STOP -->

<?php if (0) { ?>
	<!DOCTYPE html>
	<html prefix="og: http://ogp.me/ns#" lang="ru">
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta id="myViewport" name="viewport" content="width=device-width, initial-scale=1">
		<meta name="author" content="">
		<meta name="yandex-verification" content="5af09a2774b6b74b"/>

		<meta name="SKYPE_TOOLBAR" content="SKYPE_TOOLBAR_PARSER_COMPATIBLE">
		<meta name="format-detection" content="telephone=no"/>

		<link href="/favicon.ico" rel="icon" type="image/x-icon">

		<link rel="apple-touch-icon" sizes="57x57" href="/images/apple-icon-57x57.png">
		<link rel="apple-touch-icon" sizes="60x60" href="/images/apple-icon-60x60.png">
		<link rel="apple-touch-icon" sizes="72x72" href="/images/apple-icon-72x72.png">
		<link rel="apple-touch-icon" sizes="76x76" href="/images/apple-icon-76x76.png">

		<link rel="apple-touch-icon" sizes="114x114" href="/images/apple-icon-114x114.png">
		<link rel="apple-touch-icon" sizes="120x120" href="/images/apple-icon-120x120.png">
		<link rel="apple-touch-icon" sizes="144x144" href="/images/apple-icon-144x144.png">
		<link rel="apple-touch-icon" sizes="152x152" href="/images/apple-icon-152x152.png">
		<link rel="apple-touch-icon" sizes="180x180" href="/images/apple-icon-180x180.png">

		<link rel="icon" type="image/png" sizes="192x192" href="/images/android-icon-192x192.png">
		<link rel="icon" type="image/png" sizes="32x32" href="/images/favicon-32x32.png">
		<link rel="icon" type="image/png" sizes="96x96" href="/images/favicon-96x96.png">
		<link rel="icon" type="image/png" sizes="16x16" href="/images/favicon-16x16.png">

		<title><?= $this->context->page_title ?></title>
        <?= Yii::$app->controller->renderPartial('@layouts/_seo_head.php'); ?>

		<!-- Bootstrap core CSS-->
	</head>

	<body>
    <?php M::printr(__FILE__); ?>

	<link href="<?= $themePath ?>/assets/css/slick.css" rel="stylesheet">
	<link href="<?= $themePath ?>/assets/css/blueimp-gallery.min.css" rel="stylesheet">
	<link href="<?= $themePath ?>/assets/css/bootstrap-select.css" rel="stylesheet">
	<link href="<?= $themePath ?>/assets/css/ion.rangeSlider.css" rel="stylesheet">
	<link href="<?= $themePath ?>/assets/css/ion.rangeSlider.skinHTML5.css" rel="stylesheet">
	<link href="<?= $themePath ?>/assets/css/all.css" rel="stylesheet">
	<link href="<?= $themePath ?>/assets/css/theme.css" rel="stylesheet">
	<link href="<?= $themePath ?>/assets/css/owl.carousel.css" rel="stylesheet">
	<script src="<?= $themePath ?>/vendor/jquery-1.11.3.min.js"></script>

	<div class="page-wrapper" style="Xpadding-bottom: 435px;">

		<!-- CONTENT START index -->
        <?php echo $content; ?>
		<!-- CONTENT STOP -->

		<div class="scroll-top-btn">
			<svg class="svg-icon ico-slider-control">
				<use xmlns:xlink="http://www.w3.org/1999/xlink"
				     xlink:href="/themes/fishmen/assets/css/symbols.svg#ico-slider-control"></use>
			</svg>
		</div>
        <?= Yii::$app->controller->renderPartial('@layouts/_footer.php'); ?>

	</div>

	<script src="//yastatic.net/es5-shims/0.0.2/es5-shims.min.js"></script>
	<script src="//yastatic.net/share2/share.js"></script>

	<script src="<?= $themePath ?>/assets/js/bs/transition.js"></script>
	<script src="<?= $themePath ?>/assets/js/bs/collapse.js"></script>
	<script src="<?= $themePath ?>/assets/js/bs/dropdown.js"></script>
	<script src="<?= $themePath ?>/assets/js/bs/modal.js"></script>
	<script src="<?= $themePath ?>/assets/js/ion.rangeSlider.js"></script>
	<script src="<?= $themePath ?>/assets/js/owl.carousel.min.js"></script>
	<script src="<?= $themePath ?>/assets/js/jquery.validate.min.js"></script>
	<script src="<?= $themePath ?>/assets/js/autosize.js"></script>
	<script src="<?= $themePath ?>/assets/js/slick.min.js"></script>
	<script src="<?= $themePath ?>/assets/js/jquery.blueimp-gallery.min.js"></script>
	<script src="<?= $themePath ?>/assets/js/scripts.js?<?= time() ?>"></script>
	<script src="<?= $themePath ?>/assets/js/js.cookie-2.2.0.min.js"></script>
	<script src="<?= $themePath ?>/vendor/jquery.tmpl.min.js"></script>
	<script src="<?= $themePath ?>/vendor/serializejson/jquery.serializejson.min.js"></script>

	</body>
	</html>
<?php } ?>
