<?php
$params = require(__DIR__ . '/params.php');

return [
    'db'=> [
        'class' => 'yii\db\Connection',
        'dsn' => 'mysql:host=localhost;dbname=yii2basic',
        'username' => 'root',
        'password' => '',
        'charset' => 'utf8',
    ],
    'mailer'=>[
        'class' => 'yii\swiftmailer\Mailer',
        'viewPath' => '@app/mail',
        'useFileTransport' => false,
        'enableSwiftMailerLogging' => true,
        'transport' => [
            'class' => 'Swift_SmtpTransport',
            [
                'class' => 'Swift_Plugins_LoggerPlugin',
                'constructArgs' => [new Swift_Plugins_Loggers_EchoLogger],
            ],
            'host' => '',
            'username' => '',
            'password' => '',
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
                'categories' => ['app\*'],
                'message' => [
                    'from' => [$params['adminEmail']],
                    'to' => [$params['adminEmail']],
                    'subject' => 'Error in '.$params['siteName'],
                ],
            ],
            // swiftMailer Logging
            [
                'class' => 'yii\log\FileTarget',
                'categories' => ['yii\swiftmailer\Logger::add'],
            ],

        ],
    ],];
