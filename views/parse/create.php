<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Parse */

$this->title = Yii::t('app', 'Create Parse');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Parses'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="parse-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
