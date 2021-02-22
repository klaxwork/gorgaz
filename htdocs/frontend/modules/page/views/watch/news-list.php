<div class="page-wrapper">
    <?php
    $breadcrumbs = [];
    $breadcrumbs['Главная'] = '/';
    $breadcrumbs[$oNews->node_name] = '/news/';
    //$breadcrumbs += $oNews->getBreadcrumbs();
    //$breadcrumbs += $oCategory->getBreadcrumbs();
    //M::printr($breadcrumbs, '$breadcrumbs');
    ?>
    <div class="breadcrumb-wr">
        <div class="container">
            <div class="breadcrumb">
                <?php if (isset($breadcrumbs)) { ?>
                    <?php
                    $this->widget(
                        'common.widgets.Breadcrumbs.Breadcrumbs',//'zii.widgets.CBreadcrumbs',
                        array(
                            'links' => $breadcrumbs,
                        )
                    );
                    ?><!-- breadcrumbs -->
                <?php } ?>
            </div>
        </div>
    </div>
    <section class="main-title">
        <div class="container">
            <h1><?= $oNews->content->page_longtitle ?: $oNews->content->page_title ?></h1>
        </div>
    </section>

    <div class="catalog-item-wr">
        <div class="container">
            <div class="catalog-item__list">
                <div class="row">
                    <div class="catalog-item__item col-md-12 col-sm-12 col-xs-12">
                        <article>
                            <?php foreach ($oNewsList as $oItem) { ?>
                                <div class="main-news__item clearfix" style="margin: 10px 0;">
                                    <?php
                                    $img = '/images/noimg_64.jpg';
                                    $oImages = $oItem->getImages();
                                    if (!empty($oImages)) {
                                        $oImg = $oImages[0]->getCropped('ecm:teaser_news');
                                        $img = '/store' . $oImg->fs_alias;
                                    }
                                    $itemUrl = $this->createUrl('/page/watch/newsView', ['alias' => $oItem->url_alias]);
                                    ?>
                                    <div class="main-news__item-img"><a href="<?= $itemUrl ?>"><img
                                                    src="<?= $img ?>"
                                                    alt="<?= $oItem->content->page_longtitle ?: $oItem->content->page_title ?>"></a>
                                    </div>
                                    <div class="main-news__item-description">
                                        <div class="main-news__item-date"><?= M::OfMonth($oItem->dt_created) ?></div>
                                        <div class="main-news__item-name"><h2>
                                                <a href="<?= $itemUrl ?>"
                                                   title="<?= $oItem->content->page_longtitle ?: $oItem->content->page_title ?>"><?= $oItem->content->page_longtitle ?: $oItem->content->page_title ?></a>
                                            </h2>
                                        </div>
                                        <div class="main-news__item-caption"><?= $oItem->content->page_teaser ?></div>
                                    </div>
                                </div>
                            <?php } ?>

                            <?php //= $page->page_body ?>
                        </article>
                        <!--
                        <p>Рыболовный интернет-магазин «Фишмен.ру» находится в городе Ярославле, ул.Комарова, 3А.</p>
                        <p>Мы осуществляем продажу удилищ, катушек, приманок, лесок и других товаров для рыбалки.</p>
                        <p><a href="/about/contacts">Подробная контактная информация</a></p>
                        -->
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?= $this->renderPartial('_main/_subs') ?>