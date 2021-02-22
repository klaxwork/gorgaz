<?php
$cs = Yii::app()->clientScript;
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

?>

<div class="row">
    <div class="col-md-3">
        <div class="panel">
            <div class="panel-heading">
                <span class="panel-title">Управление</span>
            </div>

            <div class="panel-menu">
                <div class="chart-legend mb10">
                    <a class="ajax-popup-link legend-item btn btn-block btn-info ph30 mr20"
                       href="<?= $this->createUrl('tree/createNode', array('id' => $id)); ?>">Создать страницу</a>
                </div>
            </div>
        </div>
        <script type="application/javascript">
            $(document).ready(function () {
                $('.ajax-popup-link').magnificPopup({
                    type: 'ajax',
                    modal: true
                });
            });
        </script>
    </div>

    <div class="col-md-9">
        <div class="panel">
            <div class="panel-heading">
                <span class="panel-title"><?= $oSite->tree->node_name ?></span>
            </div>
            <div class="panel-menu">
                <div class="chart-legend">
                    <table>
                        <tr>
                            <td>&nbsp;</td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<script type="application/javascript">
    $(document).ready(function () {
        "use strict";

        // Init Theme Core
        //Core.init();

        // Init Demo JS
        //Demo.init();

        //var tree = $("#viewtree").fancytree("getTree");
        //tree.reload(result);

        // Init FancyTree - w/Drag and Drop Functionality
        $("#viewtree").fancytree({
            extensions: ["dnd", "filter", "edit", "childcounter"],
            filter: {
                autoApply: true, // Re-apply last filter if lazy data is loaded
                counter: true, // Show a badge with number of matching child nodes near parent icons
                hideExpandedCounter: true, // Hide counter badge, when parent is expanded
                mode: "hide"  // "dimm": Grayout unmatched nodes, "hide": remove unmatched nodes
            },
            // titlesTabbable: true,
            source: {
                url: '<?php echo Yii::app()->createUrl('/cms/site/gwDataTree', array('id' => $id)); ?>'
            },
            childcounter: {
                deep: true,
                hideZeros: true,
                hideExpanded: true
            },
            dnd: {
                autoExpandMS: 400,
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
                        url: '<?php echo Yii::app()->createUrl('/cms/tree/moveNode'); ?>',
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
            click: function (event, data) {
                //console.log('click');
            },
            dblclick: function (event, data) {
                console.log('dblclick');
                console.log('[DATA]', data);
                var url = '<?= $this->createUrl('editContent', array('id' => '__id__')); ?>'.replace('__id__', data.node.key);
                console.log('[url]', url);
                window.location = url;
            },
            activate: function (event, data) {
                //console.log('activate', data);
            }
            /*,
             lazyLoad: function (event, data) {
             data.result = {
             url: "/json/ajax-sub2.json"
             }
             }*/
        });

        //раскрыть все узлы
        var tree = $("#viewtree").fancytree("getTree")
        tree.visit(function (node) {
            node.setExpanded(true);
        });
    });
</script>