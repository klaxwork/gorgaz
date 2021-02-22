<?php
$oBlock = \common\models\models\CmsTree::getBlock('order');
$this->context->fillSeo($oBlock);
$Cart = (new \common\models\Cart())->give();
?>
<div class="breadcrumb-wr">
    <div class="container">
        <div class="breadcrumb">
            <?php
            $breadcrumbs = [];
            $breadcrumbs['Главная'] = '/';
            $breadcrumbs['Корзина'] = \yii\helpers\Url::to(['/page/cart']);
            $breadcrumbs['Оформление заказа'] = \yii\helpers\Url::to(['/page/order']);
            //$breadcrumbs[] = $oProduct->product_name;
            //M::printr($breadcrumbs, '$breadcrumbs');
            ?>
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
<section class="main-title">
    <div class="container">
        <h2>Оформление заказа</h2>
    </div>
</section>
<section class="your-order">
    <div class="container">
        <div class="your-order__title">
            <?= $oBlock->page_body ?>
            <?php /*/ ?>
            <div class="your-order__title-main">Уважаемые клиенты! Просим вас обратить особое внимание на следующую
                информацию
            </div>
            <div class="your-order__title-secondary">Минимальная сумма для заказа <b>1500 </b>рублей. Доставка возможна
                по всей территории России через транспортные компании или почтовым отправлением первого класса.<br><b>Заказы
                    на сумму более 3000 рублей доставляются бесплатно! </b><a href="#">Подробнее об условиях доставки и
                    оплаты...</a>
            </div>
            <?php //*/ ?>
        </div>
    </div>
