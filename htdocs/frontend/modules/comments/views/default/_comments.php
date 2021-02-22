<?php foreach ($oComments as $oComment) { ?>
    <div class="main-item-tab__revievs-item">
        <div class="main-item-tab__revievs-item-info clearfix">
            <div class="main-item-tab__revievs-item-info-user">
                <div class="main-item-tab__revievs-item-info-user-detail">
                    <div class="main-item-tab__revievs-item-info-user-detail-time">
                        <?= strftime('%d.%m.%Y, %H:%M') ?>
                    </div>
                    <div class="main-item-tab__revievs-item-info-user-detail-name">
                        <?= $oComment->relationClient->client_view_name ?>
                    </div>
                </div>
                <div class="main-item-tab__revievs-item-info-user-popular">
                    <div class="main-item-ds__main-info-popular">
                        <ul class="list">
                            <?php for ($i = 0; $i < 5; $i++) { ?>
                                <li class="<?= $i < $oComment->rate ? 'active' : '' ?>">
                                    <svg class="svg-icon ico-fish">
                                        <use xmlns:xlink="http://www.w3.org/1999/xlink"
                                             xlink:href="/themes/fishmen/assets/css/symbols.svg#ico-fish"></use>
                                    </svg>
                                </li>
                            <?php } ?>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="main-item-tab__revievs-item-likes">
                <div
                        class="main-item-tab__revievs-item-likes-item main-item-tab__revievs-item-likes-item_like">
                    <svg class="svg-icon ico-like">
                        <use xmlns:xlink="http://www.w3.org/1999/xlink"
                             xlink:href="/themes/fishmen/assets/css/symbols.svg#ico-like"></use>
                    </svg>
                    <span>0</span>
                </div>
                <div
                        class="main-item-tab__revievs-item-likes-item main-item-tab__revievs-item-likes-item_dislike">
                    <svg class="svg-icon ico-dislike">
                        <use xmlns:xlink="http://www.w3.org/1999/xlink"
                             xlink:href="/themes/fishmen/assets/css/symbols.svg#ico-dislike"></use>
                    </svg>
                    <span>0</span>
                </div>
            </div>
        </div>
        <div class="main-item-tab__revievs-item-text">
            <?= $oComment->client_message ?>
        </div>
        <div class="main-item-tab__revievs-item-advanteges">
            <div class="main-item-tab__revievs-item-advanteges-title">
                <svg class="svg-icon ico-like">
                    <use xmlns:xlink="http://www.w3.org/1999/xlink"
                         xlink:href="/themes/fishmen/assets/css/symbols.svg#ico-like"></use>
                </svg>
                <span>Достоинства</span>
            </div>
            <div class="main-item-tab__revievs-item-advanteges-body">
                <?= $oComment->positive ?>
            </div>
        </div>
        <div
                class="main-item-tab__revievs-item-advanteges main-item-tab__revievs-item-advanteges_dis">
            <div class="main-item-tab__revievs-item-advanteges-title">
                <svg class="svg-icon ico-dislike">
                    <use xmlns:xlink="http://www.w3.org/1999/xlink"
                         xlink:href="/themes/fishmen/assets/css/symbols.svg#ico-dislike"></use>
                </svg>
                <span>Недостатки</span>
            </div>
            <div class="main-item-tab__revievs-item-advanteges-body">
                <?= $oComment->negative ?>
            </div>
        </div>
    </div>
<?php } ?>
