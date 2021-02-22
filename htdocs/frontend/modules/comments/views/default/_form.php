<?php if (1) { ?>
    <form id="<?= $formName ?>" action="#">
        <input type="hidden" id="ecm_products_ref" name="ecm_products_ref" value="<?= $oProduct->id ?>">
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

<script>
    function setRate(i) {
        var on = '/images/advantages.png';
        var off = '/images/disadvantages.png';
        var curr = on;
        $('.raiting-group__checks img').each(function (index, item) {
            var $r = $(item).data('rate');
            if ($r > i) {
                curr = off;
            }
            $(item).attr('src', curr);
        });
    }

    $(document).ready(function () {
        $('.raiting-group__checks img').on('mouseover', function () {
            var rate = $(this).data('rate');
            setRate(rate);
        });

        $('.raiting-group__checks img').on('click', function () {
            var rate = $(this).data('rate');
            $(this).closest('.raiting-group__checks').find('input').val(rate);
        });

        $('.raiting-group__checks img').on('mouseout', function () {
            var rate = $(this).closest('.raiting-group__checks').find('input').val();
            setRate(rate);
        });

        $('body #<?= $formName ?>_vote_value').on('keyup change', function () {
            var num = Number($(this).val());
            if (num > 5) {
                $(this).val(5);
            }
            if (num < 1) {
                $(this).val(1);
            }
        });

        $('#SendReview').on('click', function (e) {
            //console.log(SendReview, 'SendReview');
            e.preventDefault();

            var error = false;
            var errorClass = 'error-input';
            var validClass = 'success-input';

            var first_name = $('#<?= $formName ?>_first_name').val();
            console.log('[first_name]', first_name);
            $('#<?= $formName ?>_first_name').removeClass(validClass);
            $('#<?= $formName ?>_first_name').removeClass(errorClass);
            if (first_name != '') {
                $('#<?= $formName ?>_first_name').addClass(validClass);
            } else {
                $('#<?= $formName ?>_first_name').addClass(errorClass);
                error = true;
            }

            var email = $('#<?= $formName ?>_email').val();
            var pattern = /^([a-z0-9_\.-])+@[a-z0-9-]+\.([a-z]{2,4}\.)?[a-z]{2,4}$/i;
            console.log('[email]', email);
            $('#<?= $formName ?>_email').removeClass(validClass);
            $('#<?= $formName ?>_email').removeClass(errorClass);
            if (pattern.test(email)) {
                $('#<?= $formName ?>_email').addClass(validClass);
            } else {
                $('#<?= $formName ?>_email').addClass(errorClass);
                error = true;
            }

            var client_message = $('#<?= $formName ?>_client_message').val();
            console.log('[client_message]', client_message);
            $('#<?= $formName ?>_client_message').removeClass(validClass);
            $('#<?= $formName ?>_client_message').removeClass(errorClass);
            if (client_message != '') {
                $('#<?= $formName ?>_client_message').addClass(validClass);
            } else {
                $('#<?= $formName ?>_client_message').addClass(errorClass);
                error = true;
            }

            if (!error) {
                $('#<?= $formName ?>').hide();
                $('#preloader').show();
                $.ajax({
                    url: '<?= \yii\helpers\Url::to(['/comments/default/form-comments', 'ecm_products_ref' => $oProduct->id]) ?>',
                    type: 'POST',
                    dataType: 'json',
                    data: $('body #<?= $formName ?>').serialize()
                }).success(function (response) {
                    console.log('[response]', response);
                    if (response.success == true) {
                        //ошибок нет
                        $('#preloader').hide();
                        $('#success').show();
                        yaCounter20170870.reachGoal('post-review');
                        /*
                        pnotify(
                            'success',
                            'Спасибо. Ваш отзыв появится на сайте после модерации администратором.',
                            'Обновление страницы.'
                        );
                        */
                        setTimeout(function () {
                            //location.reload();
                        }, 2000);
                    } else {
                        //ошибки есть
                        var message = $('<div>');
                        var errors = response.messages;
                        var p = '';
                        if (response.messages != undefined) {
                            for (var field in errors) {
                                var error = errors[field];
                                //console.log('[ERROR]', error);
                                for (var index in error) {
                                    var item = error[index];
                                    //console.log('[ITEM]', item);
                                    p += '<p>' + item + '</p>';
                                }
                            }
                            message = '<div style="display: block;">' + p + '</div>';
                            console.log(message);
                            //pnotify('warning', 'Сохранение не прошло', message);
                        }
                        console.log(message);
                        //pnotify('warning', 'Сохранение не прошло', response.message);
                        //$('#submit').prop('disabled', false);
                    }
                }).error(function (data, key, value) {
                    return false;
                    //after_send(data);
                });
            }

        });
    });
</script>
