<?php

use common\components\M;
use yii\helpers\Url;

//M::printr(count($cats), 'count($cats)');
?>

<?php foreach ($cats as $cat) { ?>
    <?php
    //M::printr($cat->primaryKey, '$cat->primaryKey');
    //M::printr($cat, '$cat');
    //M::printr($cat->category->attributes, '$cat->category->attributes');
    //M::printr($cat->attributes, '$cat->attributes');
    $oImages = $cat
        ->category
        ->content
        ->getImages();
    //M::printr($oImages, '$oImages');
    $imgUrl = '/images/noimg_192.jpg';
    if (!empty($oImages[0])) {
        $oImg = $oImages[0];
        $oCropped = $oImg->getCropped('ecm:teaser_small');
        //M::printr($oCropped->attributes, '$oCropped->attributes');
        $imgUrl = '/store' . $oCropped->fs_alias;
    }
    $name = !empty($cat->category->content->page_longtitle) ? $cat->category->content->page_longtitle : $cat->category->content->page_title;
    $url = Url::toRoute(['/route/catalog', 'id' => $cat->category_id]);
    //M::printr($imgUrl, '$imgUrl');
    ?>
    <div style="vertical-align:top; display: inline-block; width: 200px; min-height: 400px;border: 1px solid #000; margin: 15px;">
        <a href="<?= $url ?>">
            <span><img src="<?= $imgUrl ?>"></span>
            <span><?= $name ?></span><br><br>
        </a>
        <a href="<?= $url ?>">
            <?php if ($cat->price > 0) { ?>
                <span style="background-color: #0f0;">от <?= $cat->price ?> руб.</span>
            <?php } else { ?>
                <span style=""><?= $cat->price ?>Нет в продаже</span>
            <?php } ?>
        </a>
    </div>
<?php } ?>