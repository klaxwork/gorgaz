<?php
$bodyclass = ['sb-top', 'sb-top-sm'];
if (isset($this->bodyclass)) {
    $bodyclass = array_merge($bodyclass, $this->bodyclass);
}


/*/
$cs = Yii::app()->clientScript;
$themePath = Yii::app()->theme->baseUrl;

$cs->registerCoreScript('jquery', CClientScript::POS_END);
$cs->registerCoreScript('jquery.ui', CClientScript::POS_END);

$cs->registerScriptFile($themePath . '/vendor/jquery/jquery.tmpl.min.js', CClientScript::POS_END);
$cs->registerScriptFile($themePath . '/assets/js/plugins/notifications/pnotify.min.js', CClientScript::POS_END);
//*/
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title><?php //= $this->pageTitle ?></title>

	<link href="/favicon.ico" rel="icon" type="image/x-icon">

	<!-- Global stylesheets -->
	<link href="https://fonts.googleapis.com/css?family=Roboto:400,300,100,500,700,900" rel="stylesheet"
	      type="text/css">
	<link href="/themes/limit/assets/css/icons/icomoon/styles.css" rel="stylesheet" type="text/css">
	<link href="/themes/limit/assets/css/icons/fontawesome/styles.min.css" rel="stylesheet" type="text/css">
	<link href="/themes/limit/assets/css/bootstrap.css" rel="stylesheet" type="text/css">
	<link href="/themes/limit/assets/css/core.css" rel="stylesheet" type="text/css">
	<link href="/themes/limit/assets/css/components.css" rel="stylesheet" type="text/css">
	<link href="/themes/limit/assets/css/theme.css" rel="stylesheet" type="text/css">
	<link href="/themes/limit/assets/css/colors.css" rel="stylesheet" type="text/css">
	<!-- /global stylesheets -->

	<script type="text/javascript" src="/themes/limit/vendor/jquery/jquery-1.11.1.min.js"></script>
	<script type="text/javascript" src="/themes/limit/vendor/jquery/jquery_ui/jquery-ui.min.js"></script>
	<script type="text/javascript" src="/themes/limit/assets/js/plugins/notifications/pnotify.min.js"></script>

	<script type="text/javascript" src="/themes/limit/assets/js/functions.js"></script>
	<!-- Core JS files -->
	<script type="text/javascript" src="/themes/limit/assets/js/plugins/loaders/pace.min.js"></script>
	<script type="text/javascript" src="/themes/limit/vendor/jquery/jquery.tmpl.min.js"></script>
	<script type="text/javascript" src="/themes/limit/vendor/plugins/liTranslit/js/jquery.liTranslit.js"></script>

	<script type="text/javascript" src="/themes/limit/assets/js/core/libraries/bootstrap.min.js"></script>
	<script type="text/javascript" src="/themes/limit/assets/js/plugins/loaders/blockui.min.js"></script>
	<script type="text/javascript" src="/themes/limit/assets/js/plugins/ui/nicescroll.min.js"></script>
	<script type="text/javascript" src="/themes/limit/assets/js/plugins/ui/drilldown.js"></script>
	<script type="text/javascript" src="/themes/limit/assets/js/plugins/forms/styling/uniform.min.js"></script>
	<script type="text/javascript" src="/themes/limit/assets/js/plugins/editors/summernote/summernote.min.js"></script>
	<script type="text/javascript" src="/themes/limit/assets/js/plugins/forms/editable/editable.min.js"></script>
	<!-- /core JS files -->

	<link href="/themes/limit/vendor/plugins/jqueryContextMenu/dist/jquery.contextMenu.css" rel="stylesheet"
	      type="text/css">
	<script type="text/javascript"
	        src="/themes/limit/vendor/plugins/jqueryContextMenu/dist/jquery.contextMenu.js"></script>
	<script type="text/javascript"
	        src="/themes/limit/vendor/plugins/jqueryContextMenu/dist/jquery.ui.position.min.js"></script>

	<!-- Theme JS files -->
	<script type="text/javascript" src="/themes/limit/assets/js/core/app.js"></script>

</head>

<body>
<?php echo $content; ?>

<!-- Footer -->
<div class="footer text-muted text-center">
	&copy; 2017. <a href="http://nays.ru">NAYS Development Kit</a>
</div>
<!-- /footer -->

<div id="modal" class="modal fade" style="display: none;">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
		</div>
	</div>
</div>

<script>
	$(".styled").uniform();

	$('.summernote').summernote();
	$('.summernote-height').summernote({
		height: 400
	});

	//обработка изменения поля summernote
	$('body')
		.on('change keyup click', '.note-editor', function (e) {
			var contentSummerNote;
			if ($(this).hasClass('codeview')) {
				contentSummerNote = $(this).find('.note-codable').val();
			} else {
				contentSummerNote = $(this).find('.note-editable').html();
			}
			$(this).siblings('textarea').val(contentSummerNote);
		})
	;

	$('#modal').on('hidden.bs.modal', function () {
		$('#modal .modal-container').empty();
		$('#modal').removeData();
	});
</script>

<script type="text/javascript" src="/themes/limit/vendor/plugins/fancytree/jquery.fancytree-all.min.js"></script>
<script type="text/javascript" src="/themes/limit/vendor/plugins/fancytree/extensions/jquery.fancytree.childcounter.js"></script>
<script type="text/javascript" src="/themes/limit/vendor/plugins/fancytree/extensions/jquery.fancytree.columnview.js"></script>
<script type="text/javascript" src="/themes/limit/vendor/plugins/fancytree/extensions/jquery.fancytree.dnd.js"></script>
<script type="text/javascript" src="/themes/limit/vendor/plugins/fancytree/extensions/jquery.fancytree.edit.js"></script>
<script type="text/javascript" src="/themes/limit/vendor/plugins/fancytree/extensions/jquery.fancytree.filter.js"></script>

</body>
</html>
