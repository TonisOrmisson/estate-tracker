<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $model \app\models\Item */
?>
<div class="item-listings">
    <div class="box box-default">
        <div class="box-header"><h4>Price Changes</h4></div>
        <div class="box-body">
            <?= GridView::widget([
                'dataProvider' => new \yii\data\ActiveDataProvider([
                    'query' => \app\models\Listing::find()->where(['item_id' => $model->primaryKey, 'change' => 1]),
                    'sort' => [
                        'defaultOrder' => [
                            'listing_id' => SORT_DESC,
                        ]
                    ],
                ]),
                'columns' => [

                    'time_created',
                    ['attribute'=>'change','header'=>'change','format' =>'boolean', 'options'=>['width'=>"10%", 'align' => 'right']],
                    ['attribute'=>'price','header'=>'price','format' =>'currency' ,'options'=>['width'=>"10%", 'align' => 'right']],
                    ['attribute'=>'m2','header'=>'m2','format' =>'decimal', 'options'=>['width'=>"10%", 'align' => 'right']],
                ],
            ]); ?>
        </div>
    </div>

    <div class="box box-default">
        <div class="box-header"><h4>All Listing checks</h4></div>
        <div class="box-body">
            <?= GridView::widget([
                'dataProvider' => new \yii\data\ActiveDataProvider([
                    'query' => \app\models\Listing::find()->where(['item_id' => $model->primaryKey]),
                    'sort' => [
                        'defaultOrder' => [
                            'listing_id' => SORT_DESC,
                        ]
                    ],
                ]),
            'rowOptions' => function ($model, $key, $index, $grid) {
                /** @var \app\models\Listing $model */
                if($model->change === 1) {
                     return ['class' => 'text-success text-bold'];
                }
                return [];
            },
                'columns' => [

                    'time_created',
                    ['attribute'=>'change','header'=>'change','format' =>'boolean', 'options'=>['width'=>"10%", 'align' => 'right']],
                    ['attribute'=>'price','header'=>'price','format' =>'currency' ,'options'=>['width'=>"10%", 'align' => 'right']],
                    ['attribute'=>'m2','header'=>'m2','format' =>'decimal', 'options'=>['width'=>"10%", 'align' => 'right']],
                ],
            ]); ?>
        </div>
    </div>
</div>
