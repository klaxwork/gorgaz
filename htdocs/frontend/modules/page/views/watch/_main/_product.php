<?php

use \yii\helpers\Url;

?>
<section class="main-product">
    <div class="container">
        <div class="main-product__nav clearfix">
            <h2 class="main-product__title">Акционные товары. Распродажа</h2>

            <div class="main-product__slider-control">
                <div class="main-product__slider-control-item main-product__slider-control-item_prev pr_prev">
                    <svg class="svg-icon ico-slider-control">
                        <use xmlns:xlink="http://www.w3.org/1999/xlink"
                             xlink:href="/themes/fishmen/assets/css/symbols.svg#ico-slider-control"></use>
                    </svg>
                </div>
                <div class="main-product__slider-control-item main-product__slider-control-item_next pr_next">
                    <svg class="svg-icon ico-slider-control">
                        <use xmlns:xlink="http://www.w3.org/1999/xlink"
                             xlink:href="/themes/fishmen/assets/css/symbols.svg#ico-slider-control"></use>
                    </svg>
                </div>
            </div>
            <div class="main-product__all-product"><a
                        href="/catalog/"
                        title="Каталог товаров">Смотреть все предложения</a></div>
        </div>
        <div class="filters-catalog__list block-items-visible" style="margin-top: 20px; width: 100%;">
            <div class="filters-catalog__items clearfix" id="products">
                <?php
                print $cards;
                if (0) {
                    $this->widget(
                        'application.widgets.CatalogsCards.CatalogsCardsWidget',
                        array(
                            'catalogs' => $catalogs,
                        )
                    );
                }
                if (0) {
                    $this->widget(
                        'application.widgets.TeaserForFilter.TeaserForFilterWidget',
                        array(
                            'catalogs' => $catalogs,
                        )
                    );
                }
                ?>
            </div>
        </div>
        <div class="main-product__list">
            <div class="main-product__list-wr">
                <div class="main-product__list-sider">
                    <?php
                    if (0) {
                        //M::printr($catalogs, '$catalogs');
                        $this->widget(
                            'application.widgets.TeaserForFilter.TeaserForFilterWidget',
                            array(
                                'catalogs' => $catalogs,
                            )
                        );
                    }

                    if (0) {
                        $this->widget(
                            'application.widgets.TeaserForMainPage.TeaserForMainPageWidget',
                            array(
                                'products' => $oProducts,
                                'category' => $oCategories
                            )
                        );
                    }
                    ?>
                </div>
            </div>
        </div>
        <?php /* ?>
<div class="main-product__list">
<div class="main-product__list-wr">
<div class="main-product__list-sider">
<?php $c = 0; ?>
<?php for ($i = 0; $i < count($oProducts); $i++) { ?>
<div class="main-product__list-sider-item">
<?php if (isset($oProducts[$i])) {
$this->widget(
'application.widgets.TeaserMain.TeaserMainWidget',
array(
'product' => $oProducts[$i]
)
);
?>
<?php } ?>
<?php $i++; ?>
<?php if (isset($oProducts[$i])) {
$this->widget(
'application.widgets.TeaserMain.TeaserMainWidget',
array(
'product' => $oProducts[$i]
)
);
?>
<?php } ?>
</div>
<?php } ?>
</div>
</div>
</div>
<?php */ ?>
        <div class="main-product__catalog"><a
                    href="/catalog/" class="btn btn_catalog"
                    title="Каталог товаров"><span>Все предложения</span>
                <svg class="svg-icon ico-arrow">
                    <use xmlns:xlink="http://www.w3.org/1999/xlink"
                         xlink:href="/themes/fishmen/assets/css/symbols.svg#ico-arrow"></use>
                </svg>
            </a>
        </div>
    </div>
</section>

<div id="templateInBasket" class="hide">
    <a href="/cart/" rel="nofollow" title="Перейти в корзину">
        <svg class="svg-icon ico-product-in-basket">
            <use xmlns:xlink="http://www.w3.org/1999/xlink"
                 xlink:href="/themes/fishmen/assets/css/symbols.svg#ico-product-in-basket"></use>
        </svg>
        <span>В корзине</span>
    </a>
</div>

<script>
    $(document).ready(function () {
        $('[data-target ^= to-]').on('click', function (e) {
            if (e != undefined) {
                e.preventDefault();
            }
            var pre_target = $(this).data('target');
            var target = pre_target.substr(3);
            var $href = $('[href = #' + target + ']');
            $href.trigger('click');
            $('html, body').stop().animate({
                scrollTop: $href.offset().top - 80
            }, 1000);
        });

        $('body').on('click', '.addToCart', function (e) {
            $(this).closest('.product-item').addClass('product-item_in-basket');
            var $temp = $('#templateInBasket').html();
            $(this).closest('.product-item__status').html($temp);
        });
    });
</script>