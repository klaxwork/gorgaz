<?php
$webtheme = Yii::getAlias('@webtheme');
?>
<link href="<?= $webtheme ?>/vendor/plugins/dropzone/css/dropzone.css" rel="stylesheet" type="text/css">
<script src="<?= $webtheme ?>/vendor/plugins/dropzone/dropzone.min.js"></script>
<script src="<?= $webtheme ?>/assets/js/functions.js"></script>
<script src="<?= $webtheme ?>/vendor/jquery/jquery.tmpl.min.js" type="text/javascript"></script>

<style>
	.upload_image {
		max-width: 100%;
		max-height: 100px;
	}

	.upload_name {
		font-weight: bold;
	}
</style>

<div class="modal-header">
	<button type="button" class="close" data-dismiss="modal">&times;</button>
	<h5 class="modal-title">Basic modal</h5>
</div>

<div class="modal-body">
	<div id="uploadGallery" class="panel">
		<div class="panel-heading">
			Загрузка изображений.
		</div>
		<div class="panel-body Form admin-form">
			<div id="tab_Upload" class="tab-pane active">

				<form action="<?= \yii\helpers\Url::to(['/images/default/store']) ?>" class="dropzone dropzone-sm"
				      id="dropZone">
					<div class="fallback">
						<input name="file" type="file" multiple="on"
						       style="width: 100%; height: 600px; border: solid 1px red;">
					</div>
					<div class="dz-message" data-dz-message><span>Your Custom Message</span></div>
				</form>

			</div>

			<input id="galleryParams" type="hidden" value="">

            <?php if (0) { ?>
				<div id="tab_Gallery" class="tab-pane">
					<div id="previewBlock">
                        <?php foreach ($oCategories as $oCategory) { ?>
							<div class=" row">
								<div style="display: none; position: absolute; right: 20px;" class="icons">
									<i class="expanded fa fa-sort-down"></i>
								</div>
								<div class="toggleImgs progress progress-bar-xl">
									<div class="progress-bar progress-bar-success" role="progressbar"
									     aria-valuenow="100"
									     aria-valuemin="0" aria-valuemax="100" style="width: 100%;">
										<span class="category_name"><?= $oCategory->category_name ?></span>
									</div>
								</div>
								<div class="imgs row category<?= $oCategory->id ?>">
								</div>
							</div>
                        <?php } ?>
						<div class=" row">
							<div style="display: none; position: absolute; right: 20px;" class="icons">
								<i class="expanded fa fa-sort-down"></i>
							</div>
							<div class="toggleImgs progress progress-bar-xl">
								<div class="progress-bar progress-bar-success" role="progressbar" aria-valuenow="100"
								     aria-valuemin="0" aria-valuemax="100" style="width: 100%;">
									<span class="category_name">Без категории</span>
								</div>
							</div>
							<div class="imgs row category">
							</div>
						</div>
					</div>
				</div>
            <?php } ?>

		</div>
		<div class="panel-footer Form admin-form buttonOk" style="display: block;">
			<div class="tab-content pn br-n">
				<span class="btn btn-success btn-sm" onclick="javascript:sendResponse();">OK</span>
			</div>
		</div>
	</div>
</div>

<div class="modal-footer">
	<button type="button" class="btn btn-link" data-dismiss="modal">Close</button>
	<button type="button" class="btn btn-primary">Save changes</button>
</div>