</section>
<section class="basket-step">
    <div class="container">
        <?php /*/ ?>
        <?php $form = $this->beginWidget(
            'CActiveForm', array(
                'id' => $formName,
                // Please note: When you enable ajax validation, make sure the corresponding
                // controller action is handling ajax validation correctly.
                // There is a call to performAjaxValidation() commented in generated controller code.
                // See class documentation of CActiveForm for details on this.
                'enableAjaxValidation' => false,
                'action' => $this->createUrl('/page/order'),
            )
        );
        ?>
        <?php //*/ ?>
        <form action="<?= \yii\helpers\Url::to(['/page/order']) ?>" id="<?= $formName ?>">
            <div class="basket-step__item">
                <div class="basket-step__item-title">Кому доставляем?</div>
                <div class="basket-step__whom-deliver">
                    <div class="basket-step__whom-deliver-items">
                        <div class="basket-step__whom-deliver-item">
                            <div class="basket-step__whom-deliver-name"><span>Ваше имя<i class="star">*</i></span></div>
                            <div class="basket-step__whom-deliver-input">
                                <div class="basket-step__whom-deliver-input-wr">
                                    <input type="text" class="main-input main-input_bk"
                                           name="<?= $formName ?>[first_name]"
                                           id="<?= $formName ?>_first_name">
                                </div>
                            </div>
                        </div>
                        <div class="basket-step__whom-deliver-item">
                            <div class="basket-step__whom-deliver-name"><span>Фамилия<i class="star hide">*</i></span>
                            </div>
                            <div class="basket-step__whom-deliver-input">
                                <div class="basket-step__whom-deliver-input-wr">
                                    <input type="text" class="main-input main-input_bk"
                                           name="<?= $formName ?>[family_name]">
                                </div>
                            </div>
                        </div>
                        <div class="basket-step__whom-deliver-item">
                            <div class="basket-step__whom-deliver-name"><span>Отчество<i
                                            class="star hide">*</i></span><i>(Если
                                    есть)</i></div>
                            <div class="basket-step__whom-deliver-input">
                                <div class="basket-step__whom-deliver-input-wr">
                                    <input type="text" class="main-input main-input_bk"
                                           name="<?= $formName ?>[second_name]">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="basket-step__whom-deliver-items">
                        <div class="basket-step__whom-deliver-item">
                            <div class="basket-step__whom-deliver-name"><span>Телефон<i class="star">*</i></span><i>(Для
                                    подтверждения и отправки уведомлений о статусе заказа)</i></div>
                            <div class="basket-step__whom-deliver-input">
                                <div class="basket-step__whom-deliver-input-wr">
                                    <input type="text" class="main-input main-input_bk"
                                           name="<?= $formName ?>[phone]"
                                           id="<?= $formName ?>_phone">
                                </div>
                                <div class="basket-step__whom-deliver-ckeck-wr">
                                    <div class="filters-catalog__filter-item-check-item">
                                        <label> <input type="checkbox" name="<?= $formName ?>[phone_notify]"><span>Бесплатные
                                            уведомления о статусе Вашего заказа</span> </label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="basket-step__whom-deliver-item">
                            <div class="basket-step__whom-deliver-name"><span>E-mail @<i
                                            class="star hide">*</i></span><i>(Для
                                    отправки уведомлений о статусе заказа)</i></div>
                            <div class="basket-step__whom-deliver-input">
                                <div class="basket-step__whom-deliver-input-wr">
                                    <input type="text" class="main-input main-input_bk"
                                           name="<?= $formName ?>[email]">
                                </div>
                                <div class="basket-step__whom-deliver-ckeck-wr">
                                    <div class="filters-catalog__filter-item-check-item">
                                        <label> <input type="checkbox" name="<?= $formName ?>[email_notify]"><span>Подписаться
                                            на информационные рассылки</span> </label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="basket-step__item" id="delivery_types">
                <div class="basket-step__item-title">Выберите способ и укажите адрес для доставки</div>
                <div class="basket-step__item-delivery">
                    <div class="basket-step__item-delivery-itms">
                        <div class="basket-step__item-delivery-itm">
                            <div class="basket-standart-radio">
                                <label>
                                    <input type="radio" name="<?= $formName ?>[delivery_type]" value="transport"
                                           data-content="2" class="delivery_type" data-text="Транспортной компанией">
                                    <span class="basket-standart-radio__content"><span>Транспортной компанией</span><i>(СДЭК, DPD)</i></span>
                                </label>
                            </div>
                        </div>
                        <div class="basket-step__item-delivery-itm">
                            <div class="basket-standart-radio">
                                <label>
                                    <input type="radio" name="<?= $formName ?>[delivery_type]" value="russian-post"
                                           data-cost="<?= $deliveryList['russian-post']['defaultCost'] ?>"
                                           data-content="3" class="delivery_type delivery" data-text="Почта России">
                                    <span class="basket-standart-radio__content"><span>Почта России</span></span>
                                </label>
                            </div>
                        </div>
                        <div class="basket-step__item-delivery-itm">
                            <div class="basket-standart-radio">
                                <label>
                                    <input type="radio" name="<?= $formName ?>[delivery_type]" value="courier-yar"
                                           data-cost="<?= $deliveryList['courier-yar']['defaultCost'] ?>"
                                           data-content="1" class="delivery_type delivery"
                                           data-text="Курьером до двери">
                                    <span class="basket-standart-radio__content"><span>Курьером по Ярославлю</span><i>200 руб.</i><i
                                                class="hide">(Доставка до двери, 3-5 дней)</i></span>
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="basket-step__item-delivery-itm-content">
                        <div data-ct="1" class="basket-step__item-delivery-itm-content-unit active">
                        </div>
                        <div data-ct="2" class="basket-step__item-delivery-itm-content-unit">
                            <div class="basket-standart-radio">
                                <label> <input type="radio" name="<?= $formName ?>[delivery]" value="sdek"
                                               data-cost="<?= $deliveryList['sdek']['defaultCost'] ?>"
                                               class="delivery"><span class="basket-standart-radio__content"><span
                                                class="basket-standart-radio__content-img"><img
                                                    src="/images/sdek.png" alt=""></span><span
                                                class="basket-standart-radio__content-caption"><span>СДЭК, <b><?= $deliveryList['sdek']['defaultCost'] ?>
                                                    руб.</b></span><i>Сроки доставки: 2-5 дней</i></span></span>
                                </label>
                            </div>
                            <div class="basket-standart-radio">
                                <label> <input type="radio" name="<?= $formName ?>[delivery]" value="dpd"
                                               data-cost="<?= $deliveryList['dpd']['defaultCost'] ?>"
                                               class="delivery"><span class="basket-standart-radio__content"><span
                                                class="basket-standart-radio__content-img"><img
                                                    src="/images/dpd.png" alt=""></span><span
                                                class="basket-standart-radio__content-caption"><span>DPD, <b><?= $deliveryList['dpd']['defaultCost'] ?>
                                                    руб.</b></span><i>Сроки доставки: 2-5 дней</i></span></span>
                                </label>
                            </div>
                        </div>
                        <div data-ct="3" class="basket-step__item-delivery-itm-content-unit"></div>
                    </div>
                </div>
            </div>
            <!--<a id="anchorName" href="#anchorName"></a>-->
            <div class="basket-step__item">
                <div class="basket-step__item-sity">
                    <div class="basket-step__item-sity-chose">Выбранный город:<i class="star">*</i>
                        <a class="select_city" id="select_city_button">
                            <?php
                            $cookies = Yii::$app->request->cookies;
                            $city_name = $cookies->getValue('gorod', 'Москва');
                            ?>
                            <?= $city_name ?>
                        </a>
                        <input id="city_name" type="hidden" name="<?= $formName ?>[city]" value="<?= $city_name ?>">
                    </div>
                    <div class="basket-step__item-sity-caption">Укажите ваш город для расчетa доставки ↑</div>
                </div>
                <div class="basket-step__whom-deliver-items">
                    <div class="basket-step__whom-deliver-item" id="pole_city">
                        <!--
                        <div class="basket-step__whom-deliver-name"><span>Город / Населеный пункт<i
                                        class="star hide">*</i></span><i>(Измените, если выбрано не верно)</i></div>
                        <div class="basket-step__whom-deliver-input">
                            <div class="basket-step__whom-deliver-input-wr">
                                <input type="text" class="main-input main-input_bk"
                                       name="<?= $formName ?>[city]"
                                       id="form-city">
                            </div>
                        </div>
                        -->
                    </div>
                    <?php if (!empty($city_name)) { ?>
                        <input type="hidden" name="<?= $formName ?>[city]" id="city" value="<?= $city_name ?>">
                    <?php } ?>
                    <div class="basket-step__whom-deliver-item" id="selfget">
                        <div class="basket-step__whom-deliver-name"><span>Адрес</span><i>(Улица,
                                дом / строение, квартира, офис и т.д.)</i></div>
                        <div class="basket-step__whom-deliver-input">
                            <div class="basket-step__whom-deliver-unit">
                                <div class="basket-step__whom-deliver-input-wr basket-step__whom-deliver-input-wr_street">
                                    <input type="text" class="main-input main-input_bk"
                                           name="<?= $formName ?>[street]"
                                           id="form-street">
                                </div>
                                <div class="basket-step__whom-deliver-unit-ds">Улица</div>
                            </div>
                            <div class="basket-step__whom-deliver-unit">
                                <div class="basket-step__whom-deliver-input-wr basket-step__whom-deliver-input-wr_home">
                                    <input type="text" class="main-input main-input_bk"
                                           name="<?= $formName ?>[building]"
                                           id="form-house">
                                </div>
                                <div class="basket-step__whom-deliver-unit-ds">Дом / Строение</div>
                            </div>
                            <div class="basket-step__whom-deliver-unit">
                                <div class="basket-step__whom-deliver-input-wr basket-step__whom-deliver-input-wr_flat">
                                    <input type="text" class="main-input main-input_bk" name="<?= $formName ?>[flat]">
                                </div>
                                <div class="basket-step__whom-deliver-unit-ds">Квартира / Офис</div>
                            </div>
                            <div class="basket-step__whom-deliver-unit">
                                <div class="basket-step__whom-deliver-input-wr basket-step__whom-deliver-input-wr_index">
                                    <input type="text" class="main-input main-input_bk"
                                           name="<?= $formName ?>[post_index]">
                                </div>
                                <div class="basket-step__whom-deliver-unit-ds">Почтовый индекс</div>
                            </div>
                        </div>
                    </div>
                    <div class="basket-step__whom-deliver-item">
                        <div class="basket-step__whom-deliver-name"><span>Комментарий</span><i>(Дополнительная
                                информация для вашего заказа)</i></div>
                        <div class="basket-step__whom-deliver-input">
                            <div class="basket-step__whom-deliver-input-wr basket-step__whom-deliver-input-wr_textarea">
                                <textarea class="textarea textarea_rw"
                                          name="<?= $formName ?>[client_comment]"></textarea>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="basket-step__item" id="payment_types">
                <div class="basket-step__item-title">Варианты оплаты заказа</div>
                <div class="basket-step__payment-variant">
                    <div class="basket-step__payment-variant-item">
                        <label>
                            <input type="radio" name="<?= $formName ?>[payment_type]" class="payment_type"
                                   value="bank-card" data-text="Банковской картой">
                            <span class="basket-step__payment-variant-item-content">
                            <span class="basket-step__payment-variant-item-content-img">
                                <img src="/images/mn2.png" alt="">
                            </span>
                            <span class="basket-step__payment-variant-item-content-caption">Банковской картой</span>
                        </span>
                        </label>
                    </div>
                    <div class="basket-step__payment-variant-item">
                        <label>
                            <input type="radio" name="<?= $formName ?>[payment_type]" class="payment_type" value="cash"
                                   data-text="Оплата наличными">
                            <span class="basket-step__payment-variant-item-content">
                            <span class="basket-step__payment-variant-item-content-img">
                                <img src="/images/mn1.png" alt="">
                            </span>
                            <span class="basket-step__payment-variant-item-content-caption">Наложенный платеж</span>
                        </span>
                        </label>
                    </div>
                    <?php /*/ ?>
                <div class="basket-step__payment-variant-item">
                    <label>
                        <input type="radio" name="<?= $formName ?>[payment_type]" class="payment_type"
                               value="bank-card" data-text="Карта MasterCard">
                        <span class="basket-step__payment-variant-item-content">
                            <span class="basket-step__payment-variant-item-content-img">
                                <img src="/images/mn3.png" alt="">
                            </span>
                            <span class="basket-step__payment-variant-item-content-caption">Карта MasterCard</span>
                        </span>
                    </label>
                </div>
                <?php //*/ ?>

                    <!--<div class="basket-step__payment-variant-item">
                    <label> <input type="radio" name="<?= $formName ?>[payment_type]" class="payment_type" value="Electron"
                                   data-text="Карта Electron"><span
                                class="basket-step__payment-variant-item-content"><span
                                    class="basket-step__payment-variant-item-content-img"><img
                                        src="/images/mn4.png" alt=""></span><span
                                    class="basket-step__payment-variant-item-content-caption">Картой
                                Electron</span></span> </label>
                </div>
                <div class="basket-step__payment-variant-item">
                    <label> <input type="radio" name="<?= $formName ?>[payment_type]" class="payment_type" value="Yandex.Money"
                                   data-text="Яндекс.Деньги"><span
                                class="basket-step__payment-variant-item-content"><span
                                    class="basket-step__payment-variant-item-content-img"><img
                                        src="/images/mn5.png" alt=""></span><span
                                    class="basket-step__payment-variant-item-content-caption">Яндекс.Деньги</span></span>
                    </label>
                </div>
                <div class="basket-step__payment-variant-item">
                    <label> <input type="radio" name="<?= $formName ?>[payment_type]" class="payment_type" value="QIWI"
                                   data-text="QIWI кошелек"><span
                                class="basket-step__payment-variant-item-content"><span
                                    class="basket-step__payment-variant-item-content-img"><img
                                        src="/images/mn6.png" alt=""></span><span
                                    class="basket-step__payment-variant-item-content-caption">QIWI кошелек</span></span>
                    </label>
                </div>
                <div class="basket-step__payment-variant-item">
                    <label> <input type="radio" name="<?= $formName ?>[payment_type]" class="payment_type" value="Megafon"
                                   data-text="Мегафон"><span class="basket-step__payment-variant-item-content"><span
                                    class="basket-step__payment-variant-item-content-img"><img
                                        src="/images/mn7.png" alt=""></span><span
                                    class="basket-step__payment-variant-item-content-caption">Мегафон</span></span>
                    </label>
                </div>
                <div class="basket-step__payment-variant-item">
                    <label> <input type="radio" name="<?= $formName ?>[payment_type]" class="payment_type" value="MTS"
                                   data-text="МТС"><span class="basket-step__payment-variant-item-content"><span
                                    class="basket-step__payment-variant-item-content-img"><img
                                        src="/images/mn8.png" alt=""></span><span
                                    class="basket-step__payment-variant-item-content-caption">МТС</span></span> </label>
                </div>
                <div class="basket-step__payment-variant-item">
                    <label> <input type="radio" name="<?= $formName ?>[payment_type]" class="payment_type" value="Beeline"
                                   data-text="Билайн"><span
                                class="basket-step__payment-variant-item-content"><span
                                    class="basket-step__payment-variant-item-content-img"><img
                                        src="/images/mn9.png" alt=""></span><span
                                    class="basket-step__payment-variant-item-content-caption">Билайн</span></span>
                    </label>
                </div>-->
                </div>
            </div>

            <?php
            //M::printr($Cart, '$Cart');
            $cost = 0;
            foreach ($Cart->cartProducts as $cartProduct) {
                //M::printr($cartProduct, '$cartProduct');
                $oProduct = $cartProduct->product;
                $oLabels = $oProduct->getLabels();
                $price = !empty($oLabels['is_sale']) ? $oProduct->product_new_price : $oProduct->product_price;
                //M::printr($oProduct, '$oProduct');
                $cost += $cartProduct->quantity * $price;
            }
            ?>
            <input id="freeDelivery" type="hidden" name="<?= $formName ?>[freeDelivery]"
                   value="<?= ($cost >= 3000) ? 'true' : 'false' ?>">
            <div class="basket-step__item">
                <div class="basket-step__item-title">Завершить оформление заказа</div>
                <div class="basket-step__confrimation">
                    <div class="row">
                        <div class="col-md-3 col-xs-12">
                            <div class="basket-step__confrimation-back"><a
                                        href="<?= \yii\helpers\Url::to(['/page/cart']) ?>">←
                                    <span>Назад к составу заказа</span></a></div>
                        </div>
                        <div class="col-md-9 col-xs-12">
                            <div class="basket-step__confrimation-content">
                                <div class="basket-step__confrimation-content-list">
                                    <ul class="list">
                                        <li>Стоимость доставки: <b><span id="delivery">0</span> руб. </b><i>(<span
                                                        id="delivery_type">Способ доставки не выбран</span>, <a
                                                        href="#delivery_types">изменить</a>)</i></li>
                                        <li>Способ оплаты: <b><span id="payment_type">Не выбран</span></b> <i>(<a
                                                        href="#payment_types">изменить способ оплаты</a>)</i></li>
                                        <li>Стоимость товаров: <b><span id="cost"><?= $cost ?></span> руб.</b></li>
                                        <li class="hide">Скидки: <b>- 10% </b>(2 755 руб.)</li>
                                        <li class="hide">Будет списано потрачено бонусов: <b>- 1000 бонусов </b><i>(<a
                                                        href="#">изменить</a>)</i></li>
                                        <li class="hide">Будет начислено: <b>120 бонусов </b><i>(<a
                                                        href="#">Авторизуйтесь</a> для начисления бонусов)</i></li>
                                    </ul>
                                </div>
                                <div class="basket-step__confrimation-content-payment">
                                    <div class="basket-step__confrimation-content-payment-number"><span
                                                class="basket-step__confrimation-content-payment-number-title">Итого:</span><span
                                                class="basket-step__confrimation-content-payment-number-price"><span
                                                    id="summ"><?= $cost ?></span> <i class="rouble">a</i></span>
                                        <div class="basket-step__confrimation-content-payment-number-btn">
                                            <button type="submit" class="btn btn_standart back" id="createOrder">
                                                Оформить заказ
                                            </button>
                                        </div>
                                    </div>
                                    <div class="basket-step__confrimation-content-payment-rules" id="is_agree_error"
                                         style="display: none;">
                                        Необходимо принять условия:
                                    </div>
                                    <div class="basket-step__confrimation-content-payment-rules" id="is_agree_div">
                                        <div class="filters-catalog__filter-item-check-item">
                                            <label> <input type="checkbox" name="<?= $formName ?>[is_agree]"
                                                           id="is_agree"
                                                           class="error"><span>Я подтверждаю, что я старше 18 лет, принимаю
                                                условия работы сайта и даю добровольное согласие на обработку своих
                                                персональных данных и получение E-mail / SMS-рассылок с информацией об
                                                акциях и новых поступлениях Интернет-магазина. <a href="#">См. основные
                                                    правила</a>.</span> </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <?php //$this->endWidget(); ?>
        </form>
    </div>
