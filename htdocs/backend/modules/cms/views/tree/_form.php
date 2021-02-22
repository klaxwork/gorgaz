<?php

use common\components\M;
use common\models\models\AppGalleryCategories;
use \yii\helpers\Url;
use \yii\helpers\Json;
use \common\models\models\EcmCustomFields;

$isProps = false;
$oEcmCustomFields = [];
if (0) { //(isset($descendants) && empty($descendants)) {
    $isProps = true;
    $criteria = new CDbCriteria();
    $criteria->addColumnCondition(['is_visible' => true]);
    $criteria->order = 'field_name ASC';
    $oEcmCustomFields = EcmCustomFields::model()->with(['customFieldMeta'])->findAll($criteria);
    //M::printr($oEcmCustomFields, '$oEcmCustomFields');
    //M::printr($oNode, '$oNode');
    $oNode->is_last_folder = true;
}
$is_last_folder = true;

//M::printr($oNode, '$oNode');
?>
<link rel="stylesheet" href="//code.jquery.com/ui/1.12.0/themes/base/jquery-ui.css">

<style>
	.multiple, #category1 {
		list-style-type: none;
		margin: 0;
		padding: 0;
		#width: 350px;
	}

	.multiple .previewx, #category1 .previewx {
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
</style>
<script>
	var num = 0;

	$(function () {
		$(".multiple").sortable({ //#category1
			zIndex: 9999
			//placeholder: "ui-state-highlight"
			//#items: "> previewx"
		});
		$(".multiple").disableSelection(); //#category1
	});
</script>

