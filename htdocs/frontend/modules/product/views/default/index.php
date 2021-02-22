<?php

use common\components\M;


/*/
$this->context->page_title = $oContent->seo_title;
//$this->context->pageTitle = $oContent->page_title;
$this->context->page_keywords = $oContent->seo_keywords;
$this->context->page_description = $oContent->seo_description;
$this->context->page_noindexing = $oContent->is_seo_noindexing;
//*/

//M::printr($this->context, '$this->context');
?>
<div class="row">
	<div class="form-group">
		<div class="col-lg-10">
			<div class="row">
				<div class="col-lg-3 col-md-6 col-sm-9 col-xs-12">
					<div class="form-group has-feedback has-feedback-left">
						<input type="text" class="form-control" id="SearchString" placeholder="Search string">
						<div class="form-control-feedback">
							<i class="icon-search4 text-size-base"></i>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

<div class="preloader">
	<img src="/images/preloaders/preloader.gif" style="display: none;">
</div>

<div class="row">
	<div class="col-lg-6" id="Products">

	</div>
</div>

<?php if (0) { ?>
	<div class="panel border-left-lg border-left-primary hide">
		<div class="panel-body">
			<div class="row">
				<div class="col-md-8">
					<h6 class="no-margin-top"><a href="task_manager_detailed.html">${title}</a></h6>
					<p class="mb-15">${description}</p>
				</div>

				<div class="col-md-4 hide">
					<ul class="list task-details">
						<li>28 January, 2016</li>
						<li class="dropdown">
							Priority: &nbsp;
							<a href="#" class="label label-primary dropdown-toggle" data-toggle="dropdown">Normal <span
										class="caret"></span></a>
							<ul class="dropdown-menu dropdown-menu-right">
								<li><a href="#"><span class="status-mark position-left bg-danger"></span> Highest
										priority</a></li>
								<li><a href="#"><span class="status-mark position-left bg-info"></span> High
										priority</a>
								</li>
								<li class="active"><a href="#"><span
												class="status-mark position-left bg-primary"></span> Normal priority</a>
								</li>
								<li><a href="#"><span class="status-mark position-left bg-success"></span> Low priority</a>
								</li>
							</ul>
						</li>
						<li><a href="#">Eternity app</a></li>
					</ul>
				</div>
			</div>
		</div>
	</div>

	<table style="padding: 0px; border: 1px solid #000;" class="hide">
		<tr style="height: 100px">
			<td colspan=2></td>
		</tr>
		<tr style="height: 700px; vertical-align: top;">
			<td id="Tree" class="tree" style="width: 800px;">

				<form method="post">
					<div class="panel">
						<div class="panel-heading panel-visible">
							<span class="panel-icon"></span> <span class="panel-title">Короткое описание</span>
						</div>

						<div class="panel-body Form admin-form">
							<div class="formField mb10" data-type="text">
							</div>
						</div>
					</div>
				</form>

			</td>
			<td id="Data" class="data" style="width: 800px;">
			</td>
		</tr>
	</table>

	<div class="btn btn-warning" id="ImageButton1" class="imageButton1">ImageButton1</div>
<?php } ?>

<!-- - ->
<script type="text/javascript" src="/web/js/ckeditor5-master/packages/ckeditor5-build-classic/build/ckeditor.js"></script-->
<!-- -->

