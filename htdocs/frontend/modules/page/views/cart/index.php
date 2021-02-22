<?php

use common\models\Cart;
use common\models\models\CmsTree;
use common\components\M;
use frontend\components\widgets\BreadcrumbsWidget\BreadcrumbsWidget;
use yii\helpers\Url;

$oBlock = CmsTree::getBlock('cart');
$this->context->fillSeo($oBlock);
$Cart = (new Cart())->give();


?>

<?php
$breadcrumbs = [];
$breadcrumbs['Главная'] = '/';
$breadcrumbs['Корзина'] = '/cart/';
?>
<div class="breadcrumb-wr">
    <div class="container">
        <div class="breadcrumb">
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
        <h2>Ваш заказ<span class="aaaxxx"></span></h2>
    </div>
</section>

<section class="your-order">
    <div class="container">
        <div class="your-order__title items-cart">
            <?= $oBlock->page_body ?>
            <?php /*/ ?>
            <div class="your-order__title-main">Уважаемые клиенты! Просим вас обратить особое внимание на следующую
                информацию
            </div>
            <div class="your-order__title-secondary">Минимальная сумма для заказа <b>1500</b> рублей. Доставка возможна
                по всей территории России через транспортные компании или почтовым отправлением первого класса.<br><b>Заказы
                    на сумму более 3000 рублей доставляются бесплатно! </b><a href="#">Подробнее об условиях доставки и
                    оплаты... </a>
            </div>
            <?php //*/ ?>
        </div>
        <?php /*/ ?>
        <?php $form = $this->beginWidget(
            'CActiveForm', array(
                'id' => $formName,
                // Please note: When you enable ajax validation, make sure the corresponding
                // controller action is handling ajax validation correctly.
                // There is a call to performAjaxValidation() commented in generated controller code.
                // See class documentation of CActiveForm for details on this.
                'enableAjaxValidation' => false,
                'action' => \yii\helpers\Url::to(['/page/order']),
            )
        );
        <?php //*/ ?>
        <form action="<?= Url::to(['/page/order/index']) ?>" id="<?= $formName ?>">
            <!--<form id="cart" action="< ?= $this->createUrl('/page/order/order'); ?>">-->
            <div class="your-order__table">
                <table id="cartProducts">
                    <thead>
                    <tr>
                        <td class="your-order__table-goods">Товары / Наименование</td>
                        <td class="your-order__table-price">Цена</td>
                        <td class="your-order__table-number">Количество</td>
                        <td class="your-order__table-summ">Сумма</td>
                        <td class="your-order__table-delete"></td>
                    </tr>
                    </thead>
                    <tbody>
                    <?php foreach ($Cart->cartProducts as $oCartProduct) { ?>
                        <?php
                        $oProduct = $oCartProduct->product;
                        if (empty($oProduct)) {
                            continue;
                        }
                        $oCategory = $oProduct->appProduct->tree;
                        $oImgs = $oCategory->content->getImages();
                        $oImg = isset($oImgs[0]) ? $oImgs[0] : false;
                        $img_path = '/images/noimg_micro.jpg';
                        if (!empty($oImg)) {
                            $oTeaserMicro = $oImg->getCropped('ecm:teaser_micro');
                            if (!empty($oTeaserMicro)) {
                                $img_path = '/store' . $oTeaserMicro->fs_alias;
                            }
                            //M::printr($img, '$img');
                        }
                        $oVendor = $oProduct->getField('1c_product_vendor');
                        $oLabels = $oProduct->getLabels();
                        ?>
                        <tr data-id="<?= $oProduct->id ?>" class="table-item">
                            <input type="hidden" id="<?= $formName ?>_Products_<?= $oProduct->id ?>_ecm_products_ref"
                                   name="Products[<?= $oProduct->id ?>][ecm_products_ref]" value="<?= $oProduct->id ?>">
                            <!-- -->
                            <td class="your-order__table-goods-item">
                                <div class="your-order__table-goods-item-ico"><a
                                            href="<?= Url::to(['/route/product', 'id' => $oProduct->id]) ?>"
                                            target="<?= $oProduct->id ?>"><img
                                                src="<?= $img_path ?>" alt=""></a></div>
                                <div class="your-order__table-goods-item-name">
                                    <a href="<?= Url::to(['/route/product', 'id' => $oProduct->id]) ?>"
                                       target="<?= $oProduct->id ?>"><?= $oProduct->product_long_name ?: $oProduct->product_name ?></a>
                                </div>
                                <div class="your-order__table-goods-item-article">
                                    Артикул: <?= $oVendor->field_value ?></div>
                            </td>
                            <td class="your-order__table-price-item">
                                <div class="your-order__table-price-item-number">
                                    <span class="price-item"><?= !empty($oLabels['is_sale']) ? $oProduct->product_new_price : $oProduct->product_price ?></span>
                                    <?= Yii::$app->user->currency ?>
                                </div>
                                <!--<div class="your-order__table-price-item-bonus">+12 бонусов</div>-->
                            </td>
                            <td class="your-order__table-number-item">
                                <div class="number-choser">
                                    <div class="number-choser__input">
                                        <input type="number"
                                               id="<?= $formName ?>_Products_<?= $oProduct->id ?>_quantity"
                                               name="Products[<?= $oProduct->id ?>][quantity]"
                                               value="<?= $oCartProduct->quantity ?>"
                                               class="main-input quantity_product">
                                    </div>
                                    <div class="number-choser__btn"><i class="plus"></i><i class="minus"></i></div>
                                </div>
                            </td>
                            <td class="your-order__table-summ-item">
                                <span class="summ-item"><?= $oCartProduct->quantity * $oProduct->product_price ?></span> <?= Yii::$app->user->currency ?>
                            </td>
                            <td class="your-order__table-delete-item">
                                <div class="your-order__table-delete-item-btn remove-item"></div>
                            </td>
                        </tr>
                    <?php } ?>
                    </tbody>

                </table>
            </div>
            <div class="your-order__caption">
                <div class="row">
                    <div class="col-md-6 col-xs-12">
                        <div class="your-order__caption-code hide">
                            <div class="your-order__caption-code-title"><a href="#">У меня есть «секретный код» или
                                    сертификат!</a></div>
                            <div class="your-order__caption-code-caption">Введите ваш код прейдя по ссылке выше ↑</div>
                        </div>
                    </div>
                    <div class="col-md-6 col-xs-12">
                        <div class="your-order__caption-total">
                            <div class="your-order__caption-total-subtotal">
                                <div class="your-order__caption-total-subtotal-title"><span>Предитог:</span><a
                                            href="javascript:void(0);" id="clearCart">Очистить корзину</a></div>
                                <div class="your-order__caption-total-subtotal-number">
                                    <div class="your-order__caption-total-subtotal-number-price"><span
                                                class="summ-total">0</span> <?= Yii::$app->user->currency ?></div>
                                    <div class="your-order__caption-total-subtotal-number-article hide">+120 бонусов
                                    </div>
                                </div>
                            </div>
                            <!-- -- >
                            <div class="your-order__caption-total-payment-bonuses hide">
                                <div class="your-order__caption-total-payment-bonuses-title clearfix">
                                    <div class="your-order__caption-total-payment-bonuses-title-bn"><b>Оплата бонусами</b>
                                    </div>
                                    <div class="your-order__caption-total-payment-bonuses-title-equality">1 бонус = 1 рубль
                                    </div>
                                </div>
                                <div class="your-order__caption-total-payment-bonuses-description">У вас есть <b>500
                                        бонусов</b><br>Вы можете потратить максимум 300 бонусов в качестве скидки за ваш
                                    заказ.
                                </div>
                                <div class="your-order__caption-total-payment-bonuses-calculate"><b>Использовать</b>
                                    <div class="your-order__caption-total-payment-bonuses-calculate-input">
                                        <input type="number" class="main-input main-input_rw">
                                    </div>
                                    <span>бонусов</span>
                                    <button class="btn btn_use-bonuses">Применить</button>
                                </div>
                            </div>
                            <!-- -->
                            <div class="your-order__caption-total-sett-list">
                                <ul class="list">
                                    <li>Количество товаров в заказе: <b
                                                class="count-items"><?= count($Cart->cartProducts) ?></b></li>
                                    <li class="hide">Использовано бонусов: <b>-120 бонусов</b></li>
                                    <li class="hide">Скидка по промо-коду: <b>-15% (150 руб.)</b></li>
                                </ul>
                            </div>
                            <div class="your-order__caption-total-price">
                                <div class="your-order__caption-total-price-title"><span>Итого</span><span>без учета
									доставки:</span></div>
                                <div class="your-order__caption-total-price-num-sub">
                                    <div class="your-order__caption-total-price-number "><span
                                                class="summ-total">0</span> <?= Yii::$app->user->currency ?>
                                    </div>
                                    <div class="your-order__caption-total-price-submit">
                                        <button type="submit" class="btn btn_standart back">Оформить заказ</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!--</form>-->
        </form>
        <?php //$this->endWidget(); ?>
    </div>
