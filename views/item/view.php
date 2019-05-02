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

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a(Yii::t('app', 'Update'), ['update', 'id' => $model->item_id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a(Yii::t('app', 'Delete'), ['delete', 'id' => $model->item_id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => Yii::t('app', 'Are you sure you want to delete this item?'),
                'method' => 'post',
            ],
        ]) ?>
        <?= Html::a(Yii::t('app','Source'), Url::to($model->url),[
            'target'=>'_blank',
            'class'=>'btn btn-success'
        ]);?>
    </p>
    <?= $this->render('_chart', [
        'model' => $model,
    ]) ?>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'item_id',
            'name',
            'rating',
            'title',
            'provider_id',
            'key',
            'm2',
            'time_created',
            'time_changed',
            'content:html',
        ],
    ]) ?>

    <iframe src="<?=$model->url?>" width="100%" height="600">

    </iframe>

</div>
