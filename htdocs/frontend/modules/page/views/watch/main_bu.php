<?php

use common\components\M;

$this->context->page_title = $oContent->seo_title;
//$this->context->pageTitle = $oContent->page_title;
$this->context->page_keywords = $oContent->seo_keywords;
$this->context->page_description = $oContent->seo_description;
$this->context->page_noindexing = $oContent->is_seo_noindexing;

?>

<?php //*/ ?>
<!--<h1>Интернет-магазин ФИШМЕН<?php //= $content->page_title ?></h1>
<p><?= $oContent->page_body ?></p>
<?php //= $this->renderPartial('_main/banner') ?>-->
<?php //*/ ?>

<?php //if ($this->beginCache('page' . $this->cache_key, $this->cache_opts)) { ?>

<div class="visuallyhidden">
    <h1>Рыболовный интернет-магазин Фишмен</h1>
</div>
<div class="visuallyhidden" itemscope itemtype="http://schema.org/Organization">
    <span itemprop="name">Интернет-магазин Фишмен</span> <a itemprop="url" title="" href="https://fishmen.ru"></a>
    <!-- -->
    <a itemprop="sameAs" title="" href="https://vk.com/fishmen_ru" rel="nofollow"></a>
    <a itemprop="sameAs" title="" href="https://www.facebook.com/fishmen.ru/" rel="nofollow"></a><!-- -->
    <img itemprop="logo" alt="" src="https://fishmen.ru/images/icon-200x200.png">

    <div itemprop="address" itemscope itemtype="http://schema.org/PostalAddress">
        <span itemprop="streetAddress">ул.Комарова, 3А</span> <span
                itemprop="postalCode">150034</span> <span itemprop="addressLocality">Ярославль</span>
    </div>
    Телефон:<span itemprop="telephone">+7 4852 60-70-47</span>, Факс:<span
            itemprop="faxNumber">+7 4852 60-70-47</span>,
    Электронная почта: <span itemprop="email">info@fishmen.ru</span>
</div>

<!-- HEADER START ? -->
<?php

?>
<?= Yii::$app->controller->renderPartial('_main/_head_banner') ?>

<!-- HEADER STOP -->

<?= Yii::$app->controller->renderPartial('_main/_product', ['cards' => $cards]) ?>
<?php if (0) { ?>
    <?= Yii::$app->controller->renderPartial('_main/_banner1') ?>
    <?= Yii::$app->controller->renderPartial('_main/_news') ?>
    <?= Yii::$app->controller->renderPartial('_main/_description') ?>
    <?= Yii::$app->controller->renderPartial('_main/_banner2') ?>
    <?= Yii::$app->controller->renderPartial('_main/_subs') ?>
<?php } ?>
<?php //$this->endCache(); ?>
<?php //} ?>