</section>

<script>

    function isDelivery() {
        var is_validate = true;
        var delivery_type = $('.delivery_type:checked').val();
        console.log('[DELIVERY_TYPE]', delivery_type);
        var delivery = $('.delivery:checked').val();
        console.log('[DELIVERY]', delivery);
        console.log('[is_validate]', is_validate);
        return is_validate;
    }


    function validate() {
        var is_validate = true;

        is_validate = isDelivery();
        metka = 'seccess';

        var errorClass = 'my-input-error';
        //var validClass = 'success-input';

        if ($('#is_agree').prop('checked')) {
            $('#is_agree_div').removeClass(errorClass);
            $('#is_agree_error').hide();
        } else {
            $('#is_agree_div').addClass(errorClass);
            $('#is_agree_error').show();
            metka = 'is_agree';
            is_validate = false;
        }
        if ($('#<?= $formName ?>_phone').val() != '') {
            $('#<?= $formName ?>_phone').removeClass(errorClass);
        } else {
            $('#<?= $formName ?>_phone').addClass(errorClass);
            is_validate = false;
            metka = '<?= $formName ?>_phone';
        }
        if ($('#<?= $formName ?>_first_name').val() != '') {
            $('#<?= $formName ?>_first_name').removeClass(errorClass);
        } else {
            $('#<?= $formName ?>_first_name').addClass(errorClass);
            metka = '<?= $formName ?>_first_name';
            is_validate = false;
        }

        <?php /*?>
            if (delivery_type == 'transport') {
                if ($('#form-city').val() != '') {
                    $('#form-city').removeClass(errorClass);
                } else {
                    $('#form-city').addClass(errorClass);
                    is_validate = false;
                }
            }
            if (delivery_type != 'self-delivery') {
                if ($('#form-street').val() != '') {
                    $('#form-streen').removeClass(errorClass);
                } else {
                    $('#form-street').addClass(errorClass);
                    is_validate = false;
                }
                if ($('#form-house').val() != '') {
                    $('#form-house').removeClass(errorClass);
                } else {
                    $('#form-house').addClass(errorClass);
                    is_validate = false;
                }
            }
            <?php //*/?>
        if (metka != 'seccess') {
            //window.location.hash = "#anchorName";
            var filter_head = $('#' + metka).offset();
            console.log(filter_head);
            $('html, body').stop().animate({
                scrollTop: filter_head.top - 70
            }, 700);
            return;
        }

        return is_validate;
    }

    function calculate() {
        if ($('#freeDelivery').val() != 'true') {
            var summ = Number($('#delivery').text()) + Number($('#cost').text());
            $('#summ').text(summ);
        } else {
        }
    }

    $(document).ready(function () {
        //подсчитываем полную стоимость
        calculate();
        $('#selfget').show();
        //$('#pole_city').hide();

        $('.delivery_type').on('click', function () {
            //isDelivery();
            var delivery_type = $('.delivery_type:checked').val();
            //alert(delivery_type);
            if (delivery_type == 'russian-post') {
                //$('.delivery:not(".delivery_type")').prop('checked', false);
                $('#selfget').show();
                //$('#pole_city').hide();
                $('input[name="<?= $formName ?>[delivery]"]').attr('checked', false);
            }
            if (delivery_type == 'courier-yar') {
                //$('.delivery:not(".delivery_type")').prop('checked', false);
                $('#selfget').show();
                $('#pole_city').hide();
                $('input[name="<?= $formName ?>[delivery]"]').attr('checked', false);
            }
            if (delivery_type == 'transport') {
                //$('.delivery:not(".delivery_type")').prop('checked', false);
                $('#selfget').show();
                //$('#pole_city').show();
            }
            delivery_type = $(this).data('text');
            $('#delivery_type').text(delivery_type);
        });

        //изменяем способ доставки
        $('.delivery').on('click', function () {
            isDelivery();
            var cost = $(this).data('cost');
            console.log('[COST]', cost);
            if ($('#freeDelivery').val() != 'true') {
                $('#delivery').text(cost);
            }
            console.log('#delivery', $('#delivery').text());
            var delivery_type = $(this).data('text');
            console.log('[delivery_type]', delivery_type);
            $('#delivery_type').text(delivery_type);
            calculate();
        });

        //изменяем способ оплаты
        $('.payment_type').on('click', function () {
            var payment_type = $(this).data('text');
            $('#payment_type').text(payment_type);
            calculate();
        });

        $('#createOrder').on('click', function (e) {
            e.preventDefault();

            //поставить прелоадер на кнопку "Оформить заказ"
            var $textOrder = $('#createOrder').html();
            $('#createOrder').html('<img src="/images/preloader3.gif">').prop('disabled', true);
            $('#city_id').val($('#input_city_id').val());
            $('#city_name').val($('#input_city_name').val());
            console.log('CITY_ID', $('#input_city_id').val());
            //если валидация прошла, то отправить данные на сервер
            if (validate()) {
                var url = '<?= \yii\helpers\Url::to(['/page/order/create']) ?>';

                $.ajax({
                    url: url,
                    type: 'POST',
                    dataType: 'json',
                    data: $('#<?= $formName ?>').serialize()
                }).success(function (response) {
                    console.log('[RESPONSE]', response);
                    if (response.success == true) {
                        document.location.href = '<?= \yii\helpers\Url::to(['/page/order/success', 'order_id' => '__order_id__']) ?>'.replace('__order_id__', response.order_id);
                        //ошибок нет
                        //console.log('<?= \yii\helpers\Url::to(['/page/order/success', 'order_id' => '__order_id__']) ?>'.replace('__order_id__', response.order_id));
                        console.log('Ok');
                    } else {
                        //ошибки есть
                        //вернуть текст на кнопку
                        $('#createOrder').html($textOrder).prop('disabled', false);
                        //$('#errors').empty().append(printrErrors(response.errors));
                        //$('#submit').prop('disabled', false);
                    }
                }).error(function (data, key, value) {
                    $('#createOrder').html($textOrder).prop('disabled', false);
                    return false;
                    //after_send(data);
                });

            } else {
                $('#createOrder').html($textOrder).prop('disabled', false);
            }
        });
    });
</script>
