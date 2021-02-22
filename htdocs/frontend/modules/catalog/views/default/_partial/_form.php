<?php if (1) { ?>
    <form id="<?= $formName ?>" action="#">
        <div class="raiting-group">
            <div class="raiting-group__title"><b>Ваша оценка:</b></div>
            <div class="raiting-group__checks input-group_star" style="cursor: pointer;">
                <img alt="1" src="/images/advantages.png" title="bad" data-rate="1">&nbsp;<!-- -->
                <img alt="2" src="/images/advantages.png" title="poor" data-rate="2">&nbsp;<!-- -->
                <img alt="3" src="/images/advantages.png" title="regular" data-rate="3">&nbsp;<!-- -->
                <img alt="4" src="/images/advantages.png" title="good" data-rate="4">&nbsp;<!-- -->
                <img alt="5" src="/images/advantages.png" title="gorgeous" data-rate="5"><!-- -->
                <input name="<?= $formName ?>[rate]" id="<?= $formName ?>_rate" type="hidden" value="5">
            </div>
        </div>
        <div class="input-group input-group_in input-group_star">
            <input placeholder="Ваше имя" aria-required="true" aria-invalid="false"
                   type="text" class="main-input main-input_rw" id="<?= $formName ?>_first_name"
                   name="<?= $formName ?>[first_name]" value="">
        </div>
        <div class="input-group input-group_in input-group_star">
            <input placeholder="Электронная почта" aria-required="true" aria-invalid="false"
                   type="text" class="main-input main-input_rw" id="<?= $formName ?>_email"
                   name="<?= $formName ?>[email]" value="">
        </div>
        <div class="input-group input-group_tx">
		<textarea placeholder="Достоинства" id="<?= $formName ?>_positive" name="<?= $formName ?>[positive]"
                  class="textarea textarea_rw"></textarea>
        </div>
        <div class="input-group input-group_tx">
		<textarea placeholder="Недостатки" id="<?= $formName ?>_negative" name="<?= $formName ?>[negative]"
                  class="textarea textarea_rw"></textarea>
        </div>
        <div class="input-group input-group_tx input-group_star">
		<textarea placeholder="Отзыв" id="<?= $formName ?>_client_message" name="<?= $formName ?>[client_message]"
                  class="textarea textarea_rw" aria-required="true"></textarea>
        </div>
        <div class="input-group">
            <button type="submit" class="btn btn_standart-rw" id="SendReview">Оставить отзыв</button>
            <span class="input-group__caption"><i class="star">* </i>— обязательные поля</span>
        </div>
    </form>

    <div id="preloader" style="display: none;">
        <img src="/images/preloader2.gif">
    </div>

    <div id="success" style="display: none;">
        <p>Спасибо за ваш отзыв. После проверки администрацией сайта отзыв будет обубликован.</p>
    </div>
<?php } ?>

<?php if (0) { ?>
    <div class="formBlock">
        <form id="CommentForm">
            <input type="hidden" id="ecm_products_ref" name="ecm_products_ref" value="<?= $oProduct->id ?>">
            <div>Name:<br><input type="text" name="name" value=""></div>
            <div>Email:<br><input type="text" name="email" value=""></div>
            <div class="client_message">Comment:<br><textarea name="client_message"></textarea></div>
            <div class="positive">Positive:<br><textarea name="positive"></textarea></div>
            <div class="negative">Negative:<br><textarea name="negative"></textarea></div>
            <div>
                <button id="SaveComment" class="saveComment">Save comment</button>
            </div>
        </form>
    </div>
<?php } ?>