<?php

use \common\components\M;
use \common\models\ar_inherit\EquipmentModels;
use \common\models\ar_inherit\EquipmentTypes;

$oTypes = EquipmentTypes::find()->orderBy('type_name ASC')->all();
?>
<style>
	a[data-action="remove"]:after {
		content: '\e9b6';
	}
</style>
<form id="OrderForm" action="" class="form-horizontal">
	<div class="panel panel-flat">
		<div class="panel-heading">
			<h5 class="panel-title">Форма заявки</h5>
		</div>

		<div class="panel-body">

			<!-- account -->
			<div class="form-group">
				<div class="row">
					<div class="col-lg-2">
						<label>Лицевой счет</label> <input type="text" name="order[account]"
						                                   placeholder="Лицевой счет"
						                                   class="form-control border-teal require"> <span
								class="help-block text-danger" style="display: none;">Поле обязательно для
							заполнения</span>
					</div>
				</div>
			</div>

			<!-- ФИО -->
			<div class="form-group">
				<div class="row">
					<div class="col-lg-2">
						<label>Фамилия собственника</label> <input type="text" name="order[second_name_owner]"
						                                           placeholder="Фамилия собственника"
						                                           class="form-control border-teal require"> <span
								class="help-block text-danger" style="display: none;">Поле обязательно для
							заполнения</span>
					</div>

					<div class="col-lg-2">
						<label>Имя собственника</label> <input type="text" name="order[first_name_owner]"
						                                       placeholder="Имя собственника"
						                                       class="form-control border-teal require"> <span
								class="help-block text-danger" style="display: none;">Поле обязательно для
							заполнения</span>
					</div>

					<div class="col-lg-2">
						<label>Отчество собственника</label> <input type="text" name="order[third_name_owner]"
						                                            placeholder="Отчество собственника"
						                                            class="form-control border-teal require"> <span
								class="help-block text-danger" style="display: none;">Поле обязательно для
							заполнения</span>
					</div>
				</div>
			</div>

			<!-- checkbox -->
			<div class="form-group">
				<div class="checkbox">
					<label> <input type="checkbox" name="order[is_declarant_owner]" value="is_declarant_owner"
					               class="styled"
					               checked="checked"
					               id="IsDeclarantOwner">Заявитель является собственником</label>
				</div>
			</div>

			<!-- agent -->
			<div class="row">
				<div id="AgentPanel" class="col-lg-6" style="border: 0; display: none;">
					<div class="panel">
						<div class="panel-body">
							<div class="form-group" id="AgentPanel">
								<div class="row">
									<div class="col-lg-4">
										<label>Фамилия доверенного лица</label> <input type="text"
										                                               name="order[second_name_agent]"
										                                               placeholder="Фамилия доверенного лица"
										                                               class="form-control border-teal">
									</div>

									<div class="col-lg-4">
										<label>Имя доверенного лица</label> <input type="text"
										                                           name="order[first_name_agent]"
										                                           placeholder="Имя доверенного лица"
										                                           class="form-control border-teal">
									</div>

									<div class="col-lg-4">
										<label>Отчество доверенного лица</label> <input type="text"
										                                                name="order[third_name_agent]"
										                                                placeholder="Отчество доверенного лица"
										                                                class="form-control border-teal">
									</div>
								</div>
							</div>
							<div class="form-group">
								<div class="row">
									<div class="col-lg-12">
										<div class="file_upload">
                                            <?php ?>
											<label class="noFoto">Фото/скан доверенности</label>
                                            <?php ?>
											<label class="uploadFoto" style="display: none;"></label>
                                            <?php ?>
											<input type="file" id="ProxyImageRef" class="form-control border-teal">
                                            <?php ?>
											<input type="hidden" name="order[proxy_image_ref]" class="proxyImageRef"
											       value="">
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>

			<!-- индекс, область, город -->
			<div class="form-group">
				<div class="row">
					<div class="col-lg-2">
						<label>Индекс</label>
                        <?php ?>
						<input type="text" name="order[index]" placeholder="Индекс"
						       class="form-control border-teal toAddress require"> <span
								class="help-block text-danger" style="display: none;">Поле обязательно для
							заполнения</span>
					</div>

					<div class="col-lg-2">
						<label>Область/Край</label>
                        <?php ?>
						<input type="text" name="order[state]" placeholder="Область/Край"
						       class="form-control border-teal toAddress require"> <span
								class="help-block text-danger" style="display: none;">Поле обязательно для
							заполнения</span>
					</div>

					<div class="col-lg-2">
						<label>Город/Населенный пункт</label>
                        <?php ?>
						<input type="text" name="order[city]" placeholder="Город/Населенный пункт"
						       class="form-control border-teal toAddress require"> <span
								class="help-block text-danger" style="display: none;">Поле обязательно для
							заполнения</span>
					</div>

				</div>
			</div>

			<!-- улица, дом, корпус, квартира -->
			<div class="form-group">
				<div class="row">
					<div class="col-lg-3">
						<label>Улица</label>
                        <?php ?>
						<input type="text" name="order[street]" placeholder="Улица"
						       class="form-control border-teal toAddress require"> <span
								class="help-block text-danger" style="display: none;">Поле обязательно для
							заполнения</span>
					</div>

					<div class="col-lg-1">
						<label>Номер дома</label>
                        <?php ?>
						<input type="text" name="order[house]"
						       placeholder="Номер дома"
						       class="form-control border-teal toAddress require"> <span
								class="help-block text-danger" style="display: none;">Поле обязательно для
							заполнения</span>
					</div>

					<div class="col-lg-1">
						<label>Корпус</label> <input type="text" name="order[building]"
						                             placeholder="Корпус"
						                             class="form-control border-teal toAddress">
					</div>

					<div class="col-lg-1">
						<label>Квартира</label> <input type="text" name="order[apartment]"
						                               placeholder="Квартира"
						                               class="form-control border-teal toAddress require"> <span
								class="help-block text-danger" style="display: none;">Поле обязательно для
							заполнения</span>
					</div>
				</div>
			</div>

			<!-- полный адрес -->
			<div class="form-group">
				<div class="row">
					<div class="col-lg-6">
						<label>Адрес объекта</label> <input type="text" name="order[address]"
						                                    placeholder="Адрес объекта"
						                                    class="form-control border-teal fullAddress">
					</div>
				</div>
			</div>

			<!-- причина обращения -->
			<div class="form-group pt-15">
				<div class="row">
					<div class="col-lg-6">
						<label>Причина обращения</label>
                        <?php ?>
						<select name="order[reason_ref]" id="ReasonRef"
						        class="col-lg-6 form-control border-teal reason">
                            <?php foreach ($oReasons as $oReason) { ?>
								<option value="<?= $oReason->id ?>"><?= $oReason->reason_name ?></option>
                            <?php } ?>
							<option value="other">Другое</option>
						</select>
					</div>
				</div>
			</div>

			<!-- моя причина обращения -->
			<div id="ReasonOther" style="display: none;">
				<div class="form-group">
					<div class="row">
						<div class="col-lg-6">
							<label>Ваша причина обращения</label>
                            <?php ?>
							<input type="text" name="order[reason_your]" placeholder="Ваша причина обращения"
							       class="form-control border-teal">
						</div>
					</div>
				</div>
			</div>

			<!-- Текст обращения -->
			<div id="ReasonText" style="display: block;">
				<div class="form-group">
					<div class="row">
						<div class="col-lg-6">
							<label>Текст обращения (напишите в свободной форме цель обращения)</label>
                            <?php ?>
							<textarea rows="4" cols="4" class="form-control border-teal elastic"
							          name="order[reason_text]"
							          placeholder="Текст обращения"></textarea>
						</div>
					</div>
				</div>
			</div>

			<!-- контактные данные -->
			<div class="form-group">
				<div class="row">
					<div class="col-lg-3">
						<label>Контактный телефон</label> <input type="text" name="order[phone]"
						                                         placeholder="Контактный телефон"
						                                         class="form-control border-teal require"> <span
								class="help-block text-danger" style="display: none;">Поле обязательно для
							заполнения</span>
					</div>

					<div class="col-lg-3">
						<label>Email</label> <input type="text" name="order[email]"
						                            placeholder="Email"
						                            class="form-control border-teal require"> <span
								class="help-block text-danger" style="display: none;">Поле обязательно для
							заполнения</span>
					</div>

				</div>
			</div>

			<!-- Добавить установленное газовое оборудование -->
			<div class="form-group">
				<div class="checkbox">
					<label> <input type="checkbox" name="order[is_add_equipment]" value="is_add_equipment"
					               class="styled"
					               id="IsAddEquipment"> Добавить установленное газовое оборудование </label>
				</div>
			</div>

			<div id="SettedEquipment" class="settedEquipment" style="display: none;">

				<!-- оборудование -->
				<div class="form-group">
					<div class="row">
						<h4 class="col-lg-12">Оборудование</h4>
					</div>
				</div>

				<!-- оборудование -->
				<div class="row">
					<div class="col-lg-6">
						<div id="EquipmentLines">
							<div class="equipmentLine hide" data-equipment_id="1">
								<div class="panel">
									<div class="panel-body">
										<div class="form-group">
											<div class="row">
												<!-- Вид газового оборудования -->
												<div class="col-lg-6">
													<label>Вид газового оборудования</label>
                                                    <?php ?>
													<select class="selectbox equipmentTypes border-teal"
													        name="order[equipment][1][equipment_types_ref]"
													        data-width="100%">
                                                        <?php foreach ($oTypes as $oType) { ?>
															<option value="<?= $oType->id ?>"><?= $oType->type_name ?></option>
                                                        <?php } ?>
													</select>
												</div>
												<!-- Модель газового оборудования -->
												<div class="col-lg-5 eqmod">
													<label>Модель газового оборудования</label>
                                                    <?php ?>
													<select class="selectbox equipmentModels border-teal"
													        name="order[equipment][1][equipment_models_ref]"
													        data-width="100%">
                                                        <?php foreach ($oModels as $oModel) { ?>
															<option value="<?= $oModel->id ?>"><?= $oModel->model_name ?></option>
                                                        <?php } ?>
														<option value="other">Другое</option>
													</select>
												</div>
												<div class="col-lg-1">
													<ul class="icons-list" style="text-align: right;">
														<li><a class="removeEquipment" data-action="close"></a></li>
													</ul>
												</div>
											</div>
										</div>
										<div class="form-group">
											<div class="row">
												<!-- Images -->
												<div class="col-lg-6">
													<label>Фото паспорта газового оборудования (1-я страница)</label>
                                                    <?php ?>
													<input type="file"
													       placeholder="EquipmentDocImageRef"
													       class="form-control border-teal equipmentDocImageRef">
                                                    <?php ?>
													<input type="hidden"
													       name="order[equipment][1][image_ref]"
													       class="image_ref"
													       value="">
												</div>

												<!-- Ваша модель газового оборудования -->
												<div class="col-lg-6 otherModel" style="display: none;">
													<label>Ваша модель газового оборудования</label>
                                                    <?php ?>
													<input type="text" name="order[equipment][1][other_model]"
													       placeholder="Ваша модель газового оборудования"
													       class="form-control border-teal">
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>

				<!-- добавить оборудование -->
				<div class="row">
					<div class="col-lg-6">
						<div id="AddEquipment" class="col-lg-4 col-md-8 col-sm-12 col-xs-12 btn btn-xs btn-success">
							Добавить оборудование
						</div>
					</div>
				</div>
				<!-- /добавить оборудование -->
			</div>

			<div class="form-group">
				<div class="row">
					<div class="col-lg-6 pt-15">
						<div id="SendForm" class="btn btn-info btn-xs">Отправить</div>
					</div>
				</div>
			</div>

			<div>
				<div class="form-group">
					<div class="row">
					</div>
				</div>
			</div>
		</div>
	</div>
