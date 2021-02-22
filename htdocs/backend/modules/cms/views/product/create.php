<?php

use common\components\M;

//M::printr('create');
//M::printr($oProduct, '$oProduct');

if (0) {
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

    $cs->registerCssFile($themePath . '/vendor/plugins/select2/css/core.css');
//$cs->registerScriptFile($themePath . '/vendor/plugins/select2/select2.full.js', CClientScript::POS_END);
}
?>

<div class="row">
	<div class="col-md-12">
        <?= $this->context->renderPartial('_formProduct', ['formName' => $formName, 'oProduct' => $oProduct, 'oStores' => $oStores]); ?>
		<?php M::printr($oStores, '$oStores'); ?>
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

	});
</script>

<?php if (0) { ?>
	<div class="row">
		<div class="col-md-3">
            <?= $this->renderPartial('_left_panel', compact('formName', 'model')); ?>
		</div>
		<div class="col-md-9">
            <?= $this->renderPartial('_formQuest', compact('formName', 'model', 'oCompany')); ?>
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

		});
	</script>
<?php } ?>
