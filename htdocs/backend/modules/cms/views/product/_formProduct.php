<?php

use \common\components\M;

$webtheme = Yii::getAlias('@webtheme');
?>
<script src="<?= $webtheme ?>/assets/js/plugins/forms/styling/uniform.min.js" type="text/javascript"></script>
<script src="<?= $webtheme ?>/vendor/plugins/liTranslit/js/jquery.liTranslit.js" type="text/javascript"></script>
<script src="<?= $webtheme ?>/vendor/jquery/jquery.tmpl.min.js" type="text/javascript"></script>
<script src="<?= $webtheme ?>/vendor/jquery/jquery_ui/jquery-ui.min.js" type="text/javascript"></script>
<script src="<?= $webtheme ?>/vendor/plugins/summernote-0.8.18/summernote.min.js" type="text/javascript"></script>
<link href="<?= $webtheme ?>/vendor/plugins/summernote-0.8.18/summernote.css" rel="stylesheet" type="text/css">
<!-- - ->
<script type="text/javascript" src="<?= $webtheme ?>/assets/js/pages/editor_summernote.js"></script>
<!-- -->

<?php
$formName = 'Product';
$webtheme = Yii::getAlias('@webtheme');
?>
<button type="button" class="btn btn-default btn-sm" data-toggle="modal" data-target="#modal_default">Launch <i
			class="icon-play3 position-right"></i></button>

<!-- -->
<style>
	.multiple, #category1 {
		list-style-type: none;
		margin: 0;
		padding: 0;
		#width: 350px;
	}

	#ImagesGallery .previewx, .multiple .previewx, #category1 .previewx {
		margin: 3px 3px 3px 0;
		padding: 1px;
		float: left;
		width: 350px;
		#height: 90px;
		#font-size: 4em;
		text-align: center;
	}

	#CategoryProduct {
		width: 600px;
	}

	#popup {
		#position: absolute;
		margin: auto;
		width: 50%;
		height: 400px;
	}

	.wraptree {
		#position: relative;
		overflow-y: scroll;
		max-height: 500px;
	}

	.mytree {
		width: 50%;
		background-color: #fff;
		margin: auto;
		position: relative;
		padding: 20px;
	}

	.key_dots {
		cursor: pointer;
	}

	.teaser_small_clear, .teaser_big_clear {
		position: absolute;
		margin: 5px;
		right: 0;
		top: 0;
		font-size: 25px;
		color: red;
		border-radius: 5px;
		border: solid 2px #ff8888;
		padding: 3px;
		cursor: pointer;
	}
</style>
<!-- -->

<script>
	if (0) {
		$(function () {
			$(".multiple").sortable({ //#category1
				zIndex: 9999
				//placeholder: "ui-state-highlight"
				//#items: "> previewx"
			});
			$(".multiple").disableSelection(); //#category1
		});
	}
</script>

