<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use andmemasin\jsonform\JsonForm;

/* @var $this yii\web\View */
/* @var $model app\models\Provider */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="provider-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'url')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'active')->textInput() ?>

    <?= $form->field($model, 'locator_options')->textInput(['maxlength' => true]) ?>
    <?= JsonForm::widget([
        'id'=>'locator_options',
        'json'=>$model->locator_options,
        'jsonFieldId'=>'provider-locator_options',
        'variables' => $model->getOptionVars(),
        'labels'=>true,
    ]); ?>

    <?= $form->field($model, 'comment')->textarea(['rows' => 6]) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
