<?php

use \yii\helpers\Url;
use common\components\M;

M::printr('FOOTER');


if (0) {
    $cookie = Yii::$app->request->cookies;
    $city = $cookie->getValue('gorod', 'Москва');
    $confirmCity = $cookie->getValue('is_gorod', 0);
}
?>

<script>
	$(document).ready(function () {

		$('.summernote').summernote();
		$('.summernote-height').summernote({
			height: 400
		});

		//обработка изменения поля summernote
		$('body')
			.on('change keyup click', '.note-editor', function (e) {
				let contentSummerNote;
				if ($(this).hasClass('codeview')) {
					contentSummerNote = $(this).find('.note-codable').val();
				} else {
					contentSummerNote = $(this).find('.note-editable').html();
				}
				$(this).siblings('textarea').val(contentSummerNote);
			})
		;

	});
</script>

<script>
	function retrieveImageFromClipboardAsBase64(pasteEvent, callback, imageFormat) {
		if (pasteEvent.clipboardData == false) {
			if (typeof(callback) == "function") {
				callback(undefined);
			}
		}
		var items = pasteEvent.clipboardData.items;
		if (items == undefined) {
			if (typeof(callback) == "function") {
				callback(undefined);
			}
		}
		for (var i = 0; i < items.length; i++) {
			// Skip content if not image
			if (items[i].type.indexOf("image") == -1) continue;
			// Retrieve image on clipboard as blob
			var blob = items[i].getAsFile();
			// Create an abstract canvas and get context
			var mycanvas = document.createElement("canvas");
			var ctx = mycanvas.getContext('2d');
			// Create an image
			var img = new Image();
			// Once the image loads, render the img on the canvas
			img.onload = function () {
				// Update dimensions of the canvas with the dimensions of the image
				mycanvas.width = this.width;
				mycanvas.height = this.height;
				// Draw the image
				ctx.drawImage(img, 0, 0);
				// Execute callback with the base64 URI of the image
				if (typeof(callback) == "function") {
					callback(mycanvas.toDataURL(
						(imageFormat || "image/png")
					));
				}
			};
			// Crossbrowser support for URL
			var URLObj = window.URL || window.webkitURL;
			// Creates a DOMString containing a URL representing the object given in the parameter
			// namely the original Blob
			img.src = URLObj.createObjectURL(blob);
		}
	}

	window.addEventListener("paste", function (e) {
		// Handle the event
		retrieveImageFromClipboardAsBase64(e, function (imageDataBase64) {
			// If there's an image, open it in the browser as a new window :)
			if (imageDataBase64) {
				// data:image/png;base64,iVBORw0KGgoAAAAN......
				window.open(imageDataBase64);
			}
		});
	}, false);