</form>

<div class="row" id="Message" style="display: none;">
	<div class="col-lg-3">
		<div class="panel panel-flat">
			<div class="panel-body">
				<h4>Спасибо, ваша заявка принята.<br> После поступления и обработки заявки на сервере ей будет присвоен
					номер. Уведомление будет отправлено Вам на указанный е-маил в заявлении.</h4>
			</div>
		</div>
	</div>
</div>

<script id="oldTemplate" type="text/template">
	<div class="equipmentModelLine" data-equipment_id="${num}">
		<div class="form-group">
			<div class="row">
				<div class="col-lg-4">
					<label>Вид газового оборудования</label>
                    <?php ?>
					<select class="selectbox equipmentTypes" name="[order][equipment][${num}]equipment_type">
                        <?php foreach ($oTypes as $oType) { ?>
							<option value="<?= $oType->id ?>"><?= $oType->type_name ?></option>
                        <?php } ?>
					</select>
				</div>

				<div class="col-lg-4 eqmod">
					<label>Модель газового оборудования</label>
                    <?php ?>
					<select class="selectbox equipmentModels" name="[order][equipment][${num}]equipment_model">
                        <?php foreach ($oModels as $oModel) { ?>
							<option value="<?= $oModel->id ?>"><?= $oModel->model_name ?></option>
                        <?php } ?>
						<option value="other">Другое</option>
					</select>
				</div>
			</div>
		</div>
		<div class="form-group">
			<div class="row">
				<div class="col-lg-8">
					<label>Ваша модель газового оборудования</label>
                    <?php ?>
					<textarea name="[order][equipment][${num}]equipment_new_model" rows="6" cols="4"
					          class="form-control elastic" placeholder="Ваша модель газового оборудования"></textarea>
				</div>
			</div>
		</div>
		<div class="form-group">
			<div class="row">
				<div class="col-lg-4">
					<label>Images</label>
                    <?php ?>
					<input type="file" name="[order][equipment][${num}]images" placeholder="Images"
					       class="form-control">
				</div>
			</div>

		</div>
	</div>
