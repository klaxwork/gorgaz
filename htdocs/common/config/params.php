<?php
return [
    'adminEmail' => 'klaxwork.dn@gmail.com',
    'supportEmail' => 'klaxwork.dn@gmail.com',
    'senderEmail' => 'klaxwork.dn@gmail.com',
    'senderName' => 'KlaxWork',
    'user.passwordResetTokenExpire' => 3600,

    'from' => [
        'email' => 'klaxwork.dn@gmail.com',
        'name' => 'KlaxWork',
    ],

    'emails' => [
        //основное
        'to' => 'klaxwork.dn@gmail.com',
        // копия
        'cc' => null,
        //скрытая копия
        'bcc' => [
            'klaxwork@mail.ru',
            'klaxwork@yandex.ru',
            'klaxwork.dn@gmail.com',
            //'denis@nays.ru',
        ],
        //кому отвечать
        //'ReplyTo' => 'klaxwork.dn@gmail.com',
    ],

];
