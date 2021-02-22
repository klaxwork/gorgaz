<?php
//$this->pageTitle = 'Номенклатуры - распределение';

/*/
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
				<h5 class="panel-title">Каталог товаров <i
							class="fancytree-title icon-loop3 position-right" id="reload" style="font-size: 0.9em;"></i>
				</h5>
			</div>
			<div class="panel-body">
				<div class="row CopyPaste">
					<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6"
					     style="border-right: 1px solid #dadada; max-height: 690px; overflow-y: scroll;">
						<div class="chart-legend">
							<div id="viewtree" class=""></div>
						</div>
					</div>
					<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">

						<form action="/cms/default/saveseo" id="SeoForm" class="form-horizontal" style="display: none;">
							<input type="hidden" name="id" value="" id="id">
							<div class="tabbable">
                                <?php
                                //$oRegions = AppRegions::model()->findAll(['order' => 'region_name ASC']);
                                //$oRegionProperties = AppRegionProperties::model()->findAll(['order' => 'id ASC']);
                                ?>
								<ul class="nav nav-tabs nav-tabs-highlight">
									<li class="active">
										<a href="#tabMain" data-toggle="tab" aria-expanded="true">Основные</a>
									</li>
                                    <?php /*foreach ($oRegions as $oRegion) { ?>
                                        <li class="">
                                            <a href="#tabRegion<?= $oRegion->id ?>" data-toggle="tab"
                                               aria-expanded="false"><?= $oRegion->region_name ?></a>
                                        </li>
                                    <?php }*/ ?>
								</ul>

								<div class="tab-content">
									<div class="tab-pane active" id="tabMain">
										<div class="form-group">
											<label class="control-label col-lg-2">Сгенерировать из</label>
											<div class="col-lg-2 btn btn-sm btn-info" id="genTitleAlias">
												page_title
											</div>
											<div class="col-lg-offset-1 col-lg-2 btn btn-sm btn-info"
											     id="genLongTitleAlias">
												page_longtitle
											</div>
										</div>
										<div class="form-group">
											<label class="control-label col-lg-2">alias</label>
											<div class="col-lg-10">
												<input type="text" class="form-control" placeholder="url_alias"
												       name="url_alias" id="url_alias">
											</div>
										</div>
										<div class="form-group">
											<label class="control-label col-lg-2">node_name</label>
											<div class="col-lg-10">
												<input type="text" class="form-control" placeholder="node_name"
												       name="node_name" id="node_name">
											</div>
										</div>
										<div class="form-group">
											<label class="control-label col-lg-2">page_title</label>
											<div class="col-lg-10">
												<input type="text" class="form-control" placeholder="page_title"
												       name="page_title" id="page_title">
											</div>
										</div>
										<div class="form-group">
											<label class="control-label col-lg-2">page_longtitle</label>
											<div class="col-lg-10">
												<input type="text" class="form-control" placeholder="page_longtitle"
												       name="page_longtitle" id="page_longtitle">
											</div>
										</div>
										<div class="form-group">
											<label class="control-label col-lg-2">page_teaser</label>
											<div class="col-lg-10">
												<input type="text" class="form-control" placeholder="page_teaser"
												       name="page_teaser" id="page_teaser">
											</div>
										</div>
										<div class="form-group">
											<label class="control-label col-lg-2">menu_title</label>
											<div class="col-lg-10">
												<input type="text" class="form-control" placeholder="menu_title"
												       name="menu_title" id="menu_title">
											</div>
										</div>
										<div class="form-group">
											<label class="control-label col-lg-2">seo_title</label>
											<div class="col-lg-10">
												<input type="text" class="form-control" placeholder="seo_title"
												       name="seo_title" id="seo_title">
											</div>
										</div>
										<div class="form-group">
											<label class="control-label col-lg-2">seo_keywords</label>
											<div class="col-lg-10">
												<input type="text" class="form-control" placeholder="seo_keywords"
												       name="seo_keywords" id="seo_keywords">
											</div>
										</div>
										<div class="form-group">
											<label class="control-label col-lg-2">seo_description</label>
											<div class="col-lg-10">
												<textarea class="form-control" placeholder="seo_description"
												          name="seo_description" id="seo_description"></textarea>
											</div>
										</div>

										<div class="form-group">
											<div class="col-lg-3" style="Xborder: solid 1px #000;">
												<div class="row">
													<div class="col-lg-12 text-center" style="Xborder: solid 1px #00f;">
														<label class="control-label text-center"
														       style="Xborder: solid 1px #f00;">Запрет СЕО
															индексации</label>
													</div>
													<div class="col-lg-12" style="Xborder: solid 1px #0f0;">
														<input type="checkbox" class="form-control"
														       style="height: 20px;" name="is_seo_noindexing"
														       id="is_seo_noindexing">
													</div>
												</div>
											</div>

											<div class="col-lg-3" style="Xborder: solid 1px #000;">
												<div class="row">
													<div class="col-lg-12 text-center" style="Xborder: solid 1px #00f;">
														<label class="control-label text-center"
														       style="Xborder: solid 1px #f00;">Опубликовать</label>
													</div>
													<div class="col-lg-12" style="Xborder: solid 1px #0f0;">
														<input type="checkbox" class="form-control"
														       style="height: 20px;" name="is_node_published"
														       id="is_node_published">
													</div>
												</div>
											</div>

											<div class="col-lg-3" style="Xborder: solid 1px #000;">
												<div class="row">
													<div class="col-lg-12 text-center" style="Xborder: solid 1px #00f;">
														<label class="control-label text-center"
														       style="Xborder: solid 1px #f00;">Показывать в
															Yandex.Markets</label>
													</div>
													<div class="col-lg-12" style="Xborder: solid 1px #0f0;">
														<input type="checkbox" class="form-control"
														       style="height: 20px;" name="is_in_markets"
														       id="is_in_markets">
													</div>
												</div>
											</div>

											<div class="col-lg-3" style="Xborder: solid 1px #000;">
												<div class="row">
													<div class="col-lg-12 text-center" style="Xborder: solid 1px #00f;">
														<label class="control-label text-center"
														       style="Xborder: solid 1px #f00;">Показывать в Google
															покупках и eLama</label>
													</div>
													<div class="col-lg-12" style="Xborder: solid 1px #0f0;">
														<input type="checkbox" class="form-control"
														       style="height: 20px;" name="is_in_google"
														       id="is_in_google">
													</div>
												</div>
											</div>

										</div>

									</div>

                                    <?php /*/foreach ($oRegions as $oRegion) { ?>
                                        <div class="tab-pane" id="tabRegion<?= $oRegion->id ?>">
                                            <div class="form-group">
                                                <label class="control-label col-lg-2">Включить SEO</label>
                                                <div class="col-lg-1">
                                                    <input type="checkbox" class="form-control text-left is_seo_on"
                                                           style="height: 20px;" value="1"
                                                           name="RegionSeo[<?= $oRegion->id ?>][is_seo_on]"
                                                           id="<?= $oRegion->id ?>_is_seo_on">
                                                </div>
                                            </div>

                                            <?php foreach ($oRegionProperties as $oProp) { ?>
                                                <div class="form-group">
                                                    <label class="control-label col-lg-2"><?= $oProp->property_name ?></label>
                                                    <div class="col-lg-10">

                                                        <?php if ($oProp->property_type == 'string') { ?>
                                                            <input type="text" class="form-control"
                                                                   placeholder="<?= $oProp->property_name ?>"
                                                                   name="RegionSeo[<?= $oRegion->id ?>][<?= $oProp->id ?>]"
                                                                   id="<?= $oRegion->id ?>_<?= $oProp->id ?>">
                                                        <?php } else if ($oProp->property_type == 'text') { ?>
                                                            <textarea class="form-control" style="height: 200px;"
                                                                      placeholder="<?= $oProp->property_name ?>"
                                                                      name="RegionSeo[<?= $oRegion->id ?>][<?= $oProp->id ?>]"
                                                                      id="<?= $oRegion->id ?>_<?= $oProp->id ?>"></textarea>
                                                        <?php } ?>

                                                    </div>
                                                </div>
                                            <?php } ?>


                                        </div>
                                    <?php }//*/ ?>

								</div>
							</div>

							<div class="form-group">
								<div class="col-lg-offset-2 col-lg-10">
									<input type="submit" class="btn btn-info" id="SaveBtn" value="Сохранить">
								</div>
							</div>
						</form>

					</div>
				</div>
			</div>
		</div>
	</div>
