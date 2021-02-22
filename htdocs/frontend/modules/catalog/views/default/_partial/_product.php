<?php

use common\models\Cart;
use common\models\Wish;

$cache_opts = [
    'duration' => 86400, // 24hours
    'dependency' => [
        'class' => 'CDbCacheDependency',
        //'sql' => 'SELECT MAX(dt_updated) FROM cms_tree',
        /*/
        'sql' => "select TO_CHAR(max(t1.dt_updated), 'YYYY-MM-DD_HH24:MI:SS:US') || '_' || TO_CHAR(max(t3.dt_updated), 'YYYY-MM-DD_HH24:MI:SS:US') \"cachetime\"
from cms_tree t1
left join app_products t2 on t2.cms_tree_ref = t1.id
left join ecm_products t3 on t3.id = t2.ecm_products_ref;
",
        //*/
        'sql' => "SELECT TO_CHAR(MAX(dt_created), 'YYYY-MM-DD') \"cachetime\" FROM sys_cache_resets;",
    ],
];


if ($category['image']['teaserBig'] == '/images/noimg_big.jpg') {
    $is_set_micro = false;
} else {
    $is_set_micro = true;
}


$tm1 = microtime(true) * 1000;
//\CmsTree\Cache\Dependency::instance();

$post = \yii\helpers\Json::encode($_POST);
$md5 = md5('fish_frontend_product_' . $oCategory->id . '_' . $post);


$oCart = (new Cart)->give();
$oWish = (new Wish)->give();
//M::printr($oCart, '$oCart');
//$oChProducts = $oCategory->getProducts();
//if (empty($oChProducts)) return false;

//$oProducts = $oCategory->getProducts();
usort($oProducts, function ($item1, $item2) {
    $name1 = $item1->product_long_name ?: $item1->product_name;
    $name2 = $item2->product_long_name ?: $item2->product_name;
    if ($name1 >= $name2) {
        return 1;
    } else {
        return -1;
    }
}
);

$is_in_cart = false;
if (!empty($oCart->cartProducts[$oProduct->id])) {
    $is_in_cart = true;
}

$quantity = $oProduct->getProductCount();
$oVendor = $oProduct->getField('1c_product_vendor');

/*/
$noImg = '/images/noimage_396.png';
$oImgs = $oCategory->content->getImages();
$oImg = isset($oImgs[0]) ? $oImgs[0] : false;
if (!empty($oImg)) {
    $oTeaserSmall = $oImg->getCropped('ecm:teaser_small');
    $this->page_image = '/store' . $oTeaserSmall->fs_alias;
}
//*/
$oComments = []; //$oProduct->getComments();
$oLabels = $oProduct->getLabels();
//imgUrl
$price = $oProduct->product_price;
if (!empty($oLabels['is_sale'])) {
    $price = $oProduct->product_new_price;
}
//if ($this->beginCache($md5, $cache_opts)) {
?>

