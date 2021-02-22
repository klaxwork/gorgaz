<?php

use common\components\M;
use yii\helpers\Url;

//M::printr('card.php');
$card = $this->context->card;
if (empty($card['cart'])) $card['cart'] = 1;

$catalog['cart'] = $card['cart'];
$catalog['price'] = $card['price'];
$catalog['count'] = $card['count'];
$catalog['category'] = $card['catalog'];
$catalog['node_name'] = $card['name'];
$catalog['content'] = [];
$catalog['url'] = $card['url'];
$catalog['img'] = $card['imgUrl'];
?>
<?php if (1) { ?>
    <?php
    /*/
    $catalog['cart'] = 1;
    if ($catalog['price'] > 0) {
        if ($catalog['count'] > 0) {
            $catalog['cart'] = 1;
        } else {
            $catalog['cart'] = 1;
        }
    } else {
        $catalog['cart'] = 4;
    }
    if (!$catalog['price'] && !$catalog['count']) {
    }
    //*/

    //$catalog['cart'] = 1;

    //if (empty($catalog['count'])) $catalog['cart'] = 4;
    //$catalog['product_id'] = $catalog['id'];
    //$catalog['node_name'] = $catalog['category_name'];
    //$catalog['content'] = [];
    //$catalog['url'] = Yii::app()->createUrl('page/catalog', ['id' => $catalog['category']]);
    $product_id = !empty($catalog['product_id']) ? $catalog['product_id'] : false;
    ?>
	<div class="filters-catalog__item"
	     data-some="price=<?= $catalog['price'] ?>; cart=<?= $catalog['cart'] ?>">
		<div class="catalog-item <?php
        if ($catalog['cart'] == 1) {
            print "";
        } elseif ($catalog['cart'] == 2) {
            print "catalog-item_in-basket";
        } elseif ($catalog['cart'] == 3) {
            print "catalog-item_order";
        } elseif ($catalog['cart'] == 4) {
            print "catalog-item_out-stock";
        }
        ?>">
            <?php
            $alt = !empty($catalog['content']['page_longtitle']) ? $catalog['content']['page_longtitle'] : $catalog['node_name'];
            $alt = str_replace([",", "\"", "/", "*", "(", ")"], "", $alt);
            ?>
			<div class="catalog-item__ico">
				<div class="catalog-item__img">
					<a title="<?= !empty($catalog['content']['page_longtitle']) ? $catalog['content']['page_longtitle'] : $catalog['node_name'] ?>"
					   href="<?= $catalog['url'] ?><?= $product_id ? '?product_id=' . $product_id : '' ?>"> <img
								class="imgTeaserCatalog" alt="<?= $alt ?>"
								src="<?= !empty($catalog['img']) ? $catalog['img'] : '/images/noimg_small.jpg' ?>"> </a>
				</div>
				<div class="catalog-item__label">
                    <?php if (!empty($catalog['labels']['is_new'])) { ?>
						<div class="product-item__label product-item__label_new">
							<span>Новинка</span>
						</div>
                    <?php } ?>
                    <?php if (!empty($catalog['labels']['is_sale'])) { ?>
						<div class="product-item__label product-item__label_sale">
							<span>Распродажа</span>
						</div>
                    <?php } ?>
				</div>
			</div>
			<div class="catalog-item__main-info">
				<div class="catalog-item__main-name catalog-item__main-name_line">
					<a title="<?= !empty($catalog['content']['page_longtitle']) ? $catalog['content']['page_longtitle'] : $catalog['node_name'] ?>"
					   href="<?= $catalog['url'] ?><?= $product_id ? '?product_id=' . $product_id : '' ?>"> <span
								class="link-style"><?= !empty($catalog['content']['page_longtitle']) ? $catalog['content']['page_longtitle'] : $catalog['node_name'] ?></span>
					</a>
					<div class="hider-bottom x1"></div>
				</div>
				<div class="catalog-item__main-name catalog-item__main-block">
					<a title="<?= !empty($catalog['content']['page_longtitle']) ? $catalog['content']['page_longtitle'] : $catalog['node_name'] ?>"
					   href="<?= $catalog['url'] ?><?= $product_id ? '?product_id=' . $product_id : '' ?>">
						<h3 class="link-style"><?= !empty($catalog['content']['page_longtitle']) ? $catalog['content']['page_longtitle'] : $catalog['node_name'] ?></h3>
						<div class="hider-bottom"></div>
					</a>
				</div>
                <?php if (!empty($catalog['content']['page_teaser'])) { ?>
					<div class="catalog-item__main-description">
                        <?= $catalog['content']['page_teaser'] ?>
					</div>
                <?php } ?>
			</div>
			<div class="catalog-item__price">
				<div class="catalog-item__price-mn clearfix">
                    <?php
                    $price = $catalog['price'];
                    //$price = number_format($catalog['price'], 0, ' ', ' ');
                    ?>
					<div class="product-item__price">
                        <?php if ($price) { ?>
							<div class="product-item__new-price">
								от <?= $price ?> <?= Yii::$app->user->currency ?>
							</div>
                        <?php } ?>
					</div>
                    <?php if ($catalog['cart'] == 1) { ?>
						<div class="product-item__status">
							<a href="<?= $catalog['url'] ?><?= $product_id ? '?product_id=' . $product_id : '' ?>"
							   class=""
							   title="<?= !empty($catalog['content']['page_longtitle']) ? $catalog['content']['page_longtitle'] : $catalog['node_name'] ?>"
							   data-product_id="<?= $product_id ?>">
								<svg class="svg-icon ico-basket">
									<use xmlns:xlink="http://www.w3.org/1999/xlink"
									     xlink:href="/themes/fishmen/assets/css/symbols.svg#ico-basket"></use>
								</svg>
								<span>Купить</span> </a>
						</div>
                    <?php } else if ($catalog['cart'] == 4) { ?>
						<div class="product-item__status">
							<a href="<?= $catalog['url'] ?><?= $product_id ? '?product_id=' . $product_id : '' ?>"
							   class=""
							   title="<?= !empty($catalog['content']['page_longtitle']) ? $catalog['content']['page_longtitle'] : $catalog['node_name'] ?>"
							   data-product_id="<?= $product_id//$this->product_id       ?>">
								<svg class="svg-icon ico-basket">
									<use xmlns:xlink="http://www.w3.org/1999/xlink"
									     xlink:href="/themes/fishmen/assets/css/symbols.svg#ico-basket"></use>
								</svg>
								<span>Нет в<br>продаже</span> </a>
						</div>
                    <?php } ?>
				</div>
			</div>
		</div>
	</div>
<?php } ?>

