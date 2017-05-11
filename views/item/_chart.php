<?php

use miloschuman\highcharts\Highcharts;
use app\models\Item;


/* @var $this yii\web\View */
/* @var $model Item */
echo Highcharts::widget([
    'setupOptions' =>[
        'global'=>['useUTC'=> false],
    ],
    'options' => [
        'credits' => ['enabled' => false],

        'chart'=>[
            'type'=>'line'
        ],
        'title' => ['text' => Yii::t('app','Price trend')],
        'xAxis' => [
            'type'=>'datetime',
            'dateTimeLabelFormats'=>[
                'month'=>'%e. %b',
                'year'=>'%b',
            ]
        ],
        'plotOptions'=> [
            'column'=>[
                //'grouping'=>false,
                'pointPadding'=>-0.35,
                'borderWidth'=>0,
            ]
        ],
        'yAxis' => [
            'title' => ['text' => Yii::t('app','Item price')]
        ],
        'series' => [
            [
                'name' => Yii::t('app','Price'),
                'data' => $model->getChartData(),
                'colorIndex'=>7,
            ],
       ]
    ]
]);