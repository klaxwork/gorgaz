<?php

use common\components\M;

use frontend\components\widgets\BreadcrumbsWidget\BreadcrumbsWidget;
use \yii\helpers\Json;
use \yii\helpers\Url;

use yii\helpers\Html;

//M::printr('view.php');
?>
<?= $_breadcrumbs ?>
<?= $_product ?>
<?= $_tabs ?>
<?= $_more_products ?>

<?php if (0) { ?>
	<h1>ТОВАРЫ</h1>
	<style>
		.list {
			padding-left: 0;
			list-style-type: none;
			margin-bottom: 0;
		}

		ul, ol {
			margin-top: 0;
			margin-bottom: 10px;
		}

		.breadcrumb ul li {
			float: left;
			position: relative;
			font-size: 17px;
		}
	</style>
	<div class="wrap_bc">
		<div class="breadcrumb">
            <?= BreadcrumbsWidget::widget(
                [
                    //'is_hide_last' => true,
                    'links' => $breadcrumbs,
                ]
            ); ?>
		</div>
	</div>

	<script>
		var filterConfig = <?= Json::encode($config) ?>;
	</script>

	<div class="cms-default-index">
        <?php //= common\components\M::printr($this->context, '$this->context');?>
		<h1><?= $oCategory->content->page_title ?></h1>
		<div style="border: 1px solid #000;">
			<ul class="" style="list-style-type: none;">
                <?php foreach ($oChs as $oCh) { ?>
                    <?php $oContent = $oCh->content; ?>
					<li>
                        <?php
                        //M::printr($oCh->id, '$oCh->id');
                        //$to = Url::to(['page/catalog', 'id' => $oCh->id]);
                        $to = \yii\helpers\Url::toRoute(['/route/catalog', 'id' => $oCh->id]);
                        //M::printr($to, '$to');
                        ?>
						<a href="<?= $to ?>"><?= !empty($oContent->page_long_title) ? $oContent->page_long_title : $oContent->page_title ?></a>
					</li>
                <?php } ?>
			</ul>
		</div>
		<p>
			This is the view content for action "<?= $this->context->action->id ?>". The action belongs to the
			controller "<?= get_class($this->context) ?>" in the "<?= $this->context->module->id ?>" module.
		</p>
		<p>
			You may customize this page by editing the following file:<br> <code><?= __FILE__ ?></code>
		</p>
	</div>

	<img src="<?= $imgUrl ?>">

    <?php $tm1 = microtime(true); ?>
    <?php foreach ($oProducts as $oProduct) { ?>
		<div id="Product_<?= $oProduct->id ?>" class="selectProduct" data-id="<?= $oProduct->id ?>">
            <?php
            $stores = $oProduct->productStore;
            $store = $oProduct->productStore;
            $oFields = $oProduct->getProductFields();
            $quantity = $store->quantity;
            $oVendor = $oProduct->getField('1c_product_vendor');
            ?>
            <?php M::printr("ID={$oProduct->id} VENDOR={$oVendor->field_value} - {$oProduct->product_name} ({$quantity}) - ({$oProduct->product_price} руб.)"); ?>
		</div>
    <?php } ?>

    <?php
    $tm2 = microtime(true);
    $r = $tm2 - $tm1;
    //M::printr($r, '$r');
    ?>

	<div id="CommentsForm" class="commentsForm" style="margin-bottom: 40px;">
		<h2>ФОРМА ДЛЯ ОТЗЫВОВ (комментариев)</h2>
        <?= Yii::$app->controller->renderPartial('_partial/_form', ['oProduct' => $oProduct]) ?>
	</div>

	<div id="Comments" class="comments" style="margin-bottom: 40px;">
		<h2>Отзывы о товаре (комментарии)</h2>
		<div id="CommentsBlock" class="commentsBlock"></div>
		<div id="Preloader" class="preloader" style="display: none;"><img src="/images/preloader3.gif"></div>
	</div>

	<div id="Fields" class="fields" style="margin-bottom: 40px;">
		<h2>Свойства товара</h2>
		<div id="FieldsBlock" class="fieldsBlock"></div>
		<div id="Preloader" class="preloader" style="display: none;"><img src="/images/preloader3.gif"></div>
	</div>
<?php } ?>