</script>
<script id="EquipmentLineTemplate" type="text/template">
	<div class="equipmentLine" data-equipment_id="${num}">
		<div class="panel">
			<div class="panel-body">
				<div class="form-group">
					<div class="row">
						<!-- Вид газового оборудования -->
						<div class="col-lg-6">
							<label>Вид газового оборудования</label>
                            <?php ?>
							<select class="selectbox equipmentTypes border-teal"
							        name="order[equipment][${num}][equipment_types_ref]"
							        data-width="100%">
                                <?php foreach ($oTypes as $oType) { ?>
									<option value="<?= $oType->id ?>"><?= $oType->type_name ?></option>
                                <?php } ?>
							</select>
						</div>
						<!-- Модель газового оборудования -->
						<div class="col-lg-5 eqmod">
							<label>Модель газового оборудования</label>
                            <?php ?>
							<select class="selectbox equipmentModels border-teal"
							        name="order[equipment][${num}][equipment_models_ref]"
							        data-width="100%">
                                <?php foreach ($oModels as $oModel) { ?>
									<option value="<?= $oModel->id ?>"><?= $oModel->model_name ?></option>
                                <?php } ?>
								<option value="other">Другое</option>
							</select>
						</div>
						<div class="col-lg-1">
							<ul class="icons-list" style="text-align: right;">
								<li><a class="removeEquipment" data-action="close"></a></li>
							</ul>
						</div>
					</div>
				</div>
				<div class="form-group">
					<div class="row">
						<!-- Images -->
						<div class="col-lg-6">
							<label>Фото паспорта газового оборудования (1-я страница)</label>
                            <?php ?>
							<input type="file"
							       placeholder="EquipmentDocImageRef"
							       class="form-control border-teal equipmentDocImageRef">
                            <?php ?>
							<input type="hidden"
							       name="order[equipment][${num}][image_ref]"
							       class="image_ref"
							       value="">
						</div>
						<!-- Ваша модель газового оборудования -->
						<div class="col-lg-6 otherModel" style="display: none;">
							<label>Ваша модель газового оборудования</label>
                            <?php ?>
							<input type="text" name="order[equipment][${num}][other_model]"
							       placeholder="Ваша модель газового оборудования"
							       class="form-control border-teal">
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</script>