<form id="<?= $formName ?>" action="/cms/tree/edit-node">
	<div class="panel panel-flat">
		<div class="panel-heading panel-visible">
			<h6><span class="">Параметры узла &laquo;<?=
                    $oNode->node_name ? htmlspecialchars($oNode->node_name) : ''
                    ?>&raquo;</span></h6>
		</div>

		<div class="panel-body Form admin-form">
			<div class="tabbable">
				<ul class="nav panel-tabs-border panel-tabs nav-tabs">
					<li class="active">
						<a href="#tab_general" data-toggle="tab">Основные</a>
					</li>
					<li>
						<a href="#tab_seo" data-toggle="tab">SEO</a>
					</li>
					<li>
						<a href="#tab_images" data-toggle="tab">Галлерея</a>
					</li>
				</ul>
				<div class="tab-content pn br-n">
					<div id="tab_general" class="tab-pane active">
						<div id="General">
							<div class="row formField mb10" data-type="text">
								<div class="col-md-2">
									<label class=""
									       for="<?= $formName ?>_id"><?= $oNode->getAttributeLabel('id') ?></label>
									<input
											type="text" class="form-control input-sm" id="<?= $formName ?>_id"
											name="<?= $formName ?>[id]" data-type="text"
											value="<?= $oNode->id ? $oNode->id : '' ?>" disabled>
								</div>

                                <?php /*/ ?>
                        <div class="col-md-4">
                            <label class=""
                                   for="<?= $formName ?>_key"><?= $oNode->getAttributeLabel('key') ?></label> <input
                                    type="text" class="form-control input-sm" id="<?= $formName ?>_key"
                                    name="<?= $formName ?>[key]" data-type="text"
                                    value="<?= $oNode->key ? $oNode->key : '' ?>" disabled>
                        </div>
                        <?php //*/ ?>

								<div class="col-md-3">
									<label class=""
									       for="<?= $formName ?>_dt_created"><?= $oNode->getAttributeLabel('dt_created') ?></label>
									<input
											type="text" class="form-control input-sm" id="<?= $formName ?>_dt_created"
											name="<?= $formName ?>[dt_created]" data-type="text"
											value="<?= strftime('%d.%m.%Y %H:%M:%S', strtotime($oNode->dt_created)) //$oNode->dt_created ? $oNode->dt_created : ''                                                                                                                                               ?>"
											disabled>
								</div>
								<div class="col-md-3">
									<label class=""
									       for="<?= $formName ?>_dt_updated"><?= $oNode->getAttributeLabel('dt_updated') ?></label>
									<input
											type="text" class="form-control input-sm" id="<?= $formName ?>_dt_updated"
											name="<?= $formName ?>[dt_updated]" data-type="text"
											value="<?= strftime('%d.%m.%Y %H:%M:%S', strtotime($oNode->dt_updated)) //$oNode->dt_updated ? $oNode->dt_updated : ''                                                                                                                                               ?>"
											disabled>
								</div>
							</div>
							<div class="row formField mb10">
								<div class="col-lg-4">
									<label class=""
									       for="<?= $formName ?>_node_name"><?= $oNode->getAttributeLabel('node_name') ?></label>

									<input type="text" id="<?= $formName ?>_node_name" class="form-control input-sm"
									       name="<?= $formName ?>[node_name]" data-type="text"
									       value="<?= $oNode->node_name ? htmlspecialchars($oNode->node_name) : '' ?>">
								</div>
								<div class="col-lg-4">
									<label class=""
									       for="<?= $formName ?>_page_title"><?= $oNode->content->getAttributeLabel('page_title') ?></label>
									<input type="text" id="<?= $formName ?>_page_title"
									       class="form-control input-sm"
									       name="<?= $formName ?>[page_title]" data-type="text"
									       value="<?= $oNode->content->page_title ? htmlspecialchars($oNode->content->page_title) : '' ?>">
								</div>
								<div class="col-lg-4">
									<label class=""
									       for="<?= $formName ?>_page_longtitle"><?= $oNode->content->getAttributeLabel('page_longtitle') ?></label>
									<input type="text" id="<?= $formName ?>_page_longtitle"
									       class="form-control input-sm"
									       name="<?= $formName ?>[page_longtitle]" data-type="text"
									       value="<?= $oNode->content->page_longtitle ? htmlspecialchars($oNode->content->page_longtitle) : '' ?>">
								</div>
							</div>

							<div class="row formField mb10">
								<div class="col-md-12">
									<label class=""
									       for="<?= $formName ?>_page_teaser"><?= $oNode->content->getAttributeLabel('page_teaser') ?></label>

									<input type="text" id="<?= $formName ?>_page_teaser" class="form-control input-sm"
									       name="<?= $formName ?>[page_teaser]" data-type="text"
									       value="<?= $oNode->content->page_teaser ? htmlspecialchars($oNode->content->page_teaser) : '' ?>">
								</div>
							</div>

							<div class="formField mb10" data-type="text">
								<button id="toTranslit"
								        class="col-md-12 btn btn-sm btn-info mb10"><?= $oNode->getAttributeLabel('node_name') ?>
									>> <?= $oNode->getAttributeLabel('url_alias') ?>
								</button>
							</div>

							<div class="formField mb10" data-type="text">
								<label class=""
								       for="<?= $formName ?>_url_alias"><?= $oNode->getAttributeLabel('url_alias') ?></label>
								<input type="text" class="form-control input-sm" id="<?= $formName ?>_url_alias"
								       name="<?= $formName ?>[url_alias]" data-type="text"
								       value="<?= $oNode->url_alias ? $oNode->url_alias : '' ?>">
							</div>
							<div class="row formField mb10" data-type="text">
								<div class="col-md-10">
									<label class=""
									       for="<?= $formName ?>_menu_title"><?= $oNode->getAttributeLabel('menu_title') ?></label>
									<input type="text" class="form-control input-sm" id="<?= $formName ?>_menu_title"
									       name="<?= $formName ?>[menu_title]" data-type="text"
									       value="<?= $oNode->menu_title ? $oNode->menu_title : '' ?>">
								</div>
								<div class="col-md-2">
									<label class=""
									       for="<?= $formName ?>_menu_index"><?= $oNode->getAttributeLabel('menu_index') ?></label>
									<input type="text" class="form-control input-sm" id="<?= $formName ?>_menu_index"
									       name="<?= $formName ?>[menu_index]" data-type="text"
									       value="<?= $oNode->menu_index ? $oNode->menu_index : '' ?>">
								</div>
							</div>

							<div class="formField mb10" data-type="text">
								<div class="checkbox-custom mb5">
									<input type="checkbox" <?= $oNode->is_menu_visible ? 'checked' : '' ?>
									       class="styled"
									       id="<?= $formName ?>_is_menu_visible"
									       name="<?= $formName ?>[is_menu_visible]"> <label
											for="<?= $formName ?>_is_menu_visible"><?= $oNode->getAttributeLabel('is_menu_visible') ?></label>
								</div>
							</div>

							<div class="formField mb10" data-type="text">
								<div class="checkbox-custom mb5">
									<input type="checkbox" <?= $oNode->is_node_published ? 'checked' : '' ?>
									       class="styled"
									       id="<?= $formName ?>_is_node_published"
									       name="<?= $formName ?>[is_node_published]"> <label
											for="<?= $formName ?>_is_node_published"><?= $oNode->getAttributeLabel('is_node_published') ?></label>
								</div>
							</div>

                            <?php if ($is_last_folder) { ?>
								<div class="formField mb10" data-type="text">
									<div class="checkbox-custom mb5">
										<input type="checkbox" <?= $oNode->content->is_in_markets ? 'checked' : '' ?>
										       class="styled"
										       id="<?= $formName ?>_is_in_markets"
										       name="<?= $formName ?>[is_in_markets]"> <label
												for="<?= $formName ?>_is_in_markets"><?= $oNode->content->getAttributeLabel('is_in_markets') ?></label>
									</div>
								</div>

								<div class="formField mb10" data-type="text">
									<div class="checkbox-custom mb5">
										<input type="checkbox" <?= $oNode->content->is_in_google ? 'checked' : '' ?>
										       class="styled"
										       id="<?= $formName ?>_is_in_google"
										       name="<?= $formName ?>[is_in_google]"> <label
												for="<?= $formName ?>_is_in_google"><?= $oNode->content->getAttributeLabel('is_in_google') ?></label>
									</div>
								</div>
                            <?php } ?>
						</div>
					</div>

					<div id="tab_seo" class="tab-pane">
						<div id="Seo">
							<div class="formField mb10" data-type="text">
								<label class=""
								       for="<?= $formName ?>_seo_title"><?= $oNode->content->getAttributeLabel('seo_title') ?></label>
								<input type="text" class="form-control input-sm" id="<?= $formName ?>_seo_title"
								       name="<?= $formName ?>[seo_title]" data-type="text"
								       value="<?= $oNode->content->seo_title ? htmlspecialchars($oNode->content->seo_title) : '' ?>">
							</div>

							<div class="formField mb10" data-type="text">
								<label class=""
								       for="<?= $formName ?>_seo_keywords"><?= $oNode->content->getAttributeLabel('seo_keywords') ?></label>
								<input type="text" class="form-control input-sm"
								       id="<?= $formName ?>_seo_keywords"
								       name="<?= $formName ?>[seo_keywords]" data-type="text"
								       value="<?= $oNode->content->seo_keywords ? htmlspecialchars($oNode->content->seo_keywords) : '' ?>">
							</div>

							<div class="formField mb10" data-type="text">
								<label class=""
								       for="<?= $formName ?>_seo_description"><?= $oNode->content->getAttributeLabel('seo_description') ?></label>
								<textarea class="form-control input-sm"
								          id="<?= $formName ?>_seo_description" rows="3"
								          name="<?= $formName ?>[seo_description]"
								          data-type="text"><?= $oNode->content->seo_description ? htmlspecialchars($oNode->content->seo_description) : '' ?></textarea>
							</div>

							<div class="formField mb10" data-type="text">
								<div class="checkbox-custom mb5">
									<input
											type="checkbox" <?= $oNode->content->is_seo_noindexing ? 'checked' : '' ?>
											id="<?= $formName ?>_is_seo_noindexing"
											class="styled"
											name="<?= $formName ?>[is_seo_noindexing]"> <label
											for="<?= $formName ?>_is_seo_noindexing"><?= $oNode->content->getAttributeLabel('is_seo_noindexing') ?></label>
								</div>
							</div>

						</div>
					</div>

					<div id="tab_images" class="tab-pane <?= isset($_GET['tab_Images']) ? 'active' : '' ?>">
                        <?php
                        $galleryCategory = AppGalleryCategories::findOne(['dev_key' => 'ecm:illustrations']);
                        ?>
                        <?php $name = 'images_illustrations' ?>
						<div class="formField mb10" data-type="text">
							<label class=""
							       for="<?= $formName ?>_<?= $name ?>"><?= $galleryCategory->category_name ?></label>

							<div>
                                <?php
                                $params = array(
                                    'quest' => isset($model->id) ? $model->id : null,
                                    'category' => $galleryCategory->id,
                                    'multiple' => true,
                                    'callback' => 'setIllustrations',
                                );
                                ?>
								<a class="Xajax-popup-link legend-item btn btn-info ph30 mr20 selectPhoto"
								   data-toggle="modal" data-target="#modal"
								   href="<?= Url::to(
                                       [
                                           '/images/default/index',
                                           'params' => Json::encode($params),
                                       ]
                                   ); ?>">... (выбрать)</a>
							</div>

							<span>(Иллюстрации можно менять местами с помощью перетаскивания мышью.)</span>

							<div id="category_<?= $galleryCategory->id ?>" class="multiple previews">
							</div>
						</div>

					</div>
				</div>
			</div>
		</div>

        <?php if (!empty($oNode->id)) { ?>
			<div class="panel-body Form admin-form">
				<div class="formField mb10" data-type="text">
					<div class="checkbox-custom mb5">
						<input type="checkbox"
						       class="styled"
						       id="<?= $formName ?>_do_delete"
						       name="<?= $formName ?>[do_delete]"> <label
								for="<?= $formName ?>_do_delete">Удалить узел со всеми дочерними</label>
					</div>
				</div>
			</div>
        <?php } ?>

		<div class="panel-body Form admin-form">
			<button id="submit" class="btn btn-success btn-sm">Сохранить</button>
		</div>

		<div class="panel-body Form admin-form" style="display: none;">
			<div id="success" class="btn btn-info btn-sm">Сохранено успешно!</div>
		</div>

	</div>

	<div class="panel">
		<div class="panel-heading panel-visible">
			<span class="panel-icon"></span> <span class="panel-title">Короткое описание</span>
		</div>

		<div class="panel-body Form admin-form">
			<div class="formField mb10" data-type="text">
				<textarea class="summernote form-control input-sm" id="<?= $formName ?>_page_description"
				          name="<?= $formName ?>[page_description]"
				          data-type="text"><?= $oNode->content->page_description ?></textarea>
			</div>
		</div>
	</div>

	<div class="panel">
		<div class="panel-heading panel-visible">
			<span class="panel-icon"></span> <span
					class="panel-title"><?= $oNode->content->getAttributeLabel('page_body') ?></span>
		</div>

		<div class="panel-body Form admin-form">
			<div class="formField mb10" data-type="text">
				<textarea class="summernote form-control input-sm" id="<?= $formName ?>_page_body"
				          name="<?= $formName ?>[page_body]"
				          data-type="text"><?= $oNode->content->page_body ?></textarea>
			</div>
		</div>
	</div>

