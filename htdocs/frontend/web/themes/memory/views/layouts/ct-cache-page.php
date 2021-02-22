<?php /* @var $this Controller */ ?>

<?php $this->beginContent('//layouts/main'); ?>

<?php if ($this->beginCache('page' .$this->cache_key, $this->cache_opts)) { ?>


    <?php echo $content; ?>


<?php $this->endCache(); } ?>

<?php $this->endContent(); ?>

