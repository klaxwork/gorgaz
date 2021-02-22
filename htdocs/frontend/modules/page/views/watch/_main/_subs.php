<div class="main-subs">
    <div class="container">
        <div class="main-subs__wrapper clearfix">
            <div class="main-subs__description">
                <div class="main-subs__description-title"><span>Хотите быть в курсе новостей и акций?</span><i>@ПОДПИШИТЕСЬ@ </i><span>НА
                        РАССЫЛКУ!</span></div>
                <div class="main-subs__description-caption">Подпишитесь на рассылку информации о новых товарах и
                    акционных предложений от интернет-магазина «Fishmen.ru». Только полезная информация!
                </div>
            </div>
            <div class="main-subs__form tForm">
                <form id="subsForm" action="#">
                    <div class="input-group">
                        <svg class="svg-icon ico-envelope">
                            <use xmlns:xlink="http://www.w3.org/1999/xlink"
                                 xlink:href="/themes/fishmen/assets/css/symbols.svg#ico-envelope"></use>
                        </svg>
                        <input type="email" placeholder="vash_e-mail@name.ru" name="email" id="email"
                               class="main-input main-input_subs">
                    </div>
                    <div class="main-subs__form-control">
                        <div class="main-subs__form-control-btn">
                            <button type="submit" class="btn btn_standart">Подписаться</button>
                        </div>
                        <div class="main-subs__form-control-check">
                            <label> <input type="checkbox" name="is_agree" id="is_agree" value="1" required="required"><span
                                        class="main-subs__form-control-check-content"><span>С </span><a href="#">условиями
                                        ознакомлен</a><span> и согласен</span></span> </label>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function () {
        /*
        var is_added = false;

        $('.tForm').on('click', function () {
            if (!is_added) {
                var hid = '<input type="hidden" name="checked" value="1">';
                $(this).find('form').append(hid);
                is_added = true;
            }
        });
        */

        $('#subsForm').on('submit', function (e) {
            if (e !== undefined) e.preventDefault();
            var dataForm = $('#subsForm').serialize();
            console.log('[dataForm]', dataForm);
            var url = '<?php echo Yii::app()->createUrl('/page/subscribe/unsubscribe') ?>';
            var is_agree = $(this).find('#is_agree').prop('checked');
            var email = $(this).find('#email').val();
            console.log('is_agree', is_agree);
            if (is_agree && email) {
                sendSubscribe(dataForm, url);
            }
        });

        function sendSubscribe(data, url) {
            $.ajax({
                url: url,
                type: 'POST',
                dataType: 'json',
                data: data,
                success: function (response) {
                    console.log('[response]', response);
                    if (response.success) {
                        console.log('[SUCCESS TRUE]');
                    } else {
                        console.log('[SUCCESS FALSE]');
                    }
                },
                error: function (data, key, value) {
                    console.log('[ERROR]');
                    return false;
                    //after_send(data);
                }
            });
        }
    });
</script>