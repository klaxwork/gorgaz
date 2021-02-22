<?php

use common\components\M;

//use backend\assets\BackAsset;

//BackAsset::register($this);
//M::printr($this->assetBundles, '$this->assetBundles');

//list(, $url) = Yii::$app->assetManager->publish('css/');
//M::printr($url, '$url');
//$assetManager = Yii::$app->assetManager;
//M::printr($assetManager, '$assetManager');
$themePath = $this->theme->baseUrl;

//$this->registerJsFile('@webtheme/vendor/jquery/jquery-1.11.1.min.js');

//$this->registerCssFile('@theme/assets/admin-tools/admin-forms/css/admin-forms.css');
//$this->registerCssFile("@theme/assets/css/core.css");

if (0) {
    $cs = Yii::$app()->clientScript;
    $themePath = Yii::app()->theme->baseUrl;

    $cs->registerCssFile($themePath . '/assets/admin-tools/admin-forms/css/admin-forms.css');
    $cs->registerCssFile($themePath . '/vendor/plugins/magnific/magnific-popup.css');
    $cs->registerScriptFile($themePath . '/vendor/plugins/magnific/jquery.magnific-popup.js', CClientScript::POS_END);
    $cs->registerScriptFile($themePath . '/vendor/plugins/jquerymask/jquery.maskedinput.min.js', CClientScript::POS_END);
    $cs->registerScriptFile($themePath . '/vendor/jquery/jquery_ui/jquery-ui.min.js', CClientScript::POS_END);
    $cs->registerScriptFile($themePath . '/vendor/plugins/liTranslit/js/jquery.liTranslit.js', CClientScript::POS_END);
    $cs->registerCssFile($themePath . '/vendor/plugins/fancytree/skin-win8/ui.fancytree.min.css');
    $cs->registerScriptFile($themePath . '/vendor/plugins/fancytree/jquery.fancytree-all.min.js', CClientScript::POS_END);
    $cs->registerScriptFile($themePath . '/vendor/plugins/fancytree/extensions/jquery.fancytree.childcounter.js', CClientScript::POS_END);
    $cs->registerScriptFile($themePath . '/vendor/plugins/fancytree/extensions/jquery.fancytree.columnview.js', CClientScript::POS_END);
    $cs->registerScriptFile($themePath . '/vendor/plugins/fancytree/extensions/jquery.fancytree.dnd.js', CClientScript::POS_END);
    $cs->registerScriptFile($themePath . '/vendor/plugins/fancytree/extensions/jquery.fancytree.edit.js', CClientScript::POS_END);
    $cs->registerScriptFile($themePath . '/vendor/plugins/fancytree/extensions/jquery.fancytree.filter.js', CClientScript::POS_END);
    $cs->registerScriptFile($themePath . '/vendor/plugins/bootbox/bootbox.min.js', CClientScript::POS_END);

    $cs->registerCssFile($themePath . '/vendor/plugins/select2/css/core.css');
    $cs->registerScriptFile($themePath . '/vendor/plugins/select2/select2.full.js', CClientScript::POS_END);

    $cs->registerCssFile($themePath . '/vendor/plugins/dropzone/css/dropzone.css');
    $cs->registerScriptFile($themePath . '/vendor/plugins/dropzone/dropzone.min.js', CClientScript::POS_END);
}
?>
<!--
<link href="<?= $themePath ?>/assets/admin-tools/admin-forms/css/admin-forms.css" rel="stylesheet" type="text/css">
<script type="text/javascript" src="<?= $themePath ?>/vendor/jquery/jquery_ui/jquery-ui.min.js"></script>
-->
<?php
$webtheme = Yii::getAlias('@webtheme');
?>
<script src="<?= $webtheme ?>/vendor/jquery/jquery.tmpl.min.js" type="text/javascript"></script>
<style>
	.productLine {
		cursor: default;
	}
</style>
<?php if (0) { ?>
	<div class="row">
		<div class="col-md-12">
			<div class="panel">
				<div class="panel-menu">
					<div class="chart-legend">
						<table class="table">
							<thead>
							<tr class="primary">
								<td>#ID</td>
								<td>Название товара</td>
								<td>is_closed</td>
								<td>is_trash</td>
								<td>Категория</td>
								<!--
                                <td align="center">Закрыт</td>
                                <td align="center">Опубликован</td>
                                <td align="center">Запрет<br/> индексации</td>
                                -->
								<td style="width: 67px;">&nbsp;</td>
							</tr>
							</thead>
							<tbody>
                            <?php foreach ($oProducts as $oProduct) { ?>
								<tr>
									<td><?= $oProduct->id ?></td>
									<td>
										<a class="Xajax-popup-link"
										   href="<?= $this->createUrl('/cms/product/edit', ['id' => $oProduct->id]) ?>"><?= $oProduct->product_name ?></a>
									</td>
									<td><?= $oProduct->is_closed ? '<i class="fa fa-eye-slash"></i>' : '' ?></td>
									<td><?= $oProduct->is_trash ? '<i class="fa fa-trash-o"></i>' : '' ?></td>
									<td><?= $oProduct->appProduct->tree->node_name ?></td>

                                    <?php /*/ ?>
                                <td><?= empty($oQuest->company) ? '-' : $oQuest->company->company_name ?></td>
                                <td><?= $oQuest->ecmProduct->version->version_name ?></td>
                                <td align="center">
                                    <div class="checkbox-custom fill checkbox-disabled mb10">
                                        <input type="checkbox" <?= $oQuest->ecmProduct->is_closed ? 'checked' : '' ?>
                                               disabled="" id="checkboxDefault11"> <label
                                            for="checkboxDefault11"></label>
                                    </div>
                                </td>
                                <td align="center">
                                    <div class="checkbox-custom fill checkbox-disabled mb10">
                                        <input
                                            type="checkbox" <?= $oQuest->tree->is_node_published ? 'checked' : '' ?>
                                            disabled="" id="checkboxDefault11"> <label
                                            for="checkboxDefault11"></label>
                                    </div>
                                </td>
                                <td align="center">
                                    <div class="checkbox-custom fill checkbox-disabled mb10">
                                        <input
                                            type="checkbox" <?= $oQuest->tree->is_seo_noindexing ? 'checked' : '' ?>
                                            disabled="" id="checkboxDefault11"> <label
                                            for="checkboxDefault11"></label>
                                    </div>
                                </td>
                                <?php //*/ ?>
									<td class="text-right">
										<div class="btn-group text-right">
											<a class="btn btn-success btn-xs fs12" title=""
											   href="<?= $this->createUrl('edit', ['id' => $oProduct->id]) ?>"> <i
														class="fa fa-edit"></i> </a>
											<button type="button"
											        class="btn btn-success br2 btn-xs fs12 dropdown-toggle"
											        data-toggle="dropdown" aria-expanded="false"><span
														class="caret"></span>
											</button>
											<ul class="dropdown-menu dropdownMenuRight0" role="menu">
												<li>
													<a href="<?= $this->createUrl('edit', ['id' => $oProduct->id]) ?>">Изменить</a>
												</li>
												<li class="divider"></li>
												<li>
													<a class="ajax-popup-link"
													   href="<?= $this->createUrl('delete', ['id' => $oProduct->id]) ?>">Удалить</a>
												</li>
												<li>
													<a href="#">Complete</a>
												</li>
												<li>
													<a href="#">Pending</a>
												</li>
												<li>
													<a href="#">Canceled</a>
												</li>
											</ul>
										</div>
									</td>

								</tr>
                            <?php } ?>
							</tbody>
						</table>
					</div>
				</div>
			</div>
		</div>
	</div>
<?php } ?>

