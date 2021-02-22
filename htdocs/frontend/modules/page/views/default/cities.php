<div class="cities">
    <?php foreach ($oCities as $oCity) { ?>
        <div class="city_wrap">
            <a href="javascript: void(0);" class="city cityBtn"
               data-city_id="<?= $oCity['id'] ?>" data-city_name="<?= $oCity['name'] ?>"><?= $oCity['name'] ?></a>
        </div>
    <?php } ?>
</div>