<?php

use yii\helpers\Html;
use kartik\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\ParseSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Parses');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="parse-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [

            'parse_id',
            'provider_id',
            'time_start',
            'time_end',
            'items_parsed',

            ['class' => 'yii\grid\ActionColumn',
                'template'=>'{view}'],
        ],
    ]); ?>
</div>
