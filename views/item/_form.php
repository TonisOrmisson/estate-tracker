<?php

use app\models\Provider;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;
use kartik\switchinput\SwitchInput;

/* @var $this yii\web\View */
/* @var $model app\models\Item */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="item-form">

    <?php $form = ActiveForm::begin(); ?>
    <div class="panel panel-primary">
        <div class="panel-heading"><?=Yii::t('app', 'Item form')?></div>
        <div class="panel-body">
            <div class="row">
                <div class="col-lg-6">
                    <?= $form->field($model, 'provider_id')->widget(Select2::className(), [
                        'data' => ArrayHelper::map(Provider::find()->all(),'provider_id','name'),
                        'options' => [
                            'placeholder' => Yii::t('app', 'Select provider'),
                        ],
                        'pluginOptions' => [
                            'allowClear' => false,
                        ]
                    ]);?>
                </div>
                <div class="col-lg-6"><?= $form->field($model, 'key',['enableAjaxValidation' => true])->textInput(['maxlength' => true]) ?></div>
            </div>




            <div class="row">
                <div class="col-lg-6"><?= $form->field($model, 'm2')->textInput(['maxlength' => true]) ?></div>
                <div class="col-lg-6"><?= $form->field($model, 'active')->widget(SwitchInput::classname(), []); ?></div>
            </div>

        </div>
    </div>




    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