</script>
<?php if (0) { ?>
	<!-- FOOTER START -->
	<footer>
		<div class="footer__nav clearfix">
			<div class="container">
				<div class="footer__nav-item">
					<div class="footer__nav-item-categories">
						<ul class="list">
							<li><a href="<?= Url::to(['/route/catalog', 'id' => 307]) ?>"
							       title="Приманки для рыбалки"><b>Приманки</b></a></li>
							<li><a href="<?= Url::to(['/route/catalog', 'id' => 718]) ?>"
							       title="Рыболовные удилища">Удилища</a></li>
							<li><a href="<?= Url::to(['/route/catalog', 'id' => 322]) ?>"
							       title="Рыболовные катушки">Катушки</a></li>
							<li><a href="<?= Url::to(['/route/catalog', 'id' => 886]) ?>"
							       title="Лески и плетеные шнуры">Лески и плетеные шнуры</a></li>
							<li><a href="<?= Url::to(['/route/catalog', 'id' => 339]) ?>"
							       title="Мягкие приманки">Мягкие приманки</a></li>
							<li><a href="<?= Url::to(['/route/catalog', 'id' => 514]) ?>"
							       title="Прикормки и ароматизаторы">Прикормки</a></li>
						</ul>
					</div>
				</div>
				<div class="footer__nav-item">
					<div class="footer__nav-item-categories">
						<ul class="list">
							<li><a href="#" rel="nofollow" title="Как купить"><b>Как купить</b></a>
							<li><a href="#" rel="nofollow" title="Как сделать заказ">Как сделать заказ</a></li>
							<li><a href="/about/dostavka-i-oplata/" title="Доставка заказа">Доставка заказа</a></li>
							<li><a href="#" rel="nofollow" title="Способы оплаты">Способы оплаты</a></li>
							<li><a href="#modal-order" data-toggle="modal" rel="nofollow"
							       title="Проверить состояние заказа">Состояние заказа</a></li>
							<li><a href="#" rel="nofollow" title="Возврат и обмен товара">Возврат и обмен товара</a>
							</li>
						</ul>
					</div>
				</div>
				<div class="footer__nav-item">
					<div class="footer__nav-item-btn">
						<ul class="list">
							<li><a href="/catalog/" class="btn btn_pr-catalog" title="Каталог рыболовных товаров">
									<svg class="svg-icon ico-menu-btn">
										<use xmlns:xlink="http://www.w3.org/1999/xlink"
										     xlink:href="/themes/fishmen/assets/css/symbols.svg#ico-menu-btn"></use>
									</svg>
									<span>Каталог товаров</span></a></li>
							<li><a href="#modal-feedback" data-toggle="modal" rel="nofollow" class="btn btn_write"
							       title="Обратная связь">
									<svg class="svg-icon ico-envelope">
										<use xmlns:xlink="http://www.w3.org/1999/xlink"
										     xlink:href="/themes/fishmen/assets/css/symbols.svg#ico-envelope"></use>
									</svg>
									<span>Написать нам</span></a></li>
						</ul>
					</div>
				</div>
				<div class="footer__nav-item">
					<div class="footer__nav-item-categories">
						<ul class="list">
							<li><a href="/about/" title="О нашем магазине"><b>О магазине</b></a></li>
							<li><a href="/about/contacts/<?php //= $this->createUrl('/about/contacts') ?>"
							       title="Контакты">Контактная информация</a></li>
							<li><a href="#" rel="nofollow" title="Сотрудничество">Сотрудничество</a></li>
							<li><a href="/news/" title="Новости, акции, обзоры"><b>Новости, акции, обзоры</b></a></li>
							<li><a href="#" rel="nofollow" title="Статьи и обзоры">Статьи и обзоры</a></li>
							<li><a href="#" rel="nofollow" title="Каталог производителей">Каталог производителей</a>
							</li>
						</ul>
					</div>
				</div>
			</div>
		</div>
		<div class="footer__info">
			<div class="container">
				<div class="footer__info-wrpper">
					<div class="footer__info-main clearfix">
						<div class="footer__info-copy">
							<div class="footer__info-copy-description">
								© 2014—<?= strftime('%Y') ?>, «<a href="/"
								                                  title="Интернет-магазин товаров для рыбалки Фишмен">Fishmen.ru</a>».<br>
								Интернет-магазин товаров для рыбалки и активного отдыха
							</div>
							<div class="footer__info-copy-link">
								<!--LiveInternet counter-->
								<script type="text/javascript">
									document.write("<a href='//www.liveinternet.ru/click' rel='nofollow' " +
										"target=_blank><img src='//counter.yadro.ru/hit?t26.1;r" +
										escape(document.referrer) + ((typeof(screen) == "undefined") ? "" :
											";s" + screen.width + "*" + screen.height + "*" + (screen.colorDepth ?
											screen.colorDepth : screen.pixelDepth)) + ";u" + escape(document.URL) +
										";h" + escape(document.title.substring(0, 150)) + ";" + Math.random() +
										"' alt='' title='LiveInternet: показано число посетителей за" +
										" сегодня' " +
										"border='0' width='88' height='15'><\/a>")
								</script><!--/LiveInternet--><br> <a href="http://nays.ru" rel="nofollow"
								                                     title="Разработка и поддержка сайта">Разработка и
									поддержка сайта</a>&nbsp;&mdash;&nbsp;NAYS
							</div>
						</div>
						<div class="footer__info-conect-pay">
							<div class="footer__info-conect">Контактный телефон — <a href="tel:+74852607047"
							                                                         rel="nofollow"
							                                                         title="Позвонить по телефону"
							                                                         onclick="yaCounter20170870.reachGoal('tel-click'); return true;"><b>+7
										(4852) 60-70-47</b></a><br> Электронная почта для заказов — <a
										href="mailto:info@fishmen.ru" rel="nofollow" class="underline-link"
										title="Написать на почту">info@fishmen.ru</a>
							</div>
							<div class="footer__info-pay clearfix"><span>Принимаем к оплате<br> (<a href="#"
							                                                                        rel="nofollow"
							                                                                        title="Способы оплаты">Все
										способы оплаты</a>)</span> <img src="/images/payment.png" alt="">
							</div>
						</div>
						<div class="footer__info-social"><span><b>МЫ в соц.сетях.</b><br>Подпишись на обновления
								—</span>
							<ul class="list clearfix">
								<li><a href="https://vk.com/fishmen_ru" target="_blank" rel="nofollow"
								       title="Наша группа во Вконтакте">
										<svg class="svg-icon ico-vk">
											<use xmlns:xlink="http://www.w3.org/1999/xlink"
											     xlink:href="/themes/fishmen/assets/css/symbols.svg#ico-vk"></use>
										</svg>
									</a></li>
								<li><a href="https://www.facebook.com/fishmen.ru/" target="_blank" rel="nofollow"
								       title="Наша группа в Фейсбуке">
										<svg class="svg-icon ico-fb">
											<use xmlns:xlink="http://www.w3.org/1999/xlink"
											     xlink:href="/themes/fishmen/assets/css/symbols.svg#ico-fb"></use>
										</svg>
									</a></li>
							</ul>
						</div>
					</div>
					<div class="footer__info-overal">Информация, указанная на сайте, не является публичной офертой.
						Информация о технических характеристиках товаров, указанная на сайте, может быть изменена
						производителем в одностороннем порядке. Изображения товаров на фотографиях, представленных в
						каталоге на сайте, могут отличаться от оригиналов. Наличие в магазине указано на начало дня.
					</div>
				</div>
			</div>
		</div>
        <?php if (PRODUCTION_MODE) { ?>
			<!-- Yandex.Metrika counter -->
			<script type="text/javascript"> (function (m, e, t, r, i, k, a) {
					m[i] = m[i] || function () {
						(m[i].a = m[i].a || []).push(arguments)
					};
					m[i].l = 1 * new Date();
					k = e.createElement(t), a = e.getElementsByTagName(t)[0], k.async = 1, k.src = r, a.parentNode.insertBefore(k, a)
				})(window, document, "script", "https://mc.yandex.ru/metrika/tag.js", "ym");
				ym(20170870, "init", {
					clickmap: true,
					trackLinks: true,
					accurateTrackBounce: true,
					webvisor: true,
					trackHash: true,
					ecommerce: "dataLayer"
				}); </script>
			<noscript>
				<div><img src="https://mc.yandex.ru/watch/20170870" style="position:absolute; left:-9999px;" alt=""/>
				</div>
			</noscript>
			<!-- /Yandex.Metrika counter -->
        <?php } ?>

	</footer>
	<!-- FOOTER STOP -->

	<!-- MODALS START -->
	<div id="modal-for-recall" tabindex="-1" role="dialog" class="modal fade">
		<div role="document" class="modal-dialog">
			<div class="modal-content">
				<div class="modal-content__close">
					<button type="button" data-dismiss="modal" aria-label="Close" class="close"></button>
				</div>
				<div class="modal-content__title tSuccess" style="display: none;">
					<div class="modal-content__title-heading">Запрос успешно отправлен</div>
				</div>
				<div class="modal-content__title tText">
					<div class="modal-content__title-heading">Нужна консультация?</div>
					<div class="modal-content__title-caption">Оставьте свою электронную почту или номер телефона,<br> и
						мы перезвоним вам.
					</div>
					<div class="modal-content__title-caption">Укажите телефон вместе с кодом,<br/>например:
						+7-XXX-XXX-XX-XX
					</div>
				</div>
				<div class="modal-content__form tForm">
					<form id="modalRecall" action="#">
						<input type="hidden" id="product_id_recall" name="product_id" value="">
						<div class="input-group">
							<input type="text" placeholder="Телефон или Email" name="phoneEmail"
							       class="main-input main-input_modal">
						</div>
						<div class="input-group modal-content__title error" style="display: none;">
							<div class="modal-content__title-caption message"></div>
						</div>
						<div class="button-group">
							<button type="submit" class="btn btn_send" id="buttonRecall">
								<svg xmlns="http://www.w3.org/2000/svg" style="display: none;" class="ico-preloader"
								     width="24px" height="24px" viewBox="0 0 128 128" xml:space="preserve"><g
											transform="rotate(140.709 24 24)">
										<path fill="#fff"
										      d="M109.25 55.5h-36l12-12a29.54 29.54 0 0 0-49.53 12H18.75A46.04 46.04 0 0 1 96.9 31.84l12.35-12.34v36zm-90.5 17h36l-12 12a29.54 29.54 0 0 0 49.53-12h16.97A46.04 46.04 0 0 1 31.1 96.16L18.74 108.5v-36z"></path>
										<animateTransform attributeName="transform" type="rotate" from="0 64 64"
										                  to="360 64 64" dur="1040ms"
										                  repeatCount="indefinite"></animateTransform>
									</g>
                            </svg>
								<svg class="svg-icon ico-send">
									<use xmlns:xlink="http://www.w3.org/1999/xlink"
									     xlink:href="/themes/fishmen/assets/css/symbols.svg#ico-send"></use>
								</svg>
								<span>Отправить</span></button>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
	<div id="modal-for-order" tabindex="-1" role="dialog" class="modal fade">
		<div role="document" class="modal-dialog">
			<div class="modal-content">
				<div class="modal-content__close">
					<button type="button" data-dismiss="modal" aria-label="Close" class="close"></button>
				</div>
				<div class="modal-content__title tSuccess" style="display: none;">
					<div class="modal-content__title-heading">Запрос успешно отправлен</div>
				</div>
				<div class="modal-content__title tText">
					<div class="modal-content__title-heading">Сообщите мне когда появится товар</div>
					<div class="modal-content__title-caption">Оставьте свою электронную почту или номер телефона, и мы
						сообщим вам как только товар поступит на склад.
					</div>
					<div class="modal-content__title-caption">Укажите телефон вместе с кодом,<br/>например:
						+7-XXX-XXX-XX-XX
					</div>
				</div>
				<div class="modal-content__form tForm">
					<form id="modalForOrder" action="#">
						<input type="hidden" id="product_id_order" name="product_id" value="">
						<div class="input-group">
							<input type="text" placeholder="Телефон или Email" name="phoneEmail"
							       class="main-input main-input_modal">
						</div>
						<div class="input-group">
							<input type="text" placeholder="Вас зовут" name="first_name"
							       class="main-input main-input_modal">
						</div>
						<div class="input-group modal-content__title error" style="display: none;">
							<div class="modal-content__title-caption message"></div>
						</div>
						<div class="button-group">
							<button type="submit" class="btn btn_standart">Отправить</button>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
	<div id="modal-order" tabindex="-1" role="dialog" class="modal fade">
		<div role="document" class="modal-dialog">
			<div class="modal-content">
				<div class="modal-content__close">
					<button type="button" data-dismiss="modal" aria-label="Close" class="close"></button>
				</div>
				<div class="modal-content__title">
					<div class="modal-content__title-heading">Проверка состояния заказа</div>
					<div class="modal-content__title-caption">Для проверки состояния заказа, введите номер заказа или
						номер телефона указанный при оформлени
					</div>
				</div>
				<div class="modal-content__form">
					<form id="modalOrder" action="#">
						<div class="input-group">
							<input type="number" placeholder="Номер заказа или телефон" name="id" id="model_order_id"
							       class="main-input main-input_modal">
						</div>
						<div class="input-group modal-content__title error" id="modalOrderResponse"
						     style="display: none">
							<div class="modal-content__title-caption message">
								Заказ № <b><span id="modalOrderViewId">00</span></b>: <span id="modalOrderViewStatus">нет
									статуса</span>
							</div>
						</div>
						<div class="modal-content__form">

						</div>
						<div class="button-group">
							<span class="btn btn_standart" id="modalOrderSubmit">Проверить</span>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
	<div id="modal-callback" tabindex="-1" role="dialog" class="modal fade">
		<div role="document" class="modal-dialog">
			<div class="modal-content">
				<div class="modal-content__close">
					<button type="button" data-dismiss="modal" aria-label="Close" class="close"></button>
				</div>
				<div class="modal-content__title tSuccess" style="display: none;">
					<div class="modal-content__title-heading">Запрос успешно отправлен</div>
				</div>
				<div class="modal-content__title tText">
					<div class="modal-content__title-heading">Обратный звонок</div>
					<div class="modal-content__title-caption">Хотите сделать заказ или возникли вопросы?<br>Мы
						перезвоним вам
					</div>
				</div>
				<div class="modal-content__form tForm">
					<form id="modalCallback" action="#">
						<div class="input-group">
							<input type="text" placeholder="Как Вас зовут?" name="first_name"
							       class="main-input main-input_modal">
						</div>
						<div class="input-group">
							<input type="tel" placeholder="Контактный телефон" name="phone"
							       class="main-input main-input_modal">
						</div>
						<div class="input-group modal-content__title error" style="display: none;">
							<div class="modal-content__title-caption message"></div>
						</div>

						<div class="button-group">
							<button type="submit" class="btn btn_send" id="buttonCallback">
								<svg xmlns="http://www.w3.org/2000/svg" style="display: none;" class="ico-preloader"
								     width="24px" height="24px" viewBox="0 0 128 128" xml:space="preserve"><g
											transform="rotate(140.709 24 24)">
										<path fill="#fff"
										      d="M109.25 55.5h-36l12-12a29.54 29.54 0 0 0-49.53 12H18.75A46.04 46.04 0 0 1 96.9 31.84l12.35-12.34v36zm-90.5 17h36l-12 12a29.54 29.54 0 0 0 49.53-12h16.97A46.04 46.04 0 0 1 31.1 96.16L18.74 108.5v-36z"></path>
										<animateTransform attributeName="transform" type="rotate" from="0 64 64"
										                  to="360 64 64" dur="1040ms"
										                  repeatCount="indefinite"></animateTransform>
									</g>
                            </svg>
								<svg class="svg-icon ico-send">
									<use xmlns:xlink="http://www.w3.org/1999/xlink"
									     xlink:href="/themes/fishmen/assets/css/symbols.svg#ico-send"></use>
								</svg>
								<span>Отправить</span>
							</button>
						</div>
					</form>
				</div>
				<div class="modal-content__callback-foot">
					<div class="modal-content__callback-foot-caption">Вы можете позвонить нам по телефону</div>
					<div class="modal-content__callback-foot-phone"><a href="tel:+74852607047" rel="nofollow"
					                                                   title="Позвонить по телефону">8 (4852)
							60-70-47</a>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div id="modal-login" tabindex="-1" role="dialog" class="modal fade">
		<div role="document" class="modal-dialog">
			<div class="modal-content">
				<div class="modal-content__close">
					<button type="button" data-dismiss="modal" aria-label="Close" class="close"></button>
				</div>
				<div class="modal-content__title tSuccess" style="display: none;">
					<div class="modal-content__title-heading tSuccessMessage">Вы успешно аутентифицированы.</div>
				</div>
				<div class="modal-content__title tTextAuth">
					<div class="modal-content__title-heading">
						Авторизация / <a class="tLinkReg" href="javascript: void(0);" rel="nofollow"
						                 title="Регистрация">Регистрация</a>
					</div>
					<div class="modal-content__title-caption">Выполните вход в «Личный кабинет» для просмотра<br>истории
						покупок и возможности копить «<a href="#" rel="nofollow" title="Бонусы">бонусные баллы</a>»
					</div>
				</div>
				<div class="modal-content__title tTextReg" style="display: none;">
					<div class="modal-content__title-heading">
						<a class="tLinkAuth" href="javascript: void(0);" rel="nofollow"
						   title="Авторизация">Авторизация</a> / Регистрация
					</div>
					<div class="modal-content__title-caption">Зарегистрируйтесь на сайте для просмотра<br>истории
						покупок и возможности копить «<a href="#" rel="nofollow" title="Бонусы">бонусные баллы</a>»
					</div>
				</div>
				<div class="modal-content__form tFormAuth">
					<form id="modalLogin" action="<?php //= $this->action->id ?>">
						<div class="input-group">
							<input type="text" placeholder="Email или номер телефона" name="username"
							       class="main-input main-input_modal">
						</div>
						<div class="input-group">
							<input type="password" placeholder="Ваш пароль" name="password"
							       class="main-input main-input_modal">
						</div>
						<div class="button-group">
							<button type="submit" class="btn btn_send">
								<svg class="svg-icon ico-lock">
									<use xmlns:xlink="http://www.w3.org/1999/xlink"
									     xlink:href="/themes/fishmen/assets/css/symbols.svg#ico-lock"></use>
								</svg>
								<span>Войти</span>
							</button>
						</div>
					</form>
					<div class="modal-content__callback-foot">
						<div class="modal-content__callback-foot-caption">
							<a href="#" rel="nofollow">Забыли пароль?</a>
						</div>
					</div>
				</div>
				<div class="modal-content__form tFormReg" style="display: none;">
					<form id="modalReg" action="<?php //= $this->action->id ?>">
						<div class="input-group">
							<input type="text" placeholder="Ваше Имя" name="modalReg[first_name]"
							       class="main-input main-input_modal">
						</div>
						<div class="input-group">
							<input type="text" placeholder="Email или номер телефона" name="modalReg[username]"
							       class="main-input main-input_modal">
						</div>
						<div class="input-group">
							<div class="row">
								<div class="col-xs-1 col-sm-1 col-md-1 col-lg-1">
									<input type="checkbox" name="modalReg[agree]" id="agree" value="1"
									       class="checkbox main-input main-input_modal"
									       style="width: 15px; height: 15px; display: inline;">
								</div>
								<div class="col-xs-10 col-sm-10 col-md-10 col-lg-10">
									<label for="agree">Подтвердите, что вы согласны с условиями сайта по обработке
										данных.</label>
								</div>
							</div>
						</div>
						<div class="input-group modal-content__title error" style="display: none;">
							<div class="modal-content__title-caption message"></div>
						</div>
						<div class="button-group">
							<button type="submit" class="btn btn_send">
								<svg class="svg-icon ico-lock">
									<use xmlns:xlink="http://www.w3.org/1999/xlink"
									     xlink:href="/themes/fishmen/assets/css/symbols.svg#ico-lock"></use>
								</svg>
								<span>Зарегистрироваться</span>
							</button>
						</div>
					</form>
					<div class="modal-content__callback-foot">
						<div class="modal-content__callback-foot-caption">Войдя на сайт, Вы сможете управлять своими
							заказами, видеть накопленные «бонусы» и управлять подписками
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div id="modal-feedback" tabindex="-1" role="dialog" class="modal fade">
		<div role="document" class="modal-dialog">
			<div class="modal-content">
				<div class="modal-content__close">
					<button type="button" data-dismiss="modal" aria-label="Close" class="close"></button>
				</div>
				<div class="modal-content__title tSuccess" style="display: none;">
					<div class="modal-content__title-heading tSuccessMessage">
						Спасибо за сообщение. Мы ответим Вам в течение 24 часов.
					</div>
				</div>
				<div class="modal-content__title tText">
					<div class="modal-content__title-heading">
						Напишите нам
					</div>
					<div class="modal-content__title-caption">Появились вопросы, критика или предложение?<br> Напишите
						нам, мы обязательно ответим.
					</div>
				</div>
				<div class="modal-content__form tForm">
					<form id="modalFeedback" action="#" novalidate="novalidate">
						<div class="input-group" style="margin-bottom: 20px;">
							<input type="text" placeholder="Как Вас зовут?" name="first_name"
							       class="main-input main-input_modal" required="required">
						</div>
						<div class="input-group" style="margin-bottom: 20px;">
							<input type="text" placeholder="Контактный телефон или email" name="contact"
							       class="main-input main-input_modal" required="required">
						</div>
						<div class="input-group" style="margin-bottom: 20px;">
							<textarea name="message" placeholder="Сообщение"
							          class="main-input main-input_modal" style="height: 200px;"></textarea>
						</div>
						<div class="input-group modal-content__title error" style="display: none;">
							<div class="modal-content__title-caption message"></div>
						</div>

						<div class="button-group">
							<button type="submit" class="btn btn_send">
								<svg class="svg-icon ico-send">
									<use xmlns:xlink="http://www.w3.org/1999/xlink"
									     xlink:href="/themes/fishmen/assets/css/symbols.svg#ico-send"></use>
								</svg>
								<span>Отправить</span>
							</button>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>

	<style>
		.block_tr {
			vertical-align: top;
		}

		.modal_content_wrap {
			width: 100%;
			margin: 0;
			padding: 0;
		}

		.left_block {
			width: 30%;
			height: 500px;
			overflow-y: scroll;
			display: inline-block;
			left: 0;
			top: 0;
			position: relative;
		}

		.right_wrap {
			width: 69%;
			height: 500px;
			overflow-y: hidden;
			display: inline-block;
			right: 0;
			top: 0;
			position: relative;
			padding-left: 20px;
		}

		.right_block {
			width: 100%;
			height: 430px;
			overflow-y: auto;
			display: inline-block;
			right: 0;
			top: 0;
			position: relative;
		}

		.search_block {
			width: 100%;
			height: 70px;
			Xoverflow-y: scroll;
			display: inline-block;
			right: 0;
			top: 0;
			position: relative;
		}
	</style>
	<div id="modal-region-city" tabindex="-1" role="dialog" class="modal fade">
		<div class="modal-dialog" style="width: 900px;">
			<div class="modal-content">
				<div class="modal-content__close">
					<button type="button" data-dismiss="modal" aria-label="Close" class="close"></button>
				</div>
				<div class="modal-content__title">
					<div class="modal-content__title-heading">
						Укажите ваш город
					</div>
					<div class="modal-content__title-caption hide">Появились вопросы, критика или предложение?<br>
						Напишите нам, мы обязательно ответим.
					</div>
				</div>
				<div class="modal-content__form" style="height: 500px; margin-bottom: 30px;">
					<div class="modal_content_wrap" style="">
						<div class="left_block">

						</div>
						<div class="right_wrap">
							<div class="search_block">
								<input id="input_city" type="text"
								       placeholder="Введите название города"
								       class="main-input main-input_sity input_city">
							</div>
							<div id="preloader_city" class="preloader"
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
							<div class="right_block">

							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<!-- MODALS STOP -->

	<script>
		function getRegions() {
			console.log('getRegions()');
			$.ajax({
				url: '<?= Url::to(['/page/default/get-regions']); ?>',
				type: 'GET',
				dataType: 'json',
				success: function (response) {
					console.log('[RESPONSE]', response);
					if (response.success) {
						//ошибок нет
						$('.left_block').html(response.regionsHtml);

					} else {
						//ошибки есть
						$('.tFormReg .error .message').text(response.message);
						$('.tFormReg .error').show();
					}
					if (response.redirect !== undefined) {
						window.location.href = response.redirect;
					}
				},
				error: function (data, key, value) {
					return false;
				}
			});
		}

		function getCities(regionId) {
			console.log('getCities(regionId)', regionId);
			$.ajax({
				url: '<?= Url::to(['/page/default/get-cities', 'regionId' => '__REGIONID__']); ?>'.replace('__REGIONID__', regionId),
				type: 'GET',
				dataType: 'json',
				success: function (response) {
					console.log('[RESPONSE]', response);
					if (response.success) {
						//ошибок нет
						$('.right_block').html(response.citiesHtml);
					} else {
						//ошибки есть
					}
					if (response.redirect !== undefined) {
						window.location.href = response.redirect;
					}
				},
				error: function (data, key, value) {
					return false;
				}
			});
		}

		$(document).ready(function () {
			var city = '';
			var confirmCity = 0;
			//getRegions();

			$('body')
				.on('click', '.regionBtn', function (e) {
					//выбрали регион
					console.log('.regionBtn');
					$('.region_wrap').removeClass('active');
					$(this).closest('.region_wrap').addClass('active');
					$('#input_city').val('');
					$('.right_block').empty();
					var regionId = $(this).data('region_id');
					console.log('regionId', regionId);
					getCities(regionId);
				})
				.on('click', '.cityBtn', function (e) {
					//выбрали город
					console.log('.cityBtn');
					var cityId = $(this).data('city_id');
					city = $(this).data('city_name');
					console.log('cityId', cityId);
					console.log('cityName', city);

					Cookies.set('gorod', city, {expires: <?= time() ?> +3600 * 24 * 7});
					Cookies.set('is_gorod', 1, {expires: <?= time() ?> +3600 * 24 * 7});

					console.log('Cookies.get()', Cookies.get());
					$('#modal-region-city').modal('hide');
					$('.select_city').text(city);
				})
			;

			$('#modalLogin').on('submit', function (e) {
				if (e !== undefined) e.preventDefault();
				var data = $(this).serialize();
				console.log('[DATA]', data);
				var url = '<?= Url::to(['/cabinet/auth/login']); ?>';
				sendForEmail(data, url);
			});

			//спрятать авторизацию, показать регистрацию
			$('.tLinkReg').on('click', function (e) {
				if (e !== undefined) e.preventDefault();
				$('.tTextAuth, .tFormAuth').hide();
				$('.tTextReg, .tFormReg').show();
				$('.tFormReg .error').hide();
			});

			//спрятать регистрацию, показать авторизацию
			$('.tLinkAuth').on('click', function (e) {
				if (e !== undefined) e.preventDefault();
				$('.tTextAuth, .tFormAuth').show();
				$('.tTextReg, .tFormReg').hide();
				$('.tFormReg .error').hide();
			});

			//отправка регистрационных данных
			$('#modalReg').on('submit', function (e) {
				if (e !== undefined) e.preventDefault();

				var fData = $(this).serialize();
				var url = '<?= Url::to(['/cabinet/auth/reg']); ?>';
				$.ajax({
					url: url,
					type: 'POST',
					dataType: 'json',
					data: fData
				}).success(function (response) {
					console.log('[RESPONSE]', response);
					if (response.success) {
						//ошибок нет
						$('.tSuccessMessage').text('Вы успешно зарегистрировались.');
						$('.tSuccess').show();
						$('.tLinkAuth').trigger('click');

					} else {
						//ошибки есть
						$('.tFormReg .error .message').text(response.message);
						$('.tFormReg .error').show();
					}
					if (response.redirect !== undefined) {
						window.location.href = response.redirect;
					}
				}).error(function (data, key, value) {
					return false;
				});
			});
		});
	</script>

	<div id="modal-summ-small" tabindex="-1" role="dialog" class="modal fade">
		<div role="document" class="modal-dialog">
			<div class="modal-content">
				<div class="modal-content__close">
					<button type="button" data-dismiss="modal" aria-label="Close" class="close"></button>
				</div>
				<div class="modal-content__title">
					<div class="modal-content__title-heading">Увы и ах...</div>
					<div class="modal-content__title-caption">Для успешного оформления заказа Вам необходимо добавить в
						корзину товаров на сумму от 1500 рублей.
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="header__contact-sity">
		<!--style="top: 123px; left: 715px;"-->
		<div>
			<div style="margin-bottom: 10px;">Ваш город &mdash; <b><?= $city ?></b>?
			</div>
			<input class="btn btn_catalog small_btn" style="font-size: 15px;" type="button" value="Да" id="CityYes">
			<input
					class="btn btn_catalog small_btn" style="font-size: 15px;" type="button"
					value="Выбрать другой город"
					id="CityNo">
		</div>
        <?php /*/ ?>
    <form action="#" style="display: none;">
        <div class="input-group group">
            <input id="input_city" type="text"
                   placeholder="Введите название города" class="main-input main-input_sity input_city">
            <button type="reset" class="btn btn_reset"></button>
            <input id="input_city_id" type="hidden">
            <input id="input_city_name" type="hidden">
        </div>
        <div id="preloader_city" class="preloader" style="text-align: center; width: 100%; display: none;">
            <svg xmlns="http://www.w3.org/2000/svg" width="64px" height="64px"
                 viewBox="0 0 128 128" xml:space="preserve"><g>
                    <path fill="#c7bd00"
                          d="M109.25 55.5h-36l12-12a29.54 29.54 0 0 0-49.53 12H18.75A46.04 46.04 0 0 1 96.9 31.84l12.35-12.34v36zm-90.5 17h36l-12 12a29.54 29.54 0 0 0 49.53-12h16.97A46.04 46.04 0 0 1 31.1 96.16L18.74 108.5v-36z"/>
                    <animateTransform attributeName="transform" type="rotate" from="0 64 64" to="360 64 64"
                                      dur="1040ms" repeatCount="indefinite"></animateTransform>
                </g></svg>
        </div>
        <div id="city_result" style="display: none;" class="header__search-result-product-list">
            <ul style="list-style-type: none;" class="list">
                <?php for ($i = 0; $i < 7; $i++) { ?>
                    <li id="city_option_<?= $i ?>" onclick="choose_city(<?= $i ?>)"></li>
                <?php } ?>
            </ul>
        </div>
    </form>
    <?php //*/ ?>
		<!--<div class="header__contact-sity-detail">
            <a href="#" rel="nofollow" title="Информация о доставке">Подробнее о доставке</a>
        </div>-->
	</div>

	<div class="header__contact_search">

		<div id="Xpreloader_search3" class="preloader" style="text-align: center; width: 100%; display: none;">
			PRELOADER
			<!--<svg xmlns:svg="http://www.w3.org/2000/svg" xmlns="http://www.w3.org/2000/svg"
                 xmlns:xlink="http://www.w3.org/1999/xlink" width="64px" height="64px"
                 viewBox="0 0 128 128" xml:space="preserve"><g>
                    <path fill="#c7bd00"
                          d="M109.25 55.5h-36l12-12a29.54 29.54 0 0 0-49.53 12H18.75A46.04 46.04 0 0 1 96.9 31.84l12.35-12.34v36zm-90.5 17h36l-12 12a29.54 29.54 0 0 0 49.53-12h16.97A46.04 46.04 0 0 1 31.1 96.16L18.74 108.5v-36z"/>
                    <animateTransform attributeName="transform" type="rotate" from="0 64 64" to="360 64 64"
                                      dur="1040ms" repeatCount="indefinite"></animateTransform>
                </g></svg>-->
		</div>
		<div id="search_result" style="display: none;" class="header__search-result-product-list">
			SEARCH_RESULT
			<!--<ul style="list-style-type: none;" class="list">
                <?php for ($i = 0; $i < 7; $i++) { ?>
                    <li id="city_option_<?= $i ?>" onclick="choose_city(<?= $i ?>)"></li>
                <?php } ?>
            </ul>-->
		</div>
	</div>

    <?php if (PRODUCTION_MODE) { ?>
		<!-- ga -->
		<script>
			(function (i, s, o, g, r, a, m) {
				i['GoogleAnalyticsObject'] = r;
				i[r] = i[r] || function () {
					(i[r].q = i[r].q || []).push(arguments)
				}, i[r].l = 1 * new Date();
				a = s.createElement(o),
					m = s.getElementsByTagName(o)[0];
				a.async = 1;
				a.src = g;
				m.parentNode.insertBefore(a, m)
			})(window, document, 'script', 'https://www.google-analytics.com/analytics.js', 'ga');

			ga('create', 'UA-5801458-28', 'auto');
			ga('send', 'pageview');
		</script>
		<!-- ga -->
    <?php } ?>

	<script>
		/**
		 * отправка данных
		 */
		function sendForEmail(data, url, reachGoalCode) {
			$('.error').hide();
			$('.tSuccess').hide();

			//console.log('[DATA]', data);
			data += '&uri=<?= $_SERVER['REQUEST_URI'] ?>';
			//console.log('[DATA]', data);
			$.ajax({
				url: url,
				type: 'POST',
				dataType: 'json',
				data: data
			}).success(function (response) {
				//console.log('[response]', response);
				if (response.success) {
					//ошибок нет
					//console.log('[RESPONSE]', response);

					//очистить поля
					$('#modalForOrder, #modalCallback, #modalForRecall, #modalLogin, #modalFeedback').find('input').val('');

					//спрятать modal-content__title
					$('.tText, .tForm').hide();
					$('.tSuccessAuth').show();
					$('.tSuccess').show();
					setTimeout(function () {
						//спрятать модальное окно
						$('#modal-for-order, #modal-for-recall, #modal-callback, #modal-login, #modal-feedback').modal('hide');
						if (response.redirect !== undefined) {
							window.location.href = response.redirect;
						}
						setTimeout(function () {
							$('.tForm').show();
							$('.tSuccess').hide();
							$('.error').hide();
						}, 500);
					}, 3000);
					if (reachGoalCode !== undefined) {
						yaCounter20170870.reachGoal(reachGoalCode);
					}

				} else {
					//ошибки есть
					$('.error .message').text(response.message);
					$('.error').show();

					//$('#errors').empty().append(printrErrors(response.errors));
					//$('#submit').prop('disabled', false);
				}
				$('.ico-send').show();
				$('.ico-preloader').hide();
				$('#modalCallback button, #modalRecall button, #modalFeedback button').attr('disabled', false);
			}).error(function (data, key, value) {
				return false;
				//after_send(data);
			});

		}

		var time_keypress_city = performance.now();
		var time_keypress_search = performance.now();
		var time_keypress_limit = 400; // задержка в милисекундах
		var city_option = new Array(7);

		function send_city() {
			console.log('send_city()');
			pause = performance.now() - time_keypress_city;
			if (pause > time_keypress_limit) {
				str = $('#input_city').val();
				if (str.length >= 2) {
					console.log('send_city() > 2');
					$('.right_block').empty();
					$('#city_result').hide();
					$('#preloader_city').show();
					//console.log("ЗАПРОС К СЕРВЕРУ:", str);
					//$('#preloader_city').hide();
					$.ajax({
						url: '/cityReply/',
						type: 'GET',
						dataType: 'json',
						data: {
							'request': str
						}
					}).success(function (response) {
						console.log('response', response);
						$('#preloader_city').hide();
						$('.right_block').empty();
						if (response.success) {
							var $cities = $('<div>').addClass('cities');
							response.city.forEach(function (item, index) {
								var $wrap = $('<div>').addClass('city_wrap');
								var $a = $('<a>')
									.attr('href', 'javascript: void(0);')
									.addClass('city cityBtn')
									.data('city_id', item.id)
									.data('city_name', item.name)
								;
								var str = item.type_view + ' ' + item.name + ' (' + item.region + ')';
								$a.append(str);
								$wrap.append($a);
								$cities.append($wrap);
							});
							$('.right_block').append($cities);
							if (0) {
								for (i = 0; i < response.count; i++) {
									city_option[i] = new Array();
									city_option[i]['name'] = response.city[i]['name'];
									city_option[i]['fullName'] = response.city[i]['type_view'] + ' ' + response.city[i]['name'] + ' (' + response.city[i]['region'] + ')';
									city_option[i]['id'] = response.city[i]['id'];
									//console.log(i, city_option[i]['name']);
									$('#city_option_' + i).text(city_option[i]['fullName']);
								}
								for (; i < response.count; i++) {
									$('#city_option_' + i).text("");
								}
								$('#city_result').show();
							}
						} else {

						}
					}).error(function (data, key, value) {
						return false;
					});
				} else {
					$('#preloader_city').hide();
				}
			}
		}

		function clear_city() {
			$('#city_result').hide();
			$('#city_result li').text('');
		}

		function close_city() {
			$('#input_city').val("");
			clear_city();
		}

		function choose_city(i) { //щелчёк по говоду в списке предложений
			$('#input_city_id, #cityId').val(city_option[i]['id']);
			$('#input_city_name, #city').val(city_option[i]['name']);
			console.log('CITY_ID_1', city_option[i]['id']);
			console.log('CITY_NAME', city_option[i]['name']);

			$('.select_city').text(city_option[i]['name']);
			$('.header__contact-sity').removeClass('active');
			close_city();
			Cookies.set('city_option', {
				'id': city_option[i]['id'],
				'name': city_option[i]['name']
			}, {expires: <?= time() ?> +3600 * 24 * 7});
			if (city_option[i]['name'] == 'Москва') {
				$('.product_city').hide();
			} else {
				$('.product_city').show();
			}
		}

		function clear_search() {
			//$('#city_result').hide();
			//$('#city_result li').text('');
		}

		/*function close_city() {
         $('#main_search_input').val("");
         clear_search();
         }*/

		function changeWishesCount(action) {
			var count = Number(Cookies.get('wishesCount'));
			//console.log('Cookies.count', count);
			if (isNaN(count)) {
				count = 0;
			}
			if (action == 'add') {
				count++;
				//console.log('[COUNT+]', count);
			}
			if (action == 'remove') {
				count = count - 1;
				if (count < 0) {
					count = 0;
				}
				//console.log('[COUNT-]', count);
			}
			Cookies.set('wishesCount', count, {expires: <?= time() ?> +3600 * 24 * 7});
			$('.wishesCount').text(count);
		}

		//отправка товара на сервер для добавления или удаления из закладок
		function send_wish(product_id, $self) {
			if ($self === undefined) {
				$self = $('footer');
			}
			var text = '', title = '';

			$.ajax({
				url: '<?= Url::to(['/page/wish/toggle', 'id' => '__product_id__']); ?>'
					.replace('__product_id__', product_id),
				type: 'GET',
				dataType: 'json',
				success: function (response) {
					if (response.success) {
						//console.log('[ACTION]', response.action);
						if (response.action == 'add') {
							//console.log('ADD');
							$self.find('use').attr('xlink:href', '/themes/fishmen/assets/css/symbols.svg#ico-tab-selected');
							text = 'Удалить из закладок';
							title = 'Удалить товар из закладок';
						}
						if (response.action == 'remove') {
							//console.log('REMOVE');
							$self.find('use').attr('xlink:href', '#ico-tab-un-selected');
							text = 'Добавить в закладки';
							title = 'Добавить товар в закладки';
						}
						var nodeName = $self.attr('rel');
						//console.log('[nodeName]', nodeName);
						if (nodeName == 'nofollow') {
							$self.text(text).attr('title', text);
							$self.blur();
						}
						changeWishesCount(response.action);
						//console.log('success.toggle');
					} else {
						//console.log('!success.toggle');
					}
				},
				error: function (data, key, value) {
					return false;
				}
			});
		}

		var is_added = false;
		var tm = null; //таймаут

		function send_search() {
			console.log('send_search()');
			var currTime = performance.now();
			console.log('Текущее время', currTime);
			console.log('Время последнего нажатия', time_keypress_search);


			//time_keypress_search = currTime;
			pause = currTime - time_keypress_search;
			console.log('time_keypress_search', time_keypress_search);
			console.log('pause', pause);
			if (pause > time_keypress_limit) {
				str = $('#main_search_input').val();
				console.log('str.length', str.length);
				if (str.length == 0) {
					str = $('.main-input_search').val();
				}
				if (str.length >= 3) {

					//$('#search_result').hide();
					//$('.header__search-result').show();
					$('.header__search-result').removeClass('hidden');
					//$('#Xpreloader_search').show();
					console.log("ЗАПРОС К СЕРВЕРУ:", str);

					$.ajax({
						//url: '/searchReply/',
						url: '/search/',
						type: 'GET',
						dataType: 'text',
						data: {
							'request': str
						},
						success: function (response) {
							console.log("ОТВЕТ СЕРВЕРА ПОЛУЧЕН");
							//$('#Xpreloader_search').hide();
							$('.preloader').hide();
							$('.header__search-result-wr').html(response);
							$('.header__search-result-wr').show();
						},
						error: function (data, key, value) {
							console.log("ОТВЕТ СЕРВЕРА НЕ РАСПОЗНАН");
							return false;
						}
					});
				} else {
					$('#preloader_city').hide();
				}
			}
		}

		var SearchString = null;
		var oldSearchString = null;

		$(document).ready(function () {

			//при вводе в строку поиска
			$('#main_search_input')
				.on('keyup', function (e) {
					//меняем строку поиска
					//показать прелоадер
					//через 700мс сделать запрос на поиск искомой строки
					//как только запрос ответил
					//спрятать прелоадер
					//показать результаты

					if ((e.keyCode === 10) || (e.keyCode === 13)) {
						e.preventDefault();
						return false;
					}
					clearInterval(tm);

					$('.preloader').show();
					$('.header__search-result-wr').html('');
					$('.header__search-result-wr').show();

					SearchString = $('#main_search_input').val();
					console.log('SearchString', SearchString);
					tm = setInterval(function () {
						if (SearchString !== oldSearchString) {
							oldSearchString = SearchString;
							send_search();
						}
					}, 700);

					//console.log('time_keypress_search: ', time_keypress_search);
					//console.log('time_keypress_limit: ', time_keypress_limit);
					//tm = setTimeout(send_search(), time_keypress_limit);
					//time_keypress_search = performance.now();
				})
				.closest('form')
				.on('submit', function (e) {
					//e.preventDefault();
					//send_search();
				})
			;

			//показать подтверждение города
			if (1) {
				confirmCity = Cookies.get('is_gorod', 0);
				console.log('>>> confirmCity', confirmCity);

				$('#CityYes').on('click', function (e) {
					//подтверждаем, что полученный город тот что нужно
					console.log('#CityYes');
					console.log('Cookies.get()', Cookies.get());
					city = Cookies.get('gorod');
					confirmCity = Cookies.get('is_gorod');
					console.log('gorod', city);
					console.log('is_gorod', confirmCity);
					//Cookies.set('gorod', city, {expires: <?= time() ?> +3600 * 24 * 7});
					Cookies.set('is_gorod', 1, {expires: <?= time() ?> +3600 * 24 * 7});
					$('.header__contact-sity').removeClass('active');
				});

				$('#CityNo').on('click', function (e) {
					//Показать модальное окно
					console.log('Показать модальное окно.');
					//$.cookie('confirmCity', 1);
					$('#modal-region-city').modal('show');
				});

				//кликнули по городу
				$('.select_city').on('click', function (e) {
					console.log('.select_city');
					console.log('Cookies.get()', Cookies.get());
					city = Cookies.get('gorod');
					confirmCity = Cookies.get('is_gorod', 0);
					console.log('CITY:', city);
					console.log('CONFIRM:', confirmCity);
					if (confirmCity == 1) {
						console.log('CONFRM -- 1');
						$('#modal-region-city').modal('show');
					} else {
						console.log('CONFRM -- 0');
						console.log('event', e.target);
						console.log('XY', $('#' + e.target.id).offset());
						position_xy = $('#' + e.target.id).offset();
						console.log('XY', position_xy);
						if (position_xy.top == 0) return false;
						position_xy.top += 7 + $('#' + e.target.id).height();
						//console.log('XY', position_xy);
						$('.header__contact-sity').offset(position_xy);
						$(this).addClass('active');
						$('.header__contact-sity').addClass('active');
						setTimeout(function () {
							$('#input_city').focus();
						}, 100);
					}
				});
			}

			//удалить товар из закладок
			$('.items-wishes .remove-item').on('click', function (e) {
				e.preventDefault();
				var product_id = $(this).data('id');
				send_wish(product_id);
				$(this).closest('.filters-catalog__item').remove();
			});

			//обработка желаний (закладок)
			$('.wishes').on('click', function (e) {
				e.preventDefault();
				var product_id = $(this).data('id');
				var $self = $(this);
				send_wish(product_id, $self);
			});

			//обработка нажатия клавиши Escape
			$('body').keyup(function (e) {
				if (e.keyCode == 27) {
					$('.header__contact-sity').removeClass('active');
					$('.header__contact-sity-btn').removeClass('active');
					$('#input_city').val("");
					clear_city();
				}
			});

			//очистка списка городов при нажатии на крестик
			$('.btn_reset').on('click', function () {
				clear_city();
			});

			//при вводе города
			$('#input_city')
				.on('keyup', function (e) {
					if ((e.keyCode === 10) || (e.keyCode === 13)) {
						e.preventDefault();
						return false;
					}
					var l = $('#input_city').val();
					if ($('#input_city').val().length < 2) {
						clear_city();
					}
					time_keypress_city = performance.now();
					//console.log(time_keypress_city);
					setTimeout(send_city, time_keypress_limit);
				})
				.closest('form')
				.on('submit', function (e) {
					e.preventDefault();
				})
			;

			$('body')
			//добавить в корзину
				.on('click', '.addToCart', function (e) {
					console.log('footer addToCart');
					var id = $(this).data('product_id');
					console.log('id', id);
					var url = '<?= Url::to(['/page/cart/add-product', 'id' => '__product_id__']); ?>'.replace('__product_id__', id);
					console.log('url', url);
					// __product_id__ => $oProduct->id
					var quantity = Number($('#number').val());
					if (isNaN(quantity)) {
						quantity = 1;
					}
					console.log('quantity', quantity);
					products[id].is_in_cart = true;
					$('#number').val(1);
					$(this).closest('.unit-description__details').find('.jsToCart').addClass('hide');
					$(this).closest('.unit-description__details').find('.jsInCart').removeClass('hide');
					AddToCart(url, quantity);
				})
				//добавить товар в форму для создания под заказ
				.on('click', '.forOrder', function (e) {
					e.preventDefault();
					$('.tText, .tForm').show();
					$('.tSuccess').hide();
					//$('#modal-for-order').modal('show');
					var product_id = $(this).data('product_id');
					$('#modalForOrder #product_id_order').val(product_id);
				})
				//добавить товар в форму для создания под заказ
				.on('click', '.forRecall', function (e) {
					e.preventDefault();
					$('.tText, .tForm').show();
					$('.tSuccess').hide();
					$('#modal-for-recall').modal('show');
					var product_id = $(this).data('product_id');
					//console.log('[PRODUCT_ID]', product_id);
					$('#modalRecall #product_id_recall').val(product_id);
				})
			;

			$('#modalForOrder').on('submit', function (e) {
				//отправить данные для сохранения заказа
				e.preventDefault();
				var data = $('#modalForOrder').serialize();
				var url = '<?= Url::to(['/order/order/sendForOrder']) ?>';
				sendForEmail(data, url, 'request-for-order');
			});

			//*/
			$('#modalOrderSubmit').on('click', function (e) {
				$.ajax({
					url: '/order/status',
					type: 'GET',
					dataType: 'json',
					data: {
						'id': $('#model_order_id').val()
					}
				}).success(function (response) {
					if (response.success) {
						$('#modalOrderViewId').text(response.id);
						$('#modalOrderViewStatus').text(response.status);
						$('#modalOrderResponse').show();

					} else {
						$('#modalOrderViewId').text(response.id);
						$('#modalOrderViewStatus').text(response.status);
						$('#modalOrderResponse').show();
					}
				}).error(function (data, key, value) {
					return false;
				});
			});
			//*/

			$('body').on('click', '.XforCallback', function (e) {
				e.preventDefault();
				$('.tText, .tForm').show();
				$('.tSuccess').hide();
				$('#modal-callback').modal('show');
			});

			$('#modalCallback').on('submit', function (e) {
				e.preventDefault();
				$('.ico-send').hide();
				$('.ico-preloader').show();
				$('#modalCallback button').attr('disabled', true);
				var data = $('#modalCallback').serialize();
				var url = '<?= Url::to(['/page/modals/send-for-callback']) ?>';
				sendForEmail(data, url, 'request-callback');
			});

			$('.tForm').on('click', function () {
				if (!is_added) {
					var hid = '<input type="hidden" name="checked" value="1">';
					$(this).find('form').append(hid);
					is_added = true;
				}
			});

			$('#modalFeedback').on('submit', function (e) {
				e.preventDefault();
				$('.ico-send').hide();
				$('.ico-preloader').show();
				$('#modalFeedback button').attr('disabled', true);
				var data = $('#modalFeedback').serialize();
				var url = '<?= Url::to(['/page/watch/contactsFeedbackForm']) ?>';
				sendForEmail(data, url, 'request-feedback');
			});

			$('#modalRecall').on('submit', function (e) {
				e.preventDefault();
				$('.ico-send').hide();
				$('.ico-preloader').show();
				$('#modalRecall button').attr('disabled', true);
				var data = $('#modalRecall').serialize();
				var url = '<?= Url::to(['/page/modals/send-for-recall']) ?>';
				sendForEmail(data, url, 'request-recall');
			});

			//есом закрывается модальное окно
			$('.modal').on('hidden.bs.modal', function (e) {
				var $form = $(this).find('.tForm form');
				if ($form.length > 0) {
					console.log('HIDE MODAL!!!');
					setTimeout(function () {
						$('.tForm').show();
						$form[0].reset();
						$('.tSuccess').hide();
						$('.error').hide();
					}, 500);
				}
			});

			//если открываем модальное окно
			$('.modal').on('shown.bs.modal', function (e) {
				console.log('SHOW MODAL!!!');
			});

			if (Number(confirmCity) == 0) {
				console.log('confirmCity', confirmCity);
				console.log('Открыть подтверждение города (Да/Нет)');
				$('.select_city').trigger('click');
			}

			$('.XsearchForm').submit(function () {
				//console.log('.searchForm submit');
				//send_search();
				//$(this).submit();
			});

		});
	</script>

    <?php if (PRODUCTION_MODE) { ?>
		<!-- BEGIN JIVOSITE CODE {literal} -->
		<script type='text/javascript'>
			(function () {
				var widget_id = '4NFEoVdmVT';
				var d = document;
				var w = window;

				function l() {
					var s = document.createElement('script');
					s.type = 'text/javascript';
					s.async = true;
					s.src = '//code.jivosite.com/script/widget/' + widget_id;
					var ss = document.getElementsByTagName('script')[0];
					ss.parentNode.insertBefore(s, ss);
				}

				if (d.readyState == 'complete') {
					l();
				} else {
					if (w.attachEvent) {
						w.attachEvent('onload', l);
					} else {
						w.addEventListener('load', l, false);
					}
				}
			})();</script>
		<!-- {/literal} END JIVOSITE CODE -->
    <?php } ?>
	<script>
		function getCity() {
			console.log('getCity()');
			$.ajax({
				url: '<?= Url::to(['/page/default/get-city']); ?>',
				type: 'GET',
				dataType: 'json',
				data: {
					ip: '<?= \common\components\M::get_ip() ?>'
				},
				success: function (response) {
					console.log('RESPONSE', response);
					if (response.success) {
						$('#header__contact-sity-btn_2').text(response.city);
						console.log('response.city', response.city);
						//TODO включить Cookies.set()
						Cookies.set('gorod', response.city, {expires: <?= time() ?> +3600 * 24 * 7});
						$('.select_city').trigger('click');
					} else {
					}
				},
				error: function (data, key, value) {
					alert('Город не вернулся...');
					return false;
				}
			});

		}

		$(document).ready(function () {
			console.log('$(document).ready()');
			var all = Cookies.get();
			console.log('ALL', all);
			city = Cookies.get('gorod');
			confirmCity = Cookies.get('is_gorod');
			console.log('CITY', city);
			console.log('CONFIRMCITY', confirmCity);

			//город не выбран
			if (confirmCity == undefined || confirmCity == 0 || confirmCity == '0' || confirmCity == false || confirmCity == null) {
				getCity();
			} else {
				console.log('city', city);
				$('.select_city').text(city);
			}
			//getCity();
		});
	</script>
<?php } ?>
