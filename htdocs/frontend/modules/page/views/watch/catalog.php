<?php

use common\components\M;
use frontend\components\widgets\BreadcrumbsWidget\BreadcrumbsWidget;

?>

<?php if (1) { ?>
    <?php
    /*
    level 1
    */ ?>
    <?php
    $breadcrumbs = [];
    $breadcrumbs['Главная'] = '/';
    $breadcrumbs['Каталог товаров'] = '/catalog/';
    ?>
    <div class="breadcrumb-wr">
        <div class="container">
            <div class="breadcrumb">
                <?php if (isset($breadcrumbs)) { ?>
                    <?php
                    print BreadcrumbsWidget::widget(
                        [
                            'links' => $breadcrumbs,
                        ]
                    );
                    ?><!-- breadcrumbs -->
                <?php } ?>
            </div>
        </div>
    </div>
    <section class="main-title">
        <div class="container">
            <?php //$oBlock = CmsTree::getBlock('catalog'); //var_dump($oBlock);?>
            <h1><?= $oBlock->page_longtitle ?: $oBlock->page_title ?></h1>
        </div>
    </section>

    <section class="main-catalog">
        <div class="container">
            <div class="main-catalog__list">
                <?php $oChs1 = $oCategory->children(1)->andWhere(['is_node_published' => true])->all(); ?>
                <?php foreach ($oChs1 as $index => $oCh1) { ?>
                    <div
                            class="main-catalog__item <?= $index == 0 ? 'main-catalog__item_banner-option clearfix' : 'clearfix' ?>">
                        <?php
                        //Yii::app()->basePath .
                        $frontend = Yii::getAlias('@frontend');
                        ?>
                        <div class="main-catalog__item-ico"><img
                                    src="<?= file_exists($frontend . '/web/images/catalog/' . $oCh1->content->url_alias . '.png') ? '/images/catalog/' . $oCh1->content->url_alias . '.png' : '/images/noimg.jpg' ?>"
                                    alt=""></div>
                        <div class="main-catalog__item-content">
                            <div class="main-catalog__item-title"><h2><a
                                            href="<?= \yii\helpers\Url::to(['/route/catalog', 'id' => $oCh1->id]) ?>"
                                            title="<?= $oCh1->node_name ?>"><?= $oCh1->node_name ?></a></h2>
                            </div>
                            <div class="main-catalog__item-list">
                                <ul class="list clearfix">
                                    <?php $oChs2 = $oCh1->children(1)->andWhere(['is_node_published' => true])->all(); ?>
                                    <?php foreach ($oChs2 as $oCh2) { ?>
                                        <?php if (!$oCh2->is_node_published) continue; ?>
                                        <li>
                                            <h3>
                                                <a href="<?= \yii\helpers\Url::to(['/route/catalog', 'id' => $oCh2->id]) ?>"
                                                   title="<?= $oCh2->node_name ?>"><?= $oCh2->node_name ?></a></h3>
                                        </li>
                                    <?php } ?>
                                </ul>
                            </div>
                        </div>
                        <?php if ($index == 0) { ?>
                            <div class="main-catalog__item-banner visible-md visible-lg">
                                <div
                                        class="nav__main-catalog-usercontent-banner-item nav__main-catalog-usercontent-banner-item_position-variant">
                                    <div class="nav__main-catalog-usercontent-banner-item-name">Bandit</div>
                                    <div class="nav__main-catalog-usercontent-banner-item-description">Новые поступления
                                        цветов и моделей отличных воблеров для троллинга
                                    </div>
                                    <div class="nav__main-catalog-usercontent-banner-item-link"><a
                                                title="Воблеры Bandit"
                                                href="<?= \yii\helpers\Url::to(['/route/catalog', 'id' => 309]) ?>"
                                                class="btn btn_nav-main-banner">Перейти к выбору</a></div>
                                    <div class="nav__main-catalog-usercontent-banner-item-pic"><img
                                                src="/images/item_banner.png"
                                                alt="Воблеры Bandit"></div>
                                </div>
                            </div>
                        <?php } ?>
                    </div>
                <?php } ?>

            </div>
        </div>
    </section>
    <?php //= $this->renderPartial('_main/_banner1') ?>
    <?php /*/?>
<section class="main-banner">
    <div class="container">
        <div class="main-banner__content">Баннер max 1210х160 (резиновый)</div>
    </div>
</section>
<section class="main-catalog-slider">
    <div class="container">
        <div class="main-product__nav clearfix">
            <div class="main-product__title">Акционные товары. Распродажа</div>
            <div class="main-product__slider-control">
                <div class="main-product__slider-control-item main-product__slider-control-item_prev pr_prev">
                    <svg class="svg-icon ico-slider-control">
                        <use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="/themes/fishmen/assets/css/symbols.svg#ico-slider-control"></use>
                    </svg>
                </div>
                <div class="main-product__slider-control-item main-product__slider-control-item_next pr_next">
                    <svg class="svg-icon ico-slider-control">
                        <use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="/themes/fishmen/assets/css/symbols.svg#ico-slider-control"></use>
                    </svg>
                </div>
            </div>
            <div class="main-product__all-product"><a href="#">Смотреть все предложения</a></div>
        </div>
        <div class="main-product__list">
            <div class="main-product__list-wr">
                <div class="main-product__list-sider">
                    <div class="main-product__list-sider-item">
                        <div class="product-item">
                            <div class="product-item__body">
                                <div class="product-item__fast-info">
                                    <div class="product-item__img"><img src="/images/item.jpg" alt=""></div>
                                    <div class="product-item__labels">
                                        <div class="product-item__label product-item__label_new"><span>Новинка</span>
                                        </div>
                                        <div class="product-item__label product-item__label_sale">
                                            <span>Распродажа</span></div>
                                    </div>
                                    <div class="product-item__modal"><a href="#">
                                            <svg class="svg-icon ico-look">
                                                <use xmlns:xlink="http://www.w3.org/1999/xlink"
                                                     xlink:href="/themes/fishmen/assets/css/symbols.svg#ico-look"></use>
                                            </svg>
                                            <span>Быстрый просмотр</span></a></div>
                                </div>
                                <div class="product-item__vendor-code">
                                    <svg class="svg-icon ico-tab-un-selected">
                                        <use xmlns:xlink="http://www.w3.org/1999/xlink"
                                             xlink:href="/themes/fishmen/assets/css/symbols.svg#ico-tab-un-selected"></use>
                                    </svg>
                                    <span>Артикул: 003996</span>
                                </div>
                                <div class="product-item__name"><a href="#">Воблер Bandit Walleye Deep, #2 (Blue
                                        Shiner), 17.5 гр., 12 см.</a></div>
                                <div class="product-item__description">Плавающий, заглубление до 8.1 метра при троллинге
                                </div>
                            </div>
                            <div class="product-item__foot">
                                <div class="product-item__purchase clearfix">
                                    <div class="product-item__price">
                                        <div class="product-item__old-price">665 <i class="rouble">a</i></div>
                                        <div class="product-item__new-price">15 550 <i class="rouble">a</i></div>
                                    </div>
                                    <div class="product-item__status"><a href="#">
                                            <svg class="svg-icon ico-basket">
                                                <use xmlns:xlink="http://www.w3.org/1999/xlink"
                                                     xlink:href="/themes/fishmen/assets/css/symbols.svg#ico-basket"></use>
                                            </svg>
                                            <span>Купить</span></a></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="main-product__list-sider-item">
                        <div class="product-item product-item_out-stock">
                            <div class="product-item__body">
                                <div class="product-item__fast-info">
                                    <div class="product-item__img"><img src="/images/item.jpg" alt=""></div>
                                    <div class="product-item__modal"><a href="#">
                                            <svg class="svg-icon ico-look">
                                                <use xmlns:xlink="http://www.w3.org/1999/xlink"
                                                     xlink:href="/themes/fishmen/assets/css/symbols.svg#ico-look"></use>
                                            </svg>
                                            <span>Быстрый просмотр</span></a></div>
                                </div>
                                <div class="product-item__vendor-code">
                                    <svg class="svg-icon ico-tab-selected">
                                        <use xmlns:xlink="http://www.w3.org/1999/xlink"
                                             xlink:href="/themes/fishmen/assets/css/symbols.svg#ico-tab-selected"></use>
                                    </svg>
                                    <span>Артикул: 003996</span>
                                </div>
                                <div class="product-item__name"><a href="#">Воблер Bandit Walleye Deep, #2 (Blue
                                        Shiner), 17.5 гр., 12 см.</a></div>
                                <div class="product-item__description">Плавающий, заглубление до 8.1 метра при троллинге
                                </div>
                            </div>
                            <div class="product-item__foot">
                                <div class="product-item__purchase clearfix">
                                    <div class="product-item__price">
                                        <div class="product-item__new-price">15 550 <i class="rouble">a</i></div>
                                    </div>
                                    <div class="product-item__status">
                                        <svg class="svg-icon ico-basket">
                                            <use xmlns:xlink="http://www.w3.org/1999/xlink"
                                                 xlink:href="/themes/fishmen/assets/css/symbols.svg#ico-basket"></use>
                                        </svg>
                                        <span>Нет в<br>продаже</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="main-product__list-sider-item">
                        <div class="product-item product-item_in-basket">
                            <div class="product-item__body">
                                <div class="product-item__fast-info">
                                    <div class="product-item__img"><img src="/images/item.jpg" alt=""></div>
                                    <div class="product-item__modal"><a href="#">
                                            <svg class="svg-icon ico-look">
                                                <use xmlns:xlink="http://www.w3.org/1999/xlink"
                                                     xlink:href="/themes/fishmen/assets/css/symbols.svg#ico-look"></use>
                                            </svg>
                                            <span>Быстрый просмотр</span></a></div>
                                </div>
                                <div class="product-item__vendor-code">
                                    <svg class="svg-icon ico-tab-un-selected">
                                        <use xmlns:xlink="http://www.w3.org/1999/xlink"
                                             xlink:href="/themes/fishmen/assets/css/symbols.svg#ico-tab-un-selected"></use>
                                    </svg>
                                    <span>Артикул: 003996</span>
                                </div>
                                <div class="product-item__name"><a href="#">Воблер Bandit Walleye Deep, #2 (Blue
                                        Shiner), 17.5 гр., 12 см.</a></div>
                                <div class="product-item__description">Плавающий, заглубление до 8.1 метра при троллинге
                                </div>
                            </div>
                            <div class="product-item__foot">
                                <div class="product-item__purchase clearfix">
                                    <div class="product-item__price">
                                        <div class="product-item__new-price">550 <i class="rouble">a</i></div>
                                    </div>
                                    <div class="product-item__status">
                                        <svg class="svg-icon ico-product-in-basket">
                                            <use xmlns:xlink="http://www.w3.org/1999/xlink"
                                                 xlink:href="/themes/fishmen/assets/css/symbols.svg#ico-product-in-basket"></use>
                                        </svg>
                                        <span>В корзине</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="main-product__list-sider-item">
                        <div class="product-item product-item_order">
                            <div class="product-item__body">
                                <div class="product-item__fast-info">
                                    <div class="product-item__img"><img src="/images/item.jpg" alt=""></div>
                                    <div class="product-item__modal"><a href="#">
                                            <svg class="svg-icon ico-look">
                                                <use xmlns:xlink="http://www.w3.org/1999/xlink"
                                                     xlink:href="/themes/fishmen/assets/css/symbols.svg#ico-look"></use>
                                            </svg>
                                            <span>Быстрый просмотр</span></a></div>
                                </div>
                                <div class="product-item__vendor-code">
                                    <svg class="svg-icon ico-tab-selected">
                                        <use xmlns:xlink="http://www.w3.org/1999/xlink"
                                             xlink:href="/themes/fishmen/assets/css/symbols.svg#ico-tab-selected"></use>
                                    </svg>
                                    <span>Артикул: 003996</span>
                                </div>
                                <div class="product-item__name"><a href="#">Воблер Bandit Walleye Deep, #2 (Blue
                                        Shiner), 17.5 гр., 12 см.</a></div>
                                <div class="product-item__description">Плавающий, заглубление до 8.1 метра при троллинге
                                </div>
                            </div>
                            <div class="product-item__foot">
                                <div class="product-item__purchase clearfix">
                                    <div class="product-item__price">
                                        <div class="product-item__new-price">550 <i class="rouble">a</i></div>
                                    </div>
                                    <div class="product-item__status"><a href="#">
                                            <svg class="svg-icon ico-basket">
                                                <use xmlns:xlink="http://www.w3.org/1999/xlink"
                                                     xlink:href="/themes/fishmen/assets/css/symbols.svg#ico-basket"></use>
                                            </svg>
                                            <span>Под заказ</span></a></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="main-product__list-sider-item">
                        <div class="product-item product-item_under-order">
                            <div class="product-item__body">
                                <div class="product-item__fast-info">
                                    <div class="product-item__img"><img src="/images/item.jpg" alt=""></div>
                                    <div class="product-item__modal"><a href="#">
                                            <svg class="svg-icon ico-look">
                                                <use xmlns:xlink="http://www.w3.org/1999/xlink"
                                                     xlink:href="/themes/fishmen/assets/css/symbols.svg#ico-look"></use>
                                            </svg>
                                            <span>Быстрый просмотр</span></a></div>
                                </div>
                                <div class="product-item__vendor-code">
                                    <svg class="svg-icon ico-tab-un-selected">
                                        <use xmlns:xlink="http://www.w3.org/1999/xlink"
                                             xlink:href="/themes/fishmen/assets/css/symbols.svg#ico-tab-un-selected"></use>
                                    </svg>
                                    <span>Артикул: 003996</span>
                                </div>
                                <div class="product-item__name"><a href="#">Воблер Bandit Walleye Deep, #2 (Blue
                                        Shiner), 17.5 гр., 12 см.</a></div>
                                <div class="product-item__description">Плавающий, заглубление до 8.1 метра при троллинге
                                </div>
                            </div>
                            <div class="product-item__foot">
                                <div class="product-item__purchase clearfix">
                                    <div class="product-item__price">
                                        <div class="product-item__old-price">665 <i class="rouble">a</i></div>
                                        <div class="product-item__new-price">550 <i class="rouble">a</i></div>
                                    </div>
                                    <div class="product-item__status"><a href="#">
                                            <svg class="svg-icon ico-basket">
                                                <use xmlns:xlink="http://www.w3.org/1999/xlink"
                                                     xlink:href="/themes/fishmen/assets/css/symbols.svg#ico-basket"></use>
                                            </svg>
                                            <span>Доступен<br>под заказ</span></a></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="main-product__list-sider-item">
                        <div class="product-item">
                            <div class="product-item__body">
                                <div class="product-item__fast-info">
                                    <div class="product-item__img"><img src="/images/item.jpg" alt=""></div>
                                    <div class="product-item__labels">
                                        <div class="product-item__label product-item__label_new"><span>Новинка</span>
                                        </div>
                                        <div class="product-item__label product-item__label_sale">
                                            <span>Распродажа</span></div>
                                    </div>
                                    <div class="product-item__modal"><a href="#">
                                            <svg class="svg-icon ico-look">
                                                <use xmlns:xlink="http://www.w3.org/1999/xlink"
                                                     xlink:href="/themes/fishmen/assets/css/symbols.svg#ico-look"></use>
                                            </svg>
                                            <span>Быстрый просмотр</span></a></div>
                                </div>
                                <div class="product-item__vendor-code">
                                    <svg class="svg-icon ico-tab-un-selected">
                                        <use xmlns:xlink="http://www.w3.org/1999/xlink"
                                             xlink:href="/themes/fishmen/assets/css/symbols.svg#ico-tab-un-selected"></use>
                                    </svg>
                                    <span>Артикул: 003996</span>
                                </div>
                                <div class="product-item__name"><a href="#">Воблер Bandit Walleye Deep, #2 (Blue
                                        Shiner), 17.5 гр., 12 см.</a></div>
                                <div class="product-item__description">Плавающий, заглубление до 8.1 метра при троллинге
                                </div>
                            </div>
                            <div class="product-item__foot">
                                <div class="product-item__purchase clearfix">
                                    <div class="product-item__price">
                                        <div class="product-item__old-price">665 <i class="rouble">a</i></div>
                                        <div class="product-item__new-price">15 550 <i class="rouble">a</i></div>
                                    </div>
                                    <div class="product-item__status"><a href="#">
                                            <svg class="svg-icon ico-basket">
                                                <use xmlns:xlink="http://www.w3.org/1999/xlink"
                                                     xlink:href="/themes/fishmen/assets/css/symbols.svg#ico-basket"></use>
                                            </svg>
                                            <span>Купить</span></a></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<?php //*/ ?>
    <?php if (!empty($oCategory->content->page_body)) { ?>
        <section class="about-section open">
            <div class="container">
                <div class="about-section__wr">
                    <?= $oCategory->content->page_body ?>

                    <div class="about-section__more">
                        <div class="about-section__more-btn">Читать полностью</div>
                    </div>
                </div>
            </div>
        </section>
    <?php } ?>
<?php } ?>

