<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $searchModel app\models\ItemSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Items');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="item-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a(Yii::t('app', 'Create Item'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            [
                'attribute'=>'provider_id',
                'value' => 'provider.name',
                'filter' => \yii\helpers\ArrayHelper::map(\app\models\Provider::find()->all(), 'provider_id', 'name'),
                'options'=>['width'=>"1%"],
            ],
            ['attribute'=>'active','options'=>['width'=>"1%"]],
            [
                'attribute'=>'item_type_id',
                'value' => 'itemType.name',
                'filter' => \yii\helpers\ArrayHelper::map(\app\models\ItemType::find()->all(), 'item_type_id', 'name'),
                'options'=>['width'=>"1%"],
            ],
            ['attribute'=>'key', 'header'=>'key', 'options'=>['width'=>"1%"]],
            ['attribute'=>'rating', 'options'=>['width'=>"1%"]],
            'name:ntext',
            'title:ntext',
            [
                'format'=>'raw',
                'header'=>Yii::t('app','Source'),
                'value'=>function($model){
                    /** @var \app\models\Item $model  */
                    return Html::a(Yii::t('app','Source'), Url::to($model->url),[
                            'target'=>'_blank',
                            'class'=>'btn btn-success'
                    ]);
                }
            ],

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