</section>

<script>
    var SummAll = 0;

    function setProduct(id, quantity) {
        var url = '<?= Url::to(['/page/cart/set-product', 'id' => '__id__', 'quantity' => '__quantity__']) ?>'.replace('__id__', id).replace('__quantity__', quantity);
        $.ajax({
            url: url,
            type: 'POST',
            dataType: 'json'
        }).success(function (response) {
            if (response.success == true) {
                //ошибок нет
                //console.log(response);
                //console.log('Ok');
            } else {
                //ошибки есть
                //$('#errors').empty().append(printrErrors(response.errors));
                //$('#submit').prop('disabled', false);
            }
        }).error(function (data, key, value) {
            return false;
            //after_send(data);
        });
    }

    function clearCart() {
        var url = '<?= Url::to(['/page/cart/clearCart'])?>';
        $.ajax({
            url: url,
            type: 'POST',
            dataType: 'json'
        }).success(function (response) {
            if (response.success == true) {
                //ошибок нет
                console.log(response);
                $('#cartProducts').find('tbody tr').remove();
                calculate();
                //console.log('Ok');
            } else {
                //ошибки есть
                //$('#errors').empty().append(printrErrors(response.errors));
                //$('#submit').prop('disabled', false);
            }
        }).error(function (data, key, value) {
            return false;
            //after_send(data);
        });
    }

    //посчитать сумму цен
    function calculate() {
        console.log('calculate');
        var $items = $('.table-item');
        var summAll = 0;
        var $countItems = 0;
        $items.each(function (i, element) {
            var price = $(element).find('.price-item').text();
            var quantity = $(element).find('.quantity_product').val();
            var summ = price * quantity;
            $(element).find('.summ-item').text(summ);
            summAll += summ;
            $countItems++;
        });
        $('.summ-total').text(summAll);
        SummAll = summAll;
        $('.count-items').text(declOfNum($countItems, ['товар', 'товара', 'товаров']));
        $('.your-order__caption-total-sett-list .count-items').text($countItems);
    }

    $(document).ready(function () {
        //увеличить количество
        $('.number-choser .plus').on('click', function (e) {
            var id = $(this).closest('tr').data('id');
            var quantity = $(this).closest('tr').find('.quantity_product').val();
            calculate();
            setProduct(id, quantity);
        });

        //уменьшить количество
        $('.number-choser .minus').on('click', function (e) {
            var id = $(this).closest('tr').data('id');
            var quantity = $(this).closest('tr').find('.quantity_product').val();
            calculate();
            setProduct(id, quantity);
        });

        //установить количество, введенное вручную
        $('.quantity_product').on('change keyup', function () {
            var id = $(this).closest('tr').data('id');
            var quantity = $(this).closest('tr').find('.quantity_product').val();
            calculate();
            setProduct(id, quantity);
        });

        //удалить товар из корзины
        $('.remove-item').on('click', function (e) {
            var id = $(this).closest('tr').data('id');
            var quantity = 0;
            $(this).closest('tr').remove();
            calculate();
            setProduct(id, quantity);
        });

        $('.your-order__caption-total-price-submit').on('click', function (e) {
            //ограничение минимума суммы заказа
            if (Number(SummAll) < 1500) {
                e.preventDefault();
                console.log('[SummAll]', SummAll);
                $('#modal-summ-small').modal('show');
            } else {
                $('button').html('<img src="/images/preloader3.gif">');
            }
        });

        $('#clearCart').on('click', function (e) {
            e.preventDefault();
            clearCart();
        });

        calculate();
    });
</script>

