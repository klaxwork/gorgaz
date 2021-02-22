<?php

use common\components\M;
use common\models\models\CmsTree;
use frontend\components\widgets\BreadcrumbsWidget\BreadcrumbsWidget;
use frontend\components\widgets\CatalogCardWidget\CatalogCardWidget;
use yii\helpers\Url;
use common\models\Wish;

$oCategory = CmsTree::getCategoryByAlias('wishes');
$this->context->fillSeo($oCategory->content);
$oWish = (new Wish())->give();
$wishProducts = $oWish->wishProducts;
?>
<div class="breadcrumb-wr">
    <div class="container">
        <div class="breadcrumb">
            <?php
            $breadcrumbs = [];
            $breadcrumbs['Главная'] = '/';
            $breadcrumbs['Закладки'] = Url::to(['/page/wish']);
            //$breadcrumbs[] = $oProduct->product_name;
            //M::printr($breadcrumbs, '$breadcrumbs');
            ?>
            <?php if (isset($breadcrumbs)) { ?>
                <!-- breadcrumbs -->
                <?= BreadcrumbsWidget::widget(
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

<section class="main-title">
    <div class="container">
        <h2><?= $oCategory->content ? ($oCategory->content->page_longtitle ?: $oCategory->content->page_title) : $oCategory->node_name ?></h2>
    </div>
</section>

<section class="your-order">
    <div class="container">
        <?php if (!empty($oCategory->content)) { ?>
            <div class="your-order__title" style="margin-bottom: 20px;">
                <?= $oCategory->content->page_body ?>
            </div>
        <?php } ?>

        <div class="block-items-visible items-wishes">
            <?php
            ?>
            <?php foreach ($wishProducts as $wishProduct) { ?>
                <?php
                $oProduct = $wishProduct->product;
                $oAppProduct = $oProduct->appProduct;
                if (empty($oAppProduct)) continue;
                $oNode = $oAppProduct->tree;
                if (empty($oNode)) continue;
                $oContent = $oNode->content;
                $oImages = $oContent->getImages();
                $imgUrl = '/images/noimg_192.jpg';
                if (!empty($oImages[0])) {
                    $oImage = $oImages[0]->getCropped('ecm:teaser_small');
                    $imgUrl = '/store' . $oImage->fs_alias;
                }
                $card = [
                    'catalog' => $oNode->id,
                    'url' => Url::to(['/route/catalog', 'id' => $oNode->id]),
                    'imgUrl' => $imgUrl,
                    'name' => !empty($oContent->page_longtitle) ? $oContent->page_longtitle : $oContent->page_title,
                    'price' => $oProduct->product_price,
                    'count' => 1,
                ];
                ?>
                <?= CatalogCardWidget::Widget(
                    [
                        'card' => $card,
                    ]
                ); ?>
            <?php } ?>
        </div>

        <?php if (!empty($wishProducts)) { ?>
            <div class="clearfix" id="clearfix" style="text-align: center; width: 100%;">
                <p>
                <span class="btn btn__wish-to-cart" id="WishToCart">
                    <svg class="svg-icon ico-basket">
                        <use xmlns:xlink="http://www.w3.org/1999/xlink"
                             xlink:href="/themes/fishmen/assets/css/symbols.svg#ico-basket"></use>
                    </svg>
                    <span>Добавить все в корзину</span>
                </span>
                </p>

                <p>
                    <span class="clear-wish" id="ClearWish"><u>Очистить список закладок</u></span>
                </p>
            </div>
        <?php } ?>

    </div>
</section>

<script>
    function ClearWish() {
        var url = '<?= Url::to('/page/wish/clearWish')?>';
        $.ajax({
            url: url,
            type: 'POST',
            dataType: 'json'
        }).success(function (response) {
            if (response.success == true) {
                //ошибок нет
                $('.block-items-visible').text('');
                $('.wishesCount').text(0);
            } else {
                //ошибки есть
                //$('#errors').empty().append(printrErrors(response.errors));
                //$('#submit').prop('disabled', false);
            }
        }).error(function (data, key, value) {
            return false;
        });
    }

    function WishToCart() {
        //console.log('WishToCart()');
        var url = '<?= Url::to('/page/wish/wishToCart')?>';
        $.ajax({
            url: url,
            type: 'POST',
            dataType: 'json'
        }).success(function (response) {
            if (response.success == true) {
                //console.log('WishToCart().success');
                //ошибок нет
                //$('.block-items-visible').text('');
                //$('.wishesCount').text(0);
                window.location = '<?= Url::to('/page/cart') ?>';
            } else {
                //ошибки есть
                //$('#errors').empty().append(printrErrors(response.errors));
                //$('#submit').prop('disabled', false);
            }
        }).error(function (data, key, value) {
            return false;
        });
    }

    $(document).ready(function () {

        $('#ClearWish').on('click', function (e) {
            e.preventDefault();
            ClearWish();
            $('#clearfix').hide();
        });

        $('#WishToCart').on('click', function (e) {
            e.preventDefault();
            WishToCart();
            $('#clearfix').hide();
        });
    });
</script>