<div class="section-unit-description">
	<div class="container">
		<div class="unit-description__content" itemscope itemtype="http://schema.org/Product">

			<!-- top -->
			<div class="unit-description__head">
				<div class="unit-description__title">
					<h1 itemprop="name" data-product_id='<?= $oProduct->id ?>'
					    id="product_id"><?= !empty($oCategory->content->page_longtitle) ? $oCategory->content->page_longtitle : $oCategory->node_name ?></h1>
					<link itemprop="url"
					      href="https://fishmen.ru<?= \yii\helpers\Url::to(['/route/catalog', 'id' => $oCategory->id]) ?>"/>
					<ul class="visuallyhidden" itemprop="offers" itemscope itemtype="http://schema.org/Offer">
						<li itemprop="price"><?= !empty($oLabels['is_sale']) ? $oProduct->product_new_price : $oProduct->product_price ?></li>
						<li itemprop="priceCurrency">RUB</li>
						<li>
							<link itemprop="availability"
							      href="http://schema.org/<?= $quantity > 0 ? 'InStock' : 'OutOfStock' ?>"/><?= $quantity > 0 ? 'In stock' : 'Out of stock' ?>
						</li>
					</ul>
				</div>
				<div class="unit-description__head-detail">
					<div class="labels-box">
						<div class="label-box new jsIsNew"
						     style="display: <?= !empty($oLabels['is_new']) ? 'block' : 'none' ?>">
							<span>Новинка</span>
						</div>
						<div class="label-box sale jsIsSale"
						     style="display: <?= !empty($oLabels['is_sale']) ? 'block' : 'none' ?>">
							<span>Распродажа</span>
						</div>
					</div>
					<div class="vendor-code-box">
						<span>Артикул: <span class="jsVendor"
						                     itemprop="productID"><?= $oVendor->field_value ?></span></span>
					</div>
                    <?php if (count($oComments)) { ?>
						<div class="visuallyhidden" itemtype="http://schema.org/AggregateRating" itemscope
						     itemprop="aggregateRating">
							<meta itemprop="ratingValue" content="<?= ceil($oProduct->rating * 10) / 10 ?>">
							<meta content="1" itemprop="worstRating">
							<meta content="5" itemprop="bestRating">
							<meta content="<?= count($oComments) ?>" itemprop="ratingCount">
						</div>
                    <?php } ?>

					<div class="rating-box">
						<div class="rating-box__stars jsStars">
                            <?php //$oProduct->rating = 4; ?>
                            <?php for ($i = 0; $i < 5; $i++) { ?>
								<i class="<?= $i < floor($oProduct->rating) ? 'active' : '' ?>">
									<svg class="svg-icon ico-fish">
										<use xmlns:xlink="http://www.w3.org/1999/xlink"
										     xlink:href="/themes/fishmen/assets/css/symbols.svg#ico-fish"></use>
									</svg>
								</i>
                            <?php } ?>
						</div>
						<div class="rating-box__reviews">
							<span>Отзывов: </span> <a href="javascript: void(0);" data-target="to-reviews"
							                          class="link link_du jsCountComments"><?= $oProduct->getCommentsCount() ?></a>
						</div>
					</div>
					<div class="bookmarks-box">
						<a href="javascript: void(0);" class="link link_du jsWish"
						   data-product_id="<?= $oProduct->id ?>">
							<svg class="svg-icon ico-tab-selected">
								<use xmlns:xlink="http://www.w3.org/1999/xlink"
								     xlink:href="/themes/fishmen/assets/css/symbols.svg#ico-tab-selected"></use>
							</svg>
							<span class="jsAddWish"
							      style="display: <?= !empty($oWish->wishProducts[$oProduct->id]) ? 'none' : 'block' ?>;">Добавить
								в закладки</span> <span class="jsDelWish"
							                            style="display: <?= !empty($oWish->wishProducts[$oProduct->id]) ? 'block' : 'none' ?>;">Удалить
								из закладок</span> </a>
					</div>
				</div>
			</div>
			<!-- /top -->

			<div class="unit-description__body">

				<!-- left -->
				<div class="unit-description__view">

					<div class="unit-description__carousel">
						<div class="unit-description-carousel-box">
							<div class="unit-description-carousel-main">
								<div class="unit-description-carousel-main__controls">
									<button type="button" class="btn-clear">
										<svg class="svg-icon ico-zoom">
											<use xmlns:xlink="http://www.w3.org/1999/xlink"
											     xlink:href="/themes/fishmen/assets/css/symbols.svg#ico-zoom"></use>
										</svg>
									</button>
								</div>
                                <?php if (1) { ?>
									<div class="unit-description-carousel-main__content">
										<div class="unit-description-carousel-main__unit">
											<a href="<?= $category['image']['illustration'] ?>" data-gallery
											   id="ImgIllustration" class="imgIllustration"
											   title="<?= $oCategory->content->page_longtitle ? $oCategory->content->page_longtitle : $oCategory->node_name ?>">
												<picture>
													<img <?= !$is_set_micro ? 'itemprop = "image"' : '' ?>
															id="ImgTeaserBig" class="imgTeaserBig"
															src="<?= $category['image']['teaserBig'] ?>"
															alt="<?= $oCategory->content->page_longtitle ? $oCategory->content->page_longtitle : $oCategory->node_name ?>">
												</picture>
											</a>
										</div>
									</div>
                                <?php } ?>
                                <?php if (0) { ?>
									<div class="unit-description-carousel-main__content">
                                        <?php
                                        $oImgs = $oCategory->content->getImages();
                                        ?>
                                        <?php if (!empty($oImgs)) { ?>
                                            <?php $is_set_micro = false; ?>
                                            <?php foreach ($oImgs as $oImg) { ?>
                                                <?php $oTeaserBig = $oImg->getCropped('ecm:teaser_big'); ?>
                                                <?php $oIllustration = $oImg->getCropped('ecm:illustrations'); ?>
												<div class="unit-description-carousel-main__unit">
                                                    <?php $href = "/store{$oIllustration->fs_alias}" ?>
													<a href="<?= $href ?>" data-gallery
													   class="imgIllustreation"
													   id="ImgIllustreation"
													   title="<?= $oCategory->content->page_longtitle ? $oCategory->content->page_longtitle : $oCategory->node_name ?>">
														<picture>
															<img <?= !$is_set_micro ? 'itemprop = "image"' : '' ?>
																	id="ImgTeaserBig" class="imgTeaserBig"
																	src="/store<?= $oTeaserBig->fs_alias ?>"
																	alt="<?= $oCategory->content->page_longtitle ? $oCategory->content->page_longtitle : $oCategory->node_name ?>">
														</picture>
													</a>
												</div>
                                                <?php $is_set_micro = true; ?>
                                            <?php } ?>
                                        <?php } else { ?>
											<div class="main-item-ds__slider-bg-item" style="height: 396px;">
												<a href="/images/noimg_big.jpg" data-gallery> <img
															src="/images/noimg_big.jpg" alt=""> </a>
											</div>
                                        <?php } ?>
									</div>
                                <?php } ?>
							</div>
                            <?php if (1) { ?>
								<div class="unit-description-carousel-nav">
									<!-- слайдер миникартинок -->
                                    <?php if (!empty($oImgs)) { ?>
										<div class="unit-description-carousel-nav__controls">
											<button type="button" class="btn-clear prev">
												<svg class="svg-icon ico-slider-control">
													<use xmlns:xlink="http://www.w3.org/1999/xlink"
													     xlink:href="/themes/fishmen/assets/css/symbols.svg#ico-slider-control"></use>
												</svg>
											</button>
											<button type="button" class="btn-clear next">
												<svg class="svg-icon ico-slider-control">
													<use xmlns:xlink="http://www.w3.org/1999/xlink"
													     xlink:href="/themes/fishmen/assets/css/symbols.svg#ico-slider-control"></use>
												</svg>
											</button>
										</div>
										<div class="unit-description-carousel-nav__content">
                                            <?php foreach ($oImgs as $oImg) { ?>
                                                <?php $oMicro = $oImg->getCropped('ecm:teaser_micro'); ?>
												<div class="unit-description-carousel-nav__unit">
													<div>
														<button type="button" class="btn-clear">
															<picture>
																<img src="/store<?= $oMicro->fs_alias ?>"
																     alt="<?= $oCategory->content->page_longtitle ? $oCategory->content->page_longtitle : $oCategory->node_name ?>">
															</picture>
														</button>
													</div>
												</div>
                                            <?php } ?>
										</div>
                                    <?php } ?>
								</div>
                            <?php } ?>
                            <?php if (0) { ?>
								<div class="unit-description-carousel-nav">
									<!-- слайдер миникартинок -->
                                    <?php if (!empty($oImgs)) { ?>
										<div class="unit-description-carousel-nav__controls">
											<button type="button" class="btn-clear prev">
												<svg class="svg-icon ico-slider-control">
													<use xmlns:xlink="http://www.w3.org/1999/xlink"
													     xlink:href="/themes/fishmen/assets/css/symbols.svg#ico-slider-control"></use>
												</svg>
											</button>
											<button type="button" class="btn-clear next">
												<svg class="svg-icon ico-slider-control">
													<use xmlns:xlink="http://www.w3.org/1999/xlink"
													     xlink:href="/themes/fishmen/assets/css/symbols.svg#ico-slider-control"></use>
												</svg>
											</button>
										</div>
										<div class="unit-description-carousel-nav__content">
                                            <?php foreach ($oImgs as $oImg) { ?>
                                                <?php $oMicro = $oImg->getCropped('ecm:teaser_micro'); ?>
												<div class="unit-description-carousel-nav__unit">
													<div>
														<button type="button" class="btn-clear">
															<picture>
																<img src="/store<?= $oMicro->fs_alias ?>"
																     alt="<?= $oCategory->content->page_longtitle ? $oCategory->content->page_longtitle : $oCategory->node_name ?>">
															</picture>
														</button>
													</div>
												</div>
                                            <?php } ?>
										</div>
                                    <?php } ?>
								</div>
                            <?php } ?>
							<div class="unit-description-carousel__caption">Реальное изображение товара может отличаться
								от изображения представленного на сайте
							</div>
						</div>
					</div>
					<div class="main-item-ds__payment-social">
						<div class="main-item-ds__payment-social-title">Поделитесь с друзьями</div>
						<div class="ya-share2"
						     data-services="vkontakte,facebook,odnoklassniki,gplus,twitter,viber,whatsapp,telegram"></div>
					</div>

				</div>
				<!-- /left -->

				<!-- right -->
				<div class="unit-description__details">

                    <?php
                    $cart = 1;

                    if ($price > 0 && $quantity > 0) {
                        $cart = 1;
                        if ($is_in_cart) $cart = 2;
                    }
                    if ($price > 0 && $quantity == 0) {
                        $cart = 3;
                    }
                    if ($price == 0) {
                        $cart = 4;
                    }
                    ?>

					<!-- toCart -->
					<div class="unit-description__buy-info jsInfo jsToCart <?= $cart == 1 ? '' : 'hide' ?>">
						<div class="unit-description__price">
							<div class="price-box">
								<div class="price-box__description">
									<div class="price-box__main">
										<span class="jsPrice"><?= number_format($price, 0, '.', ' ') ?></span> <?= Yii::$app->user->currency ?>
									</div>
									<div class="price-box__detail"
									     style="display: <?= !empty($oLabels['is_sale']) ? 'block' : 'none' ?>;">
										<span class="price-box__old-price"> <span
													class="jsNewPrice"><?= $oProduct->product_price ?></span> <?= Yii::$app->user->currency ?>
										</span> <span class="price-box__econom">Экономия <span
													class="jsEconom"><?= $oProduct->product_price - $oProduct->product_new_price ?></span> <?= Yii::$app->user->currency ?>
										</span>
									</div>
								</div>
								<div class="price-box__availability green">
									<svg class="svg-icon icon-ok">
										<use xmlns:xlink="http://www.w3.org/1999/xlink"
										     xlink:href="/themes/fishmen/assets/css/symbols.svg#icon-ok"></use>
									</svg>
									<span class="jsStore"><?= $quantity > 4 ? "Есть в наличии &gt; 4" : "Есть в наличии" ?></span>
								</div>
							</div>
						</div>
						<div class="unit-description__actions">
							<div class="unit-description__counter">
								<div class="number-choser">
									<div class="number-choser__input">
										<input type="number" id="number" value="1" class="main-input">
									</div>
									<div class="number-choser__btn"><i class="plus"></i><i class="minus"></i></div>
								</div>
							</div>
							<div class="unit-description__action js">
								<a href="javascript: void(0);" class="addToCart"
								   data-product_id="<?= $oProduct->id ?>">
									<svg class="svg-icon ico-basket">
										<use xmlns:xlink="http://www.w3.org/1999/xlink"
										     xlink:href="/themes/fishmen/assets/css/symbols.svg#ico-basket"></use>
									</svg>
									<span>Купить</span> </a>
							</div>
						</div>
					</div>
					<!-- /toCart -->

					<!-- inCart -->
					<div class="unit-description__buy-info jsInfo jsInCart <?= $cart == 2 ? '' : 'hide' ?>">
						<div class="unit-description__price">
							<div class="price-box">
								<div class="price-box__description">
									<div class="price-box__main">
										<span class="jsPrice"><?= number_format($price, 0, '.', ' ') ?></span> <?= Yii::$app->user->currency ?>
									</div>
									<div class="price-box__detail"
									     style="display: <?= !empty($oLabels['is_sale']) ? 'block' : 'none' ?>;">
										<span class="price-box__old-price"> <span
													class="jsNewPrice"><?= $oProduct->product_price ?></span> <?= Yii::$app->user->currency ?>
										</span> <span class="price-box__econom">Экономия <span
													class="jsEconom"><?= $oProduct->product_price - $price ?></span> <?= Yii::$app->user->currency ?>
										</span>
									</div>
								</div>
								<div class="price-box__availability green">
									<svg class="svg-icon icon-ok">
										<use xmlns:xlink="http://www.w3.org/1999/xlink"
										     xlink:href="/themes/fishmen/assets/css/symbols.svg#icon-ok"></use>
									</svg>
									<span class="jsStore"><?= $quantity > 4 ? "Есть в наличии &gt; 4" : "Есть в наличии" ?></span>
								</div>
							</div>
						</div>
						<div class="unit-description__actions">
							<div class="unit-description__action unit-description__action_in-basket">
								<a href="/cart/">
									<svg class="svg-icon icon-ok">
										<use xmlns:xlink="http://www.w3.org/1999/xlink"
										     xlink:href="/themes/fishmen/assets/css/symbols.svg#icon-ok"></use>
									</svg>
									<span>Уже в корзине</span> </a>
							</div>
						</div>
					</div>
					<!-- /inCart -->

					<!-- forOrder -->
					<div class="unit-description__buy-info jsInfo jsForOrder <?= $cart == 3 ? '' : 'hide' ?>">
						<div class="unit-description__price">
							<div class="price-box">
								<div class="price-box__description">
									<div class="price-box__main">
										~<span class="jsPrice"><?= $oProduct->product_price ?></span> <?= Yii::$app->user->currency ?>
									</div>
									<div class="price-box__detail">
										<span class="grey">Точная цена — при поступлении товара на склад</span>
									</div>
								</div>
								<div class="price-box__availability blue">
									<svg class="svg-icon icon-ok">
										<use xmlns:xlink="http://www.w3.org/1999/xlink"
										     xlink:href="/themes/fishmen/assets/css/symbols.svg#icon-ok"></use>
									</svg>
									<span>Доступно под заказ</span>
								</div>
							</div>
						</div>
						<div class="unit-description__actions">
							<div class="unit-description__action unit-description__action_under-order">
								<a href="#modal-for-order" title="Под заказ" rel="nofollow" class="forOrder"
								   data-toggle="modal" data-product_id="<?= $oProduct->id ?>">
									<svg class="svg-icon ico-basket">
										<use xmlns:xlink="http://www.w3.org/1999/xlink"
										     xlink:href="/themes/fishmen/assets/css/symbols.svg#ico-basket"></use>
									</svg>
									<span>Под заказ</span> </a>
							</div>
						</div>
					</div>
					<!-- /forOrder -->

					<!-- noStore -->
					<div class="unit-description__buy-info unit-description__buy-info_center jsInfo jsNoStore <?= $cart == 4 ? '' : 'hide' ?>"
					     style="min-height: 75px;">
						<div class="unit-description__price">
							<div class="price-box">
								<div class="price-box__description">
									<div class="price-box__main disabled">Нет в наличии</div>
								</div>
							</div>
						</div>
						<div class="unit-description__actions">
							<a href="#modal-for-order" title="Сообщить о поступлении"
							   class="link link_under forOrder" data-toggle="modal" rel="nofollow"
							   data-product_id="<?= $oProduct->id ?>">Сообщить о поступлении</a>
						</div>
					</div>
					<!-- /noStore -->

					<div class="unit-description__chooser">
						<div class="unit-chooser-box">
							<div class="unit-chooser-box__title">
								<b style="margin-right: 5px;">Выбрать модель / размер:</b>
								<div class="main-item-tab__characteristic-table-item-position-hint">
									<div class="main-item-tab__characteristic-table-item-position-hint-ico">
										<svg class="svg-icon ico-info">
											<use xmlns:xlink="http://www.w3.org/1999/xlink"
											     xlink:href="/themes/fishmen/assets/css/symbols.svg#ico-info"></use>
										</svg>
									</div>
									<div class="main-item-tab__characteristic-table-item-position-hint-description">
										У вас есть варианты выбора одного и того же товара с отличием в цвете или
										размере
									</div>
								</div>
                                <?php /*/ ?>
                                <div class="info-box">
                                    <button type="button" class="btn-clear">
                                        <svg class="svg-icon icon-information">
                                            <use xmlns:xlink="http://www.w3.org/1999/xlink"
                                                 xlink:href="/themes/fishmen/assets/css/symbols.svg#icon-information"></use>
                                        </svg>
                                    </button>
                                </div>
                                <?php //*/ ?>
							</div>
							<div class="unit-chooser-box__content">
								<ul class="list">
                                    <?php foreach ($oProducts as $oChProduct) { ?>
										<li>
											<div class="radio-box <?= $oChProduct->product_price == 0 ? 'radio-box_disabled' : '' ?>"
											     data-product_id="<?= $oChProduct->id ?>">
												<label><input <?= $oChProduct->id == $oProduct->id ? 'checked' : '' ?>
															type="radio" name="radio" class="product">
													<span><?= $oChProduct->product_long_name ?: $oChProduct->product_name ?></span>
												</label>
											</div>
										</li>
                                    <?php } ?>
								</ul>
							</div>
						</div>
					</div>
					<div class="unit-description__last-info">
						<div class="unit-description__connention">
							<div class="unit-description__consultation">
								<svg class="svg-icon icon-telephone">
									<use xmlns:xlink="http://www.w3.org/1999/xlink"
									     xlink:href="/themes/fishmen/assets/css/symbols.svg#icon-telephone"></use>
								</svg>
								<span><b>Нужна консультация? </b> <a href="#xmodal-for-recall" rel="nofollow"
								                                     title="Нужна консультация?"
								                                     class="link link_du forRecall"
								                                     data-product_id="<?= $oProduct->id ?>"
								                                     data-toggle="modal">Оставьте свой номер
										телефона</a> — мы перезвоним!</span>
							</div>
							<div class="unit-description__small-description">
                                <?php
                                $descr = $oCategory->content->page_teaser;
                                if (empty($oCategory->content->page_teaser)) {
                                    $descr = $oCategory->content->seo_description;
                                    if (empty($oCategory->content->seo_description)) {
                                        $descr = $oCategory->content->page_longtitle . " вы можете приобрести в рыболовном интернет-магазине Фишмен.";
                                        if (empty($oCategory->content->page_longtitle)) {
                                            $descr = $oCategory->content->page_title . " вы можете приобрести в рыболовном интернет-магазине Фишмен.";
                                        }
                                    }
                                }
                                $this->context->page_description = $descr;
                                ?>
                                <?php if (!empty($oCategory->content->page_teaser)) { ?>
									<div class="unit-description__small-description-title">Краткое описание</div>
									<div class="unit-description__small-description-content"
									     itemprop="description"><?= $oCategory->content->page_teaser ?></div>
                                <?php } else { ?>
									<div itemprop="description" class="visuallyhidden"><?= $descr ?></div>
                                <?php } ?>
								<div class="unit-description__small-description-action">
									<a href="#to-characteristic" data-target="to-characteristic" rel="nofollow"
									   class="link"><span>Полное описание и характеристики</span> ↓</a>
								</div>
							</div>
						</div>
						<div class="unit-description__delivery">
							<div class="unit-description__delivery-title">
								<span style="margin-right: 5px;"> <b>Доставка в </b> <a href="javascript: void(0);"
								                                                        class="select_city">
                                        <?php
                                        $cookies = Yii::$app->request->cookies;
                                        $city = $cookies->getValue('gorod');
                                        ?>
                                        <?= $city ?>
									</a> </span>
								<div class="main-item-tab__characteristic-table-item-position-hint">
									<div class="main-item-tab__characteristic-table-item-position-hint-ico">
										<svg class="svg-icon ico-info">
											<use xmlns:xlink="http://www.w3.org/1999/xlink"
											     xlink:href="/themes/fishmen/assets/css/symbols.svg#ico-info"></use>
										</svg>
									</div>
									<div class="main-item-tab__characteristic-table-item-position-hint-description">
										Правильно указанный город помогает нам рассчитать время и стоимость доставки
									</div>
								</div>
                                <?php /*/ ?>
                                <div class="info-box">
                                    <button type="button" class="btn-clear">
                                        <svg class="svg-icon icon-information">
                                            <use xmlns:xlink="http://www.w3.org/1999/xlink"
                                                 xlink:href="/themes/fishmen/assets/css/symbols.svg#icon-information"></use>
                                        </svg>
                                    </button>
                                </div>
                                <?php //*/ ?>
							</div>
							<div class="unit-description__delivery-content">
								<ul class="list">
									<li>
										<picture>
											<img src="/themes/fishmen/assets/img/template/NEW/cdek.png" alt="">
										</picture>
										<span>СДЭК — 400 <?= Yii::$app->user->currency ?></span>
									</li>
									<li>
										<picture>
											<img src="/themes/fishmen/assets/img/template/NEW/boxbery.png" alt="">
										</picture>
										<span>Boxberry — 400 <?= Yii::$app->user->currency ?></span>
									</li>
									<li>
										<picture>
											<img src="/themes/fishmen/assets/img/template/NEW/rus.png" alt="">
										</picture>
										<span>Почта России — 400 <?= Yii::$app->user->currency ?></span>
									</li>
									<li>
										<picture>
											<img src="/themes/fishmen/assets/img/template/NEW/kur.png" alt="">
										</picture>
										<span>Курьер по Ярославлю — 200 <?= Yii::$app->user->currency ?></span>
									</li>
								</ul>
							</div>
							<div class="unit-description__delivery-action">
								<a href="/about/dostavka-i-oplata/" class="link link_du">Подробнее о доставке</a>
							</div>
						</div>
					</div>
				</div>
				<!-- /right -->
			</div>
		</div>
	</div>
