<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\UserHasItem */

$this->title = Yii::t('app', 'Create User Has Item');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'User Has Items'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-has-item-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