<form id="<?= $formName ?>">
	<div class="panel">
		<div class="panel-heading">
			<h5 class="panel-title">Куда привязана страница Product</h5>
			Title: <?= $oProduct->title ?>
			oProduct->title
		</div>

		<div class="panel-body" style="display: block;">
			<div class="tabbable">
				<ul class="nav nav-tabs">
					<li class="active">
						<a href="#tab_General" data-toggle="tab" aria-expanded="true">Основные</a>
					</li>
					<li class="">
						<a href="#tab_SEO" data-toggle="tab" aria-expanded="false">SEO</a>
					</li>
					<li class="">
						<a href="#tab_IMG" data-toggle="tab" aria-expanded="false">Images</a>
					</li>
				</ul>

				<div class="tab-content">
					<!-- tab_General -->
					<div id="tab_General" class="tab-pane active">
						<input type="hidden" name="<?= $formName ?>[id]" value="<?= $oProduct->id ?>">

						<!-- Расположение товара -->
						<div class="row">
							<div class="col-md-12">
								<div class="form-group">
									<label class="" for="">Расположение товара</label> <input
											type="text" class="form-control" value="<?php //= $path ?>"
											disabled>
								</div>
							</div>
						</div>

						<!-- id, dt_created, dt_updated -->
						<div class="row">
							<!-- id -->
							<div class="col-md-4">
                                <?php $name = 'id' ?>
								<div class="form-group">
									<label><?= $oProduct->getAttributeLabel($name) ?></label><!--
											--><input type="text" class="form-control"
									                  id="<?= $formName ?>_<?= $name ?>"
									                  name="<?= $formName ?>[<?= $name ?>]"
									                  value="<?= $oProduct->$name ?>" disabled>
								</div>
							</div>

							<!-- dt_created -->
							<div class="col-md-4">
                                <?php $name = 'dt_created' ?>
								<div class="form-group">
									<label><?= $oProduct->getAttributeLabel($name) ?></label><!--
											--><input type="text" class="form-control"
									                  id="<?= $formName ?>_<?= $name ?>"
									                  name="<?= $formName ?>[<?= $name ?>]"
									                  value="<?= strftime('%d.%m.%Y, %H:%M', strtotime($oProduct->$name)) ?>"
									                  disabled>
								</div>
							</div>

							<!-- dt_updated -->
							<div class="col-md-4">
                                <?php $name = 'dt_updated' ?>
								<div class="form-group">
									<label><?= $oProduct->getAttributeLabel($name) ?></label><!--
											--><input type="text" class="form-control"
									                  id="<?= $formName ?>_<?= $name ?>"
									                  name="<?= $formName ?>[<?= $name ?>]"
									                  value="<?= strftime('%d.%m.%Y, %H:%M', strtotime($oProduct->$name)) ?>"
									                  disabled>
								</div>
							</div>
						</div>

						<!-- title -->
						<div class="row">
							<div class="col-md-12">
								<div class="form-group">
                                    <?php $name = 'title' ?>
									<label><?= $oProduct->getAttributeLabel($name) ?></label><!--
											--><input type="text"
									                  class="form-control"
									                  id="<?= $formName ?>_<?= $name ?>"
									                  name="<?= $formName ?>[<?= $name ?>]"
									                  value="<?= $oProduct->$name ?>">
								</div>
							</div>
						</div>

						<!-- description -->
						<div class="row">
							<div class="col-md-12">
								<div class="form-group">
                                    <?php $name = 'description' ?>
									<label><?= $oProduct->getAttributeLabel($name) ?></label><!--
											--><textarea class="summernote form-control"
									                     id="<?= $formName ?>_<?= $name ?>"
									                     name="<?= $formName ?>[<?= $name ?>]"
									                     data-type="text"><?= $oProduct->$name ?></textarea>
								</div>
							</div>
						</div>

						<!-- button -->
						<div class="row">
							<div class="col-md-12">
								<div class="form-group">
                                    <?php $name = 'is_published' ?>
									<input
											type="checkbox" <?= $oProduct->$name ? 'checked' : '' ?>
											id="<?= $formName ?>_<?= $name ?>"
											value="1"
											name="<?= $formName ?>[<?= $name ?>]"> <label
											for="<?= $formName ?>_<?= $name ?>"><?= $oProduct->getAttributeLabel($name) ?></label>
								</div>
							</div>
						</div>

					</div>
					<!-- /tab_General -->

					<!-- tab_SEO -->
					<div id="tab_SEO" class="tab-pane">

						<!-- seo_title, seo_keywords -->
						<div class="row">
							<!-- seo_title -->
							<div class="col-md-6">
								<div class="form-group">
                                    <?php $name = 'seo_title' ?>
									<label><?= $oProduct->getAttributeLabel($name) ?></label><!--
											--><input type="text"
									                  class="form-control"
									                  id="<?= $formName ?>_<?= $name ?>"
									                  name="<?= $formName ?>[<?= $name ?>]"
									                  value="<?= $oProduct->$name ?>">
								</div>
							</div>

							<!-- seo_keywords -->
							<div class="col-md-6">
								<div class="form-group">
                                    <?php $name = 'seo_keywords' ?>
									<label><?= $oProduct->getAttributeLabel($name) ?></label><!--
											--><input type="text"
									                  class="form-control"
									                  id="<?= $formName ?>_<?= $name ?>"
									                  name="<?= $formName ?>[<?= $name ?>]"
									                  value="<?= $oProduct->$name ?>">
								</div>
							</div>
						</div>

						<!-- seo_description -->
						<div class="row">
							<div class="col-md-12">
								<div class="form-group">
                                    <?php $name = 'seo_description' ?>
									<label><?= $oProduct->getAttributeLabel($name) ?></label><!--
											--><textarea class="form-control"
									                     id="<?= $formName ?>_<?= $name ?>"
									                     name="<?= $formName ?>[<?= $name ?>]"
									                     data-type="text"><?= $oProduct->$name ?></textarea>
								</div>
							</div>
						</div>

						<!-- toTranslit -->
						<div class="row mb-20">
							<div class="col-md-12">
								<div class="form-group">
									<button id="toTranslit"
									        class="col-lg-12 col-md-12 col-sm-12 col-xs-12 btn btn-sm btn-info"><?= $oProduct->getAttributeLabel('product_name') ?>
										>> <?= $oProduct->getAttributeLabel('url_alias') ?>
									</button>
								</div>
							</div>
						</div>

						<!-- url_alias -->
						<div class="row">
							<!-- url_alias -->
							<div class="col-md-12">
								<div class="form-group">
                                    <?php $name = 'url_alias' ?>
									<label><?= $oProduct->getAttributeLabel($name) ?></label><!--
                                    --><input type="text"
									          class="form-control"
									          id="<?= $formName ?>_<?= $name ?>"
									          name="<?= $formName ?>[<?= $name ?>]"
									          value="<?= $oProduct->$name ?>"
									          placeholder="Alias">
								</div>
							</div>
						</div>
					</div>
					<!-- /tab_SEO -->

					<!-- tab_IMG -->
					<div id="tab_IMG" class="tab-pane">

						<!-- button for images -->
						<div class="row">
							<div class="col-md-6">
								<div class="form-group">
									<a href="/images/default/index" class="btn btn-danger btn-xs" data-target="#modal"
									   data-toggle="modal">IMAGES</a>
								</div>
							</div>
						</div>

						<!-- gallery -->
						<div class="row">
							<div class="col-md-12">
								<div id="ImagesGallery" class="row">

								</div>
							</div>
						</div>

					</div>
					<!-- /tab_IMG -->
				</div>
			</div>
		</div>

		<div class="panel-body Form admin-form">
			<button id="submit" class="btn btn-success btn-sm">Сохранить</button>
		</div>
	</div>
