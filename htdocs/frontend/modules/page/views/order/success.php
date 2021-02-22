<?php
$oBlock = \common\models\models\CmsTree::getBlock('order-success');
$this->context->fillSeo($oBlock);
?>
<div class="breadcrumb-wr">
    <div class="container">
        <div class="breadcrumb">
            <?php
            $breadcrumbs = [];
            $breadcrumbs['Главная'] = '/';
            $breadcrumbs['Корзина'] = \yii\helpers\Url::to(['/page/cart']);
            $breadcrumbs['Успешный заказ'] = \yii\helpers\Url::to(['/page/order/success', 'order_id' => $oOrder['id']]);
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
        <h2>Спасибо за заказ!</h2>
    </div>
</section>
<section class="basket-success">
    <div class="container">
        <div class="basket-success__wr">
            <div class="basket-success__title"><i class="ico-success"></i><span>Заказ успешно оформлен. Номер вашего
                    заказа: <b><?= $oOrder['id'] ?></b></span></div>
            <div class="basket-success__thank">
                <div class="basket-success__thank-description">Уважаемый клиент! Вы успешно оформили заказ в нашем
                    интернет-магазине. В ближайше время мы свяжемся с вами для подтверждения наличия товара на складе и
                    уточнения выбранного варианта оплаты и доставки. <b>Спасибо, что выбрали нас!</b></div>
                <div class="basket-success__thank-nav"><!--<a href="#">Мои заказы</a><span
                class="basket-success__thank-nav-dot">|</span>--><a href="<?= \yii\helpers\Url::to(['/']) ?>">Вернуться
                        на главную</a></div>
            </div>
            <div class="basket-success__money">
                <div class="basket-success__money-title">Сумма заказа:</div>
                <div class="basket-success__money-num"><?= $oOrder['totalSumm'] ?> <i class="rouble">a</i></div>
                <?php /*/ ?>
                <div class="basket-success__money-link"><a href="#" class="btn btn_main-page">Оплатить on-line</a></div>
                <?php //*/ ?>
            </div>
            <?php
            //M::printr($oOrder, '$oOrder');
            //$data = CJSON::decode($oOrder->delivery_data);
            //M::printr($data, '$data');
            ?>

            <div class="basket-success__information">
                <div class="basket-success__information-item">Стоимость доставки: <b><?= $oOrder['delivery']['cost'] ?>
                        руб. </b>
                    <span><?php
                        if (!empty($oOrder['delivery']['code'])) {
                            switch ($oOrder['delivery']['code']) {
                                case 'dpd' :
                                    echo 'Доставка DPD';
                                    break;
                                case 'sdek' :
                                    echo 'Доставка СДЭК';
                                    break;
                                case 'courier-yar' :
                                    echo 'Доставка курьером по г.Ярославлю';
                                    break;
                                case 'russian-post' :
                                    echo 'Почта России';
                                    break;
                            }
                        } else {
                            echo 'Способ доставки не выбран.';
                        }
                        ?>
                    </span>
                </div>
                <div class="basket-success__information-item">Способ оплаты:
                    <span><b><?php
                            foreach ($oOrder['payments'] as $data) {
                                switch ($data['type']) {
                                    case 'bank-card' :
                                        echo 'банковской картой';
                                        break;
                                    case 'cash' :
                                        echo 'наличными';
                                        break;
                                }
                                //break; //выход из цикла foreach так как нужна только одна информация о платеже.
                            }
                            ?>
                    </b></span>
                </div>
                <!--<div class="basket-success__information-item">Способ оплаты: <b>Карта VISA </b><span>(+3%)</span></div>-->
                <div class="basket-success__information-item hide">Будет начислено: <b>120 бонусов </b>(<span><a
                                href="#">Авторизуйтесь</a> для начисления бонусов)</span></div>
            </div>
        </div>
    </div>
</section>

