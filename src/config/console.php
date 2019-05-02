<?php

$params = require(__DIR__ . '/params.php');
$credentials = require(__DIR__ . '/credentials.php');
$aliases = require(__DIR__ . '/aliases.php');

$config = [
    'id' => 'basic-console',
    'basePath' => dirname(__DIR__),
    'bootstrap' => [
        'log',
        'app\bootstraps\AppBootstrap',
    ],
    'aliases' => $aliases,

    'controllerNamespace' => 'app\commands',
    'components' => [
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'log' => $credentials['log'],
        'db' => $credentials['db'],
        'mailer' => $credentials['mailer'],
    ],
    'params' => $params,
    /*
    'controllerMap' => [
        'fixture' => [ // Fixture generation command line.
            'class' => 'yii\faker\FixtureController',
        ],
    ],
    */
];

if (YII_ENV_DEV) {
    // configuration adjustments for 'dev' environment
    $config['bootstrap'][] = 'gii';
    $config['modules']['gii'] = [
        'class' => 'yii\gii\Module',
    ];
}

return $config;
