<?php

use common\models\Cart;
use common\models\Wish;
use common\components\M;

$Cart = (new Cart())->give();
$oWish = (new Wish())->give();
$cookies = Yii::$app->request->cookies;
$city = $cookies->getValue('gorod', 'Москва');
$confirmCity = $cookies->getValue('is_gorod', 0);

?>
<div class="head-banner">
	<div class="head-banner__header">
		<div class="header_main">
			<div class="container">
				<div class="header__topline clearfix">
					<div class="header__main-tolpine-mobile-btn visible-sm visible-xs"><i></i></div>
					<div class="header__shop-main">
						<ul class="list clearfix">
							<li>
								<div class="header__shop-main-dr">
									<div class="header__shop-main-dr-title"><span>О магазине</span></div>
									<div class="header__shop-main-dr-content">
										<ul class="list">
											<li><a href="/about/" title="Информация о магазине">Информация о
													магазине</a></li>
											<li><a href="/news/" title="Новости и обзоры">Новости и обзоры</a>
											</li>
											<li><a href="#" rel="nofollow" title="Вакансии магазина">Вакансии</a></li>
											<li>
												<a href="/about/contacts/"
												   title="Контакты">Контактная информация</a></li>
											<li><a href="#" rel="nofollow"
											       title="Сотрудничество с нами">Сотрудничество</a></li>
										</ul>
									</div>
								</div>
							</li>
							<li><a href="/about/dostavka-i-oplata/"
							       title="Доставка и оплата">Доставка и оплата</a></li>
							<li><a href="/about/contacts/"
							       title="Контакты">Контакты</a></li>
						</ul>
					</div>
					<div class="header__order"><a href="#modal-order" data-toggle="modal" rel="nofollow"
					                              title="Проверить статус заказа">Состояние заказа</a></div>
					<div class="header__shop-tab">
						<svg class="svg-icon ico-tab-selected">
							<use xmlns:xlink="http://www.w3.org/1999/xlink"
							     xlink:href="/themes/fishmen/assets/css/symbols.svg#ico-tab-selected"></use>
						</svg>
						<a href="/wish/" rel="nofollow"
						   title="Закладки">Закладки</a><span>— <span
									class="wishesCount"><?= count($oWish->wishProducts) ?></span></span>
					</div>
					<div class="header__callback"><a href="#modal-callback" class="forCallback" data-toggle="modal"
					                                 rel="nofollow" title="Заказать обратный звонок">Обратный звонок</a>
					</div>
					<div class="header__cabinet"><a href="#modal-login" data-toggle="modal" rel="nofollow"
					                                title="Вход в личный кабинет">Личный кабинет</a></div>
				</div>
				<div class="header__userline header__userline_main clearfix">
					<div class="header__logo"><a href="/" title="Главная страница"><img src="/images/logo.png"
					                                                                    alt="Рыболовный интернет-магазин Фишмен"></a>
					</div>
					<div class="header__shop-description">интернет-магазин<br>рыболовных товаров</div>
					<div class="header__search-form">
						<form action="/mainSearch/" method="GET" class="searchForm">
							<div class="input-group">
								<input type="text" placeholder="Начните ввод..." name="request" id="main_search_input"
								       class="main-input main-input_search">
							</div>
							<div class="button-group">
								<button type="submit" class="btn btn_search">
									<svg class="svg-icon ico-search">
										<use xmlns:xlink="http://www.w3.org/1999/xlink"
										     xlink:href="/themes/fishmen/assets/css/symbols.svg#ico-search"></use>
									</svg>
								</button>
							</div>
							<div class="header__search-result hidden">
								<div id="Xpreloader_search2" class="preloader"
								     style="text-align: center; width: 100%; display: none;">
									<svg xmlns="http://www.w3.org/2000/svg" width="64px" height="64px"
									     viewBox="0 0 128 128" xml:space="preserve"><g>
											<path fill="#c7bd00"
											      d="M109.25 55.5h-36l12-12a29.54 29.54 0 0 0-49.53 12H18.75A46.04 46.04 0 0 1 96.9 31.84l12.35-12.34v36zm-90.5 17h36l-12 12a29.54 29.54 0 0 0 49.53-12h16.97A46.04 46.04 0 0 1 31.1 96.16L18.74 108.5v-36z"/>
											<animateTransform attributeName="transform" type="rotate" from="0 64 64"
											                  to="360 64 64"
											                  dur="1040ms" repeatCount="indefinite"></animateTransform>
										</g></svg>
								</div>
								<div class="header__search-result-wr" style="display: none"></div>
							</div>
						</form>
					</div>
					<div class="header__contact">
						<div class="header__contact-phone">
							<div class="header__contact-sity-btn select_city"
							     id="header__contact-sity-btn_1">
                                <?= $city ?>
							</div>
							<a href="tel:+74852607047" rel="nofollow" title="Позвоните нам"
							   onclick="yaCounter20170870.reachGoal('tel-click'); return true;">+7 (4852) 60-70-47</a>
						</div>
						<div class="header__contact-caption">Будни с 9 до 20, выходные с 11 до 18</div>

					</div>
					<div class="header__search-mobile-btn visible-xs">
						<svg class="svg-icon ico-search">
							<use xmlns:xlink="http://www.w3.org/1999/xlink"
							     xlink:href="/themes/fishmen/assets/css/symbols.svg#ico-search"></use>
						</svg>
					</div>
					<div class="header__place-mobile-btn visible-xs">
						<svg class="svg-icon ico-place">
							<use xmlns:xlink="http://www.w3.org/1999/xlink"
							     xlink:href="/themes/fishmen/assets/css/symbols.svg#ico-place"></use>
						</svg>
					</div>
					<a href="/cart/" rel="nofollow" class="header__basket clearfix"
					   title="Перейти в корзину">
						<div class="header__basket-ico">
							<svg class="svg-icon ico-basket">
								<use xmlns:xlink="http://www.w3.org/1999/xlink"
								     xlink:href="/themes/fishmen/assets/css/symbols.svg#ico-basket"></use>
							</svg>
						</div>
						<div class="header__basket-caption"><span
									class="count-items countProducts"><?= M::declOfNum(count($Cart->cartProducts), array('товар', 'товара', 'товаров')) ?></span>
						</div>
					</a>
				</div>
			</div>

		</div>
		<div class="nav_main">
			<div class="container">
				<div class="nav__content nav__content_main">
					<div class="nav__catalog">
						<div class="nav__catalog-btn">
							<svg class="svg-icon ico-menu-btn">
								<use xmlns:xlink="http://www.w3.org/1999/xlink"
								     xlink:href="/themes/fishmen/assets/css/symbols.svg#ico-menu-btn"></use>
							</svg>
							<span>Каталог товаров</span>
						</div>
					</div>
					<div class="nav__site">
						<ul class="list clearfix">
							<li>
								<a href="/catalog/primanki/"
								   title="Приманки"><span>приманки</span></a>
							</li>
							<li>
								<a href="/catalog/odezhda-i-obuv/"
								   title="Одежда и обувь"><span>одежда и обувь</span></a>
							</li>
							<li>
								<a href="/catalog/udilisha/"
								   title="Рыболовные удилища"><span>удилища</span></a>
							</li>
							<li>
								<a href="/catalog/katushki/"
								   title="Рыболовные катушки"><span>катушки</span></a>
							</li>
							<li>
								<a href="/catalog/prikormki-i-aromatizatory/"
								   title="Рыболовные прикормки"><span>прикормки</span></a>
							</li>
							<li>
								<a href="/catalog/leski-i-pletenye-shnury/"
								   title="Лески и плетеные шнуры"><span>леска</span></a>
							</li>
							<li class="nav__site-sertificate">
								<a href="#" rel="nofollow" title="Подарочные сертификаты">
									<svg class="svg-icon ico-certificate">
										<use xmlns:xlink="http://www.w3.org/1999/xlink"
										     xlink:href="/themes/fishmen/assets/css/symbols.svg#ico-certificate"></use>
									</svg>
									<span>Сертификаты</span></a>
							</li>
							<li class="nav__site-stock">
								<a href="#" rel="nofollow" title="Акции и скидки">
									<svg class="svg-icon ico-stock">
										<use xmlns:xlink="http://www.w3.org/1999/xlink"
										     xlink:href="/themes/fishmen/assets/css/symbols.svg#ico-stock"></use>
									</svg>
									<span>Акции</span></a>
							</li>
						</ul>
					</div>
					<div class="nav__site-mobile-btn visible-sm visible-xs"><i></i></div>
				</div>
			</div>
			<div class="nav__main-catalog nav__main-catalog_main">
				<div class="nav__main-catalog-topline">
					<div class="container">
						<div class="nav__main-catalog-btn">
							<svg class="svg-icon ico-menu-btn">
								<use xmlns:xlink="http://www.w3.org/1999/xlink"
								     xlink:href="/themes/fishmen/assets/css/symbols.svg#ico-menu-btn"></use>
							</svg>
							<span>Каталог товаров</span>
						</div>
					</div>
				</div>
				<div class="nav__main-catalog-usercontent">
					<div class="container clearfix">
						<div class="nav__main-catalog-usercontent-items">
							<ul class="list">
								<li class="clearfix">
									<div class="nav__main-catalog-usercontent-item-pic">
										<a href="/catalog/primanki/"
										   title="Приманки"> <img src="/images/main-menu/primanki.png"
										                          alt="Приманки"></a>
									</div>
									<div class="nav__main-catalog-usercontent-item-name">
										<a href="/catalog/primanki/"
										   title="Приманки">Приманки</a>
									</div>
								</li>
								<li class="clearfix">
									<div class="nav__main-catalog-usercontent-item-pic">
										<a href="/catalog/udilisha/"
										   title="Удилища"
										><img src="/images/main-menu/udilishha.png" alt="Удилища"></a>
									</div>
									<div class="nav__main-catalog-usercontent-item-name">
										<a href="/catalog/udilisha/"
										   title="Удилища">Удилища</a>
									</div>
								</li>
								<li class="clearfix">
									<div class="nav__main-catalog-usercontent-item-pic">
										<a href="/catalog/katushki/"
										   title="Катушки и аксессуары"> <img src="/images/main-menu/katushki.png"
										                                      alt="Катушки и аксессуары"></a>
									</div>
									<div class="nav__main-catalog-usercontent-item-name">
										<a href="/catalog/katushki/"
										   title="Катушки и аксессуары">Катушки и аксессуары</a>
									</div>
								</li>
								<li class="clearfix">
									<div class="nav__main-catalog-usercontent-item-pic">
										<a href="/catalog/leski-i-pletenye-shnury/"
										   title="Лески и плетеные шнуры"
										><img src="/images/main-menu/leski-i-pletenye-shnury.png"
										      alt="Лески и плетеные шнуры"></a>
									</div>
									<div class="nav__main-catalog-usercontent-item-name">
										<a href="/catalog/leski-i-pletenye-shnury/"
										   title="Лески и плетеные шнуры">Лески и плетеные шнуры</a>
									</div>
								</li>
								<li class="clearfix">
									<div class="nav__main-catalog-usercontent-item-pic">
										<a href="/catalog/equipment/"
										   title="Снаряжение для туризма и отдыха"> <img
													src="/images/main-menu/otdyh-i-turizm.png"
													alt="Снаряжение для туризма и отдыха"></a>
									</div>
									<div class="nav__main-catalog-usercontent-item-name">
										<a href="/catalog/equipment/"
										   title="Снаряжение для туризма и отдыха">Снаряжение</a>
									</div>
								</li>
								<li class="clearfix">
									<div class="nav__main-catalog-usercontent-item-pic">
										<a href="/catalog/odezhda-i-obuv/"
										   title="Одежда и обувь"> <img src="/images/main-menu/odezhda.png"
										                                alt="Одежда и обувь"></a>
									</div>
									<div class="nav__main-catalog-usercontent-item-name">
										<a href="/catalog/odezhda-i-obuv/"
										   title="Одежда и обувь">Одежда и обувь</a>
									</div>
								</li>
								<li class="clearfix">
									<div class="nav__main-catalog-usercontent-item-pic">
										<a href="/catalog/prikormki-i-aromatizatory/"
										   title="Прикормки"> <img src="/images/main-menu/prikormki-i-aromatizatory.png"
										                           alt="Прикормки"></a>
									</div>
									<div class="nav__main-catalog-usercontent-item-name">
										<a href="/catalog/prikormki-i-aromatizatory/"
										   title="Прикормки">Прикормки</a>
									</div>
								</li>
							</ul>
						</div>
						<div class="nav__main-catalog-usercontent-banners">
							<div
									class="nav__main-catalog-usercontent-banner-item nav__main-catalog-usercontent-banner-item_variant">
								<div class="nav__main-catalog-usercontent-banner-item-name">MEPPS</div>
								<div class="nav__main-catalog-usercontent-banner-item-description">Вращающиеся блесна
									Comet PTS Rouges OR
								</div>
								<div class="nav__main-catalog-usercontent-banner-item-link"><a
											href="/catalog/primanki/blesny/mepps/"
											class="btn btn_nav-main-banner"
											title="Блесна Mepps">Смотреть каталог</a></div>
								<div class="nav__main-catalog-usercontent-banner-item-pic"><img
											src="/images/banner_item1.png" alt=""></div>
							</div>
						</div>
					</div>
				</div>
				<div class="nav__main-catalog-popular-usercontent">
					<div class="container clearfix">
						<div class="nav__main-catalog-popular-usercontent-title">Популярные разделы:</div>
						<div class="nav__main-catalog-popular-usercontent-list">
							<ul class="list clearfix">
								<li><a href="/catalog/primanki/voblery/"
								       title="Воблеры и попперы">Воблеры и попперы</a></li>
								<li><a href="/catalog/primanki/voblery/kosadaka/"
								       title="Воблеры Косадака">Воблеры Kosadaka</a></li>
								<li><a href="/catalog/udilisha/spinningovye/akkoi/"
								       title="Спиннинговые удилища Akkoi">Спиннинги Akkoi</a></li>
								<li><a href="/catalog/primanki/myagkie-primanki/lucky-john/"
								       title="Съедобная резина Lucky John">Съедобная резина Lucky John</a></li>
								<li><a href="/catalog/primanki/voblery/bandit/deep-walleye/bandit-deep-walleye/"
								       title="Воблеры Bandit Deep Walley">Воблеры Bandit Deep Walley</a></li>
								<li><a href="/catalog/primanki/balansiry/rapala/"
								       title="Балансиры Rapala">Балансиры Rapala</a></li>
								<li><a href="/catalog/katushki/bezynercionnye-katushki/"
								       title="Безынерционные катушки">Безынерционные катушки</a></li>
								<li><a href="/catalog/prikormki-i-aromatizatory/prikormka/minenko/"
								       title="Прикормки Minenko">Прикормки Minenko</a></li>
								<li><a href="/catalog/primanki/myagkie-primanki/hitfish/"
								       title="Мягкие приманки HitFish">Мягкие приманки HitFish</a></li>
							</ul>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="head-banner__slider">
		<!--div class="head-banner__slider-item">
            <div class="container">
                <div class="head-banner__slider-item-wrpper">
                    <div class="head-banner__slider-img"><a title="Мормышки для зимней рыбалки"
                                                            href="/catalog/primanki/mormyshki/"><img
                                    src="/images/banner7.png"
                                    alt="Мормышки для зимней рыбалки"></a></div>
                    <div class="head-banner__slider-description">
                        <div class="head-banner__slider-division"><a
                                    href="/catalog/primanki/mormyshki/"
                                    title="Каталог зимних мормышек">Каталог мормышек</a></div>
                        <div class="head-banner__slider-name"><span><i>Подготовка</i></span> к зимнему сезону</div>
                        <div class="head-banner__slider-caption">Пополнение линейки вольфрамовых и свинцовых мормышек
                        </div>
                        <div class="head-banner__slider-link"><a
                                    href="/catalog/primanki/mormyshki/"
                                    title="Мормышки для зимней рыбалки" class="btn btn_head-banner">перейти к
                                выбору</a></div>
                    </div>
                </div>
            </div>
        </div-->
		<div class="head-banner__slider-item">
			<div class="container">
				<div class="head-banner__slider-item-wrpper">
					<div class="head-banner__slider-img">
						<a title="Силиконовые приманки Lucky John" href="/catalog/primanki/voblery/gillies/"><img
									src="/images/banner8.png" alt="Силиконовые приманки Lucky John"></a>
					</div>
					<div class="head-banner__slider-description">
						<div class="head-banner__slider-division">
							<a href="/catalog/primanki/" title="Рыболовные приманки">Каталог приманок</a>
						</div>
						<div class="head-banner__slider-name">
							<span><i>АКЦИЯ</i></span> на воблеры для троллинга GILLIES
						</div>
						<div class="head-banner__slider-caption">
							Качественные австралийские воблеры по доступным ценам
						</div>
						<div class="head-banner__slider-link">
							<a href="/catalog/primanki/voblery/gillies/"
							   title="Силиконовые приманки Lucky John" class="btn btn_head-banner">перейти к выбору</a>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="head-banner__slider-item">
			<div class="container">
				<div class="head-banner__slider-item-wrpper">
					<div class="head-banner__slider-img"><a title="Силиконовые приманки Lucky John"
					                                        href="/catalog/primanki/myagkie-primanki/lucky-john/"><img
									src="/images/banner4.png"
									alt="Силиконовые приманки Lucky John"></a></div>
					<div class="head-banner__slider-description">
						<div class="head-banner__slider-division"><a
									href="/catalog/primanki/"
									title="Рыболовные приманки">Каталог приманок</a></div>
						<div class="head-banner__slider-name"><span><i>Много</i></span> силикона марки Lucky John</div>
						<div class="head-banner__slider-caption">большое поступление силиконовых приманок марки Lucky
							John
						</div>
						<div class="head-banner__slider-link"><a
									href="/catalog/primanki/myagkie-primanki/lucky-john/"
									title="Силиконовые приманки Lucky John" class="btn btn_head-banner">перейти к
								выбору</a>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="head-banner__slider-item">
			<div class="container">
				<div class="head-banner__slider-item-wrpper">
					<div class="head-banner__slider-img"><a title="Каталог воблеров"
					                                        href="/catalog/primanki/voblery/"><img
									src="/images/banner1.png" alt=""></a></div>
					<div class="head-banner__slider-description">
						<div class="head-banner__slider-division"><a
									href="/catalog/primanki/"
									title="Рыболовные приманки">Каталог приманок</a></div>
						<div class="head-banner__slider-name"><span><i>Новое</i></span> поступление воблеров</div>
						<div class="head-banner__slider-caption">интернет-магазин «Fishmen» рад предложить вам большой
							выбор приманок
						</div>
						<div class="head-banner__slider-link"><a
									href="/catalog/primanki/voblery/"
									title="Каталог воблеров" class="btn btn_head-banner">перейти к выбору</a></div>
					</div>
				</div>
			</div>
		</div>
		<div class="head-banner__slider-item">
			<div class="container">
				<div class="head-banner__slider-item-wrpper">
					<div class="head-banner__slider-img"><a title="Каталог блесен"
					                                        href="/catalog/primanki/blesny/"><img
									src="/images/banner2.png" alt=""></a></div>
					<div class="head-banner__slider-description">
						<div class="head-banner__slider-division"><a
									href="/catalog/primanki/"
									title="Рыболовные приманки">Каталог приманок</a></div>
						<div class="head-banner__slider-name"><span><i>Новое</i></span> поступление блесен</div>
						<div class="head-banner__slider-caption">интернет-магазин «Fishmen» рад предложить вам большой
							выбор блесен
						</div>
						<div class="head-banner__slider-link"><a
									href="/catalog/primanki/blesny/"
									title="Каталог блесен" class="btn btn_head-banner">перейти к выбору</a></div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