</form>

<div id="templates" style="display: none;">
	<div class="stringField col-xs-12 col-sm-12 col-md-12 col-lg-12">
		<div class="formField mb10" data-type="text">
			<label class="" for=""></label><!-- -->
			<input type="text" class="field form-control input-sm"
			       name="" value="">
		</div>
	</div>

	<div class="textField col-xs-12 col-sm-12 col-md-12 col-lg-12">
		<div class="formField mb10" data-type="text">
			<label class="" for=""></label><!-- -->
			<textarea class="form-control field input-sm" rows="3"
			          name=""></textarea>
		</div>
	</div>
</div>

<?php if ($isProps) { ?>
	<script type="text/template" id="TemplateField">
		<div class="row mt10" data-num="${num}">
			<input type="hidden" name="<?= $formName ?>[fields][${num}][id]" value="${id}"><!-- -->
			<input type="checkbox" class="hide is_deleted" name="<?= $formName ?>[fields][${num}][is_deleted]">

			<div class="col-xs-1 col-sm-1 col-md-1 col-lg-1" style="width: 20px;">
				<div class="formField">
					<span style="position: relative; top: 6px;">${num}</span>
				</div>
			</div>
			<div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">
				<div class="formField">
					<select id="<?= $formName ?>_${num}"
					        name="<?= $formName ?>[fields][${num}][ecm_custom_fields_ref]"
					        class="form-control input-sm customField"
					        data-type="select">
						<option value="">- Выберите свойство -</option>
                        <?php foreach ($oEcmCustomFields as $oField) { ?>
							<option value="<?= $oField->id ?>"
							><?= $oField->field_name ?><?= $oField->field_unit ? ", " . $oField->field_unit : ''; ?></option>
                        <?php } ?>
					</select>
				</div>
			</div>
			<div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">
				<div class="formField mb10" data-type="text">
					<input type="text" class="form-control input-sm typeField"
					       id="<?= $formName ?>_type"
					       name="<?= $formName ?>[fields][${num}][type]" data-type="text"
					       value="- Выберите свойство -" disabled>
				</div>
			</div>
			<div class="col-xs-2 col-sm-2 col-md-2 col-lg-2">
				<div style="position: relative; top: 6px;">
					<input type="checkbox"
					       class="styled"
					       id="<?= $formName ?>_${num}_visible"
					       name="<?= $formName ?>[fields][${num}][is_visible_in_card]"> <label
							for="<?= $formName ?>_is_node_published">Видим в карточке</label>
				</div>
			</div>
			<div class="col-xs-1 col-sm-1 col-md-1 col-lg-1">
				<span class="btn btn-sm btn-danger removeProp">Убрать</span>
			</div>
		</div>
	</script>

	<script type="application/javascript">
		//@todo Свойства категории
        <?php $oFields = EcmCustomFields::find()->orderBy(['field_name' => 'ASC'])->all(); ?>
		var oFields = <?= empty($oFields) ? [] : Json::encode($oFields) ?>;

        <?php
        $arr = [];
        foreach ($oEcmCustomFields as $item) {
            $x = $item->attributes;
            $x['meta'] = $item->customFieldMeta->attributes;
            $arr[] = $x;
        }
        ?>
		var num = 0;
		var oEcmCustomFields = <?= Json::encode($arr) ?>;
		//console.log('[oEcmCustomFields]', oEcmCustomFields);
		var fields = <?= Json::encode($oFields) ?>;
		//console.log('[FIELDS]', fields);

		$(document).ready(function () {
			fields.forEach(function (item) {
				//console.log('[ITEM]', item);
				addProp(item);
			});

			$('#Properties').on('change', '.customField', function () {
				changeProp($(this).closest('.row').data('num'));
			});

			$('#addProp').on('click', function () {
				addProp();
			});

			$('#Properties').on('click', '.removeProp', function () {
				$(this).closest('.row').hide().find('.is_deleted').attr('checked', true);
			});
		});

		function changeProp(num) {
			var $row = $('#Properties').find('.row[data-num="' + num + '"]');
			var value = $row.find('select').val();
			var type = _.findWhere(oEcmCustomFields, {id: Number(value)});
			if (type == undefined) {
				$row.find('.typeField').val('- Выберите свойство -');
			} else {
				$row.find('.typeField').val(type.meta.field_type + ' (' + type.meta.field_meta + ')');
			}
		}

		function addProp(data) {
			num++;
			if (data == undefined) {
				data = {};
				data.id = null;
			}
			data.num = num;
			//берем шаблон и заполняем его
			var $temp = $('#TemplateField').tmpl(data);
			//выбираем нужный option
			$temp.find('select [value="' + data.ecm_custom_fields_ref + '"]').attr('selected', true);
			if (data.is_visible_in_card) {
				$temp.find('#<?= $formName ?>_' + num + '_visible').attr('checked', true);
			}
			$temp.find('.customField').trigger('change');
			$temp.appendTo('#Properties');
			changeProp(num);
		}
	</script>
<?php } ?>