<script>
	//$.serializeJSON.defaultOptions = {parseNumbers: true, parseNulls: true};
	let num = 2;
	let isValid = false;
	//<span class="help-block text-danger">Errosr input helper</span>
	let $span = $('<span>').addClass('help-block text-danger').text('Поле должно быть заполнено.');
	let errors = 0;

	//инициализация select`ов
	if (1) {
		$('.equipmentTypes').selectBoxIt({
			autoWidth: false//,
			//defaultText: "Выберите тип оборудования"
		});

		$('.equipmentModels').selectBoxIt({
			autoWidth: false//,
			//defaultText: "Выберите модель оборудования"
		});

		$('.reason').selectBoxIt({
			autoWidth: false//,
			//defaultText: "Выберите причину обращения"
		});
	}

	function uploadImage($input, $target) {
		//var $input = $("#ProxyImage");
		var fd = new FormData;

		fd.append('0', $input.prop('files')[0]);
		console.log('$input.prop(\'files\')', $input.prop('files'));
		console.log('fd', fd);
		$.ajax({
			url: '/saveImage/',
			data: fd,
			dataType: 'json',
			processData: false,
			contentType: false,
			type: 'POST',
			success: function (responseData) {
				//alert(responseData);
				console.log('responseData', responseData);
				if (responseData.image == 0) {
					$target.val('');
				} else {
					$target.val(responseData.image['id']);
				}
			}
		});
	}

	function validateFields() {
		let fields = $('input');
		$.each(fields, function (index, item) {
			console.log('index', index);
			console.log('item', $(item).val());
			console.log($(item).prop('type'));
			console.log($(item).prop('class'));
			if ($(item).hasClass('require')) {
				console.log('ТРЕБУЕТСЯ');
				if ($(item).val().trim()) {

				}
			}
			console.log('');
		});

		return false;
	}

	function validateInput($this) {
		let name = $this.prop('name');
		console.log('name', name);
		if ($this.hasClass('require')) {
			console.log('ТРЕБУЕТСЯ');
			if ($this.val() == '') {
				return false;
			}
		}

		return true;
	}

	function errorHide($this) {
		//спрятать блок с ошибкой
		$this.removeClass('border-danger').addClass('border-teal');
		$this.siblings('.help-block').hide();
	}

	function errorShow($this) {
		//показать блок с ошибкой
		$this.removeClass('border-teal').addClass('border-danger');
		$this.siblings('.help-block').show();
	}

	$(document).ready(function () {
		let url = '';
		if (1) {
			//добавить еще одно оборудование
			$('#AddEquipment').on('click', function (e) {
				e.preventDefault();
				// add new equipment line

				let $Template = $('#EquipmentLineTemplate').tmpl({'num': num});
				console.log('$Template', $Template);
				$Template.find('.selectbox').selectBoxIt({autoWidth: false});

				$('#EquipmentLines').append($Template);

				/*
                $selectModels.selectBoxIt({autoWidth: false});
                */
				num++;
			});

			//собираем полный адрес из частей
			$('.toAddress').on('change keyup', function () {
				let text = [], fullAddress;
				let $toAddress = $('.toAddress');
				//собираем все части
				$.each($toAddress, function (key, item) {
					//console.log('key, item', key, item);
					let val = $(item).val();
					if (val !== '') {
						text.push($(item).val());
					}
				});
				//склеиваем части через запятую в полный адрес
				fullAddress = text.join(', ');
				$('.fullAddress').val(fullAddress);
			});

			//загрузка фоток
			if (1) {
				//загрузка фото доверенности
				$('#ProxyImageRef').on('change keyup', function () {
					console.log('#ProxyImageRef + change keyup');
					uploadImage($("#ProxyImageRef"), $(".proxyImageRef"));
				});

			}
		}

		//отправка данных формы на сохранение
		$('#SendForm').on('click', function () {
			console.log('#SendForm click');

			let errorsCount = 0; //количество ошибок

			//получить все поля input.require;
			//проверить каждое на пустоту и если есть ошибка, то количество ошибок увеличить на 1
			let requires = $('.require');
			$.each(requires, function (index, item) {
				console.log('index', index);
				console.log('item', $(item).val().trim());
				console.log($(item).prop('type'));
				console.log($(item).prop('class'));
				if ($(item).hasClass('require') || 0) {
					console.log('ТРЕБУЕТСЯ');
					if ($(item).val().trim().length == 0) {
						errorsCount++;
						errorShow($(item));
					}
				}
				console.log('errorsCount', errorsCount);
			});

			//если количество ошибок = 0, то отправить данные на сохранение
			if (1) {
				if (validateFields()) {
					//isValid = true;
				}

				if (errorsCount == 0) {
					let form = $('body').find('#OrderForm').serializeJSON();
					$.ajax({
						url: '/saveOrder/',
						data: form,
						dataType: 'json',
						type: 'post',
						success: function (responseData) {
							console.log('responseData', responseData);
							//вывести сообщение об успехе/ошибке
							if (!responseData.success) {
								//подсветить поля, которые заполнены неверно, либо не заполнены
							}
							if (responseData.success) {
								$('form').hide();
								$('#Message').show();
							}
							//спрятать форму
						},
						error: function (xhr) {
							alert('ERROR: ' + xhr.responseText);
							console.log('ERRROR', xhr);
						}
					});
				}
			}
		});

		//подгрузка моделей в соответствии с выбранным видом оборудования

		//проверить, выбран ли пункт Другое
		$('body')
		//изменение вида оборудования
			.on('change keyup', '.equipmentTypes', function () {
				console.log('.equipmentTypes + change keyup');
				url = '<?php echo \yii\helpers\Url::to(['/product/default/get-models-of-type']); ?>';
				let $selectTypes = $(this);
				let $equipmentLine = $(this).closest('.equipmentLine');
				let equipmentTypeId = $selectTypes.val();
				let $selectModels = $equipmentLine.find('.equipmentModels');

				if (1) {
					$.ajax({
						url: url,
						data: {
							'typeId': equipmentTypeId
						},
						dataType: 'json',
						type: 'post',
						//traditional: true,
						success: function (responseText) {
							console.log('responseText', responseText);

							$equipmentLine.find('.equipmentModels').remove();
							let equipment_id = $equipmentLine.data('equipment_id');

							$selectModels = $('<select>').attr({
								'class': 'selectbox equipmentModels border-teal',
								'name': 'order[equipment][' + equipment_id + '][equipment_models_ref]'
							});

							$.each(responseText.models, function (key, item) {
								//console.log('key, item', key, item);
								$selectModels.append('<option value="' + item.id + '">' + item.model_name + '</option>');
							});
							$selectModels.append('<option value="other">Другое</option>');
							$selectModels.show();
							$equipmentLine.find('.eqmod').append($selectModels);
							$selectModels.selectBoxIt({autoWidth: false});
							if (responseText.models.length == 0) {
								console.log('MODELS IS EMPTY');
								$equipmentLine.find('.otherModel').show();
							} else {
								$equipmentLine.find('.otherModel').hide();
							}
						},
						error: function (xhr) {
							alert('ERROR: ' + xhr.responseText);
							console.log('ERRROR', xhr);
						}
					});
				}
			})

			//изменение модели оборудования
			.on('change keyup', '.equipmentModels', function () {
				console.log('.equipmentModels + change keyup');
				let r = $(this).val();
				let $equipmentLine = $(this).closest('.equipmentLine');
				console.log('r', r);
				if (r == 'other') {
					$equipmentLine.find('.otherModel').show();
				} else {
					$equipmentLine.find('.otherModel').hide();
				}
			})

			//загрузка фото документа оборудования
			.on('change keyup', '.equipmentDocImageRef', function () {
				console.log('.equipmentDocImageRef + change keyup');
				let $equipmentLine = $(this).closest('.equipmentLine');
				let $source = $equipmentLine.find('.equipmentDocImageRef');
				let $dest = $equipmentLine.find('.image_ref');
				uploadImage($source, $dest);
			})

			//удаление оборудования
			.on('click', '.removeEquipment', function () {
				$(this).closest('.equipmentLine').remove();
			})

			//проверка на требование заполненности поля
			.on('focusout', '.require', function () {
				//Проверить поле на пустоту
				//let $span = $('<span>').addClass('help-block text-danger').text('Поле должно быть заполнено.');

				//спрятать блок с ошибкой
				errorHide($(this));

				//проверить поле на валидность
				let isValid = validateInput($(this));
				if (isValid) {
					console.log('isValid is true');
					if (0) {
						//спрятать блок с ошибкой
						errorHide($(this));
					}
				} else {
					console.log('isValid is false');
					//показать блок с ошибкой
					errorShow($(this));
				}
			})
		;

		$('#ReasonRef').on('change', function () {
			let r = $(this).val();
			console.log('r', r);
			if (r == 'other') {
				$('#ReasonOther').show();
			} else {
				$('#ReasonOther').hide();
			}
		});

		$('#IsDeclarantOwner').on('click', function () {
			let isDeclarantOwner = $(this).prop('checked');
			if (!isDeclarantOwner) {
				$('#AgentPanel').show();
			} else {
				$('#AgentPanel').hide();
			}
		});

		$('#IsAddEquipment').on('click', function () {
			let isAddEquipment = $(this).prop('checked');
			if (isAddEquipment) {
				$('#SettedEquipment').show();
			} else {
				$('#SettedEquipment').hide();
			}
		});

		$('Xinput:file').change(function (e) {

			//handleFileSelect(e);

			//let file = $('#ProxyImage')[0].files[0];


			if (0) {
				//console.log('file', file);
				let is_valid = validFileType(file);
				//console.log('validFileType(file)', validFileType(file));
				if (is_valid) {
					$('#ProxyImage').html(null);
				}
				//console.log('validFileType(file)', validFileType(file));

			}

			if (0) {
				if (file) {
					$('.noFoto').hide();
					$('.uploadFoto').text(file.name);
					$('.uploadFoto').show();
					console.log(file.name);
				}
			}
		});

		function handleFileSelect(evt) {
			let file = evt.target.files; // FileList object
			let f = file[0];
			// Only process image files.
			if (!f.type.match('image.*')) {
				//alert("Image only please....");
			} else {
				let reader = new FileReader();
				// Closure to capture the file information.
				reader.onload = (function (theFile) {
					return function (e) {
						// Render thumbnail.
						let span = document.createElement('span');
						span.innerHTML = ['<img class="thumbnail" title="', escape(theFile.name), '" src="', e.target.result, '" />'].join('');
						$('#output').html('');
						$('#output').append(span);
						//document.getElementById('output').insertBefore(span, null);
					};
				})(f);
				// Read in the image file as a data URL.
				reader.readAsDataURL(f);
			}
		}

		function validFileType(file) {
			let fileTypes = [
				'image/jpg',
				'image/jpeg',
				'image/pjpeg',
				'image/png'
			];

			for (let i = 0; i < fileTypes.length; i++) {
				if (file.type === fileTypes[i]) {
					console.log('file.type', file.type);
					return true;
				}
			}

			return false;
		}

		if (1) {
			//$('#ReasonId').select2();
			//$('.select-search').select2();
		}

		function getModels(type_id) {
			//GetModelsOfType
			//$('.select2').select2();
		}
	});

</script>