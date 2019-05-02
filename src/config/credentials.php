<?php

$params = require(__DIR__ . '/params.php');

return [
    'db'=> [
        'class' => 'yii\db\Connection',
        'dsn' => 'mysql:host=db;dbname=estatetrack',
        'username' => 'root',
        'password' => 'password',
        'charset' => 'utf8',

    ],
    'mailer'=>[
        'class' => 'yii\swiftmailer\Mailer',
        'viewPath' => '@app/mail',
        'useFileTransport' => false,
        'enableSwiftMailerLogging' => false,
        'transport' => [
            'class' => 'Swift_SmtpTransport',
            'host' => 'email-smtp.eu-west-1.amazonaws.com',
            'username' => 'AKIAJOYSSUEC4DYNVT3Q',
            'password' => 'Av8O9Huaa4VmLyMp0E4lhFmGpbUgKHFSInVcfcSzcscF',
            'port' => '587',
            'encryption' => 'tls',
        ]
    ],
    'log' => [
        'traceLevel' => YII_DEBUG ? 3 : 0,
        'targets' => [
            [
                'class' => 'yii\log\FileTarget',
                'logFile'=> '@runtime/logs/error.log',
                'levels' => ['error', 'warning'],
            ],
            [
                'class' => 'yii\log\FileTarget',
                'logFile'=> '@runtime/logs/app.log',
                'categories' => ['app\*'],
                // do not log context
                'logVars' => [],
            ],
            // email  all errors in andmemasin components
            [
                'class' => 'yii\log\EmailTarget',
                'levels' => ['error'],
                'mailer' => 'mailer',
                //'categories' => ['app\*'],
                'message' => [
                    'from' => [$params['adminEmail']],
                    'to' => [$params['adminEmail']],
                    'subject' => 'Error in '.$params['siteName'],
                ],
            ],

        ],
    ],
];
