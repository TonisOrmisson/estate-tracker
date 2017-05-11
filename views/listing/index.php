<?php

use yii\helpers\Html;
use yii\grid\GridView;

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
            'price',
            'm2',

            ['class' => 'yii\grid\ActionColumn',
            'template'=>'{view}'],
        ],
    ]); ?>
</div>
