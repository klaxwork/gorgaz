<?php /* @var $this Controller */ ?>

<?php $this->beginContent('//layouts/main'); ?>


    <?php echo $this->renderPartial('//layouts/navbar-on-partner'); ?>

    <?php echo $this->renderPartial('//layouts/sidebar-top-on-partner'); ?>


    <!-- Start: Content-Wrapper -->
    <section id="content_wrapper">

        <!-- Begin: Content -->

        <?php echo $content; ?>

        <!-- End: Content -->

    </section>


<?php $this->endContent(); ?>

