<?php
/*/
$this->pageTitle = 'Номенклатуры - распределение';

$cs = Yii::app()->clientScript;
$themePath = Yii::app()->theme->baseUrl;
$cs->registerCssFile($themePath . '/vendor/plugins/fancytree/skin-win8/ui.fancytree.min.css');
$cs->registerScriptFile($themePath . '/vendor/plugins/fancytree/jquery.fancytree-all.min.js', CClientScript::POS_END);
$cs->registerScriptFile($themePath . '/vendor/plugins/fancytree/extensions/jquery.fancytree.childcounter.js', CClientScript::POS_END);
$cs->registerScriptFile($themePath . '/vendor/plugins/fancytree/extensions/jquery.fancytree.columnview.js', CClientScript::POS_END);
$cs->registerScriptFile($themePath . '/vendor/plugins/fancytree/extensions/jquery.fancytree.dnd.js', CClientScript::POS_END);
$cs->registerScriptFile($themePath . '/vendor/plugins/fancytree/extensions/jquery.fancytree.edit.js', CClientScript::POS_END);
$cs->registerScriptFile($themePath . '/vendor/plugins/fancytree/extensions/jquery.fancytree.filter.js', CClientScript::POS_END);

$cs->registerCssFile($themePath . '/vendor/plugins/jqueryContextMenu/dist/jquery.contextMenu.css');
$cs->registerScriptFile($themePath . '/vendor/plugins/jqueryContextMenu/dist/jquery.contextMenu.js');
$cs->registerScriptFile($themePath . '/vendor/plugins/jqueryContextMenu/dist/jquery.ui.position.min.js');
//*/

?>
<div class="row">
	<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
		<div class="panel panel-flat">
			<div class="panel-heading">
				<h5 class="panel-title">Каталог товаров <i class="fancytree-title icon-loop3 position-right" id="reload"
				                                           style="font-size: 0.9em;"></i>
				</h5>
			</div>
			<div class="panel-body">
				<div class="row CopyPaste">
					<div class="col-xs-4 col-sm-4 col-md-4 col-lg-4"
					     style="border-right: 1px solid #dadada; max-height: 690px; overflow-y: scroll;">
						<div class="chart-legend">
							<div id="viewtree" class=""></div>
						</div>
					</div>
					<div class="col-xs-8 col-sm-8 col-md-8 col-lg-8" id="products">
						<div class="row">
							<div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
								<div class="form-group">
									<div class="input-group">
										<input type="text" class="form-control SearchString" data-key="client"
										       placeholder="Введите фрагмент текста для поиска..."> <span
												class="input-group-btn">
											<button
													class="btn btn-default ClearSearchString"><i
														class="icon-cross2"></i></button>
										</span>
									</div>
								</div>
							</div>
							<div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 showAllBlock">
								<div class="form-group">
									<div class="checkbox">
										<label> <input type="checkbox" name="showAll" value="1"
										               style="width: 15px; height: 15px;" class="ShowAll"> Показать все
										</label>
									</div>
								</div>
							</div>
						</div>
						<div class="table-responsive table-xxs" style="position: relative; min-height: 100%;">
							<table class="table micro marking noms" id="NomenclaturesList">
								<thead>
								<tr>
									<th>Наименование товара</th>
									<th>Артикул</th>
									<th>Количество</th>
									<th>Цена</th>
								</tr>
								</thead>

								<tbody>
								</tbody>
							</table>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

<script type="text/template" id="NomTmpl">
	<tr class="" data-id="${id}" data-ecm_products_ref="${ecm_products_ref}">
		<td>${ecm_product['product_name']}</td>
		<td>${vendor['field_value']}</td>
		<td>${store}</td>
		<td>${price}</td>
		<td><span class="btn label bg-orange-300 label-warning removeBtn">Убрать</span></td>
	</tr>
</script>