<div class="row">
	<div class="col-md-12">
		<div class="panel">
			<div class="panel-menu">
			</div>
			<div class="panel-body">
				<div class="chart-legend">
					<form action="" id="SearchForm">
						<input type="text" name="searchString" value="" class="searchString" id="SearchString">
						<div class="submitButton" id="SubmitButton">Найти</div>
					</form>
				</div>

				<div class="row">
					<div class="col-lg-12 col-md-12">
						<div class="preloader" style="display: none;"><img src="/images/preloader.gif"></div>
						<table id="Products" border="1" style="display: none;">
							<thead>
							<tr>
								<td>id</td>
								<td>title</td>
								<td>score</td>
								<td>is_fotos</td>
								<td>dt_created</td>
								<td>dt_updated</td>
							</tr>
							</thead>
							<tbody>
							</tbody>
							<tfoot>

							</tfoot>
						</table>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

<script id="ProductTemplate" type="text/template">
	<tr class="productLine" data-product_id="${id}">
		<td>${id}</td>
		<td><a href="/cms/product/edit?product_id=${id}" target="_blank">${title}</a></td>
		<td>${score}</td>
		<td>${is_fotos}</td>
		<td>${dt_created}</td>
		<td>${dt_updated}</td>
	</tr>
</script>

<script type="application/javascript">

	//время последнего нажатия на кнопку
	let time_keypress_search = performance.now();
	//console.log('time_keypress_search', time_keypress_search);

	//лимит ожидания между нажатием и отправкой данных на поиск
	let time_keypress_limit = 500;
	//console.log('time_keypress_limit', time_keypress_limit);

	//старая строка
	let oldSearchString = null;

	//идентификатора отложенного срабатывания (setTimeout)
	let timeOutId;

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
			url: '/cms/product/search-product',
			type: 'GET',
			dataType: 'json',
			data: {
				'request': request
			},
			success: function (response) {
				console.log("ОТВЕТ СЕРВЕРА ПОЛУЧЕН (response)", response);
				$('.preloader').hide();
				$('#Products').show();
				let $Products = $('#ProductTemplate').tmpl(response.products);
				$('#Products tbody').empty();
				$('#Products tbody').append($Products);

			},
			error: function (data, key, value) {
				console.log("ОТВЕТ СЕРВЕРА НЕ РАСПОЗНАН (data, key, value)", data, key, value);
				$('.preloader').hide();
				$('#Products').show();
				return false;
			}
		});
	}

	function preSearch() {
		//console.log('#SearchString change keyup');

		//время последнего нажатия
		time_keypress_search = performance.now();
		//console.log('time_keypress_search', time_keypress_search);

		//разница времени между нажатиями
		let pause = performance.now() - time_keypress_search;
		//console.log('pause', pause);

		//если время еще не вышло (все еще вводим текст)
		if (pause < time_keypress_limit) {
			//остановить таймер
			clearTimeout(timeOutId);
			//console.log();
		}

		//проверить, новая ли это строка для поиска и есть ли там 3 символа
		let searchString = $('#SearchString').val();
		let searchStringLength = searchString.length;

		//епсли длина строки меньше 3-х символов, то остановиться
		if (searchStringLength < 3) return false;

		let isNewSearchString = searchString != oldSearchString;
		//console.log('isNewSearchString', isNewSearchString);
		//если строка старая
		if (!isNewSearchString) return false;

		oldSearchString = searchString;

		//если время ожидания вышло, то отправляем запрос

		timeOutId = setTimeout(function () {
			send_search(searchString)
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
				preSearch();
			})
			.on('submit', '#SearchForm', function (e) {
				e.preventDefault();
				let searchString = $('#SearchString').val();
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
			.on('dblclick', '.productLine', function (e) {
				e.preventDefault();
				console.log('dblclick');

				//открыть редактирование статьи в новой вкладке

			})
		;

	});
</script>
