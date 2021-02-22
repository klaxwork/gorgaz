<section class="main-news">
    <div class="container">
        <div class="main-news__nav clearfix">
            <h2 class="main-product__title">Новости и обзоры</h2>
            <div class="main-product__slider-control">
                <div class="main-product__slider-control-item main-product__slider-control-item_prev nw_prev">
                    <svg class="svg-icon ico-slider-control">
                        <use xmlns:xlink="http://www.w3.org/1999/xlink"
                             xlink:href="/themes/fishmen/assets/css/symbols.svg#ico-slider-control"></use>
                    </svg>
                </div>
                <div class="main-product__slider-control-item main-product__slider-control-item_next nw_next">
                    <svg class="svg-icon ico-slider-control">
                        <use xmlns:xlink="http://www.w3.org/1999/xlink"
                             xlink:href="/themes/fishmen/assets/css/symbols.svg#ico-slider-control"></use>
                    </svg>
                </div>
            </div>
            <div class="main-product__all-product"><a href="<?= $this->createUrl('/page/watch/news') ?>">Все новости и
                    обзоры</a></div>
        </div>
        <div class="main-news__list">
            <div class="main-news__items">
                <?php
                $oNews = CmsTree::model()->findByAttributes(['url_alias' => 'news', 'ns_level' => 1]);
                $criteria = new CDbCriteria();
                $criteria->addCondition('is_node_published IS TRUE AND is_trash IS FALSE');
                $criteria->order = 'dt_created DESC';
                $criteria->limit = 4;
                $criteria->offset = 0;
                $oNewsList = $oNews->descendants()->findAll($criteria);
                ?>
                <?php foreach ($oNewsList as $oItem) { ?>
                    <?php
                    $img = '';
                    $oImages = $oItem->getImages();
                    if (!empty($oImages)) {
                        $oTeaserNews = $oImages[0]->getCropped('ecm:teaser_news');
                        $img = '/store' . $oTeaserNews->fs_alias;
                    }
                    //M::printr($oImages, '$oImages');
                    //exit;
                    //if (!empty($oImages = $oItem->content->hasGallery)) {
                    //$oImages = $oItem->content->hasGallery->gallery->storage;
                    //$oTeaserNews = $oImages->getCropped('ecm:teaser_news');
                    //M::printr($oTeaserNews, '$oTeaserNews');
                    //$img = '/store' . $oTeaserNews->fs_alias;
                    //}
                    $itemUrl = $this->createUrl('/page/watch/newsView', ['alias' => $oItem->url_alias]);
                    ?>
                    <div class="main-news__item clearfix">
                        <div class="main-news__item-img"><a href="<?= $itemUrl ?>"><img src="<?= $img ?>" alt=""></a>
                        </div>
                        <div class="main-news__item-description">
                            <div class="main-news__item-date"><?= M::OfMonth($oItem->dt_created) ?></div>
                            <div class="main-news__item-name"><h3><a
                                            href="<?= $itemUrl ?>"><?= $oItem->content->page_longtitle ?: $oItem->content->page_title ?></a>
                                </h3>
                            </div>
                            <div class="main-news__item-caption"><?= $oItem->content->page_teaser ?></div>
                        </div>
                    </div>
                <?php } ?>
            </div>
        </div>
    </div>
</section>
