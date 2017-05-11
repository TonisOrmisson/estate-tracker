<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\UserHasItemSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="user-has-item-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'user_has_item_id') ?>

    <?= $form->field($model, 'user_id') ?>

    <?= $form->field($model, 'item_id') ?>

    <?= $form->field($model, 'user_created') ?>

    <?= $form->field($model, 'time_created') ?>

    <?php // echo $form->field($model, 'active') ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Search'), ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton(Yii::t('app', 'Reset'), ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