<!--
Классы внутренних span`ов
(upload_image, upload_name, upload_size, upload_dimension_width, upload_dimension_height)
не удалять!
На них ориентирован скрипт.
-->
<div id="XPreviewTemplate" style="display: none;">
	<div class="col-md-4 preview">
		<input class="image_id" type="hidden" name="id" value="">

		<div class="panel panel-tile text-center">
			<div class="panel-body">
				<div style="position: relative; height: 100px;" class="mb15">
					<img src="" class="upload_image">
				</div>
				<span class="upload_name">fileName</span><br> <span class="upload_size">fileSize</span> bytes<br> (<span
						class="upload_dimension_width">fileDimensionWidth</span>x<span class="upload_dimension_height">fileDimensionHeight</span>)
			</div>
			<div class="panel-footer bg-light dark br-t br-light p12">
				<span class="fs11"> <span class="btn btn-xs btn-info imageEdit"><i class="fa fa-edit"> </i></span> <span
							class="btn btn-xs btn-info imageView"><i class="fa fa-search-plus"> </i></span> </span>
			</div>
		</div>
	</div>
</div>

<div id="DefaultPreviewTemplate" style="display: none;">
	<div class="dz-preview dz-file-preview">
		<div class="dz-details">
			<div class="dz-filename"><span data-dz-name></span></div>
			<div class="dz-size" data-dz-size></div>
			<img data-dz-thumbnail/>
		</div>
		<div class="dz-progress"><span class="dz-upload" data-dz-uploadprogress></span></div>
		<div class="dz-success-mark"><span>✔</span></div>
		<div class="dz-error-mark"><span>✘</span></div>
		<div class="dz-error-message"><span data-dz-errormessage></span></div>
	</div>
</div>

<div id="DefaultMessage" style="display: none;">
	<i class="fa Xfa-cloud-upload"></i> <span class="main-text"><b>Drop Files</b>!!! to upload@@@</span> <br/> <span
			class="sub-text">???(or click)</span>
</div>
<div class="editImageForm" style="display: none;"></div>

<?php if (1) { ?>
	<script>
		//$params
		var galleryParams = <?= \yii\helpers\Json::encode([$params]) ?>;
		var selectedImages = [];
		var backUrl = '';
		callbackParams = [];

		/**
		 * функция для запроса на занесение картинки в галерею
		 *
		 * @param media_storage
		 * @param isSelected
		 */
		function imgToApp(media_storage, isSelected) {
			console.log('[imgToApp]', media_storage, isSelected);
			var data = {};
			data.media_storage = media_storage;
			data.app_gallery_categories_ref = $('#upload_app_category :selected').val();

			if (0) {
				$.ajax({
					url: '<?= \yii\helpers\Url::to(['addToGallery']) ?>',
					type: 'POST',
					dataType: 'json',
					data: data,
					success: function (responseAjax) {
						console.log('[imgToApp -> responseAjax]', responseAjax);
						if (responseAjax.errors == false) {
							//ошибок нет
							media_storage.app_gallery_categories_ref = $('#upload_app_category :selected').val();
							imgToGallery(media_storage, isSelected);
							//location.reload();
							//window.location = '<?= \yii\helpers\Url::to(['list']) ?>';
						} else {
							//ошибки есть
							$('#errors').empty().append(printrErrors(responseAjax.error));
							$('#submit').prop('disabled', false);
						}
					},
					error: function (data, key, value) {
						return false;
						//after_send(data);
					}
				});
			}
		}

		/**
		 * функция для отображения картинки в галерее
		 *
		 * @param media_storage
		 * @param isSelected
		 */
		function imgToGallery(media_storage, isSelected) {
			console.log('[imgToGallery]', media_storage, isSelected);
			if (media_storage.alias == undefined) {
				media_storage.alias = media_storage.fs_alias;
			}
			if (media_storage.name == undefined) {
				media_storage.name = media_storage.title != null ? media_storage.title : media_storage.fs_filename;
			}
			if (media_storage.size == undefined) {
				media_storage.size = media_storage.fs_filesize;
			}
			if (media_storage.dimension == undefined) {
				var media_storage_data = JSON.parse(media_storage.data);
				var data = media_storage_data.meta;
				media_storage.dimension = {};
				media_storage.dimension.width = data[0];
				media_storage.dimension.height = data[1];
			}
			var $template = $('#templatePreview .preview').clone();
			$template.find('.image_id').val(media_storage.id);
			$template.find('img').attr('src', '/store' + media_storage.alias);
			var filename =
				$template.find('.upload_name').text(media_storage.name);
			$template.find('.upload_size').text(media_storage.size);
			$template.find('.upload_dimension_width').text(media_storage.dimension.width);
			$template.find('.upload_dimension_height').text(media_storage.dimension.height);
			$('#previewBlock .category' + (media_storage.app_gallery_categories_ref != null ? media_storage.app_gallery_categories_ref : '')).append($template);
			if (isSelected) {
				$template.trigger('click');
			}
			console.log('[SELECTED]', selectedImages);

		}

		function getGalleryParams() {
			console.log('[Parametres]', galleryParams);
		}

		function closeGallery() {
			console.log('[closeGallery]', galleryParams);
		}

		function checkOkButton() {
			if (galleryParams.category == undefined) {
				return;
			}
			var isEmpty = true;
			selectedImages.forEach(function (item, index) {
				if (item) {
					isEmpty = false;
					return false;
				}
			});

			if (isEmpty) {
				$('.buttonOk').hide();
			} else {
				$('.buttonOk').show();
			}
			$('.buttonOk').show();
		}

		function sendResponse() {
			//if(galleryParams.callback != undefined){
			//eval(galleryParams.callback)(selectedImages, galleryParams);
			//}
			console.log('sendResponse()');
			if (0) {
				if (typeof window['galleryCallback'] == 'function') {
					console.log('[galleryCallback]', selectedImages, galleryParams);
					//galleryCallback(selectedImages, galleryParams);
				}
			}

			if (0) {
				//выполнить callback функцию
				if (typeof window['callback'] == 'function') {
					console.log('[callback]');
					//galleryCallback(selectedImages, galleryParams);
					//callback(file, responseJson);
				}
			}

			//$.magnificPopup.close();
		}

		$(document).ready(function () {
			getGalleryParams();
			//сохранение данных картинки
			$('#x');

			$('.toggleImgs').on('click', function (e) {
				$(this).siblings('.imgs').toggleClass('hide');
			});

			//выбор картинки
			$('#previewBlock')
				.on('click', '.preview', function (e) {
					e.preventDefault();
					console.log('Выделить кликнутый блок.', galleryParams);
					//получить id картинки из кликнутого блока
					if (galleryParams['multiple'] != true) {
						selectedImages = [];
						$('#previewBlock .preview .panel').removeClass('bg-info');
						//console.log('[reset]');
					}
					var current = $(this).find('.image_id').val();
					var in_array = false;
					selectedImages.forEach(function (item, index) {
						if (item == current) {
							in_array = true;
							delete selectedImages[index];
							return false;
						}
					});
					if (in_array == false) {
						selectedImages.push($(this).find('.image_id').val());
					}
					console.log('selectedImages', selectedImages);

					$(this).find('.panel').toggleClass('bg-info');
					checkOkButton();
					//console.log('selectedImages', selectedImages);
				})
			;

			/*
            //отобразить загруженные ранее картинки в галерее
            images.forEach(function (item, index, imgs) {
                //console.log('[ITEM]', item);
                if (item.app_gallery_categories_ref == galleryParams.category || item.app_gallery_categories_ref == null) {
                    imgToGallery(item);
                }
                if (galleryParams.category == undefined) {
                    imgToGallery(item);
                }
            });
            */

			var dz_options = {
				url: "<?= \yii\helpers\Url::to(['/images/default/store']) ?>",
				method: 'post',
				paramName: 'file', // The name that will be used to transfer the file
				maxFilesize: 50, // MB
				addRemoveLinks: true,
				//previewTemplate: $('#PreviewTemplate').html(),
				previewTemplate: $('#DefaultPreviewTemplate').html(),
				createImageThumbnails: true,
				init: function () {
					this
						.on('sending', function (file, xhr, formData) {
							//alert('Sending ');
							//formData.append("target", $("#dropZone").val());
							console.log('[SENDING]');
							console.log('file', file);
							console.log('xhr', xhr);
							console.log('formData', formData);

							//console.log($("#dropZone").val());
						})
						.on('success', function (file, storeData) {
							//alert('OK ' + responseData);
							console.log('[dz_options: success]');
							console.log('file', file);
							console.log('storeData', storeData);
							storeJson = $.parseJSON(storeData);
							console.log('storeJson', storeJson);

							//добавить в галерею в базе
							//imgToApp(responseData, true);

							//previewBlock -- где отобразить залитые картинки
							//добавить картинку в блок просмотра картинки
							//imgToGallery(responseData);

							if (1) {
								//выполнить callback функцию
								if (typeof window['callback'] == 'function') {
									console.log('[callback]', storeJson);
									//galleryCallback(selectedImages, galleryParams);
									callback(file, storeJson);
								}
							}
							//$(file.previewElement).remove();
						})
						.on('removedfile', function (arg1, arg2, arg3, arg4) {
							console.log('arg1', arg1);
							console.log('arg2', arg2);
							console.log('arg3', arg3);
							console.log('arg4', arg4);
						})
						.on('error', function (file, responseData, xhr) {
							alert('ERR ' + responseData);
						})
					;

				},

				dictDefaultMessage: $('#DefaultMessage').html(),
				//dictFallbackText: 'dictFallbackText',
				dictResponseError: 'Server not Configured'
			};

			var myDropzone = new Dropzone("#dropZone", dz_options);

			$('#uploadGallery')
				.on('click', '.imageEdit', function (e) {
					//imageEdit
					e.preventDefault();
					$('#uploadGallery').hide();
					$('.editImageForm').html('').show();

					var id = $(this).closest('.preview').find('input.image_id').val();

					//загрузить форму редактирования изображения
					$.ajax({
						url: '<?= \yii\helpers\Url::to(['/product/gallery/edit', 'id' => '__id__']) ?>'.replace('__id__', id),
						type: 'POST',
						dataType: 'html',
						data: {}
					}).success(function (responseAjax) {
						//console.log('[imgToApp -> responseAjax]', responseAjax);
						//$('.editImageForm').text('');
						backUrl = '';
						$('.editImageForm').html(responseAjax);
					}).error(function (data, key, value) {
						return false;
						//after_send(data);
					});


					//получить данные о выбранной картинке по id
					/*getImage(id, function (response) {
                     console.log('RESPONSE IN getImage-callback', response);
                     if (response.images.length > 0) {

                     }
                     });*/
				}).on('click', '.imageView', function (e) {
				//imageView
				e.preventDefault();
				//$('');
			});
		}); //$(document).ready...

		var callbackEditImageFunction = function (data) {
			console.log('[callbackEditImageFunction]', data);
			$('.editImageForm').hide();
			$('#uploadGallery').show();
		};

		function getImage(id, callbackFunction) {
			$.ajax({
				url: '<?= \yii\helpers\Url::to(['/product/gallery/getImage', 'id' => '__id__']) ?>'.replace('__id__', id),
				type: 'POST',
				dataType: 'json',
				data: {},
				success: function (response) {
					//console.log('[response]', response);
					if (response.errors == false) {
						//ошибок нет
					}

					//если передали callback функцию, то выполнить ее
					if (typeof callbackFunction == 'function') {
						callbackFunction(response);
					}
				},
				error: function (data, key, value) {
					return false;
					//after_send(data);
				}
			});
		}

	</script>
	<!-- - ->
	<link href="<?= '/themes/limit/vendor/plugins/cropper/cropper.css' ?>" rel="stylesheet">
	<script src="<?= '/themes/limit/vendor/plugins/cropper/cropper.js' ?>"></script>
	<!-- -->

	<!--
    <script src="/themes/admin/vendor/plugins/holder/holder.min.js"></script>
    <script src="/themes/admin/vendor/plugins/fileupload/fileupload.js"></script>
    <script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
    -->
<?php } ?>