</div>

<script type="text/template" id="NomTmpl">
	<td>$ {ecm_product['product_name']}</td>
	<td>$ {vendor['field_value']}</td>
	<td>$ {images}</td>
	<td><span class="btn label bg-orange-300 removeBtn">Убрать</span></td>
</script>

<script>
	var x;

	$(document).ready(function () {

		$('#reload').on('click', function (e) {
			if (e !== undefined) e.preventDefault();
			$('form').hide();
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
					//url: '<?php echo \yii\helpers\Url::to(['/cms/tree/gwDataTree']); ?>'
					url: '<?php echo \yii\helpers\Url::to(['/cms/tree/lazy-data-tree', 'page' => 'seo']); ?>'
				},
				lazyLoad: function (event, data) {
					var node = data.node;
					// Load child nodes via Ajax GET /getTreeData?mode=children&parent=1234
					data.result = {
						url: '<?php echo \yii\helpers\Url::to(['/cms/tree/lazy-data-tree', 'id' => '__id__', 'page' => 'seo']); ?>'.replace('__id__', node.key),
						data: {mode: "children", parent: node.key},
						cache: false
					};
				},
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
                        console.log('dragStart');
                        console.log('node', node);
                        console.log('data', data);
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
                        console.log('dragEnter');
                        console.log('node', node);
                        console.log('data', data);

                        return true;
					},
					dragDrop: function (node, data) {
						/** This function MUST be defined to enable dropping of items on
						 *  the tree.
						 */
                        console.log('dragDrop');
                        console.log('node', node);
                        console.log('data', data);

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

						console.log('data.otherNode.toDict()', data.otherNode.toDict());
						console.log('node.toDict()', node.toDict());
						console.log('data.hitMode', data.hitMode);
					}
				},
				activate: function (event, data) {
					console.log('[activate]', event, data);
					//loadSeo(data.node.key);
				},
				click: function (event, data) {
					console.log('click');
					$('input[type="checkbox"]').removeProp('checked');
					$('input[type="text"]').val('');
					$('textarea').text('');
					$('textarea').val('');

					loadSeo(data.node.key);
					$('#tabMain').tab('show');
				},
				dblclick: function (event, data) {
					//console.log('dblclick');
					window.open(
						'<?= \yii\helpers\Url::to(['/cms/tree/editNode', 'id' => '__id__']); ?>'
							.replace('__id__', data.node.key) + '?is_tab=1',
						'_blank'
					);
					window.focus();
					return true;
				}
			});
		}

		loadTree();

		function loadSeo(id) {
			console.log('id', id);
			dataForm = {id: id};
			$.ajax({
				type: 'POST',
				dataType: 'json',
				url: '<?php echo \yii\helpers\Url::to(['/cms/tree/load-seo']); ?>',
				data: dataForm,
				success: function (response) {
					console.log('[RESPONSE]', response);
					if (response.success) {
						$('.is_seo_on').removeProp('checked');
						$('#id').val(response.response_data.id);
						$('#url_alias').val(response.response_data.url_alias);
						$('#page_title').val(response.response_data.page_title);
						$('#page_longtitle').val(response.response_data.page_longtitle);
						$('#page_teaser').val(response.response_data.page_teaser);
						$('#menu_title').val(response.response_data.menu_title);
						$('#seo_title').val(response.response_data.seo_title);
						$('#seo_keywords').val(response.response_data.seo_keywords);
						$('#seo_description').text(response.response_data.seo_description);
						$('#is_seo_noindexing').prop('checked', response.response_data.is_seo_noindexing);
						$('#is_node_published').prop('checked', response.response_data.is_node_published);
						$('#is_in_markets').prop('checked', response.response_data.is_in_markets);
						$('#is_in_google').prop('checked', response.response_data.is_in_google);

						//проставить региональные данные
						/*
                        var regions = response.response_data.regions;
                        console.log('regions', regions);

                        for (var region_id in regions) {
                            //1_is_seo_on
                            $('#' + region_id + '_is_seo_on').prop('checked', true);
                            var props = regions[region_id];
                            for (var prop_id in props) {
                                prop = props[prop_id];
                                console.log('prop', prop);
                                $('#' + region_id + '_' + prop_id).val(prop.property_value);
                                $('#' + region_id + '_' + prop_id).text(prop.property_value);
                            }
                        }
                        */

						$.each(response.response_data, function (index, value) {
							$('#' + index).val(value);
						});
						$('form').show();

						//var $Template = $('#NomTmpl').tmpl(response.response_data);
						//$('#NomenclaturesList tbody').append($Template);
					} else {

					}
				},
				error: function (xhr) {
					alert('ERROR: ' + xhr.responseText);
				}
			});
		}

		function saveSeo() {
			console.log();
			dataForm = $('#SeoForm').serialize();
			$.ajax({
				type: 'POST',
				dataType: 'json',
				url: '<?php echo \yii\helpers\Url::to(['/cms/tree/save-seo']); ?>',
				data: dataForm,
				success: function (response) {
					console.log('[RESPONSE]', response);
					if (response.success) {
						//var $Template = $('#NomTmpl').tmpl(response.response_data);
						//$('#NomenclaturesList tbody').append($Template);
						new PNotify({
							title: 'Success',
							text: 'Успешно сохранено',
							addclass: 'bg-success',
							delay: 3000
						});
					} else {
						new PNotify({
							title: 'Что-то пошло не так',
							text: response.message,
							addclass: 'bg-warning',
							delay: 3000
						});
					}
				},
				error: function (xhr) {
					alert('ERROR: ' + xhr.responseText);
				}
			});
		}

		$('body')
			.on('click', '#SaveBtn', function (e) {
				e.preventDefault();
				saveSeo();
			})
			.on('click', '#genTitleAlias', function (e) {
				e.preventDefault();
				var str = $('#page_title').val();
				//var id = $('#id').val();
				//$('#url_alias').val(liTranslit(str) + '--' + id);
				$('#url_alias').val(liTranslit(str));
			})
			.on('click', '#genLongTitleAlias', function (e) {
				e.preventDefault();
				var str = $('#page_longtitle').val();
				//var id = $('#id').val();
				//$('#url_alias').val(liTranslit(str) + '--' + id);
				$('#url_alias').val(liTranslit(str));
			})
		;

		//инициировать дерево
		var tree = $("#viewtree").fancytree("getTree");
		tree.visit(function (node) {
			node.setExpanded(false);
		});
	});

</script>