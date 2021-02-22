<?php

use common\components\M;

M::printr('SEO_HEAD');
?>
<?php if (0) { ?>
	<meta name="keywords" content="<?= $this->context->page_keywords ?>">
	<meta name="description" content="<?= str_replace('"', '&#8243;', $this->context->page_description) ?>">

    <?php if (!empty($this->page_noindexing)) { ?>
		<meta name="robots" content="noindex, nofollow"/>
    <?php } else { ?>
		<meta name="robots" content="index, follow"/>
    <?php } ?>

    <?php if (false && $this->is_quest_page) { ?>
		<!-- schema.org (google plus) -->
		<meta itemscope itemtype="http://schema.org/Product">
		<meta itemprop="name" content="<?= $this->Product['name'] ?>"/>
		<meta itemprop="description" content="<?php //= str_replace('"', "'", $this->Product['description']) ?>"/>
		<meta itemprop="image" content="<?= $this->Product['image'] ?>"/>
		<link itemprop="url" content="<?= $this->Product['url']; ?>"/>
		<meta itemprop="offers" itemscope itemtype="http://schema.org/AggregateOffer"/>
		<meta itemprop="lowPrice" content="<?= $this->AggregateOffer['lowPrice']; ?>"/>
		<meta itemprop="priceCurrency" content="<?= $this->AggregateOffer['priceCurrency']; ?>"/>
    <?php } ?>

	<!-- ogp.me (facebook & vkontakte) -->
	<meta property="og:locale" content="ru_RU"/>
	<meta property="og:type" content="website"/>
	<meta property="og:url"
	      content="https://fishmen.ru/<?php //echo Yii::app()->request->pathInfo . (Yii::app()->request->pathInfo ? '/' : ''); ?>"/>
	<meta property="og:image" content="https://fishmen.ru<?php //echo $this->page_image ?>"/>
	<meta property="og:title" content="<?php //echo str_replace('"', '&#8243;', $this->pageTitle); ?>"/>
	<meta property="og:description" content="<?php //echo str_replace('"', '&#8243;', $this->page_description); ?>"/>
	<meta property="og:site_name" content="Fishmen.ru"/>

	<!-- twitter -->
	<meta name="twitter:card" content="summary"/>
	<meta name="twitter:url"
	      content="https://fishmen.ru/<?php //echo Yii::app()->request->pathInfo . (Yii::app()->request->pathInfo ? '/' : ''); ?>"/>
	<meta name="twitter:image" content="https://fishmen.ru<?php //echo $this->page_image ?>"/>
	<meta name="twitter:title" content="<?php //echo str_replace('"', '&#8243;', $this->pageTitle); ?>"/>
	<meta name="twitter:description" content="<?php //echo str_replace('"', '&#8243;', $this->page_description); ?>"/>
	<meta name="twitter:site" content="@user"/>
	<meta name="twitter:creator" content="@user"/>

<?php } ?>