</div>
<?php //$this->endCache();
//} ?>
<?php /*/ ?>
<section class="main-item-ds">
    <div class="container">
        <div class="main-item-ds__wr" itemscope itemtype="http://schema.org/Product">
            <div class="main-item-ds__title">
                <?php
                $quantity = 0;
                foreach ($oProduct->productStores as $oStore) {
                    $quantity += $oStore->quantity;
                }
                ?>
                <h1 itemprop="name"><?= str_replace('"', '&#8243;', $oCategory->content->page_longtitle ?: $oCategory->node_name) ?></h1>
                <link itemprop="url"
                      href="https://fishmen.ru<?= Yii::app()->createUrl('page/catalog', ['id' => $oCategory->id]) ?>"/>
                <ul class="visuallyhidden" itemprop="offers" itemscope itemtype="http://schema.org/Offer">
                    <li itemprop="price"><?= !empty($oLabels['is_sale']) ? $oProduct->product_new_price : $oProduct->product_price ?></li>
                    <li itemprop="priceCurrency">RUB</li>
                    <li>
                        <link itemprop="availability"
                              href="http://schema.org/<?= $quantity > 0 ? 'InStock' : 'OutOfStock' ?>">
                    </li>
                </ul>
            </div>
            <div class="main-item-ds__label">
                <?php if (!empty($oLabels['is_new'])) { ?>
                    <div class="product-item__label product-item__label_new" style="display: none;">
                        <span><?= $oLabels['is_new']->label->label_name ?></span>
                    </div>
                <?php } ?>
                <?php if (!empty($oLabels['is_sale'])) { ?>
                    <div class="product-item__label product-item__label_sale">
                        <span><?= $oLabels['is_sale']->label->label_name ?></span>
                    </div>
                <?php } ?>
            </div>
            <div class="main-item-ds__information clearfix">
                <div class="main-item-ds__slider">
                    <div class="main-item-ds__slider-bg">
                        <?php $oTeaserBig = $oImg ? $oImg->getCropped('ecm:teaser_big') : false; ?>
                        <?php if ($oTeaserBig) { ?>
                            <div class="main-item-ds__slider-bg-zoom">
                                <svg class="svg-icon ico-zoom">
                                    <use xmlns:xlink="http://www.w3.org/1999/xlink"
                                         xlink:href="/themes/fishmen/assets/css/symbols.svg#ico-zoom"></use>
                                </svg>
                            </div>
                        <?php } ?>
                        <div class="main-item-ds__slider-bg-wr">
                            <?php if (!empty($oImgs)) { ?>
                                <?php $is_set_micro = false; ?>
                                <?php foreach ($oImgs as $oImg) { ?>
                                    <?php $oTeaserBig = $oImg->getCropped('ecm:teaser_big'); ?>
                                    <?php $oIllustration = $oImg->getCropped('ecm:illustrations'); ?>
                                    <div class="main-item-ds__slider-bg-item">
                                        <a title="<?= $oProduct->product_long_name ?: $oProduct->product_name ?>"
                                           href="/store<?= $oIllustration->fs_alias ?>" data-gallery><img
                                                <?= !$is_set_micro ? 'itemprop = "image"' : '' ?>
                                                    class="imgProductBig"
                                                    src="/store<?= $oTeaserBig->fs_alias ?>"
                                                    alt="<?= $oProduct->product_long_name ?: $oProduct->product_name ?>"></a>
                                    </div>
                                    <?php $is_set_micro = true; ?>
                                <?php } ?>
                            <?php } else { ?>
                                <div class="main-item-ds__slider-bg-item"><a href="/images/noimg_big.jpg"
                                                                             data-gallery><img
                                                src="/images/noimg_big.jpg" alt=""></a></div>
                            <?php } ?>
                        </div>
                    </div>
                    <?php if (!empty($oImgs)) { ?>
                        <div class="main-item-ds__slider-sm">
                            <div class="main-item-ds__slider-sm-control">
                                <div class="main-item-ds__slider-sm-cnt main-item-ds__slider-sm-cnt_prev">
                                    <svg class="svg-icon ico-slider-control">
                                        <use xmlns:xlink="http://www.w3.org/1999/xlink"
                                             xlink:href="/themes/fishmen/assets/css/symbols.svg#ico-slider-control"></use>
                                    </svg>
                                </div>
                                <div class="main-item-ds__slider-sm-cnt main-item-ds__slider-sm-cnt_next">
                                    <svg class="svg-icon ico-slider-control">
                                        <use xmlns:xlink="http://www.w3.org/1999/xlink"
                                             xlink:href="/themes/fishmen/assets/css/symbols.svg#ico-slider-control"></use>
                                    </svg>
                                </div>
                            </div>
                            <div class="main-item-ds__slider-sm-wr">
                                <?php foreach ($oImgs as $oImg) { ?>
                                    <?php $oMicro = $oImg->getCropped('ecm:teaser_micro'); ?>
                                    <div class="main-item-ds__slider-sm-item"><img
                                                class="imgProductGallerySmall"
                                                src="/store<?= $oMicro->fs_alias ?>" alt=""></div>
                                <?php } ?>
                            </div>
                        </div>
                    <?php } ?>
                </div>
                <div class="main-item-ds__main-info">
                    <?php if (!empty($oVendor->field_value)) { ?>
                        <div class="main-item-ds__main-info-article">Артикул: <span
                                    itemprop="productID"><?= $oVendor->field_value ?></span></div>
                    <?php } ?>

                    <?php if (count($oComments)) { ?>
                        <div class="visuallyhidden" itemtype="http://schema.org/AggregateRating" itemscope
                             itemprop="aggregateRating">
                            <meta itemprop="ratingValue" content="<?= ceil($oProduct->rating * 10) / 10 ?>">
                            <meta content="1" itemprop="worstRating">
                            <meta content="5" itemprop="bestRating">
                            <meta content="<?= count($oComments) ?>" itemprop="ratingCount">
                        </div>
                    <?php } ?>
                    <div class="main-item-ds__main-info-popular"><span
                                class="main-item-ds__main-info-popular-title">Популярность:</span>
                        <ul class="list">
                            <?php for ($i = 0; $i < 5; $i++) { ?>
                                <li class="<?= $i < $oProduct->rating ? 'active' : '' ?>">
                                    <svg class="svg-icon ico-fish">
                                        <use xmlns:xlink="http://www.w3.org/1999/xlink"
                                             xlink:href="/themes/fishmen/assets/css/symbols.svg#ico-fish"></use>
                                    </svg>
                                </li>
                            <?php } ?>
                        </ul>
                        <span class="main-item-ds__main-info-popular-num"><a
                                    href="#" title="Рейтинг товара" data-target="to-reviews"
                                    rel="nofollow"><?= ceil($oProduct->rating) ?></a></span>
                    </div>
                    <div class="main-item-ds__main-info-popular-tab">
                        <?php $wishText = empty($oWish->wishProducts[$oProduct->id]) ? "Добавить в закладки" : "Удалить из закладок";
                        $wishTitle = empty($oWish->wishProducts[$oProduct->id]) ? "Добавить товар в закладки" : "Удалить товар из закладок" ?>
                        <svg class="svg-icon ico-tab-selected">
                            <use xmlns:xlink="http://www.w3.org/1999/xlink"
                                 xlink:href="/themes/fishmen/assets/css/symbols.svg#ico-tab-selected"></use>
                        </svg>
                        <a class="wishes" data-id="<?= $oProduct->id ?>" href="#"
                           title="<?= $wishTitle ?>" rel="nofollow"><?= $wishText ?></a>
                    </div><?php //var_dump($oWish) ?>
                    <?php
                    $descr = $oProduct->product_teaser;
                    if (empty($oProduct->product_teaser)) {
                        $descr = $oProduct->seo_description;
                        if (empty($oProduct->seo_description)) {
                            $descr = $oProduct->product_long_name . " вы можете приобрести в рыболовном интернет-магазине Фишмен.";
                            if (empty($oProduct->product_long_name)) {
                                $descr = $oProduct->product_name . " вы можете приобрести в рыболовном интернет-магазине Фишмен.";
                            }
                        }
                    }
                    ?>
                    <?php if (!empty($oProduct->product_teaser)) { ?>
                        <div class="main-item-ds__main-info-description"
                             itemprop="description"><?= $oProduct->product_teaser ?></div>
                    <?php } else { ?>
                        <div itemprop="description" class="visuallyhidden"><?= $descr ?></div>
                    <?php } ?>

                    <div class="main-item-ds__main-info-detail <?= $oProduct->filled_fields > 0 ? '' : 'hide' ?>"><a
                                href="#to-characteristic" data-target="to-characteristic"
                                title="Подробные характеристики"
                                rel="nofollow">Подробные характеристики</a></div>
                    <div class="main-item-ds__main-info-phone">Хотите заказать товар? <b>Нужна консультация?</b><br>
                        <a href="#xmodal-for-recall" title="Заказать обратный звонок" rel="nofollow" class="forRecall"
                           data-toggle="modal" data-product_id="<?= $oProduct->id ?>">Оставьте свой номер телефона</a> —
                        мы перезвоним!
                    </div>
                    <div class="main-item-ds__main-info-more <?= count($oChProducts) == 1 ? 'hide' : '' ?>">
                        <div class="main-item-ds__main-info-more-btn"><span>Еще доступно </span><a
                                    href="#to-models" title="Количество моделей товара" data-target="to-models"
                                    rel="nofollow"><?= M::declOfNum(count($oChProducts) - 1, array('модель', 'модели', 'моделей')) ?></a>
                            &darr;
                        </div>
                    </div>
                </div>
                <?php
                $cart = 0;
                //получить количество
                //M::printr($oProduct->productStores, '$oProduct->productStores');
                $quantity = 0;
                foreach ($oProduct->productStores as $oStore) {
                    $quantity += $oStore->quantity;
                }

                //получить цену
                $price = $oProduct->product_price;

                //склад == 1, цена == 1
                //проверить товары в корзине
                $Cart = (new Cart())->give();
                //M::printr($Cart, '$Cart');
                $inCart = 0;
                if (isset($Cart->cartProducts[$oProduct->id])) {
                    $inCart = 1;
                }

                if ($quantity > 0 && $price > 0) {
                    $cart = 2;
                    if ($inCart == 1) {
                        $cart = 1;
                    }
                }
                //склад == 0, цена == 1
                if ($quantity == 0 && $price > 0) {
                    $cart = 3;
                    if ($inCart == 1) {
                        $cart = 1;
                    }
                }
                //склад == 1, цена == 0
                if ($quantity > 0 && $price == 0) {
                    $cart = 0; //вариант исключен
                }
                //склад == 0, цена == 0
                if ($quantity == 0 && $price == 0) {
                    $cart = 4;
                }
                //$cart = 2;
                ?>

                <div class="main-item-ds__payment <?php
                if ($cart == 1) {
                    print "";
                } elseif ($cart == 2) {
                    print "main-item-ds__payment_buy";
                } elseif ($cart == 3) {
                    print "main-item-ds__payment_under-order";
                    //print "main-item-ds__payment_buy";
                } elseif ($cart == 4) {
                    print "main-item-ds__payment_out-stock";
                }
                ?>">
                    <?php
                    $price = $oProduct->product_new_price ?: $oProduct->product_price;
                    $price = number_format($price, 0, ' ', ' ');
                    ?>
                    <?php if ($oProduct->product_price > 0) { ?>
                        <?php if ($oProduct->product_new_price) { ?>
                            <div class="main-item-ds__payment-old-price">
                                <?= number_format($oProduct->product_price, 0, '.', ' ') ?> <?= Yii::app()->user->currency ?>
                            </div>
                        <?php } ?>
                        <div class="main-item-ds__payment-main-price">
                            <?= $price ?> <?= Yii::app()->user->currency ?>
                        </div>
                    <?php } ?>
                    <?php if ($cart == 1) { ?>
                        <div class="main-item-ds__payment-status-wr">
                            <div class="main-item-ds__payment-status">
                                <a href="/cart/" rel="nofollow" title="Перейти в корзину">
                                    <svg class="svg-icon ico-product-in-basket">
                                        <use xmlns:xlink="http://www.w3.org/1999/xlink"
                                             xlink:href="/themes/fishmen/assets/css/symbols.svg#ico-product-in-basket"></use>
                                    </svg>
                                    <span>Уже в корзине</span>
                                </a>
                            </div>
                        </div>
                    <?php } else if ($cart == 2) { ?>
                        <div class="main-item-ds__payment-status-wr">
                            <div class="main-item-ds__payment-status">
                                <a href="javascript:void(0);" title="Положить в корзину" rel="nofollow"
                                   class="addToCart" data-product_id="<?= $oProduct->id ?>">
                                    <svg class="svg-icon ico-basket">
                                        <use xmlns:xlink="http://www.w3.org/1999/xlink"
                                             xlink:href="/themes/fishmen/assets/css/symbols.svg#ico-basket"></use>
                                    </svg>
                                    <span>Купить</span>
                                </a>
                            </div>
                        </div>
                    <?php } else if ($cart == 3) { ?>
                        <div class="main-item-ds__payment-status-wr">
                            <div class="main-item-ds__payment-status">
                                <a href="#modal-for-order" title="Под заказ" rel="nofollow"
                                   class="forOrder" data-toggle="modal" data-product_id="<?= $oProduct->id ?>">
                                    <svg class="svg-icon ico-basket">
                                        <use xmlns:xlink="http://www.w3.org/1999/xlink"
                                             xlink:href="/themes/fishmen/assets/css/symbols.svg#ico-basket"></use>
                                    </svg>
                                    <span>Под заказ</span>
                                </a>
                            </div>
                            <div class="main-item-ds__payment-under-order hide"><a href="#" rel="nofollow">Сообщить<br>о
                                    поступлении</a>
                            </div>
                        </div>
                    <?php } else if ($cart == 4) { ?>
                        <div class="main-item-ds__payment-status-wr">
                            <div class="main-item-ds__payment-status">
                                <svg class="svg-icon ico-basket">
                                    <use xmlns:xlink="http://www.w3.org/1999/xlink"
                                         xlink:href="/themes/fishmen/assets/css/symbols.svg#ico-basket"></use>
                                </svg>
                                <span>Нет в наличии</span>
                            </div>
                            <div class="main-item-ds__payment-under-order">
                                <a href="#" rel="nofollow">Сообщить<br>о поступлении</a>
                            </div>
                        </div>
                        <div class="main-item-ds__main-info-more">
                            <div class="main-item-ds__main-info-more-btn"><b>НО! </b><span>Доступно </span>
                                <a href="#to-models" title="Другие модели товара" rel="nofollow"
                                   data-target="to-models">
                                    <?= M::declOfNum(count($oChProducts) - 1, array('другая модель', 'другие модели', 'других моделей')) ?>
                                </a> ↓
                            </div>
                        </div>
                    <?php } ?>
                    <div class="main-item-ds__payment-warehouse">
                        <div class="main-item-ds__payment-warehouse-now">
                            <?php if ($quantity > 4) { ?>
                                На складе > 4 шт.
                            <?php } else if (0 < $quantity && $quantity <= 3) { ?>
                                Есть в магазине.
                            <?php } else if ($quantity == 0) { ?>
                                Нет в наличии.
                            <?php } ?>
                        </div>
                        <!--div class="main-item-ds__payment-warehouse-bonus"><b>+45 </b><a href="#" rel="nofollow">бонусов на счет</a>
                        </div>
                        <div class="main-item-ds__payment-warehouse-more"><a href="#" rel="nofollow">Узнать больше о бонусах</a></div-->
                    </div>
                    <div class="main-item-ds__payment-delivery">
                        <div class="main-item-ds__payment-delivery-sity">Доставка по Ярославлю &mdash; 200 руб.</div>
                        <?php
                        if (isset(Yii::app()->request->cookies['city'])) {
                            $city = Yii::app()->request->cookies['city']->value;
                            //$city = 1;
                            //$city = CJson::decode($cookie)['name'];
                            //$city = json_decode($cookie)->name;
                            //var_dump(Yii::app()->request->cookies['city_option']->value);
                        } else {
                            $city = 'Ярославль';
                        }
                        ?>
                        <div class="main-item-ds__payment-delivery-sity product_city"
                             style="display: <?= $city == 'Ярославль' ? 'none;' : 'block;' ?>">Доставка в
                            <a class="select_city" id="select_city_button"><?= $city ?></a> от 400 руб.
                        </div>
                        <div class="main-item-ds__payment-delivery-detail"><a
                                    href="/about/dostavka-i-oplata/" target="_blank">Подробнее о доставке</a>
                        </div>
                    </div>
                    <div class="main-item-ds__payment-surprise">
                        <div class="main-item-ds__payment-surprise-ico"><img src="/images/surprise.png" alt="">
                        </div>
                        <div class="main-item-ds__payment-surprise-caption">Ищите что подарить?<br><a
                                    href="#" title="Подарочные сертификаты" rel="nofollow">Подарочный сертификат!</a>
                        </div>
                    </div>
                    <div class="main-item-ds__payment-social">
                        <div class="main-item-ds__payment-social-title">Поделитесь с друзьями</div>
                        <div class="ya-share2"
                             data-services="vkontakte,facebook,odnoklassniki,gplus,twitter,viber,whatsapp,telegram"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<?php //*/ ?>

