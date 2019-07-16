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
            ['title' => ['text' => Yii::t('app','Item price')],'min'=>0],
            ['title' => ['text' => Yii::t('app','m2 price')],'min'=>0,'opposite'=>true]
        ],
        'series' => [
            [
                'name' => Yii::t('app','Price'),
                'data' => $model->getChartPriceData(),
                'yAxis'=>0,
            ],
            [
                'name' => Yii::t('app','Price/m2'),
                'data' => $model->getChartPriceData(true),
                'yAxis'=>1,
            ],
       ]
    ]
]);