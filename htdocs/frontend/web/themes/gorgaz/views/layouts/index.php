<?php

use \common\components\M;

$themePath = $this->theme->baseUrl;
//M::printr($themePath, '$themePath');
//M::printr($themePath, 'layout index of $themePath');

?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="description" content='Официальный сайт АО "Железноводскгоргаз"'>
	<meta name="keywords" content='Официальный сайт АО "Железноводскгоргаз"'>
	<link rel="stylesheet" href="/css/fonts.css">
	<link rel="stylesheet" href="/css/style.css">
	<script src="<?= $themePath ?>/vendor/jquery-1.11.3.min.js"></script>

	<title>Официальный сайт АО "Железноводскгоргаз"</title>
</head>

<body>
<div class="wrapper">

	<!--Header-->
    <?= Yii::$app->controller->renderPartial('@layouts/_header.php'); ?>

	<!--Слайдер-->
	<div class="slider">
		<div id="myCarousel" class="carousel slide">
			<div class="carousel-inner">
				<div class="item active">
					<img src="/images/gorgaz/slider-img1.jpg" alt="">
				</div>

				<div class="item">
					<img src="/images/gorgaz/slider-img2.jpg" alt="">
				</div>

				<div class="item">
					<img src="/images/gorgaz/slider-img3.jpg" alt="">
				</div>
			</div>

			<a class="left carousel-control" href="#myCarousel" data-slide="prev">&lsaquo;</a>
            <?php ?>
			<a class="right carousel-control" href="#myCarousel" data-slide="next">&rsaquo;</a>
		</div>
	</div>

	<!-- CONTENT START index -->
	<!--Контент-->
	<div class="content">
		<!--Навигация-->
		<ul class="nav">
			<li><a href="/">Главная</a></li>
			<li><a href="/about/">О нас</a></li>
			<li><a href="/work/">Услуги</a></li>
			<li><a href="/blog/">Приложения</a></li>
			<li><a href="/contacts/">Контакты</a></li>
		</ul>

        <?php echo $content; ?>
	</div>
	<!-- CONTENT STOP -->

	<!--Footer-->
    <?= Yii::$app->controller->renderPartial('@layouts/_footer.php'); ?>
</div>

<!--Подключение скриптов-->
<script src="/js/jquery.js"></script>
<script src="/js/bootstrap-transition.js"></script>
<script src="/js/bootstrap-carousel.js"></script>
<script src="/js/js.js"></script>
</body>
</html>

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

		<!-- - ->
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
		<!-- -->

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
