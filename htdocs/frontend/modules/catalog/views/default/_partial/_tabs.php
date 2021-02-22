<?php

use common\components\M;

//получить все одноуровневые товары
$oChProducts = []; //$oCategory->getProducts();
$oComments = []; //$oProduct->getComments();
?>
<section class="main-item-tab">
    <div class="container">
        <div class="main-item-tab__nav">
            <ul role="tablist" class="list clearfix">
                <?php /*/ ?>
                <li role="presentation" class="<?= count($oChProducts) == 1 ? 'hide' : 'active' ?>">
                    <a href="#models" aria-controls="models" role="tab" rel="nofollow" data-toggle="tab"><h2
                                class="h2-tab">Модели <i>(<?= count($oChProducts) - 1 ?>)</i></h2></a>
                </li>
                <?php //*/ ?>
                <li role="presentation" class="active">
                    <a href="#characteristic" aria-controls="characteristic" role="tab" rel="nofollow"
                       data-toggle="tab"><h2 class="h2-tab">Характеристики и описание</h2></a>
                </li>
                <li role="presentation" class="">
                    <a href="#reviews" aria-controls="reviews" role="tab" rel="nofollow" data-toggle="tab">Отзывы
                        <i>(<span class="jsCountComments"><?= count($oComments) ?></span>)</i></a>
                </li>
                <?php /* ?>
                <li role="presentation"><a href="#delivery" aria-controls="delivery" role="tab" data-toggle="tab">Доставка
                        и оплата</a></li>
                <?php */ ?>
            </ul>
        </div>
        <div class="main-item-tab__body">
            <?php /*/ ?>
            <div id="models" role="tabpanel" class="tab-pane <?= count($oChProducts) == 1 ? 'hide' : 'active' ?>">
                <div class="main-item-tab__body-available-models">
                    <div class="main-item-tab__body-available-models-title">
                        <h3>Доступные модели товарной позиции</h3>
                    </div>
                    <div class="main-item-tab__body-available-models-table">
                        <table>
                            <thead>
                            <tr>
                                <td class="available-models-table__model">Наименование / Модель</td>
                                <td class="available-models-table__color">&nbsp;</td>
                                <td class="available-models-table__popular">Популярность</td>
                                <td class="available-models-table__price">Цена</td>
                            </tr>
                            </thead>
                            <tbody>
                            <?php
                            $Cart = (new Cart())->give();
                            //M::printr($Cart, '$Cart');
                            //M::printr($oCategory, '$oCategory');
                            ?>
                            <?php foreach ($oChProducts as $oChProduct) { ?>
                                <?php if ($oChProduct->id == $oProduct->id) continue; ?>
                                <?php
                                $oImgs = $oChProduct->getImgs();
                                $oVendor = $oChProduct->getField('1c_product_vendor');
                                //M::printr($oChProduct, '$oChProduct');
                                $oImages = $oProduct->getImages();
                                $oImg = isset($oImgs[0]) ? $oImgs[0] : false;
                                $oTeaserMicro = $oImg ? $oImg->getCropped('ecm:teaser_micro') : false;
                                //$oImgMicro = isset($oIlls[0]) ? $oIlls[0]->getCropped('ecm') : false;
                                ?>
                                <?php
                                $cart = 0;
                                //получить количество
                                //M::printr($oProduct->productStores, '$oProduct->productStores');
                                $quantity = 0;
                                foreach ($oChProduct->productStores as $oStore) {
                                    $quantity += $oStore->quantity;
                                }

                                //получить цену
                                $price = $oChProduct->product_price;

                                //проверить товары в корзине
                                $inCart = 0;
                                if (isset($Cart->cartProducts[$oChProduct->id])) {
                                    //в корзине
                                    $inCart = 1;
                                }

                                //склад == 1, цена == 1
                                if ($quantity > 0 && $price > 0) {
                                    //купить
                                    $cart = 2;
                                    if ($inCart == 1) {
                                        //в корзине
                                        $cart = 1;
                                    }
                                }
                                //склад == 0, цена == 1
                                if ($quantity == 0 && $price > 0) {
                                    //плд заказ
                                    $cart = 3;
                                    if ($inCart == 1) {
                                        //в корзине
                                        $cart = 1;
                                    }
                                }
                                //склад == 1, цена == 0
                                if ($quantity > 0 && $price == 0) {
                                    //вариант исключен
                                    $cart = 0;
                                    continue;
                                }
                                //склад == 0, цена == 0
                                if ($quantity == 0 && $price == 0) {
                                    //нет в наличии
                                    $cart = 4;
                                    //continue;
                                }
                                //M::printr(['$oChProduct->id' => $oChProduct->id, '$quantity' => $quantity, '$price' => $price, '$cart' => $cart, '$inCart' => $inCart]);
                                //$cart = 2;
                                ?>
                                <tr class="available-models-table__product-item <?php
                                if ($cart == 1) {
                                    print "available-models-table__product-item_in-basket";
                                } elseif ($cart == 2) {
                                    print "";
                                } elseif ($cart == 3) {
                                    print "available-models-table__product-item_order";
                                    //print "";
                                } elseif ($cart == 4) {
                                    print "available-models-table__product-item_not-store";
                                }
                                $product_url = Yii::app()->createUrl('page/product', ['id' => $oChProduct->id]);
                                ?>">
                                    <td class="available-models-table__product clearfix">
                                        <div class="available-models-table__product__ico"><a
                                                    title="<?= $oChProduct->product_long_name ?: $oChProduct->product_name ?>"
                                                    rel="nofollow" href="<?= $product_url ?>">
                                                <img alt="<?= $oChProduct->product_long_name ?: $oChProduct->product_name ?>"
                                                     src="<?= $oTeaserMicro ? '/store' . $oTeaserMicro->fs_alias : '/images/noimg_micro.jpg' ?>"></a>
                                        </div>
                                        <div class="available-models-table__product__ds">
                                            <div class="available-models-table__product__name"><a
                                                        title="<?= $oChProduct->product_long_name ?: $oChProduct->product_name ?>"
                                                        href="<?= $product_url ?>">
                                                    <h4><?= str_replace('"', '&#8243;', $oChProduct->product_long_name ?: $oChProduct->product_name) ?></h4>
                                                </a>
                                            </div>
                                            <?php if (!empty($oVendor->field_value)) { ?>
                                                <div class="available-models-table__product__article">
                                                    Артикул: <?= $oVendor->field_value ?></div>
                                            <?php } ?>
                                        </div>
                                    </td>
                                    <td class="available-models-table__product-code">&nbsp;<br>&nbsp;</td>
                                    <td class="available-models-table__product-popular main-item-ds__main-info-popular">
                                        <ul class="list">
                                            <?php for ($i = 0; $i < 5; $i++) { ?>
                                                <li class="<?= $i < $oChProduct->rating ? 'active' : '' ?>">
                                                    <svg class="svg-icon ico-fish">
                                                        <use xmlns:xlink="http://www.w3.org/1999/xlink"
                                                             xlink:href="/themes/fishmen/assets/css/symbols.svg#ico-fish"></use>
                                                    </svg>
                                                </li>
                                            <?php } ?>
                                        </ul>
                                        <a href="<?= $product_url ?>" rel="nofollow"
                                           title="<?= $oChProduct->product_long_name ?: $oChProduct->product_name ?>"
                                           class="available-models-table__product-popular-num"><?= (int)$oChProduct->rating ?></a>
                                    </td>
                                    <td class="available-models-table__product-price">
                                        <div class="product-item__price">
                                            <?php
                                            $price = $oChProduct->product_new_price ?: $oChProduct->product_price;
                                            $price = number_format($price, 0, ' ', ' ');
                                            ?>
                                            <?php if ($price > 0) { ?>
                                                <?php if ($oChProduct->product_new_price) { ?>
                                                    <div class="product-item__old-price">
                                                        <?= number_format($oChProduct->product_price, 0, '.', ' ') ?> <?= Yii::app()->user->currency ?>
                                                    </div>
                                                <?php } ?>
                                                <div class="product-item__new-price">
                                                    <?= $price ?> <?= Yii::app()->user->currency ?>
                                                </div>
                                            <?php } ?>
                                        </div>

                                        <?php if ($cart == 1) { ?>
                                            <!-- В корзине (желтая корзина) -->
                                            <div class="product-item__status">
                                                <a href="/cart/" rel="nofollow" title="Перейти в корзину">
                                                    <svg class="svg-icon ico-product-in-basket">
                                                        <use xmlns:xlink="http://www.w3.org/1999/xlink"
                                                             xlink:href="/themes/fishmen/assets/css/symbols.svg#ico-product-in-basket"></use>
                                                    </svg>
                                                    <span>Уже в корзине</span>
                                                </a>
                                            </div>
                                        <?php } else if ($cart == 2) { ?>
                                            <!-- Купить (зеленая корзина) -->
                                            <div class="product-item__status">
                                                <a href="#" class="addToCart addTableToCart"
                                                   data-product_id="<?= $oChProduct->id ?>">
                                                    <svg class="svg-icon ico-basket">
                                                        <use xmlns:xlink="http://www.w3.org/1999/xlink"
                                                             xlink:href="/themes/fishmen/assets/css/symbols.svg#ico-basket"></use>
                                                    </svg>
                                                    <span>Купить</span></a>
                                            </div>
                                        <?php } else if ($cart == 3) { ?>
                                            <!-- Под заказ (синяя корзина) -->
                                            <div class="product-item__status">
                                                <a href="#modal-for-order" class="forOrderTable forOrder"
                                                   data-product_id="<?= $oChProduct->id ?>" data-toggle="modal">
                                                    <svg class="svg-icon ico-basket">
                                                        <use xmlns:xlink="http://www.w3.org/1999/xlink"
                                                             xlink:href="/themes/fishmen/assets/css/symbols.svg#ico-basket"></use>
                                                    </svg>
                                                    <span>Под заказ</span></a>
                                            </div>
                                        <?php } else if ($cart == 4) { ?>
                                            <div class="product-item__status">
                                                <svg class="svg-icon ico-basket">
                                                    <use xmlns:xlink="http://www.w3.org/1999/xlink"
                                                         xlink:href="/themes/fishmen/assets/css/symbols.svg#ico-basket"></use>
                                                </svg>
                                                <span>Нет в наличии</span>
                                            </div>
                                        <?php } ?>

                                    </td>
                                </tr>
                            <?php } ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <?php //*/ ?>
            <div id="characteristic" role="tabpanel" class="tab-pane active">
                <div class="main-item-tab__characteristic celarfix">
                    <div class="row main-item-tab__characteristic-row">
                        <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 main-item-tab__characteristic-col">
                            <div class="main-item-tab__characteristic-title">
                                <h3>Характеристики выбранной модели</h3>
                            </div>
                            <div class="main-item-tab__characteristic__table">
                                <?php foreach ($oFields as $oField) { ?>
                                    <?php
                                    if (!$oField->customField->is_visible) continue;
                                    if ($oField->customField->is_permanently) continue;
                                    if ($oField->customField->field_key == '1c_product_vendor') continue;
                                    //M::printr($oField, '$oField');
                                    //continue;
                                    ?>
                                    <div class="main-item-tab__characteristic-table-item">
                                        <div class="main-item-tab__characteristic-table-item-position">
                                            <h4><?= $oField->customField->field_name ?></h4>
                                            <?php if (!empty($oField->customField->field_description)) { ?>
                                                <div class="main-item-tab__characteristic-table-item-position-hint">
                                                    <div class="main-item-tab__characteristic-table-item-position-hint-ico">
                                                        <svg class="svg-icon ico-info">
                                                            <use xmlns:xlink="http://www.w3.org/1999/xlink"
                                                                 xlink:href="/themes/fishmen/assets/css/symbols.svg#ico-info"></use>
                                                        </svg>
                                                    </div>
                                                    <div class="main-item-tab__characteristic-table-item-position-hint-description">
                                                        <?= $oField->customField->field_description ?>
                                                    </div>
                                                </div>
                                            <?php } ?>
                                        </div>
                                        <div class="main-item-tab__characteristic-table-item-conformity"><?=
                                            !empty($oField->customFieldDict) ? $oField->customFieldDict->field_value_view : $oField->field_value ?></div>
                                    </div>
                                <?php } ?>
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 main-item-tab__characteristic-col <?= !empty($oProduct->product_description) ? '' : 'hide' ?>">
                            <div class="main-item-tab__characteristic-title">
                                <h3>Подробное описание</h3>
                            </div>
                            <div class="main-item-tab__characteristic__description">
                                <?= $oProduct->product_description ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div id="reviews" role="tabpanel" class="tab-pane <?= count($oComments) == 1 ? 'active' : '' ?>">
                <div class="main-item-tab__revievs clearfix">
                    <div class="main-item-tab__revievs-new">
                        <div class="main-item-tab__characteristic-title">
                            <h3>Оставьте свой отзыв</h3>
                        </div>
                        <div class="main-item-tab__revievs-new-form">
                        </div>
                    </div>
                    <div class="main-item-tab__revievs-list">
                        <div class="main-item-tab__characteristic-title">
                            <h3>Последние отзывы о товаре</h3>
                        </div>

                        <div class="main-item-tab__revievs-items" id="reviewsBlock">
                            <?php foreach ($oComments as $oComment) { ?>
                                <?php continue; ?>
                                <div class="main-item-tab__revievs-item">
                                    <div class="main-item-tab__revievs-item-info clearfix">
                                        <div class="main-item-tab__revievs-item-info-user">
                                            <div class="main-item-tab__revievs-item-info-user-detail">
                                                <div class="main-item-tab__revievs-item-info-user-detail-time">
                                                    <?= strftime('%d.%m.%Y, %H:%M') ?>
                                                </div>
                                                <div class="main-item-tab__revievs-item-info-user-detail-name">
                                                    <?= $oComment->client->client_view_name ?>
                                                </div>
                                            </div>
                                            <div class="main-item-tab__revievs-item-info-user-popular">
                                                <div class="main-item-ds__main-info-popular">
                                                    <ul class="list">
                                                        <?php for ($i = 0; $i < 5; $i++) { ?>
                                                            <li class="<?= $i < $oComment->rate ? 'active' : '' ?>">
                                                                <svg class="svg-icon ico-fish">
                                                                    <use xmlns:xlink="http://www.w3.org/1999/xlink"
                                                                         xlink:href="/themes/fishmen/assets/css/symbols.svg#ico-fish"></use>
                                                                </svg>
                                                            </li>
                                                        <?php } ?>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="main-item-tab__revievs-item-likes">
                                            <div
                                                    class="main-item-tab__revievs-item-likes-item main-item-tab__revievs-item-likes-item_like">
                                                <svg class="svg-icon ico-like">
                                                    <use xmlns:xlink="http://www.w3.org/1999/xlink"
                                                         xlink:href="/themes/fishmen/assets/css/symbols.svg#ico-like"></use>
                                                </svg>
                                                <span>0</span>
                                            </div>
                                            <div
                                                    class="main-item-tab__revievs-item-likes-item main-item-tab__revievs-item-likes-item_dislike">
                                                <svg class="svg-icon ico-dislike">
                                                    <use xmlns:xlink="http://www.w3.org/1999/xlink"
                                                         xlink:href="/themes/fishmen/assets/css/symbols.svg#ico-dislike"></use>
                                                </svg>
                                                <span>0</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="main-item-tab__revievs-item-text">
                                        <?= $oComment->client_message ?>
                                    </div>
                                    <div class="main-item-tab__revievs-item-advanteges">
                                        <div class="main-item-tab__revievs-item-advanteges-title">
                                            <svg class="svg-icon ico-like">
                                                <use xmlns:xlink="http://www.w3.org/1999/xlink"
                                                     xlink:href="/themes/fishmen/assets/css/symbols.svg#ico-like"></use>
                                            </svg>
                                            <span>Достоинства</span>
                                        </div>
                                        <div class="main-item-tab__revievs-item-advanteges-body">
                                            <?= $oComment->positive ?>
                                        </div>
                                    </div>
                                    <div
                                            class="main-item-tab__revievs-item-advanteges main-item-tab__revievs-item-advanteges_dis">
                                        <div class="main-item-tab__revievs-item-advanteges-title">
                                            <svg class="svg-icon ico-dislike">
                                                <use xmlns:xlink="http://www.w3.org/1999/xlink"
                                                     xlink:href="/themes/fishmen/assets/css/symbols.svg#ico-dislike"></use>
                                            </svg>
                                            <span>Недостатки</span>
                                        </div>
                                        <div class="main-item-tab__revievs-item-advanteges-body">
                                            <?= $oComment->negative ?>
                                        </div>
                                    </div>
                                </div>
                            <?php } ?>
                        </div>

                        <?php if (1) { //(count($oComments) > 0) { ?>
                            <div class="main-item-tab__revievs-items-load">
                                <button class="btn btn_load" id="loadMoreReviews">
                                    <svg class="svg-icon ico-load">
                                        <use xmlns:xlink="http://www.w3.org/1999/xlink"
                                             xlink:href="/themes/fishmen/assets/css/symbols.svg#ico-load"></use>
                                    </svg>
                                    <span>Показать еще</span>
                                </button>
                            </div>
                        <?php } else { ?>
                            <p style="font-size: 1.3em;">Никто не оставлял отзывы о данном товаре. Вы можете стать
                                первым. Заполните форму справа.</p>
                        <?php } ?>
                    </div>
                </div>
            </div>
            <div id="delivery" role="tabpanel" class="tab-pane">
                <div class="main-item-tab__delivery">
                    <?php /*/ ?>
                    <!--h2>Lorem ipsum dolor</h2>

                    <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Excepturi veritatis illo eum
                        necessitatibus, quasi natus, suscipit est reprehenderit autem consectetur ab, accusantium dolore
                        ea optio! Voluptatum odio, consequuntur totam architecto! Lorem ipsum dolor sit amet,
                        consectetur adipisicing elit. Excepturi veritatis illo eum necessitatibus, quasi natus, suscipit
                        est reprehenderit autem consectetur ab, accusantium dolore ea optio! Voluptatum odio,
                        consequuntur totam architecto! Lorem ipsum dolor sit amet, consectetur adipisicing elit.
                        Excepturi veritatis illo eum necessitatibus, quasi natus, suscipit est reprehenderit autem
                        consectetur ab, accusantium dolore ea optio! Voluptatum odio, consequuntur totam architecto!
                        Lorem ipsum dolor sit amet, consectetur adipisicing elit. Excepturi veritatis illo eum
                        necessitatibus, quasi natus, suscipit est reprehenderit autem consectetur ab, accusantium dolore
                        ea optio! Voluptatum odio, consequuntur totam architecto!<br><br>Lorem ipsum dolor sit amet,
                        consectetur adipisicing elit. Excepturi veritatis illo eum necessitatibus, quasi natus, suscipit
                        est reprehenderit autem consectetur ab, accusantium dolore ea optio! Voluptatum odio,
                        consequuntur totam architecto!<br><br>Lorem ipsum dolor sit amet, consectetur adipisicing elit.
                        Excepturi veritatis illo eum necessitatibus, quasi natus, suscipit est reprehenderit autem
                        consectetur ab, accusantium dolore ea optio! Voluptatum odio, consequuntur totam architecto!<br><br>Lorem
                        ipsum dolor sit amet, consectetur adipisicing elit. Excepturi veritatis illo eum necessitatibus,
                        quasi natus, suscipit est reprehenderit autem consectetur ab, accusantium dolore ea optio!
                        Voluptatum odio, consequuntur totam architecto!<br><br><a href="#">Lorem ipsum dolor sit amet,
                            consectetur adipisicing elit.</a> Excepturi veritatis illo eum necessitatibus, quasi natus,
                        suscipit est reprehenderit autem consectetur ab, accusantium dolore ea optio! Voluptatum odio,
                        consequuntur totam architecto!<br><br><b>Lorem ipsum dolor sit amet, consectetur adipisicing
                            elit. Excepturi veritatis illo eum necessitatibus, quasi natus, suscipit est reprehenderit
                            autem consectetur ab, accusantium dolore ea optio! Voluptatum odio, consequuntur totam
                            architecto!</b><br><br>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Excepturi
                        veritatis illo eum necessitatibus, quasi natus, suscipit est reprehenderit autem consectetur ab,
                        accusantium dolore ea optio! Voluptatum odio, consequuntur totam architecto!</p>
                    <ul class="dashed">
                        <li>На эту блесну отлично клюет жерех, язь, голавль и окунь Блесны Silver Bream MS Exceed
                            оснащаются одинарным крючком Vanfook с микробородкой.
                        </li>
                        <li>На эту блесну отлично клюет жерех, язь, голавль и окунь Блесны Silver Bream MS Exceed
                            оснащаются одинарным крючком Vanfook с микробородкой.
                        </li>
                        <li>На эту блесну отлично клюет жерех, язь, голавль и окунь Блесны Silver Bream MS Exceed
                            оснащаются одинарным крючком.
                        </li>
                        <li>На эту блесну отлично клюет жерех, язь, голавль и окунь</li>
                        <li>На эту блесну отлично клюет жерех, язь, голавль и окунь Блесны Silver Bream MS Exceed
                            оснащаются одинарным крючком Vanfook с микробородкой.
                        </li>
                        <li>На эту блесну отлично клюет жерех, язь, голавль и окунь Блесны Silver Bream MS Exceed
                            оснащаются одинарным крючком.
                        </li>
                        <li>На эту блесну отлично клюет жерех, язь, голавль и окунь</li>
                    </ul-->
                    <?php //*/ ?>
                </div>
            </div>
        </div>
        <div id="blueimp-gallery" class="blueimp-gallery blueimp-gallery-controls">
            <div class="slides"></div>
            <div class="title"
                 style="width: 100%; text-align: center;"><?= !empty($oCategory->content->page_longtitle) ? $oCategory->content->page_longtitle : $oCategory->node_name ?></div>
            <a class="prev">‹</a><a class="next">›</a><a class="close">×</a>
        </div>

    </div>
</section>