<script type="text/template" id="charStringTmpl">
	<div class="main-item-tab__characteristic-table-item">
		<div class="main-item-tab__characteristic-table-item-position">
			<h4>${name}</h4>
			{{if view}}
			<div class="main-item-tab__characteristic-table-item-position-hint">
				<div class="main-item-tab__characteristic-table-item-position-hint-ico">
					<svg class="svg-icon ico-info">
						<use xmlns:xlink="http://www.w3.org/1999/xlink"
						     xlink:href="/themes/fishmen/assets/css/symbols.svg#ico-info"></use>
					</svg>
				</div>
				<div class="main-item-tab__characteristic-table-item-position-hint-description">
					${view}
				</div>
			</div>
			{{/if}}
		</div>

		<div class="main-item-tab__characteristic-table-item-conformity">${value}</div>
	</div>
</script>

<div id="templateProductInBasket" class="hide">
	<div class="main-item-ds__payment-status">
		<a href="/cart/" rel="nofollow" title="Перейти в корзину">
			<svg class="svg-icon ico-product-in-basket">
				<use xmlns:xlink="http://www.w3.org/1999/xlink"
				     xlink:href="/themes/fishmen/assets/css/symbols.svg#ico-product-in-basket"></use>
			</svg>
			<span>Уже в корзине</span> </a>
	</div>
</div>

<div id="TemplateIcoFish" class="hide">
	<i class="">
		<svg class="svg-icon ico-fish">
			<use xmlns:xlink="http://www.w3.org/1999/xlink"
			     xlink:href="/themes/fishmen/assets/css/symbols.svg#ico-fish"></use>
		</svg>
	</i>
</div>

