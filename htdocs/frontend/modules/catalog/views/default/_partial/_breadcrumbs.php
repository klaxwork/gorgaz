<?php
$breadcrumbs = [];
$breadcrumbs['Главная'] = '/';
$breadcrumbs += $oCategory->getBreadcrumbs();
?>
<div class="breadcrumb-wr">
    <div class="container">
        <div class="breadcrumb">
            <?php if (isset($breadcrumbs)) { ?>
                <!-- breadcrumbs -->
                <?= \frontend\components\widgets\BreadcrumbsWidget\BreadcrumbsWidget::widget(
                    [
                        //'is_hide_last' => true,
                        'links' => $breadcrumbs,
                    ]
                ); ?>
                <!-- /breadcrumbs -->
            <?php } ?>
        </div>
    </div>
</div>
