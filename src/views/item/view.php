<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $model app\models\Item */

$this->title = $model->item_id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Items'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

?>
<div class="item-view">
    <p>
        <?= Html::a(Yii::t('app', 'Update'), ['update', 'id' => $model->item_id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a(Yii::t('app','Source'), Url::to($model->url),[
            'target'=>'_blank',
            'class'=>'btn btn-success'
        ]);?>
        <?= Html::a(Yii::t('app', 'Delete'), ['delete', 'id' => $model->item_id], [
            'class' => 'btn btn-danger pull-right',
            'data' => [
                'confirm' => Yii::t('app', 'Are you sure you want to delete this item?'),
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <div class="box box-default">
        <div class="box-body">

            <?= $this->render('_chart', [
                'model' => $model,
            ]) ?>
        </div>
    </div>

    <div class="box box-default">
        <div class="box-body">

            <?= DetailView::widget([
                'model' => $model,
                'attributes' => [
                    'provider.name',
                    'itemType.name',
                    'item_id',
                    'name',
                    'rating',
                    'title',
                    'provider_id',
                    'key',
                    'm2',
                    'time_created',
                    'time_changed',
                ],
            ]) ?>

        </div>
    </div>


    <div class="box box-default">
        <div class="box-header">Listings</div>
        <div class="box-body">
            dfgdf
        </div>
    </div>

</div>

