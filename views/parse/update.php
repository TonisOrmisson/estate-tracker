<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Parse */

$this->title = Yii::t('app', 'Update {modelClass}: ', [
    'modelClass' => 'Parse',
]) . $model->parse_id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Parses'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->parse_id, 'url' => ['view', 'id' => $model->parse_id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="parse-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
