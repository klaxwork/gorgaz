<?php
$oChs1 = $oCategory->children(1)
    ->joinWith(['content'])
    ->andWhere(['is_node_published' => true, 'is_trash' => false,])
    ->orderBy('node_name ASC')
    ->all();
$parent_level = $oCategory->ns_level + 1;

//проверяем на текущий уровень+3
$oChs3 = $oCategory->children()
    ->joinWith(['content'])
    ->andWhere(['is_node_published' => true, 'is_trash' => false, 'ns_level' => $oCategory->ns_level + 3])
    ->orderBy('node_name ASC')
    ->all();
$is_level3 = false;
if (!empty($oChs3)) $is_level3 = true;
//$is_level3 = false;

//разбиение на столбцы
$arr = [];
foreach ($oChs1 as $key => $oCh1) {
    $p = $oCh1->getCategoryProducts();
    if (count($p) > 0) {
        $arr[] = $oCh1;
    }
    if ($is_level3) {
        $oChs2 = $oCh1->children(1)
            ->joinWith(['content'])
            ->andWhere(['is_node_published' => true, 'is_trash' => false,])
            ->all();
        foreach ($oChs2 as $oCh2) {
            $p = $oCh2->getCategoryProducts();
            if (count($p) > 0) {
                $arr[] = $oCh2;
            }
        }
    }
}
$columns = 4;
$count = ceil(count($arr) / $columns);
if ($count < 1) {
    $count = 1;
}
$oChs = array_chunk($arr, $count);
$newCol = '</div><div class="catalog-item__item col-md-3 col-sm-6 col-xs-12">';
?>

<div class="catalog-item-wr">
    <div class="container">
        <div class="catalog-item__list">
            <div class="row">
                <div class="catalog-item__item col-md-3 col-sm-6 col-xs-12">
                    <div class="visuallyhidden"><h2>Категории</h2></div>
                    <?php
                    $i = 0;
                    $isNewCol = false;
                    ?>
                    <?php foreach ($arr as $oCh) { ?>
                        <?php if ($i >= $count) $isNewCol = true; ?>
                        <?php if ($isNewCol && $oCh->ns_level == $parent_level) { ?>
                            <?= $newCol ?>
                            <?php
                            $isNewCol = false;
                            $i = 0;
                            ?>
                        <?php } ?>
                        <?php if ($oCh->ns_level == $parent_level) { ?>
                            <a class="title" href="<?= \yii\helpers\Url::to(['/route/catalog', 'id' => $oCh->id]) ?>"
                               title="<?= str_replace('"', '&#8243;', $oCh->node_name) ?>">
                                <h3 class="title"><?= str_replace('"', '&#8243;', $oCh->node_name) ?></h3>
                            </a><br>
                        <?php } elseif (($oCh->ns_left_key + 1) != $oCh->ns_right_key) { //(!$oCh->isLeaf()) { ?>
                            <a class="col-item" href="<?= \yii\helpers\Url::to(['/route/catalog', 'id' => $oCh->id])
                            ?>" title="<?= str_replace('"', '&#8243;', $oCh->node_name) ?>">
                                <?= str_replace('"', '&#8243;', $oCh->node_name) ?>
                            </a>
                        <?php } ?>


                        <?php $i++; ?>
                    <?php } ?>
                </div>
            </div>
        </div>
    </div>
</div>