<?php if (0) { ?>
    <div class="page-wrapper">
        <?php
        $breadcrumbs = [];
        $breadcrumbs['Главная'] = '/';
        $breadcrumbs += $oNode->getBreadcrumbs();
        //M::printr($breadcrumbs, '$breadcrumbs');
        ?>

        <div class="breadcrumb-wr">
            <div class="container">
                <div class="breadcrumb">
                    <?php if (isset($breadcrumbs)) { ?>
                        <?php
                        print BreadcrumbsWidget::widget(
                            [
                                //'is_hide_last' => true,
                                'links' => $breadcrumbs,
                            ]
                        );
                        ?><!-- breadcrumbs -->
                    <?php } ?>
                </div>
            </div>
        </div>
        <section class="main-title">
            <div class="container">
                <h1><?php //= $page->page_title ?></h1>
            </div>
        </section>


        <div class="cms-default-index">
            <?php //= common\components\M::printr($this->context, '$this->context');?>
            <h1><?= $oCategory->content->page_title ?></h1>
            <div style="border: 1px solid #000;">
                <ul>
                    <?php foreach ($oChs as $oCh) { ?>
                        <?php $oContent = $oCh->content; ?>
                        <li>
                            <?php
                            //M::printr($oCh->id, '$oCh->id');
                            //$to = Url::to(['page/catalog', 'id' => $oCh->id]);
                            $to = \yii\helpers\Url::toRoute(['/route/catalog', 'id' => $oCh->id]);
                            //M::printr($to, '$to');
                            ?>
                            <a href="<?= $to ?>"><?= !empty($oContent->page_long_title) ? $oContent->page_long_title : $oContent->page_title ?></a>
                        </li>
                    <?php } ?>
                </ul>
            </div>
            <p>
                You may customize this page by editing the following file:<br>
                <code><?= __FILE__ ?></code>
            </p>
        </div>
    </div>
<?php } ?>