<script>
	var categoryId = 7185;
	var nomenclatureId = false, nomenclatureIds = [];
	var mode = 'view'; //[view || move]
	var isShowAll = null;
	var ClipBoard = {type: false, srcCategoryId: null, dstCategoryId: null, ids: [], copyIds: [], cutIds: []}; //type="noms"
	var Current = {type: false, id: false}; // type="noms", id = false
	var isCtrl = false;
	var _COPY = 1, _PASTE = 2, _CUT = 3, _REMOVE = 4;
	var SearchString = '', oldSearchString = '';
	var tm = null;

	$(document).ready(function () {

		$('#reload').on('click', function (e) {
			if (e !== undefined) e.preventDefault();
			$('#NomenclaturesList tbody').empty();
			loadTree();
		});

		function loadTree() {
			$("#viewtree").fancytree({
				clickFolderMode: 1,
				extensions: ["dnd", "filter", "edit", "childcounter"],
				filter: {
					autoApply: true, // Re-apply last filter if lazy data is loaded
					counter: true, // Show a badge with number of matching child nodes near parent icons
					hideExpandedCounter: true, // Hide counter badge, when parent is expanded
					mode: "hide"  // "dimm": Grayout unmatched nodes, "hide": remove unmatched nodes
				},
				// titlesTabbable: true,
				source: {
					url: '<?php echo \yii\helpers\Url::to(['/cms/tree/gw-data-tree']); ?>'
					//url: '<?php echo \yii\helpers\Url::to(['/cms/tree/lazy-data-tree']); ?>'
				},
				/*/
                lazyLoad: function (event, data) {
                    var node = data.node;
                    // Load child nodes via Ajax GET /getTreeData?mode=children&parent=1234
                    data.result = {
                        url: '< ?php echo Yii::app()->createUrl('/cms/tree/lazyDataTree', ['id' => '__id__']); ?>'.replace('__id__', node.key),
                        data: {mode: "children", parent: node.key},
                        cache: false
                    };
                },
                //*/
				childcounter: {
					deep: true,
					hideZeros: true,
					hideExpanded: true
				},
				dnd: {
					//autoExpandMS: 400,
					autoScroll: false,
					//focusOnClick: true,
					preventVoidMoves: true, // Prevent dropping nodes 'before self', etc.
					preventRecursiveMoves: true, // Prevent dropping nodes on own descendants
					dragStart: function (node, data) {
						/** This function MUST be defined to enable dragging for the tree.
						 *  Return false to cancel dragging of node.
						 */
						return true;
					},
					dragEnter: function (node, data) {
						/** data.otherNode may be null for non-fancytree droppables.
						 *  Return false to disallow dropping on node. In this case
						 *  dragOver and dragLeave are not called.
						 *  Return 'over', 'before, or 'after' to force a hitMode.
						 *  Return ['before', 'after'] to restrict available hitModes.
						 *  Any other return value will calc the hitMode from the cursor position.
						 */
						return true;
					},
					dragDrop: function (node, data) {
						/** This function MUST be defined to enable dropping of items on
						 *  the tree.
						 */
						$.ajax({
							type: 'post',
							url: '<?php echo \yii\helpers\Url::to(['/cms/tree/move-node']); ?>',
							data: {
								'move': JSON.stringify(data.otherNode.toDict()),
								'to': JSON.stringify(node.toDict()),
								'hit': data.hitMode
							},
							traditional: true,
							success: function (responseText) {
								//alert(responseText);
								data.otherNode.moveTo(node, data.hitMode);
							},
							error: function (xhr) {
								alert('ERROR: ' + xhr.responseText);
							}
						});
						console.log('dragDrop');

						console.log('data.otherNode.toDict()', data.otherNode.toDict());
						console.log('node.toDict()', node.toDict());
						console.log('data.hitMode', data.hitMode);
					}
				},
				activate: function (event, data) {
					console.log('[activate]', event, data);
					nomenclatureId = false;
					clearNomenclatures();
				},
				click: function (event, data) {
					console.log('click');
					Current.type = false;
					Current.id = false;
					nomenclatureId = false;
					if (!data.node.lazy) { // (!data.node.children) {
						categoryId = data.node.key;
						Current.type = 'node';
						Current.id = Number(categoryId);
						loadNomenclatures();
						getAll();
						console.log('Current', Current);
					}
					if (data.node.key == 7185) {
						$('.showAllBlock').show();
					} else {
						$('.showAllBlock').hide();
					}
				},
				dblclick: function (event, data) {
					//console.log('dblclick');
					window.open(
						'<?= \yii\helpers\Url::to(['/cms/tree/edit-node', 'id' => '__id__', 'is_tab' => 1]); ?>'
							.replace('__id__', data.node.key), //&theme=admin
						'_blank'
					);
					window.focus();
					return true;
					/*
                     $.magnificPopup.open({
                     type: 'ajax',
                     items: {
                     src: '< ?= $this->createUrl('editNode', array('id' => '__id__')); ?>'.replace('__id__', data.node.key)
                     },
                     modal: true
                     });
                     */
				}
			});
		}

		loadTree();

		$('body')
		//обработка нажатия клавиш на клаве или мыши
			.on('keydown', function (e) {
				//console.log('body>keyup');
				if (e.which == 17) {
					console.log('Crtl was true');
					isCtrl = true;
				}
				doEvent(e);
			})
			.on('keyup', function (e) {
				if (e.which == 17) {
					console.log('Crtl was false');
					isCtrl = false;
				}
			})
			.on('change keyup', '.SearchString', function () {
				console.log('изменили строку поиска');
				//если новая строка отличается от старой, то заменить старую на новую и отправить данные на выборку
				SearchString = $('.SearchString').val();
				console.log('SearchString', SearchString);
				clearInterval(tm);
				tm = setInterval(function () {
					if (SearchString !== oldSearchString) {
						oldSearchString = SearchString;
						loadNomenclatures();
					}
				}, 700);
			})
			.on('change keyup', '.ShowAll', function () {
				console.log('изменили галочку showAll');
				clearInterval(tm);
				oldSearchString = SearchString;
				loadNomenclatures();
			})
			.on('click', '.ClearSearchString', function (e) {
				e.preventDefault();
				$('.SearchString').val('');
				$('.SearchString').trigger('change');
			})
		;

		//выделение строки в nomenclatures
		$('#NomenclaturesList')
			.on('click', 'tbody tr', function (e) {
				if (e !== undefined) e.preventDefault();
				console.log('#NomenclaturesList click tbody tr');
				var id = $(this).data('id');
				Current = {
					type: 'noms',
					id: id
				};

				//выделить/снять выделение с текущего элемента
				$(this).toggleClass('activeTr');
				getAll();
			})
			.on('dblclick', 'tbody tr', function () {
				nomenclatureId = $(this).data('ecm_products_ref');
				window.open(
					'<?= \yii\helpers\Url::to(['/cms/product/edit', 'id' => '__id__', 'is_tab' => 1]); ?>'
						.replace('__id__', nomenclatureId), // + '&is_tab=1', //&theme=admin
					'_blank'
				);
				window.focus();
			})
			.on('click', '.removeBtn', function (e) {
				if (e !== undefined) e.preventDefault();
				console.log('#NomenclaturesList click tbody tr');

				var id = $(this).closest('tr').data('id');
				$('body').find('tr').removeClass('currentTr');
				$(this).addClass('currentTr');
				//запомнить текущее
				Current = {
					type: 'noms',
					id: id
				};
				//дать команду на действие
				copyPaste(_REMOVE);
				console.log('[CURRENT]', Current);
			})
		;

		function getNoms() {
			console.log('getNoms()');
			//пройти по номенклатурам
			nomenclatureIds = [];
			$('#NomenclaturesList tbody tr.activeTr').each(function (index, item) {
				var id = $(item).data('id');
				nomenclatureIds.push(Number(id));
			});
			console.log('nomenclatureIds', nomenclatureIds);
		}

		function getAll() {
			getNoms();
			//getCurrent();
		}

		function getCurrent() {
			console.log('getCurrent()');
			Current.type = false;
			Current.id = false;
			//найти текущий
			self = $('tbody tr.currentTr');
			Current.id = self.data('id');
			var parent = self.closest('table');
			if (parent.hasClass('noms')) {
				console.log("hasClass('noms')");
				Current.type = 'noms';
			} else if (categoryId > 0) {
				console.log("NODE");
				Current.type = 'node';
				Current.id = categoryId;
			}
			console.log('Current', Current);
		}

		function doEvent(event, panel) {
			console.log('doEvent(event, panel)');

			if (isCtrl) {
				switch (event.which) {
					// Handle Ctrl-C, -X and -V
					case 67:
						// Ctrl-C
						console.log('CASE 67!!!');
						copyPaste(_COPY);
						break;
					case 86:
						// Ctrl-V
						console.log('CASE 86!!!');
						copyPaste(_PASTE);
						break;
					case 88:
						// Ctrl-X
						console.log('CASE 88!!!');
						copyPaste(_CUT);
						break;
				}
			}
		}

		function copyPaste(CP) {
			console.log('ClipBoard', ClipBoard);
			console.log('Current', Current);
			if (CP == _COPY) {
				console.log('_COPY');
				ClipBoard.srcCategoryId = Number(categoryId);
				if (nomenclatureIds.length > 0) {
					ClipBoard.type = 'noms';
					//ClipBoard.ids = nomenclatureIds;
					ClipBoard.copyIds = nomenclatureIds;
					ClipBoard.cutIds = [];
				} else {
					ClipBoard.type = Current.type;
					//ClipBoard.ids = [Current.id];
					ClipBoard.copyIds = [Current.id];
					ClipBoard.cutIds = [];
				}
				console.log('>>> ClipBoard', ClipBoard)
			}
			if (CP == _CUT) {
				console.log('_CUT');
				ClipBoard.srcCategoryId = Number(categoryId);
				if (nomenclatureIds.length > 0) {
					ClipBoard.type = 'noms';
					//ClipBoard.ids = nomenclatureIds;
					ClipBoard.copyIds = [];
					ClipBoard.cutIds = nomenclatureIds;
				} else {
					ClipBoard.type = Current.type;
					//ClipBoard.ids = [Current.id];
					ClipBoard.copyIds = [];
					ClipBoard.cutIds = [Current.id];
				}
				console.log('ClipBoard', ClipBoard)
			}
			if (CP == _PASTE) {
				console.log('_PASTE');
				ClipBoard.dstCategoryId = Number(categoryId);
				if (ClipBoard.type == 'noms') {

					//переместить номенклатуры в ноду
					console.log('переместить номенклатуры в ноду');
					console.log('[ClipBoard]', ClipBoard);
					console.log('[Current]', Current);

					if (ClipBoard.copyIds.length > 0) copyNoms();
					else if (ClipBoard.cutIds.length > 0) moveNoms();
					/*
                     if (Current.type == 'node') {
                     console.log('Current', Current);
                     if (ClipBoard.cutIds.length > 0)
                     moveNoms();
                     else if (ClipBoard.copyIds.length > 0)
                     copyNoms();
                     }
                     */
				}
			}
			if (CP == _REMOVE) {
				console.log('_REMOVE');
				//Убрать связку номенклатуры и категории
				console.log('Убрать связку номенклатуры и категории');
				console.log('[ClipBoard]', ClipBoard);
				console.log('[Current]', Current);
				ClipBoard.type = 'noms';
				ClipBoard.srcCategoryId = Number(categoryId);
				if (nomenclatureIds.length > 0)
					ClipBoard.ids = nomenclatureIds;
				else
					ClipBoard.ids = [Current.id];
				//Дать команду на действие
				removeNoms();
				console.log('ClipBoard', ClipBoard);
			}
		}

		//меню для узлов дерева
		$.contextMenu({
			selector: '#viewtree .fancytree-node',
			events: {
				show: function (options) {
					console.log('show');
					$(this).trigger('click');
				},
				hide: function (options) {
					console.log('hide');
				}
			},
			callback: function (key, options) {
				//$(this).find('tbody').find('tr').removeClass('currentTr');
				//var m = "clicked: " + key;
				//window.console && console.log(m) || alert(m);
				console.log('callback!');
			},
			items: {
				"openInNewFront": {
					name: "Просмотр на фронте",
					callback: function (itemKey, opt, rootMenu, originalEvent) {
						$(this).trigger('click');
						console.log('[openInNewFront THIS]', this);
						var alias = $(this).data('alias');
						var url = 'http://front.hynt.ru/product/' + alias
						window.open(url);
					}
				},
				"EditNomenclature": {
					name: "Редактировать",
					callback: function (itemKey, opt, rootMenu, originalEvent) {
						/*
                         window.open(
                         '< ?= $this->createUrl('/cms/product/edit', array('id' => '__ID__')); ?>'
                         .replace('__ID__', $(this).data('id')) + '?is_tab=1&theme=admin',
                         '_blank'
                         );
                         window.focus();
                         */
						window.open(
							'<?= \yii\helpers\Url::to(['/cms/tree/edit-node', 'id' => '__id__', 'is_tab' => 1]); ?>'
								.replace('__id__', Current.id), // + '?is_tab=1', //&theme=admin
							'_blank'
						);
						window.focus();
					}
				},
				"Paste": {
					name: "(Ctrl+V) Вставить",
					disabled: function (key, opt) {
						if (ClipBoard.copyIds.length > 0 || ClipBoard.cutIds.length > 0)
							return false;
						else
							return true;
					},
					callback: function (itemKey, opt, rootMenu, originalEvent) {
						//вызвать скрипт перемещения номенклатуры в категорию
						console.log('[ClipBoard]', ClipBoard);
						console.log('[Current]', Current);
						copyPaste(_PASTE);
						//if (ClipBoard.copyIds.length > 0) copyNoms();
						//else if (ClipBoard.cutIds.length > 0) moveNoms();
					}
				},
				"ShowInGoogle": {
					name: "Показать в Google.Покупках",
					callback: function (itemKey, opt, rootMenu, originalEvent) {
						//вызвать скрипт перемещения номенклатуры в категорию
						console.log('Current.id', Current.id);
						googleOnOff(Current.id, 1);
					}
				},
				"HideInGoogle": {
					name: "Убрать из Google.Покупок",
					callback: function (itemKey, opt, rootMenu, originalEvent) {
						//вызвать скрипт перемещения номенклатуры в категорию
						console.log('Current.id', Current.id);
						googleOnOff(Current.id, 0);
					}
				}
			}
		});

		//меню для номенклатур
		$.contextMenu({
			selector: '#NomenclaturesList tbody tr',
			events: {
				show: function (options) {
					console.log('[#NomenclaturesList tbody tr contextMenu show]');
					var id = $(this).data('id');
					Current = {
						type: 'noms',
						id: id
					};
					console.log('[CURRENT]', Current);
				},
				hide: function (options) {
					console.log('[#NomenclaturesList tbody tr contextMenu hide]');
					//$(this).removeClass('currentTr');
				}
			},
			callback: function (key, options) {
				//$(this).find('tbody').find('tr').removeClass('currentTr');
				//var m = "clicked: " + key;
				//window.console && console.log(m) || alert(m);
				console.log('callback!');
			},
			items: {
				"copy": {
					name: "(Ctrl+C) Копировать",
					callback: function (itemKey, opt, rootMenu, originalEvent) {
						var id = $(this).closest('tr').data('id');
						$('body').find('tr').removeClass('currentTr');
						$(this).addClass('currentTr');
						Current = {
							type: 'noms',
							id: id
						};
						copyPaste(_COPY);
						console.log('[CURRENT]', Current);
					}
				},
				"cut": {
					name: "(Ctrl+X) Вырезать",
					callback: function (itemKey, opt, rootMenu, originalEvent) {
						var id = $(this).closest('tr').data('id');
						$('body').find('tr').removeClass('currentTr');
						$(this).addClass('currentTr');
						Current = {
							type: 'noms',
							id: id
						};
						copyPaste(_COPY);
						console.log('[CURRENT]', Current);
					}
				},
				/*
                 "paste": {
                 name: "Вставить",
                 callback: function (itemKey, opt, rootMenu, originalEvent) {
                 copyPaste(_PASTE);
                 }
                 },
                 */
				"remove": {
					name: "Убрать",
					callback: function (itemKey, opt, rootMenu, originalEvent) {
						var id = $(this).closest('tr').data('id');
						$('body').find('tr').removeClass('currentTr');
						$(this).addClass('currentTr');
						//запомнить текущее
						Current = {
							type: 'noms',
							id: id
						};
						//дать команду на действие
						copyPaste(_REMOVE);
						console.log('[CURRENT]', Current);
					}
				},
				/*/
                 "openInNewFront": {
                 name: "Просмотр на фронте",
                 callback: function (itemKey, opt, rootMenu, originalEvent) {
                 console.log('[openInNewFront THIS]', this);
                 var alias = $(this).data('alias');
                 var url = 'http://hynt.ru/product/' + alias
                 window.open(url);
                 }
                 },
                 //*/
				"EditNomenclature": {
					name: "Редактировать",
					callback: function (itemKey, opt, rootMenu, originalEvent) {
						window.open(
							'<?= \yii\helpers\Url::to(['/cms/product/edit', 'id' => '__ID__', 'is_tab' => 1]); ?>'
								.replace('__ID__', $(this).data('ecm_products_ref')), // + '?is_tab=1', //&theme=admin
							'_blank'
						);
						window.focus();
					}
				},
				"selectAll": {
					name: "Выделить все",
					callback: function (itemKey, opt, rootMenu, originalEvent) {
						//снять выделение везде
						$('tr.activeTr').removeClass('activeTr');
						//добавить выделение всех
						$(this).closest('tbody').find('tr').addClass('activeTr');
						getAll();
					}
				},
				"deselectAll": {
					name: "Снять выделение со всех",
					callback: function (itemKey, opt, rootMenu, originalEvent) {
						$(this).closest('tbody').find('tr').removeClass('activeTr');
						getAll();
					}
				}
			}
		});

		//КОПИРОВАНИЕ товаров
		function copyNoms() {
			//Копировать
			console.log('[copyNoms()]');
			console.log('>Current', Current);
			console.log('>ClipBoard', ClipBoard);
			var Error = false;
			if (Current.type != 'node') {
				alert('Не выбрана конечная номенклатура!');
				Error = true;
			}
			if (ClipBoard.type != 'noms') {
				alert('Не выбраны товары! (!noms)');
				Error = true;
			}
			if (ClipBoard.copyIds.length == 0) {
				alert('Не выбраны товары! (length = 0)');
				Error = true;
			}
			console.log('[COPY NOMS!!!]');
			if (!Error) {
				var dataForm = {
					//nomenclatureIds: ClipBoard.ids,
					nomenclatureIds: ClipBoard.copyIds,
					categoryId: Current.id,
					srcCategoryId: ClipBoard.srcCategoryId,
					dstCategoryId: ClipBoard.dstCategoryId
				};
				$.ajax({
					type: 'POST',
					dataType: 'json',
					url: '<?php echo \yii\helpers\Url::to(['/cms/default/move-noms']); ?>',
					data: dataForm,
					success: function (response) {
						console.log('[RESPONSE]', response);
						if (response.success) {
							nomenclatureIds.forEach(function (item, index) {
								$('#NomenclaturesList tbody').html('');
							});
							clearNomenclatures();
							loadNomenclatures();
							//ClipBoard.type = false;
							//ClipBoard.ids = false;
							//Current.type = false;
							//Current.id = false;
						} else {

						}
					},
					error: function (xhr) {
						alert('ERROR: ' + xhr.responseText);
					}
				});
			}
		}

		//ПЕРЕНОС товаров
		function moveNoms() {
			var Error = false;
			if (Current.type != 'node') {
				alert('Не выбрана конечная номенклатура!');
				Error = true;
			}
			if (ClipBoard.type != 'noms') {
				alert('Не выбраны товары! (!noms)');
				Error = true;
			}
			if (ClipBoard.cutIds.length == 0) {
				alert('Не выбраны товары! (length = 0)');
				Error = true;
			}
			console.log('[MOVE NOMS!!!]');
			console.log('Error', Error);
			if (!Error) {
				var dataForm = {
					nomenclatureIds: ClipBoard.cutIds,
					categoryId: Current.id,
					srcCategoryId: ClipBoard.srcCategoryId,
					dstCategoryId: ClipBoard.dstCategoryId
				};
				var url = '<?php echo \yii\helpers\Url::to(['/cms/default/move-noms']); ?>';
				$.ajax({
					type: 'POST',
					dataType: 'json',
					url: url,
					data: dataForm,
					success: function (response) {
						console.log('[RESPONSE]', response);
						if (response.success) {
							nomenclatureIds.forEach(function (item, index) {
								$('#NomenclaturesList tbody').html('');
							});
							clearNomenclatures();
							loadNomenclatures();
							//после переноса забыть то, что перенесли
							ClipBoard.type = false;
							ClipBoard.cutIds = false;
							Current.type = false;
							Current.id = false;
						} else {

						}
					},
					error: function (xhr) {
						alert('ERROR: ' + xhr.responseText);
					}
				});
			}
		}

		//УДАЛЕННИЕ СВЯЗКИ товаров
		function removeNoms() {
			var Error = false;
			if (ClipBoard.type != 'noms') {
				alert('Не выбраны товары! (!noms)');
				Error = true;
			}
			if (ClipBoard.ids.length == 0) {
				alert('Не выбраны номенклатуры для удаления! (length = 0)');
				Error = true;
			}
			console.log('[REMOVE NOMS!!!]');
			if (!Error) {
				var dataForm = {
					nomenclatureIds: ClipBoard.ids,
					categoryId: categoryId
				};
				$.ajax({
					type: 'POST',
					dataType: 'json',
					url: '<?php echo \yii\helpers\Url::to(['/cms/default/unbind-noms']); ?>',
					data: dataForm,
					success: function (response) {
						console.log('[RESPONSE]', response);
						if (response.success) {
							nomenclatureIds.forEach(function (item, index) {
								$('#NomenclaturesList tbody').html('');
							});
							clearNomenclatures();
							loadNomenclatures();
							//после убирания забыть то, что убрали
							ClipBoard.type = false;
							ClipBoard.ids = false;
							Current.type = false;
							Current.id = false;
							//pnotify('success', 'Success', 'Успешно убрали', 3000);
						} else {
						}
					},
					error: function (xhr) {
						alert('ERROR: ' + xhr.responseText);
					}
				});
			}
		}

		//отвязка товаров от категории
		function unbindNoms() {
			var Error = false;
			if (ClipBoard.type != 'noms') {
				alert('Не выбраны товары! (!noms)');
				Error = true;
			}
			if (ClipBoard.ids.length == 0) {
				alert('Не выбраны номенклатуры для удаления! (length = 0)');
				Error = true;
			}
			console.log('[UNBIND NOMS!!!]');
			if (!Error) {
				var dataForm = {
					nomenclatureIds: ClipBoard.ids,
					categoryId: categoryId
				};
				$.ajax({
					type: 'POST',
					dataType: 'json',
					url: '<?php echo \yii\helpers\Url::to(['/cms/default/unbind-noms']); ?>',
					data: dataForm,
					success: function (response) {
						console.log('[RESPONSE]', response);
						if (response.success) {
							nomenclatureIds.forEach(function (item, index) {
								$('#NomenclaturesList tbody').html('');
							});
							clearNomenclatures();
							loadNomenclatures();
							//после убирания забыть то, что убрали
							ClipBoard.type = false;
							ClipBoard.ids = false;
							Current.type = false;
							Current.id = false;
							//pnotify('success', 'Success', 'Успешно убрали', 3000);
						} else {
						}
					},
					error: function (xhr) {
						alert('ERROR: ' + xhr.responseText);
					}
				});
			}
		}

		function loadNomenclatures() {
			clearNomenclatures();

			$.ajax({
				type: 'POST',
				dataType: 'json',
				url: '<?php echo \yii\helpers\Url::to(['/cms/default/get-ecm-products', 'id' => '__category_id__']); ?>'.replace('__category_id__', categoryId),
				data: {
					SearchString: oldSearchString,
					category_id: categoryId,
					isShowAll: $(".ShowAll").prop("checked") ? 1 : 0
				},
				success: function (response) {
					console.log('[RESPONSE]', response);
					if (response.success) {
						clearNomenclatures();
						var $Template = $('#NomTmpl').tmpl(response.response_data);
						$('#NomenclaturesList tbody').append($Template);
					} else {

					}
				},
				error: function (xhr) {
					alert('ERROR: ' + xhr.responseText);
				}
			});
		}

		function clearNomenclatures() {
			$('#NomenclaturesList tbody').html('');
		}

		function googleOnOff(id, opt) {
			$.ajax({
				type: 'post',
				dataType: 'json',
				url: '<?php echo \yii\helpers\Url::to(['/cms/default/google-on-off', 'id' => '__ID__', 'opt' => '__OPT__']); ?>'
					.replace('__ID__', id)
					.replace('__OPT__', opt),
				success: function (response) {
					if (response.success) {
						pnotify('success', 'Success', 'Успешно', 3000);
					}
				},
				error: function (xhr) {
					alert('ERROR: ' + xhr.responseText);
				}
			});
		}

		//инициировать дерево
		var tree = $("#viewtree").fancytree("getTree");
		tree.visit(function (node) {
			node.setExpanded(false);
		});

		$('#viewtree .fancytree-node');//.on('');
	});

</script>