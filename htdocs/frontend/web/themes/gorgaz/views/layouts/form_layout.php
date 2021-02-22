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
	<!--link rel="stylesheet" href="/css/style.css"-->

	<!-- Global stylesheets -->
	<link href="/css/fonts.css" rel="stylesheet" type="text/css">
	<link href="<?= $themePath ?>/assets/css/icons/icomoon/styles.css" rel="stylesheet" type="text/css">
	<link href="<?= $themePath ?>/assets/css/bootstrap.css" rel="stylesheet" type="text/css">
	<link href="<?= $themePath ?>/assets/css/core.css" rel="stylesheet" type="text/css">
	<link href="<?= $themePath ?>/assets/css/components.css" rel="stylesheet" type="text/css">
	<link href="<?= $themePath ?>/assets/css/colors.css" rel="stylesheet" type="text/css">
	<!-- /global stylesheets -->

	<!-- Core JS files -->
	<script type="text/javascript" src="<?= $themePath ?>/assets/js/plugins/loaders/pace.min.js"></script>
	<script type="text/javascript" src="<?= $themePath ?>/assets/js/core/libraries/jquery.min.js"></script>
	<script type="text/javascript" src="<?= $themePath ?>/assets/js/core/libraries/bootstrap.min.js"></script>
	<script type="text/javascript" src="<?= $themePath ?>/assets/js/plugins/loaders/blockui.min.js"></script>
	<!-- /core JS files -->

	<!-- Theme JS files -->
	<script type="text/javascript" src="<?= $themePath ?>/assets/js/plugins/visualization/d3/d3.min.js"></script>
	<script type="text/javascript" src="<?= $themePath ?>/assets/js/plugins/visualization/d3/d3_tooltip.js"></script>
	<script type="text/javascript" src="<?= $themePath ?>/assets/js/plugins/forms/styling/switchery.min.js"></script>
	<script type="text/javascript" src="<?= $themePath ?>/assets/js/plugins/forms/styling/uniform.min.js"></script>
	<script type="text/javascript"
	        src="<?= $themePath ?>/assets/js/plugins/forms/selects/bootstrap_multiselect.js"></script>
	<script type="text/javascript" src="<?= $themePath ?>/assets/js/plugins/ui/moment/moment.min.js"></script>
	<script type="text/javascript" src="<?= $themePath ?>/assets/js/plugins/pickers/daterangepicker.js"></script>

	<script type="text/javascript" src="<?= $themePath ?>/assets/js/core/app.js"></script>
	<!-- /theme JS files -->

	<link href="<?= $themePath ?>/assets/css/theme.css?<?= time(); ?>" rel="stylesheet">
	<title>Официальный сайт АО "Железноводскгоргаз"</title></head>
</head>

<body class="layout-boxed">

<div class="page-container">

	<!--Слайдер-->
	<div class="slider" style="width: 1000px;">
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

	<div class="navbar bg-primary-800 navbar-component" style="position: relative; z-index: 30;">
		<div class="navbar-boxed" id="navbar-demo">
			<ul class="nav navbar-nav">
				<li class="mega-menu mega-menu-wide active">
					<a href="/" class="menu-link" style=" color: white;">Главная</a>
				</li>
				<li class="mega-menu mega-menu-wide">
					<a href="/about/" class="menu-link" style=" color: white;">О нас</a>
				</li>
				<li class="mega-menu mega-menu-wide">
					<a href="/work/" class="menu-link" style=" color: white;">Услуги</a>
				</li>
				<li class="mega-menu mega-menu-wide">
					<a href="/blog/" class="menu-link" style=" color: white;">Приложения</a>
				</li>
				<li class="mega-menu mega-menu-wide">
					<a href="/contacts/" class="menu-link" style=" color: white;">Контакты</a>
				</li>
			</ul>
		</div>
	</div>

    <?php
    echo $content;
    ?>

	<!--Меню-->
	<div class="navbar navbar-inverse">
		<div class="navbar-header">
			<a class="navbar-brand" href="index.html"><img src="assets/images/logo_light.png" alt=""></a>

			<ul class="nav navbar-nav visible-xs-block">
				<li><a data-toggle="collapse" data-target="#navbar-mobile"><i class="icon-tree5"></i></a></li>
				<li><a class="sidebar-mobile-main-toggle"><i class="icon-paragraph-justify3"></i></a></li>
			</ul>
		</div>
	</div>

	<div class="navbar bg-primary-800 navbar-component" style="position: relative; z-index: 30;">
		<div class="navbar-boxed" id="navbar-demo">
			<ul class="nav navbar-nav">
				<li class="mega-menu mega-menu-wide active">
					<a href="/" class="menu-link" style=" color: white;">Главная</a>
				</li>
				<li class="mega-menu mega-menu-wide">
					<a href="/about/" class="menu-link" style=" color: white;">О нас</a>
				</li>
				<li class="mega-menu mega-menu-wide">
					<a href="/work/" class="menu-link" style=" color: white;">Услуги</a>
				</li>
				<li class="mega-menu mega-menu-wide">
					<a href="/blog/" class="menu-link" style=" color: white;">Приложения</a>
				</li>
				<li class="mega-menu mega-menu-wide">
					<a href="/contacts/" class="menu-link" style=" color: white;">Контакты</a>
				</li>
			</ul>
		</div>
	</div>
</div>

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
		<div class="navbar bg-primary-800 navbar-component" style="position: relative; z-index: 30;">
			<div class="navbar-collapse collapse" id="navbar-demo">
				<ul class="nav navbar-nav">
					<li class="mega-menu mega-menu-wide active">
						<a href="/" class="menu-link" style=" color: white;">Главная</a>
					</li>
					<li class="mega-menu mega-menu-wide">
						<a href="/about/" class="menu-link" style=" color: white;">О нас</a>
					</li>
					<li class="mega-menu mega-menu-wide">
						<a href="/work/" class="menu-link" style=" color: white;">Услуги</a>
					</li>
					<li class="mega-menu mega-menu-wide">
						<a href="/blog/" class="menu-link" style=" color: white;">Приложения</a>
					</li>
					<li class="mega-menu mega-menu-wide">
						<a href="/contacts/" class="menu-link" style=" color: white;">Контакты</a>
					</li>
				</ul>
			</div>
		</div>

        <?php echo $content; ?>
	</div>
	<!-- CONTENT STOP -->

	<!--Footer-->
    <?= Yii::$app->controller->renderPartial('@layouts/_footer.php'); ?>
</div>

</body>
</html>
