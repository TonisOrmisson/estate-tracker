<?php

use app\models\Provider;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $model app\models\Item */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="item-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'provider_id')->widget(Select2::className(), [
        'data' => ArrayHelper::map(Provider::find()->all(),'provider_id','name'),
        'options' => [
            'placeholder' => Yii::t('app', 'Select provider'),
        ],
        'pluginOptions' => [
            'allowClear' => false,
        ]
    ]);?>

    <?= $form->field($model, 'key',['enableAjaxValidation' => true])->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'm2')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