</form>
<div class="btn btn-success" id="CheckSummerNote">check</div>
<?php
//M::printr($oProduct, '$oProduct');

$jsStores = \yii\helpers\Json::encode($oStores);
?>
<script>
	let num = 1;
	let stores = <?= $jsStores ?>;
	console.log('stores', stores);

	//транслит
	function callback(file, store) {
		//console.log('===== file', file); //image data from dropzone
		//console.log('===== store', store); //store of database
		setImage(store);
	}

	function setImage(store) {
		console.log('setImage(store)');
		console.log('store', store);
		store.num = num;
		let $Preview = $('#PreviewTemplate').tmpl(store);

		$('#ImagesGallery').append($Preview);
		num++;
	}

	function translit(src, dest) {
		console.log('src, dest', src, dest);
		var name = $(src).val();
		//console.log('[name]', name);
		var res = liTranslit(name);
		//console.log('[res]', res);
		$(dest).val(res);
	}

	$(document).ready(function () {

		stores.forEach(function (store, i, arr) {
			setImage(store);
		});

		$('#ImagesGallery').sortable();

		$('.summernote').summernote();

		$('.summernote-height').summernote({
			height: 600
		});

		$('#modal').on('hidden.bs.modal', function () {
			$('#modal .modal-container').empty();
			$('#modal').removeData();
		});

		//отправка данных на сохранение
		$('#submit').on('click', function (e) {
			$('#submit').prop('disabled', true);
			e.preventDefault();
			$.ajax({
				url: '<?= \yii\helpers\Url::to(['save', 'id' => $oProduct->id]); ?>',
				type: 'POST',
				dataType: 'json',
				data: $('#<?= $formName ?>').serialize(),
				success: function (response) {
					console.log('[response]', response);
					$('#submit').prop('disabled', false);
					if (response.success == true) {
						//ошибок нет
						//location.reload();
						//window.location = '<?php //= $this->createUrl('list') ?>';
						window.close();
					} else {
						//ошибки есть
						pnotify('danger', 'Ошибка', response.message);
						$.each(response.messages, function (index, item) {
							pnotify('danger', index, item);
						});

						//$('#errors').empty().append(printrErrors(response.error));
						$('#submit').prop('disabled', false);
					}
				},
				error: function (data, key, value) {
					$('#submit').prop('disabled', false);
					return false;
					//after_send(data);
				}
			});

			if (0) {
				$('#alert').hide();
				$('#submit').prop('disabled', true);

				$.ajax({
					url: '<?= \yii\helpers\Url::to(['save', 'id' => $oProduct->id]); ?>',
					type: 'POST',
					dataType: 'json',
					data: $('#<?= $formName ?>').serialize(),
					success: function (response) {
						console.log('[response]', response);
						$('#submit').prop('disabled', false);
						if (response.success == true) {
							//ошибок нет
							//location.reload();
							//window.location = '<?php //= $this->createUrl('list') ?>';
							window.close();
						} else {
							//ошибки есть
							pnotify('danger', 'Ошибка', response.message);
							$.each(response.messages, function (index, item) {
								pnotify('danger', index, item);
							});

							//$('#errors').empty().append(printrErrors(response.error));
							$('#submit').prop('disabled', false);
						}
					},
					error: function (data, key, value) {
						$('#submit').prop('disabled', false);
						return false;
						//after_send(data);
					}
				});
			}
		});

		$('form').on('click', '#toTranslit', function (e) {
			e.preventDefault();
			translit('#<?= $formName ?>_title', '#<?= $formName ?>_url_alias');
		});

		//обработка изменения поля summernote
		$('body')
			.on('change keyup click', '.note-editor', function (e) {
				e.preventDefault();
				if (0) {
					let contentSummerNote;
					if ($(this).hasClass('codeview')) {
						contentSummerNote = $(this).find('.note-codable').val();
					} else {
						contentSummerNote = $(this).find('.note-editable').html();
					}
					$(this).siblings('textarea').val(contentSummerNote);
				}
			})
			.on('click', '.deleteImage', function (e) {
				e.preventDefault();
				let imageBlock = $(this).closest('.imageBlock');
				let image_id = imageBlock.data('id');
				imageBlock.find('.delete_image_id').val(image_id);
				imageBlock.hide();

				console.log('delete image_id > ', image_id);
			})
			.on('click', 'X#CheckSummerNote', function (e) {
				e.preventDefault();
				console.log('#CheckSummerNote clicked');
				let $summerNote;

				$summerNote = $('.summernote').innerHtml();
				console.log('$summerNote', $summerNote);

				if (0) {
					$summerNote = $summerNote + 'testing...';
					$(".summernote").summernote("code", $summerNote);

					$summerNote = $('.summernote').val();
					console.log('$summerNote', $summerNote);
				}
			})
		;


	});