<?php if (0) { ?>
    <?php //*/ ?>
	<!--<h1>Интернет-магазин ФИШМЕН<?php //= $content->page_title ?></h1>
	<p><?= $oContent->page_body ?></p>
	<?php //= $this->renderPartial('_main/banner') ?>-->
    <?php //*/ ?>

    <?php //if ($this->beginCache('page' . $this->cache_key, $this->cache_opts)) { ?>

	<div class="visuallyhidden">
		<h1>Рыболовный интернет-магазин Фишмен</h1>
	</div>
	<div class="visuallyhidden" itemscope itemtype="http://schema.org/Organization">
		<span itemprop="name">Интернет-магазин Фишмен</span> <a itemprop="url" title="" href="https://fishmen.ru"></a>
		<!-- -->
		<a itemprop="sameAs" title="" href="https://vk.com/fishmen_ru" rel="nofollow"></a> <a itemprop="sameAs" title=""
		                                                                                      href="https://www.facebook.com/fishmen.ru/"
		                                                                                      rel="nofollow"></a>
		<!-- -->
		<img itemprop="logo" alt="" src="https://fishmen.ru/images/icon-200x200.png">

		<div itemprop="address" itemscope itemtype="http://schema.org/PostalAddress">
			<span itemprop="streetAddress">ул.Комарова, 3А</span> <span
					itemprop="postalCode">150034</span> <span itemprop="addressLocality">Ярославль</span>
		</div>
		Телефон:<span itemprop="telephone">+7 4852 60-70-47</span>, Факс:<span
				itemprop="faxNumber">+7 4852 60-70-47</span>, Электронная почта: <span
				itemprop="email">info@fishmen.ru</span>
	</div>

	<!-- HEADER START ? -->
    <?php

    ?>
    <?= Yii::$app->controller->renderPartial('_main/_head_banner') ?>

	<!-- HEADER STOP -->

    <?= Yii::$app->controller->renderPartial('_main/_product', ['cards' => $cards]) ?>
    <?php if (0) { ?>
        <?= Yii::$app->controller->renderPartial('_main/_banner1') ?>
        <?= Yii::$app->controller->renderPartial('_main/_news') ?>
        <?= Yii::$app->controller->renderPartial('_main/_description') ?>
        <?= Yii::$app->controller->renderPartial('_main/_banner2') ?>
        <?= Yii::$app->controller->renderPartial('_main/_subs') ?>
    <?php } ?>
    <?php //$this->endCache(); ?>
    <?php //} ?>
<?php } ?>

<script type="application/javascript">

	//время последнего нажатия на кнопку
	let time_keypress_search = performance.now();
	//console.log('time_keypress_search', time_keypress_search);

	//лимит ожидания между нажатием и отправкой данных на поиск
	let time_keypress_limit = 800;
	//console.log('time_keypress_limit', time_keypress_limit);

	//новая и старая строка
	let searchString = null;
	let oldSearchString = null;
	let searchStringLength = null;
	let isNewSearchString = 0;

	//идентификатора отложенного срабатывания (setTimeout)
	let timeOutId;

	let pause;

	//идентификатор запроса
	let AjaxRequest;

	//функция отправки запроса строки для поиска на /cms/product/search-product
	function send_search(request) {
		$('.preloader').show();
		$('#Products').hide();
		console.log("ЗАПРОС К СЕРВЕРУ: " + request);

		//если был запрос, то прервать его
		if (AjaxRequest) {
			//старый запрос есть, прервать
			AjaxRequest.abort();
		}

		AjaxRequest = $.ajax({
			url: "<?= \yii\helpers\Url::to(['/product/default/search']) ?>",
			type: 'GET',
			dataType: 'json',
			data: {
				'request': request
			},
			success: function (response) {
				console.log("ОТВЕТ СЕРВЕРА ПОЛУЧЕН (response)", response);
				$('#Products').empty();
				$('#ProductTemplate').tmpl(response.products).appendTo('#Products');
				$('.preloader').hide();
				$('#Products').show();
			}

			,
			error: function (data, key, value) {
				console.log("ОТВЕТ СЕРВЕРА НЕ РАСПОЗНАН");
				console.log("data", data);
				console.log("key", key);
				console.log("value", value);
				$('.preloader').hide();
				$('#Products').show();
				return false;
			}
		})
		;
	}

	function preSearch() {
		//console.log('#SearchString change keyup');

		//получить новую строку
		searchString = $('#SearchString').val();
		//console.log('searchString', searchString);

		//проверить, новая ли это строка для поиска и есть ли там 3 символа
		searchStringLength = searchString.length;
		//console.log('searchStringLength', searchStringLength);

		//епсли длина строки меньше 3-х символов, то остановиться
		if (searchStringLength < 3) return false;
		//console.log('searchStringLength < 3');

		//разница времени между нажатиями
		pause = performance.now() - time_keypress_search;
		console.log('pause', pause);

		//если время еще не вышло (все еще вводим текст)
		if (pause < time_keypress_limit) {
			//остановить таймер
			clearTimeout(timeOutId);
			console.log('clearTimeout(timeOutId)');
		}

		//время последнего нажатия
		time_keypress_search = performance.now();
		//console.log('time_keypress_search', time_keypress_search);

		isNewSearchString = searchString != oldSearchString;
		//console.log('isNewSearchString', isNewSearchString);

		//если строка старая
		if (!isNewSearchString) return false;
		//console.log('!isNewSearchString');

		oldSearchString = searchString;

		//если время ожидания вышло, то отправляем запрос
		timeOutId = setTimeout(function () {
			send_search(searchString)
			clearTimeout(timeOutId);
		}, time_keypress_limit);
	}

	$(document).ready(function () {
		"use strict";
		// Init Theme Core
		//Core.init();
		// Init Demo JS
		//Demo.init();

		$('body')
			.on('change keyup', '#SearchString', function (e) {
				e.preventDefault();
				console.log('change keyup > #SearchString');
				preSearch();
			})
			.on('submit', '#SearchForm', function (e) {
				e.preventDefault();
				console.log('submit > #SearchForm');
				searchString = $('#SearchString').val();
				send_search(searchString);
				//preSearch();
			})
			.on('change keyup', 'X#SearchString', function (e) {
				//при вводе в строку поиска
				console.log('#SearchString ' + 'keyup');
				//если нажали Enter
				if ((e.keyCode === 10) || (e.keyCode === 13)) {
					//прервать все действия
					e.preventDefault();
					return false;
				}


				var l = $('#main_search_input').val().length;
				if (l <= 2) {
					$('#ResultBlock').hide();
					$('#TextBlock').html('');
					$('#PreloaderBlock').hide();
				}

				time_keypress_search = performance.now();
				setTimeout(send_search, time_keypress_limit);
			})
			.on('dblclick', 'X.productLine', function (e) {
				e.preventDefault();
				console.log('dblclick');

				//открыть просмотр статьи в новой вкладке

			})
		;

	});
