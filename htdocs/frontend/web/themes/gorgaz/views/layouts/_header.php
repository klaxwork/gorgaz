<?php

use common\components\M;

//M::printr('_header');

/** общее верхнее меню для всех страниц КРОМЕ главной*/
?>

<!--Header-->
<header>
	<div class="headerContent">
		<div class="logo"><a href="/"><img src="/images/gorgaz/logo.png"></a></div>
		<form class="search" style="display: none;">
			<input type="text"> <input src="/images/gorgaz/button-search.png" type="image">
		</form>
	</div>
</header>

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
