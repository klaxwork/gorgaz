<div class="regions">
    <?php foreach ($oRegions as $oRegion) { ?>
        <div class="region_wrap">
            <a href="javascript: void(0);" class="region regionBtn"
               data-region_id="<?= $oRegion['id'] ?>"><?= $oRegion['name'] ?></a>
        </div>
    <?php } ?>
</div>