<?php
$galleryCategory = AppGalleryCategories::findOne(['dev_key' => 'ecm:illustrations']);
?>
<?php $name = 'images_illustrations' ?>
<script type="text/template" id="templateIllustration">
	<div class="previewx">
		<input class="id" type="hidden" name="<?= $formName ?>[<?= $name ?>][][id]"
		       value="${id}">

		<div class="panel panel-tile text-center">
			<div class="panel-body">
				<div style="position: relative; height: 100px;" class="mb15">
					<img src="/store${fs_alias}" class="upload_image" style="max-width: 100%; max-height: 100px;">
				</div>
				<span class="upload_name" style="font-weight: bold;" title="${fs_fileName}">${filename}</span><br> <span
						class="upload_size">${fs_filesize}</span> bytes<br> (<span class="upload_dimension_width">${meta.width}</span>x<span
						class="upload_dimension_height">${meta.height}</span>)
			</div>
			<div class="panel-footer bg-light dark br-t br-light p12">
				<span class="fs11"> <span class="btn btn-xs btn-info imageEdit"><i class="fa fa-edit"> </i></span> <span
							class="btn btn-xs btn-info"><i class="fa fa-search-plus"> </i></span> <span
							class="btn btn-xs btn-danger delete"><i class="fa fa-trash-o"></i></span> </span>
			</div>
		</div>
	</div>
