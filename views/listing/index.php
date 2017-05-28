<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $searchModel app\models\ListingSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Listings');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="listing-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [

            'listing_id',
            'item_id',
            'time_created',
            'change',
            'is_success',
            'price',
            'm2',
            [
                'format'=>'raw',
                'header'=>Yii::t('app','Item'),
                'value'=>function($model){
                    /** @var \app\models\Listing $model  */
                    return Html::a(Yii::t('app', 'Item'), ['item/view', 'id' => $model->item_id],
                        ['class' => 'btn btn-primary',
                            'target'=>'_blank']);
                }
            ],
            [
                'format'=>'raw',
                'header'=>Yii::t('app','Source'),
                'value'=>function($model){
                    /** @var \app\models\Listing $model  */
                    return Html::a(Yii::t('app','Source'), Url::to($model->item->url),[
                        'target'=>'_blank',
                        'class'=>'btn btn-success'
                    ]);
                }
            ],

            ['class' => 'yii\grid\ActionColumn',
            'template'=>'{view}'],
        ],
    ]); ?>
</div>
