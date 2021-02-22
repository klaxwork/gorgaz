<?php
//M::printr($catalogs, '$catalogs');
?>
<section class="main-catalog-slider" style="background-color: #eef0f2;">
    <div class="container">
        <div class="main-product__nav clearfix">
            <div class="main-product__title">Возможно вам пригодится еще...</div>
            <div class="main-product__slider-control">
                <div class="main-product__slider-control-item main-product__slider-control-item_prev pr_prev">
                    <svg class="svg-icon ico-slider-control">
                        <use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#ico-slider-control"></use>
                    </svg>
                </div>
                <div class="main-product__slider-control-item main-product__slider-control-item_next pr_next">
                    <svg class="svg-icon ico-slider-control">
                        <use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#ico-slider-control"></use>
                    </svg>
                </div>
            </div>
        </div>
        <div class="main-product__list">
            <div class="main-product__list-wr">
                <div class="main-product__list-sider">
                    <?php foreach ($catalogs as $catalog) { ?>
                        <?php
                        //M::printr($catalog, '$catalog');
                        if ($catalog['id'] == $oCurrentCategory->id) continue;
                        
                        $price = $catalog['product']['product_new_price'] > 0 ? $catalog['product']['product_new_price'] : $catalog['product']['product_price'];
                        $price = number_format($price, 0, ' ', ' ');
                        ?>
                        <div class="main-product__list-sider-item">
                            <div class="product-item">
                                <div class="product-item__body">
                                    <div class="product-item__fast-info">
                                        <div class="product-item__img">
                                            <a href="<?= $catalog['url'] ?>">
                                                <img src="<?= !empty($catalog['image']) ? '/store' . $catalog['image']['fs_alias'] : '/images/noimg_192.jpg' ?>"
                                                     alt="">
                                            </a>
                                        </div>
                                        <div class="product-item__labels hide">
                                            <?php if (!empty($catalog['product']['is_new'])) { ?>
                                                <div class="product-item__label product-item__label_new">
                                                    <span>Новинка</span>
                                                </div>
                                            <?php } ?>
                                            <?php if (!empty($catalog['product']['is_sale'])) { ?>
                                                <div class="product-item__label product-item__label_sale">
                                                    <span>Распродажа</span>
                                                </div>
                                            <?php } ?>
                                        </div>
                                    </div>
                                    <div class="product-item__name">
                                        <a title="<?= !empty($catalog['content']['page_longtitle']) ? $catalog['content']['page_longtitle'] : $catalog['node_name'] ?>"
                                           href="<?= $catalog['url'] ?>">
                                            <?= !empty($catalog['content']['page_longtitle']) ? $catalog['content']['page_longtitle'] : $catalog['node_name'] ?>
                                        </a>
                                    </div>
                                    <?php if (0) { ?>
                                        <div class="product-item__description">
                                            Плавающий, заглубление до 8.1 метра при троллинге
                                        </div>
                                    <?php } ?>
                                </div>
                                <div class="product-item__foot">
                                    <div class="product-item__purchase clearfix">
                                        <div class="product-item__price">
                                            <div class="product-item__new-price">
                                                от <?= $price ?> <?= Yii::$app->user->currency ?>
                                            </div>
                                        </div>
                                        <div class="product-item__status">
                                            <a href="<?= $catalog['url'] ?>">
                                                <svg class="svg-icon ico-basket">
                                                    <use xmlns:xlink="http://www.w3.org/1999/xlink"
                                                         xlink:href="/themes/fishmen/assets/css/symbols.svg#ico-basket"></use>
                                                </svg>
                                                <span>Купить</span>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php } ?>
                </div>
            </div>
        </div>
    </div>
</section>