<?php if (0) { ?>
	<div style="vertical-align:top; display: inline-block; width: 200px; min-height: 400px;border: 1px solid #000; margin: 15px;">
		<a href="<?= $url ?>"> <span><img src="<?= $imgUrl ?>"></span> <span><?= $name ?></span><br><br> </a> <a
				href="<?= $url ?>">
            <?php if ($price > 0) { ?>
				<span style="background-color: #0f0;">от <?= $price ?> руб.</span>
            <?php } else { ?>
				<span style=""><?= $price ?>Нет в продаже</span>
            <?php } ?>
		</a>
	</div>
<?php } ?>


<?php if (0) { ?>
	<!-- CatalogsCardsWidget/CatalogCard -->
    <?php foreach ($catalogs as $catalog) { ?>
        <?php if (0) { ?>
            <?php
            $x = $catalog;
            $product_id = !empty($catalog['product_id']) ? $catalog['product_id'] : false;
            ?>
			<div class="filters-catalog__item"
			     data-some="price=<?= $catalog['price'] ?>; cart=<?= $catalog['cart'] ?>">
				<div class="catalog-item <?php
                if ($catalog['cart'] == 1) {
                    print "";
                } elseif ($catalog['cart'] == 2) {
                    print "catalog-item_in-basket";
                } elseif ($catalog['cart'] == 3) {
                    print "catalog-item_order";
                } elseif ($catalog['cart'] == 4) {
                    print "catalog-item_out-stock";
                }
                ?>">
                    <?php
                    $alt = !empty($catalog['content']['page_longtitle']) ? $catalog['content']['page_longtitle'] : $catalog['node_name'];
                    $alt = str_replace([",", "\"", "/", "*", "(", ")"], "", $alt);
                    ?>
					<div class="catalog-item__ico">
						<div class="catalog-item__img">
							<a title="<?= !empty($catalog['content']['page_longtitle']) ? $catalog['content']['page_longtitle'] : $catalog['node_name'] ?>"
							   href="<?= $catalog['url'] ?><?= $product_id ? '?product_id=' . $product_id : '' ?>"> <img
										class="imgTeaserCatalog"
										alt="<?= $alt ?>"
										src="<?= !empty($catalog['image']) ? '/store' . $catalog['image'] : '/images/noimg_small.jpg' ?>">
							</a>
						</div>
						<div class="catalog-item__label">
                            <?php if (!empty($catalog['labels']['is_new'])) { ?>
								<div class="product-item__label product-item__label_new">
									<span><?= $catalog['labels']['is_new']->label_name ?></span>
								</div>
                            <?php } ?>
                            <?php if (!empty($catalog['labels']['is_sale'])) { ?>
								<div class="product-item__label product-item__label_sale">
									<span><?= $catalog['labels']['is_sale']->label_name ?></span>
								</div>
                            <?php } ?>
						</div>
					</div>
					<div class="catalog-item__main-info">
						<div class="catalog-item__main-name catalog-item__main-name_line">
							<a title="<?= !empty($catalog['content']['page_longtitle']) ? $catalog['content']['page_longtitle'] : $catalog['node_name'] ?>"
							   href="<?= $catalog['url'] ?><?= $product_id ? '?product_id=' . $product_id : '' ?>">
								<span
										class="link-style"><?= !empty($catalog['content']['page_longtitle']) ? $catalog['content']['page_longtitle'] : $catalog['node_name'] ?></span>
							</a>
							<div class="hider-bottom x1"></div>
						</div>
						<div class="catalog-item__main-name catalog-item__main-block">
							<a title="<?= !empty($catalog['content']['page_longtitle']) ? $catalog['content']['page_longtitle'] : $catalog['node_name'] ?>"
							   href="<?= $catalog['url'] ?><?= $product_id ? '?product_id=' . $product_id : '' ?>">
								<h3 class="link-style"><?= !empty($catalog['content']['page_longtitle']) ? $catalog['content']['page_longtitle'] : $catalog['node_name'] ?></h3>
								<div class="hider-bottom"></div>
							</a>
						</div>
                        <?php if ($catalog['content']['page_teaser']) { ?>
							<div class="catalog-item__main-description">
                                <?= $catalog['content']['page_teaser'] ?>
							</div>
                        <?php } ?>
					</div>
					<div class="catalog-item__price">
						<div class="catalog-item__price-mn clearfix">
                            <?php
                            $price = $catalog['price'];
                            //$price = number_format($catalog['price'], 0, ' ', ' ');
                            ?>
							<div class="product-item__price">
                                <?php if ($price) { ?>
									<div class="product-item__new-price">
										от <?= $price ?> <?= Yii::$app->user->currency ?>
									</div>
                                <?php } ?>
							</div>
                            <?php if ($catalog['cart'] == 1) { ?>
								<div class="product-item__status">
									<a href="<?= $catalog['url'] ?><?= $product_id ? '?product_id=' . $product_id : '' ?>"
									   class=""
									   title="<?= !empty($catalog['content']['page_longtitle']) ? $catalog['content']['page_longtitle'] : $catalog['node_name'] ?>"
									   data-product_id="<?= $this->product_id ?>">
										<svg class="svg-icon ico-basket">
											<use xmlns:xlink="http://www.w3.org/1999/xlink"
											     xlink:href="/themes/fishmen/assets/css/symbols.svg#ico-basket"></use>
										</svg>
										<span>Купить</span> </a>
								</div>
                            <?php } else if ($catalog['cart'] == 4) { ?>
								<div class="product-item__status">
									<a href="<?= $catalog['url'] ?><?= $product_id ? '?product_id=' . $product_id : '' ?>"
									   class=""
									   title="<?= !empty($catalog['content']['page_longtitle']) ? $catalog['content']['page_longtitle'] : $catalog['node_name'] ?>"
									   data-product_id="<?= $this->product_id ?>">
										<svg class="svg-icon ico-basket">
											<use xmlns:xlink="http://www.w3.org/1999/xlink"
											     xlink:href="/themes/fishmen/assets/css/symbols.svg#ico-basket"></use>
										</svg>
										<span>Нет в<br>продаже</span> </a>
								</div>
                            <?php } ?>
						</div>
					</div>
				</div>
			</div>
        <?php } ?>
        <?php if (1) { ?>
            <?php
            $catalog['cart'] = 1;
            if ($catalog['price'] > 0) {
                if ($catalog['count'] > 0) {
                    $catalog['cart'] = 1;
                } else {
                    $catalog['cart'] = 1;
                }
            } else {
                $catalog['cart'] = 4;
            }
            if (!$catalog['price'] && !$catalog['count']) {
            }
            //if (empty($catalog['count'])) $catalog['cart'] = 4;
            $catalog['product_id'] = $catalog['id'];
            $catalog['node_name'] = $catalog['category_name'];
            $catalog['content'] = [];
            $catalog['url'] = Url::to('page/catalog', ['id' => $catalog['category']]);
            $product_id = !empty($catalog['product_id']) ? $catalog['product_id'] : false;
            ?>
			<div class="filters-catalog__item"
			     data-some="price=<?= $catalog['price'] ?>; cart=<?= $catalog['cart'] ?>">
				<div class="catalog-item <?php
                if ($catalog['cart'] == 1) {
                    print "";
                } elseif ($catalog['cart'] == 2) {
                    print "catalog-item_in-basket";
                } elseif ($catalog['cart'] == 3) {
                    print "catalog-item_order";
                } elseif ($catalog['cart'] == 4) {
                    print "catalog-item_out-stock";
                }
                ?>">
                    <?php
                    $alt = !empty($catalog['content']['page_longtitle']) ? $catalog['content']['page_longtitle'] : $catalog['node_name'];
                    $alt = str_replace([",", "\"", "/", "*", "(", ")"], "", $alt);
                    ?>
					<div class="catalog-item__ico">
						<div class="catalog-item__img">
							<a title="<?= !empty($catalog['content']['page_longtitle']) ? $catalog['content']['page_longtitle'] : $catalog['node_name'] ?>"
							   href="<?= $catalog['url'] ?><?= $product_id ? '?product_id=' . $product_id : '' ?>"> <img
										class="imgTeaserCatalog" alt="<?= $alt ?>"
										src="<?= !empty($catalog['img']) ? $catalog['img'] : '/images/noimg_small.jpg' ?>">
							</a>
						</div>
						<div class="catalog-item__label">
                            <?php if (!empty($catalog['labels']['is_new'])) { ?>
								<div class="product-item__label product-item__label_new">
									<span><?= 'Новинка' //$catalog['labels']['is_new']                                                                             ?></span>
								</div>
                            <?php } ?>
                            <?php if (!empty($catalog['labels']['is_sale'])) { ?>
								<div class="product-item__label product-item__label_sale">
									<span><?= 'Распродажа' //$catalog['labels']['is_sale']                                                                             ?></span>
								</div>
                            <?php } ?>
						</div>
					</div>
					<div class="catalog-item__main-info">
						<div class="catalog-item__main-name catalog-item__main-name_line">
							<a title="<?= !empty($catalog['content']['page_longtitle']) ? $catalog['content']['page_longtitle'] : $catalog['node_name'] ?>"
							   href="<?= $catalog['url'] ?><?= $product_id ? '?product_id=' . $product_id : '' ?>">
								<span
										class="link-style"><?= !empty($catalog['content']['page_longtitle']) ? $catalog['content']['page_longtitle'] : $catalog['node_name'] ?></span>
							</a>
							<div class="hider-bottom x1"></div>
						</div>
						<div class="catalog-item__main-name catalog-item__main-block">
							<a title="<?= !empty($catalog['content']['page_longtitle']) ? $catalog['content']['page_longtitle'] : $catalog['node_name'] ?>"
							   href="<?= $catalog['url'] ?><?= $product_id ? '?product_id=' . $product_id : '' ?>">
								<h3 class="link-style"><?= !empty($catalog['content']['page_longtitle']) ? $catalog['content']['page_longtitle'] : $catalog['node_name'] ?></h3>
								<div class="hider-bottom"></div>
							</a>
						</div>
                        <?php if (!empty($catalog['content']['page_teaser'])) { ?>
							<div class="catalog-item__main-description">
                                <?= $catalog['content']['page_teaser'] ?>
							</div>
                        <?php } ?>
					</div>
					<div class="catalog-item__price">
						<div class="catalog-item__price-mn clearfix">
                            <?php
                            $price = $catalog['price'];
                            //$price = number_format($catalog['price'], 0, ' ', ' ');
                            ?>
							<div class="product-item__price">
                                <?php if ($price) { ?>
									<div class="product-item__new-price">
										от <?= $price ?> <?= Yii::$app->user->currency ?>
									</div>
                                <?php } ?>
							</div>
                            <?php if ($catalog['cart'] == 1) { ?>
								<div class="product-item__status">
									<a href="<?= $catalog['url'] ?><?= $product_id ? '?product_id=' . $product_id : '' ?>"
									   class=""
									   title="<?= !empty($catalog['content']['page_longtitle']) ? $catalog['content']['page_longtitle'] : $catalog['node_name'] ?>"
									   data-product_id="<?= $this->product_id ?>">
										<svg class="svg-icon ico-basket">
											<use xmlns:xlink="http://www.w3.org/1999/xlink"
											     xlink:href="/themes/fishmen/assets/css/symbols.svg#ico-basket"></use>
										</svg>
										<span>Купить</span> </a>
								</div>
                            <?php } else if ($catalog['cart'] == 4) { ?>
								<div class="product-item__status">
									<a href="<?= $catalog['url'] ?><?= $product_id ? '?product_id=' . $product_id : '' ?>"
									   class=""
									   title="<?= !empty($catalog['content']['page_longtitle']) ? $catalog['content']['page_longtitle'] : $catalog['node_name'] ?>"
									   data-product_id="<?= $this->product_id ?>">
										<svg class="svg-icon ico-basket">
											<use xmlns:xlink="http://www.w3.org/1999/xlink"
											     xlink:href="/themes/fishmen/assets/css/symbols.svg#ico-basket"></use>
										</svg>
										<span>Нет в<br>продаже</span> </a>
								</div>
                            <?php } ?>
						</div>
					</div>
				</div>
			</div>
        <?php } ?>
    <?php } ?>
<?php } ?>