</script>

<script type="application/javascript">
	var propertyFields = [];
    <?php //= CJSON::encode($oPropFields) ?>;
	var regionProperties = {};
	var is_tab = <?= isset($_GET['is_tab']) && $_GET['is_tab'] == 1 ? 1 : 0 ?>;

	/**
	 * поиск элемента среди объектов по его полю
	 *
	 * @param arr
	 * @param field
	 * @param value
	 * @returns {*}
	 */
	function findInObjects3(arr, field, value) {
		if (value == undefined) {
			value = field;
			field = 'id';
		}
		for (var i in arr) {
			if (arr[i] && arr[i][field] === value) {
				var x = {};
				x.index = i;
				x.element = arr[i];
				return x;
			}
		}
		return false;
	}

	function printField(field, value = null) {
		/*if (value == undefined) {
         value = null;
         }*/
		var $template = $('#templates .' + field.property_type + 'Field').clone();
		//console.log($template);
		$template
			.find('label')
			.attr('for', field.property_key)
			.text(field.property_name);
		$template
			.find('.field')
			.attr('id', field.property_key)
			.attr('name', field.property_key)
			.val(value);
		$('#regionProps').append($template);
	}

	function callback(file, store) {
		console.log('function callback(file, store)');
		console.log('file', file);
		console.log('store', store);

		addIllustration(store);
		//setImages(store);
	}


	function xxx(response) {
		//console.log('[response]', response);
		if (response.errors == false) {
			//ошибок нет
			if (is_tab == 1) {
				//alert('сохранено');
				setTimeout(
					function () {
						window.close();
					},
					1000
				);
			} else {
				location.reload();
			}

		} else {
			//ошибки есть
			$('#errors').empty().append(printrErrors(response.error));
			console.log('[MESSAGES]', response.messages);
			$('#submit').prop('disabled', false);
		}
	}

	//заполнение и показ полей региональных настроек
	function fillRegionProps() {
		propertyFields.forEach(function (field, index, arr) {
			//console.log('[field]', field);
			var find = findInObjects3(regionProperties, 'app_region_properties_ref', field.id);
			var prop = {};
			//console.log('[FIND]', find);
			if (find == false) {
				prop.property_value = null;
			} else {
				prop.property_value = find.element.property_value;
			}
			printField(field, prop.property_value);
		});
		//$('#regionProps, #saveRegionProps').show();
	}

	//вывод ошибок
	function printrErrors(errors) {
		$('#alert').show();
		//console.log('[ERRORS]', errors);
		var $ul = $('<ul>');
		var $li = $('<li>');
		for (var index in errors) {
			$('<li>').append(index + '...');
			var $ul2 = $('<ul>');
			for (var index2 in errors[index]) {
				$ul2.append($('<li>').text(errors[index][index2]));
			}
			$li.append($ul2.clone());
			$ul.append($li);
		}

		$('#errors').empty().append($ul);
	}

	//транслит
	function translit(src, dest) {
		var name = $(src).val();
		//console.log('[name]', name);
		var res = liTranslit(name);
		//console.log('[res]', res);
		$(dest).val(res);
	}

	function save() {
		$('#alert').hide();
		$('#submit').prop('disabled', true);
		//console.log($('#<?= $formName ?>').serialize());
		var data = $('#<?= $formName ?>').serializeJSON();
		console.log('data', data);
		if (1) {
			$.ajax({
				url: '<?= Url::to(['/cms/tree/edit-node', 'id' => $id]) ?>',
				type: 'POST',
				dataType: 'json',
				data: data,
				success: function (response) {
					console.log('[response]', response);
					if (response.success == true) {
						//ошибок нет
						if (is_tab == 1) {
							//alert('сохранено');
							pnotify('success', 'Сохранено', 'Узел успешно сохранен', 4000);
							setTimeout(
								function () {
									window.close();
								},
								2000
							);
						} else {
							location.reload();
						}

					} else {
						//ошибки есть
						//$('#errors').empty().append(printrErrors(response.message));
						pnotify('warning', 'Warning', response.message, 4000);
						console.log('[MESSAGES]', response.messages);
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

	$(document).ready(function () {

		//отправка данных на сохранение
		$('#submit').on('click', function (e) {
			e.preventDefault();
			console.log('#submit');
			save();
			return 0;
			$('#alert').hide();
			$('#submit').prop('disabled', true);
			//console.log($('#<?= $formName ?>').serialize());

			if (0) {
				$.ajax({
					url: '<?= Url::to(['/cms/default/edit-node', 'id' => $id]) ?>',
					type: 'POST',
					dataType: 'json',
					data: $('#<?= $formName ?>').serialize(),
					success: function (response) {
						//console.log('[response]', response);
						if (response.errors == false) {
							//ошибок нет
							if (is_tab == 1) {
								//alert('сохранено');
								setTimeout(
									function () {
										window.close();
									},
									1000
								);
							} else {
								location.reload();
							}

						} else {
							//ошибки есть
							$('#errors').empty().append(printrErrors(response.error));
							console.log('[MESSAGES]', response.messages);
							$('#submit').prop('disabled', false);
						}
					},
					error: function (data, key, value) {
						return false;
						//after_send(data);
					}
				});
			}
		});

		//транслит
		$('form')
			.on('click', '#toTranslit', function (e) {
				e.preventDefault();
				translit('#<?= $formName ?>_node_name', '#<?= $formName ?>_url_alias');
			})
		;

		//отслеживание изменения региона
		$('#<?= $formName ?>_app_regions_ref').on('change', function (e) {
			e.preventDefault();
			var node_id = <?= $oNode->id ? $oNode->id : 0 ?>;
			if (node_id == 0) {
				alert('Необходимо сначала создать узел');
				return false;
			}

			//спрятать то, что ниже
			$('#isRegionEnabled, #regionProps, #saveRegionProps').hide();

			//сохранить поля региона, если был выбран какой-либо регион
			//saveRegionProps();

			//проверить, что выбрано
			if ($(this).val() == '') {
				return false;
			}

			//console.log('getRegionProps');
			//запросить данные выбранного региона
			getRegionProps({
				'node_id': <?= $oNode->id ? $oNode->id : 0 ?>,
				'region_id': $(this).val()
			}, function (response) {
				//получили данные
				regionProperties = response;
				//console.log('[regionProperties]', regionProperties);
				var bool = false;
				if (regionProperties.length > 0) {
					bool = true;
				}
				$('#isRegionEnabled').show();
				$('#is_region_enabled').prop("checked", bool).trigger('change');
			});

		});

		//отслеживание изменения checkbox`а региональных настроек
		$('#is_region_enabled').on('change', function (e) {
			//e.preventDefault();
			$('#regionProps').empty();
			if ($(this).prop("checked")) {
				//console.log('checked');
				//заполнить поля и показать их
				fillRegionProps();
				$('#regionProps, #saveRegionProps').show();
			} else {
				regionProperties = {};
				$('#regionProps').hide();
			}
		});

		$('#submitRegionProperties').on('click', function (e) {
			e.preventDefault();

			//console.log('Сохранить');
			saveRegionProps();
		});
	});

	/**
	 * Сохранение региональных настроек
	 */
	function saveRegionProps() {
		//пройти по всем полям и передать их на сохранение
		var data = {};
		data.node_id = <?= $oNode->id ? $oNode->id : 0 ?>;
		data.region_id = $('#<?= $formName ?>_app_regions_ref').val();
		data.fields = [];
		propertyFields.forEach(function (field, index, arr) {
			//console.log('[field.property_key]', field.property_key);
			field.value = $('#' + field.property_key).val();
			data.fields.push(field);
		});

		//console.log('[DATA]', data);
		$.ajax({
			url: '<?= Url::to(['/cms/tree/saveRegionProps']) ?>',
			type: 'POST',
			dataType: 'json',
			data: data,
			success: function (response) {
				//console.log('[response]', response);
				if (response.success == true) {
					notify('success', 'Региональные данные', 'Успешно сохранено');
					//callback(response.regionProps);
				} else {
					notify('danger', 'Региональные данные', 'Ошибка при сохранении');
					//alert('Some errors...');
					return false;
				}
			},
			error: function (data, key, value) {
				return false;
				//after_send(data);
			}
		});
	}

	function getRegionProps(data, callback) {
		//console.log('[DATA]', data);
		$.ajax({
			url: '<?= Url::to('/cms/tree/getRegionProps') ?>',
			type: 'POST',
			dataType: 'json',
			data: data,
			success: function (response) {
				//console.log('[response]', response);
				if (response.success == true) {
					callback(response.regionProps);
				} else {
					alert('Some errors...');
					return false;
				}
			},
			error: function (data, key, value) {
				return false;
				//after_send(data);
			}
		});
	}

	/**
	 *
	 * @param type [success, warning, danger]
	 * @param title
	 * @param text
	 */
	function notify(type, title, text) {
		// Create new Notification
		new PNotify({
			title: title,
			text: text,
			shadow: true,
			opacity: 1,
			addclass: 'stack_top_right',
			type: type,
			stack: {
				"dir1": "down",
				"dir2": "left",
				"push": "top",
				"spacing1": 10,
				"spacing2": 10
			},
			width: '300px',
			delay: 1400
		});

	}

</script>

<script>
	//для изображений
	var image_teaser_small = []; //'<?php //= $oImages->image_teaser_small ?>';
	//console.log('[image_teaser_small]', image_teaser_small);

	var images_illustrations = []; //<?php //= Json::encode($oImages->images_illustrations) ?>;
	//console.log('[images_illustrations]', images_illustrations);

	var company = {};
	var quest = <?= isset($oNode->id) ? $oNode->id : "''" ?>;
	var photos = 0; //< ?= $this->photos ?>;

	function galleryCallback(response, params) {
		console.log('[galleryCallback]', response, params);
		if (response == '') {
			return;
		}
		return false;
		getImages(response, params);
	}

	var mediaStores = <?= $oImages ?>;
	console.log('mediaStores', mediaStores);

	mediaStores.forEach(function (item) {
		console.log('item', item);
		addIllustration(item);
	});

	function addIllustration(store) {
		console.log('[addIllustration]');
		console.log('store', store);
		num++;
		var data = store;
		data.num = num;
		storeData = $.parseJSON(data.data);
		console.log('storeData', storeData);
		var meta = {
			width: storeData.meta[0],
			height: storeData.meta[1]
		};
		console.log('meta', meta);

		data.meta = meta;
		console.log('data', data);

		var $template = $('#templateIllustration').tmpl(data);
		console.log('[TEMPLATE]', $template);
		$('.previews').append($template);
	}

	function setIllustrations(images, params) {
		console.log('[setIllustrations]', images, params);
		images.forEach(function (item, index) {
			num++;
			console.log('[forEach]', item, index);
			var dimension = JSON.parse(item.data);
			console.log('[dimension]', dimension);
			var data = {
				'num': num,
				'image_id': item.id,
				'category_id': params.category,
				'url': '/store' + item.fs_alias,
				'fileName': item.filename,
				'fs_filename': item.fs_filename,
				'fileSize': item.fs_filesize,
				'width': dimension.meta[0],
				'height': dimension.meta[1]
			};
			var $template = $('#templateIllustration').tmpl(data);
			console.log('[TEMPLATE]', $template);
			$('#category_' + params.category).append($template);
		});
	}

	function setImages(response, params) {
		if (params == undefined) {
			params = {
				multiple: true
			};
		}
		console.log('[setImages]');
		console.log('response', response);
		console.log('params', params);
		//setIllustrations(response.images, params);
		//setTeaser(response, params);
		//console.log('response.images', response.images);
		if (params.multiple == true) {
			setIllustrations(response.images, params);
		}
		if (params.multiple !== true) {
			setTeaser(response, params);
			//$('#category' + params.category + ' .image_thumb').attr('src', '/store' + response.images[0].fs_alias);
			//$('#category' + params.category + ' input').val(response.images[0].id);
		}
	}

	function setTeaser(response, params) {
		console.log('[setTeaser]');
		//console.log('response >>>', response);
		//console.log('params >>>', params);
		$('#category_' + params.category + ' .image_thumb').attr('src', '/store' + response.images[0].fs_alias);
		$('#category_' + params.category + ' input').val(response.images[0].id);
		//getImages(response, params);
		//console.log('Callback is working!!!');
	}

	//запрашивает данные о картинках по их id в cms_media_storage
	function getImages(ids, params) {
		console.log('[IDS]', ids, params);
		if (typeof ids != 'object') {
			ids = [ids];
		}
		$.ajax({
			url: '<?= Url::to('/product/gallery/getImage') ?>',
			type: 'POST',
			dataType: 'json',
			data: {'ids': ids},
			success: function (response) {
				console.log('[response]', response);
				if (response.errors == false) {
					//ошибок нет
					//console.log('response', response);
					//console.log('params', params);
					setImages(response, params);
					//location.reload();
					//window.location = '<?= Url::to('list') ?>';
				} else {
					//ошибки есть
					$('#errors').empty().append(printrErrors(response.error));
					$('#submit').prop('disabled', false);
				}
			},
			error: function (data, key, value) {
				return false;
			}
		});
	}

	function info() {
		//infoModal
		$('#infoModal').modal('show');
	}

	$(document).ready(function () {
		"use strict";

		$('input#<?= $formName ?>_node_name').focus();

		key('command+s, ctrl+s', function () {
			console.log('Saving...');
			save();
			return false;
		});

		key('command+s, ctrl+i', function () {
			console.log('Info...');
			info();
			return false;
		});

		//если выбран переход на таб иллюстраций
		//console.log('[PHOTOS] >>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>', photos);
		if (photos) {
			//перейти на таб photos
			setTimeout(function () {
				$('.selectPhoto').trigger('click');
			}, 200);
		}

		//инициализация select2
		$(".quest_create_category, .quest_create_category-multiple").select2();

		$('.teaser_small_clear').on('click', function (e) {
			e.preventDefault();
			$('#<?= $formName ?>_image_teaser_small').val('');
			$('.small_teaser .image_thumb').prop('src', 'holder.js/192x192');
			Holder.run();
		});

        <?php if (0) { ?>
        <?php
        $galleryCategory = AppGalleryCategories::findOne(['dev_key' => 'ecm:teaser_small']);
        ?>
		galleryCallback(
			image_teaser_small,
			{
				'quest': quest,
				'category': <?= $galleryCategory->id ?>
			}
		);
        <?php
        $galleryCategory = AppGalleryCategories::findOne(['dev_key' => 'ecm:illustrations']);
        ?>
		//console.log('images_illustrations', images_illustrations);
		galleryCallback(
			images_illustrations,
			{
				'quest': quest,
				'category': <?= $galleryCategory->id ?>,
				'multiple': true
			}
		);
        <?php } ?>

		$('.multiple').on('click', '.delete', function (e) { //#category1
			$(this).closest('.previewx').remove();
		});

		// Init FancyTree - w/Drag and Drop Functionality
		if ($.fancytree != undefined) {
			$("#viewtree").fancytree({
				extensions: ["filter", "edit", "childcounter"],
				filter: {
					autoApply: true, // Re-apply last filter if lazy data is loaded
					counter: true, // Show a badge with number of matching child nodes near parent icons
					hideExpandedCounter: true, // Hide counter badge, when parent is expanded
					mode: "hide"  // "dimm": Grayout unmatched nodes, "hide": remove unmatched nodes
				},
				// titlesTabbable: true,
				source: [{title: '-', key: 0}],
				childcounter: {
					deep: true,
					hideZeros: true,
					hideExpanded: true
				},
				click: function (event, data) {
					//console.log(data);
					company.company_name = data.node.title;
					company.id = data.node.key;
				},
				dblclick: function (event, data) {
					//console.log('DBLClick', data);
					if (data.node.folder == true) {
						return;
					}
					//добавить компанию в форму квеста
					company.company_name = data.node.title;
					company.id = data.node.key;
					selectCompany(company);

					//закрыть дерево
					$('.mfp-close').trigger('click');
				},
				activate: function (event, data) {
					//console.log('activate', data);
				}/*,
                 lazyLoad: function (event, data) {
                 data.result = {
                 url: "/json/ajax-sub2.json"
                 }
                 }*/
			});
		}

		$('.selectCompany').on('click', function () {
			selectCompany(company);
			//закрыть дерево
			$('.mfp-close').trigger('click');
		});

		$("#search").on('keyup', function () {
			var value = $(this).val();
			$("#viewtree").fancytree("getTree").filterNodes(value, {autoExpand: true, leavesOnly: false});
		});

	});

</script>

<div id="infoModal" class="modal fade" style="display: none;">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">×</button>
				<h5 class="modal-title">Помощь</h5>
			</div>

			<div class="modal-body">
                <?= M::printr($oNode, '$oNode'); ?>
			</div>

			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">Закрыть</button>
			</div>
		</div>
	</div>
</div>