<?php /* @var $this Controller */ ?>

<?php $this->beginContent('@theme/views/layouts/main.php'); ?>

<?php echo Yii::$app->controller->renderPartial('@theme/views/layouts/navbar.php'); ?>

<?php echo Yii::$app->controller->renderFile('@theme/views/layouts/sidebar-top.php'); ?>

<!-- Page container -->
<div class="page-container">

    <!-- Page content -->
    <div class="page-content">
        <!-- Begin: Content -->
        <?php echo $content; ?>
        <!-- End: Content -->
    </div>
    <!-- /page content -->

</div>
<!-- /page container -->


<?php $this->endContent(); ?>

