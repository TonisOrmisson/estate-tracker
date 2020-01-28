<?php
@include '../env.php';

require(__DIR__ . '/../vendor/autoload.php');
require(__DIR__ . '/../vendor/yiisoft/yii2/Yii.php');

$config = require(__DIR__ . '/../src/config/web.php');

(new yii\web\Application($config))->run();

