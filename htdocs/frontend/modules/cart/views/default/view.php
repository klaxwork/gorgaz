<?php

use common\components\M;
//use yii\widgets\Breadcrumbs;
use yii\helpers\Url;
use frontend\components\widgets\BreadcrumbsWidget\BreadcrumbsWidget;

//M::printr($oContent, '$oContent');

//M::printr($oCategory, '$oCategory');
$breadcrumbs = $oContent->getBreadcrumbs();
M::printr($breadcrumbs, '$breadcrumbs');
//['links' => $breadcrumbs]
print BreadcrumbsWidget::widget(
    [
        //'is_hide_last' => true,
        'links' => $breadcrumbs,
    ]
);

?>


<div class="cms-default-index">
    <?php //= common\components\M::printr($this->context, '$this->context');?>
    <h1><?= $oCategory->content->page_title ?></h1>
    <div style="border: 1px solid #000;">
        <ul>
            <?php foreach ($oChs as $oCh) { ?>
                <?php $oContent = $oCh->content; ?>
                <li>
                    <?php
                    $url = \yii\helpers\Url::toRoute(['/catalog/default/view', 'node_id' => $oCh->id]);
                    M::printr($url, '$url');
                    ?>
                    <a href="<?= $url ?>"><?= !empty($oContent->page_long_title) ? $oContent->page_long_title : $oContent->page_title ?></a>
                </li>
            <?php } ?>
        </ul>
    </div>
    <p>
        This is the view content for action "<?= $this->context->action->id ?>".
        The action belongs to the controller "<?= get_class($this->context) ?>"
        in the "<?= $this->context->module->id ?>" module.
    </p>
    <p>
        You may customize this page by editing the following file:<br>
        <code><?= __FILE__ ?></code>
    </p>
</div>
<code>
    <?php
    print_r(Yii::getAlias('@layouts'));
    ?>
</code>