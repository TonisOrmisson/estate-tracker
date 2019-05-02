<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\ItemType */

$this->title = Yii::t('app', 'Update Item Type: {nameAttribute}', [
    'nameAttribute' => $model->name,
]);
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Item Types'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->item_type_id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="item-type-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
