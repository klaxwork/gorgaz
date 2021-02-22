<?php
$themePath = $this->theme->baseUrl;
?>
<html>
<head>

</head>
<body>
<script src="<?= $themePath ?>/vendor/jquery-1.11.3.min.js"></script>
<?php /*/ ?>
<script src="<?= $themePath ?>/assets/js/js.cookie-2.2.0.min.js" type="text/javascript"></script>
<?php //*/ ?>
<script src="<?= $themePath ?>/assets/packages/yii2-js-cookie/src/js.cookie.js" type="text/javascript"></script>
<?php echo $content; ?>
</body>
</html>