</script>

<script id="ProductTemplate" type="text/template">
	<div class="panel border-left-lg border-left-primary productLine" data-product_id="${id}">
		<div class="panel-body">
			<div class="row">
				<div class="col-md-12">
					<h5 class="no-margin-top itemTitle">
						<a href="/product/${id}" target="_blank">${title}</a>
					</h5>
					<h6 class="no-margin-top itemScore">${score}</h6>
					<p class="mb-15" class="itemDescription">${description}</p>
					<p>
						{{each(i, item) crops}} <img src="/store${item.fs_alias}"> {{/each}}
					</p>
				</div>
			</div>
		</div>
	</div>

</script>

<?php if (0) { ?>
	<div class="col-md-4" hide>
		<ul class="list task-details">
			<li>28 January, 2015</li>
			<li class="dropdown">
				Priority: &nbsp;
				<a href="#" class="label label-primary dropdown-toggle" data-toggle="dropdown">Normal <span
							class="caret"></span></a>
				<ul class="dropdown-menu dropdown-menu-right">
					<li><a href="#"><span class="status-mark position-left bg-danger"></span> Highest priority</a></li>
					<li><a href="#"><span class="status-mark position-left bg-info"></span> High priority</a>
					</li>
					<li class="active"><a href="#"><span
									class="status-mark position-left bg-primary"></span> Normal priority</a>
					</li>
					<li><a href="#"><span class="status-mark position-left bg-success"></span> Low priority</a>
					</li>
				</ul>
			</li>
			<li><a href="#">Eternity app</a></li>
		</ul>
	</div>
	<tr class="productLine hide" data-product_id="${id}">
		<td>${id}</td>
		<td><a href="/cms/product/edit?product_id=${id}" target="_blank">${title}</a></td>
		<td>${score}</td>
		<td>${is_fotos}</td>
		<td>${dt_created}</td>
		<td>${dt_updated}</td>
	</tr>
<?php } ?>