</script>

<?php if (1) { ?>
	<!-- PreviewTemplate -->
	<script id="PreviewTemplate" type="text/template">
		<div class="previewx imageBlock" style="" data-id="${id}">
			<div>
				<input class="image_id" type="hidden" name="<?= $formName ?>[images][${num}][image_id]"
				       value="${id}"><input
						class="delete_image_id" type="hidden" name="<?= $formName ?>[images][${num}][is_delete]"
						value="0">
			</div>

			<div class="panel panel-tile text-center">
				<div class="panel-body">
					<div style="position: relative; height: 100px;" class="mb15">
						<img src="/store${fs_alias}" class="upload_image" style="max-width: 100%; max-height: 100px;">
					</div>
					<span class="upload_name" style="font-weight: bold;">${fileName}</span><br> <span
							class="upload_size">${fileSize}</span> bytes<br> (<span
							class="upload_dimension_width">${width}</span>x<span
							class="upload_dimension_height">${height}</span>)
				</div>
				<div class="panel-footer bg-light dark br-t br-light p12">
					<span class="fs11"> <span class="btn btn-xs btn-info imageEdit"><i class="fa fa-edit"> </i></span>
						<span
								class="btn btn-xs btn-info"><i class="fa fa-search-plus"> </i></span> <span
								class="btn btn-xs btn-danger deleteImage"><i class="fa fa-trash-o"></i></span> </span>
				</div>
			</div>
		</div>
	</script>
	<!-- /PreviewTemplate -->

	<a class="ajax-modal" id="category_<?= 'asdf' ?>" href="/images/default/index" data-toggle="modal"
	   data-target="#modal">text of link</a>

	<!-- Basic modal -->
	<div id="modal" class="modal fade" style="display: none;">
		<div class="modal-dialog modal-lg">
			<div class="modal-content">

			</div>
		</div>
	</div>
	<!-- /basic modal -->

	<!-- OldPreviewTemplate -->
	<div id="OldPreviewTemplate" style="display: none;">
		<div class="col-md-4 preview">
			<input class="image_id" type="hidden" name="id" value="">

			<div class="panel panel-tile text-center">
				<div class="panel-body">
					<div style="position: relative; height: 100px;" class="mb15">
						<img src="" class="upload_image">
					</div>
					<span class="upload_name">fileName</span><br> <span class="upload_size">fileSize</span> bytes<br>
					(<span
							class="upload_dimension_width">fileDimensionWidth</span>x<span
							class="upload_dimension_height">fileDimensionHeight</span>)
				</div>
				<div class="panel-footer bg-light dark br-t br-light p12">
					<span class="fs11"> <span class="btn btn-xs btn-info imageEdit"><i class="fa fa-edit"> </i></span>
						<span
								class="btn btn-xs btn-info imageView"><i class="fa fa-search-plus"> </i></span> </span>
				</div>
			</div>
		</div>
	</div>
	<!-- /OldPreviewTemplate -->

<?php } ?>