<script>
	var limit = 2;
	var offset = 0;

	function getProductComments(ecm_products_ref) {
		$('#Preloader').show();
		$('#CommentsBlock').html();
		$.ajax({
			//url: '< ?= Url::to(['/beta/filter', 'node_id' => $oCategory->id]) ?>',
			url: '<?= Url::to(['/catalog/products/get-product-comments', 'ecm_products_ref' => '__ID__']) ?>'.replace('__ID__', ecm_products_ref),
			type: 'POST',
			dataType: 'json',
			data: {}, //{ecm_products_ref: ecm_products_ref},
			success: function (response) {
				console.log('[response]', response);
				//alert('=)');
				//$('#products').html(response);
				if (response.success) {
					//ошибок нет
					$('#Preloader').hide();
					$('#CommentsBlock').html(response.html);
					if (response.html == '') {
						$('#CommentsBlock').text('Ни одного отзыва о данном товаре не найдено или не опубликовано модератором');
					}
				} else {
					//ошибки есть
					//$('#errors').empty().append(printrErrors(response.errors));
					//$('#submit').prop('disabled', false);
				}
			},
			error: function (data, key, value) {
				return false;
				//after_send(data);
			}
		});
	}

	function getProductFields(ecm_products_ref) {
		$('#Preloader').show();
		$('#FieldsBlock').html();
		$.ajax({
			//url: '< ?= Url::to(['/beta/filter', 'node_id' => $oCategory->id]) ?>',
			url: '<?= Url::to(['/catalog/products/get-product-fields', 'ecm_products_ref' => '__ID__']) ?>'.replace('__ID__', ecm_products_ref),
			type: 'POST',
			dataType: 'json',
			data: {}, //{ecm_products_ref: ecm_products_ref},
			success: function (response) {
				console.log('[response]', response);
				//alert('=)');
				//$('#products').html(response);
				if (response.success) {
					//ошибок нет
					$('#Preloader').hide();
					$('#FieldsBlock').html(response.html);
				} else {
					//ошибки есть
					//$('#errors').empty().append(printrErrors(response.errors));
					//$('#submit').prop('disabled', false);
				}
			},
			error: function (data, key, value) {
				return false;
				//after_send(data);
			}
		});
	}

	$(document).ready(function () {
		$('body')
			.on('click', '.addToCart', function (e) {
				//e.preventDefault();
				$(this).closest('.catalog-item').addClass('catalog-item_in-basket');
				var $temp = $('#templateInBasket').html();
				$(this).closest('.product-item__status').html($temp);
			})
			.on('click', '.selectProduct', function (e) {
				console.log('.selectProduct');
				var ecm_products_ref = $(this).data('id');
				console.log('ecm_products_ref', ecm_products_ref);
				$('.ecm_products_ref').val(ecm_products_ref);

				getProductComments(ecm_products_ref);
				getProductFields(ecm_products_ref);
			})
			.on('click', '#SaveComment', function (e) {
				e.preventDefault();

				dataFilterSerial = $('#CommentForm').serializeJSON();
				dataFilterSerial['<?= \Yii::$app->request->csrfParam; ?>'] = '<?= \Yii::$app->request->getCsrfToken(); ?>';
				console.log('dataFilterSerial', dataFilterSerial);

				$.ajax({
					url: '<?= Url::to(['/catalog/products/save-comment']) ?>',
					type: 'POST',
					dataType: 'json',
					data: dataFilterSerial,
					success: function (response) {
						console.log('[response]', response);
						if (response.success) {
							//ошибок нет
							if (0) {
								console.log('[countCats]', countCats);
								console.log('limit', limit);
								console.log('offset', offset);

								$('#preloader').hide();
								$('.offset').empty();

								if (countCats > response.config.countAll) response.config.offset = response.config.countAll;

								$('.offset').text(response.config.offset);

								if (response.config.offset >= response.config.countAll) {
									$('#end_list_product').show();
								} else {
									$('#more_product_button').show();
								}
								//$('.countAll').text(response.config.countAll);
								$('.countAll').text(declOfNum(response.config.countAll, tovar));
								//offset = countCats;
								offset += limit;
								$('.offset').text(countCats);
								limit = 2;
								$('.limit').text(limit);
								//$('#products').append(response.response_html);
								$('#products').append(response.html);
							}
						} else {
							//ошибки есть
							//$('#errors').empty().append(printrErrors(response.errors));
							//$('#submit').prop('disabled', false);
						}
					},
					error: function (data, key, value) {
						return false;
						//after_send(data);
					}
				});
			})
		;

		$('.mobile_link').on('click', function () {
			var filter_head = $('#FilterForm').offset();
			console.log('[filter_head]', filter_head);
			$('html, body').stop().animate({
				scrollTop: filter_head.top - 70
			}, 700);
			$('body').find('.filters-catalog__filter-wr').addClass('active');
		});

	});

	var products = <?= Json::encode($products) ?>;
	console.log('products', products);

	function loadMoreReviews() {
		console.log('> function loadMoreReviews() (comments)');
		console.log('limit', limit);
		console.log('offset', offset);
		var product_id = $('#product_id').data('product_id');
		console.log('product_id', product_id);
		$.ajax({
			url: '<?= Url::to(['/comments/default/load-more-comments']) ?>',
			type: 'POST',
			dataType: 'json',
			data: {
				'<?= \Yii::$app->request->csrfParam; ?>': '<?= \Yii::$app->request->getCsrfToken(); ?>',
				'ecm_products_ref': product_id,
				'limit': limit,
				'offset': offset
			}
		}).success(function (response) {
			console.log('[response]', response);
			if (response.success == true) {
				$('#reviewsBlock').append(response.comments);

				limit = Number(response.limit);
				console.log('limit', limit);
				offset += Number(limit);
				console.log('offset', offset);

				$('.jsCountComments').text(response.countAll);

				if (Number(response.limit) + Number(response.offset) >= Number(response.countAll)) {
					$('#loadMoreReviews').hide();
				}

			}
		}).error(function (data, key, value) {
			return false;
			//after_send(data);
		});
	}

	function loadFormReview() {
		var product_id = $('#product_id').data('product_id');
		var url = "<?= Url::to(['/comments/default/form-comments', 'ecm_products_ref' => '__product_id__']); ?>"
			.replace('__product_id__', product_id);
		$.get(url).success(function (response) {
			$('.main-item-tab__revievs-new-form').html(response);
		});
	}

	$(document).ready(function () {
		//загрузить отзывы
		loadMoreReviews();

		//загрузить форму отзыва
		loadFormReview();

		//установить картинку товара
		function setImage(product) {
			console.log('product', product);

			$('#ImgIllustration').attr('href', product.image.illustration);
			if (product.image.teaserBig == '/images/noimg_big.jpg') {
				$('#ImgTeaserBig').removeAttr('itemprop');
			} else {
				$('#ImgTeaserBig').attr('itemprop', 'image');
			}
			$('#ImgTeaserBig').attr('src', product.image.teaserBig);
		}

		if (1) {
			//увеличить количество
			$('#inc').on('click', function (e) {
				e.preventDefault();
				$('#number').val(Number($('#number').val()) + 1);
			});

			//уменьшить количество
			$('#dec').on('click', function (e) {
				e.preventDefault();
				$('#number').val(Number($('#number').val()) - 1);
				if ($('#number').val() < 1) {
					$('#number').val(1);
				}
			});

			//добавить в корзину (есть в футере)
			$('X.addToCart').on('click', function (e) {
				console.log('last addToCart');
				e.preventDefault();
				var id = $(this).data('product_id');
				var url = '<?= Url::to(['/page/cart/addProduct', 'id' => '__product_id__']) ?>'
					.replace('__product_id__', id);
				// __product_id__ => $oProduct->id
				var quantity = Number($('#number').val());
				AddToCart(url, quantity);
			});

			//загрузка отзывов
			$('#loadMoreReviews').on('click', function (e) {
				if (e != undefined) {
					e.preventDefault();
				}
				loadMoreReviews();
			});

			$('body').on('click', '.main-item-tab__body-available-models-table .addTableToCart', function (e) {
				var $temp = $('#templateTabProductInBasket').html();
				$(this).closest('.available-models-table__product-item').addClass('available-models-table__product-item_in-basket');
				$(this).closest('.product-item__status').html($temp);
			});

			$('[data-target ^= to-]').on('click', function (e) {
				if (e != undefined) {
					e.preventDefault();
				}
				var pre_target = $(this).data('target');
				var target = pre_target.substr(3);
				var $href = $('[href=#' + target + ']');
				$href.trigger('click');
				$('html, body').stop().animate({
					scrollTop: $href.offset().top - 80
				}, 1000);
			});
		}

		//выбор товара в категории
		$('input[type="radio"]').on('click', function () {
			$('.jsInfo').addClass('hide');
			var product_id = $(this).closest('.radio-box').data('product_id');

			$('#product_id').data('product_id', product_id);
			$('.forOrder, .forRecall').data('product_id', product_id);
			$('.addToCart').data('product_id', product_id);
			$('.jsWish').data('product_id', product_id);

			var product = products[product_id];
			console.log('[product]', product);

			if (product.vendor == '') {
				$(this).closest('.vendor-code-box').hide();
			} else {
				$('.jsVendor').text(product.vendor);
				$(this).closest('.vendor-code-box').show();
			}

			var price = product.labels.is_sale == undefined ? product.product_price : product.product_new_price;
			//выставить цену
			$('.jsPrice').text(new Intl.NumberFormat('ru-RU', {
				//maximumSignificantDigits: 21,
				minimumFractionDigits: 0,
				maximumFractionDigits: 2
			}).format(price));

			//выставить скидочную цену
			$('.jsNewPrice').text(new Intl.NumberFormat('ru-RU', {
				//maximumSignificantDigits: 21,
				minimumFractionDigits: 0,
				maximumFractionDigits: 2
			}).format(product.product_price));

			//выставить экономию
			$('.jsEconom').text(new Intl.NumberFormat('ru-RU', {
				//maximumSignificantDigits: 21,
				minimumFractionDigits: 0,
				maximumFractionDigits: 2
			}).format(product.product_price - product.product_new_price));

			//спрятать/показать скидочную цену и экономию
			if (product.labels.is_sale == undefined) {
				$('.price-box__detail').hide();
			} else {
				$('.price-box__detail').show();
			}

			//выставить рейтинг
			var rating = Math.floor(product.rating);
			var $fishes = $('.rating-box__stars i');
			$fishes.removeClass('active');
			$fishes.each(function (index, item) {
				if (index < rating) {
					$(item).addClass('active');
				}
			});

			//labels
			if (product.labels.is_new == undefined) $('.jsIsNew').hide();
			else $('.jsIsNew').show();
			if (product.labels.is_sale == undefined) $('.jsIsSale').hide();
			else $('.jsIsSale').show();

			//wish
			if (product.is_in_wish) {
				$('.jsAddWish').hide();
				$('.jsDelWish').show();
			} else {
				$('.jsAddWish').show();
				$('.jsDelWish').hide();
			}

			//показать характеристики
			var $tmpl = $('#charStringTmpl');
			var $append = $('#charStringTmpl').tmpl(product.fields);
			$('.main-item-tab__characteristic__table').html($append);

			//показать нужный блок в зависимости от наличия цены и количества
			if (1) {
				if (product.product_price > 0 && product.quantity > 0) {
					if (product.is_in_cart) {
						$('.jsInCart').removeClass('hide');
					} else {
						$('.jsToCart').removeClass('hide');
					}
				}
				if (product.product_price > 0 && product.quantity == 0) {
					$('.jsForOrder').removeClass('hide');
					$('.price-box__detail').show();
				}
				if (product.product_price == 0) {
					$('.jsNoStore').removeClass('hide');
				}
			}

			$('#reviewsBlock').empty();
			offset = 0;
			loadMoreReviews();
			loadFormReview();

			setImage(product);
		});

		$('.main-item-ds__payment-status-wr .addToCart').on('click', function () {
			//получить шаблон "В корзине"
			var $temp = $('#templateProductInBasket').html();
			//удалить класс "main-item-ds__payment_buy" из "main-item-ds__payment"
			$(this).closest('.main-item-ds__payment').removeClass('main-item-ds__payment_buy');
			//заменить "Купить" на "В корзине"
			$(this).closest('.main-item-ds__payment-status-wr').html($temp);

		});

		$('.jsWish').on('click', function () {
			var product_id = $(this).data('product_id');
			var product = products[product_id];
			console.log('product', product);
			product.is_in_wish = !product.is_in_wish;
			var url = '<?= Url::to(['/page/wish/toggle', 'id' => '__PRODUCT_ID__']); ?>'.replace('__PRODUCT_ID__', product_id);
			toggleWish(url);
			$(this).find('.jsAddWish').toggle();
			$(this).find('.jsDelWish').toggle();
		});


	});

</script>
