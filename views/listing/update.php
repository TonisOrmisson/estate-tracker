<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Listing */

$this->title = Yii::t('app', 'Update {modelClass}: ', [
    'modelClass' => 'Listing',
]) . $model->listing_id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Listings'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->listing_id, 'url' => ['view', 'id' => $model->listing_id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="listing-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
