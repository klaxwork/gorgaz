<?php if (count($oProducts) > 0) { ?>
    <?php foreach ($oProducts as $oProduct) { ?>
        <?php $oLabels = $oProduct->getLabels(); ?>

        <tr class="depressive" data-id="<?= $oProduct->id ?>">
            <td><?= $oProduct->id ?></td>
            <td>
                <a class="product" target="_blank"
                   href="<?= $this->createUrl('/cms/product/edit', ['id' => $oProduct->id]) ?>"><?= $oProduct->product_name ?></a>
                <span class="is_new label label-success"
                      style="display: <?= !empty($oLabels['is_new']) ? 'inline' : 'none' ?>;">НОВИНКА</span>
                <span class="is_sale label label-danger"
                      style="display: <?= !empty($oLabels['is_sale']) ? 'inline' : 'none' ?>;">РАСПРОДАЖА</span>
            </td>
            <td><?= $oProduct->getField('1c_product_vendor')->field_value ?></td>
            <td><?= !empty($oProduct->appProduct->hasGallery) ? count($oProduct->appProduct->hasGallery) : 0 ?>
                <a target="_blank" href="<?= $this->createUrl('edit', ['id' => $oProduct->id]) ?>?photos=1&tab_Images"
                   class="btn label btn-info EditPhotosBtn">Upload</a>
            </td>
            <td><?= !empty($oProduct->appProduct->tree)
                    ? $oProduct->appProduct->tree->node_name
                    : '' ?></td>
            <td><input type="checkbox" <?= $oProduct->is_closed ? 'checked' : '' ?> disabled></td>
            <td class="price"
                style="text-align: right;"><?= number_format($oProduct->product_price, 0, '.', '&nbsp;') ?>
                <?php if ($oProduct->product_new_price > 0) { ?>
                    <br><span
                            class="label label-warning"><?= number_format($oProduct->product_new_price, 0, '.', '&nbsp;') ?></span>
                <?php } ?>

            </td>

            <td class="action text-right" style="width: 150px;">
                <div class="buttons btn-group text-right">
                    <span data-label="is_new" class="is_ label label-success">new</span><span
                            data-label="is_sale" class="is_ label label-danger">sale</span>
                </div>
                <div class="input btn-group text-right" style="display: none;">
                    <input type="text" class="form-control" name="product_new_price"
                           value="<?= !empty($oLabels['is_sale']) ? $oProduct->product_new_price : '' ?>">
                </div>
            </td>
        </tr>
    <?php } ?>
<?php } ?>

