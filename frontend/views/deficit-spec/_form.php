<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\DeficitSpec */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="deficit-spec-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'statement_id')->textInput() ?>

    <?= $form->field($model, 'nomen_id')->textInput() ?>

    <?= $form->field($model, 'kind_id')->textInput() ?>

    <?= $form->field($model, 'def_name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'def_quant')->textInput() ?>

    <?= $form->field($model, 'store_quant')->textInput() ?>

    <?= $form->field($model, 'store_note')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'analog_quant')->textInput() ?>

    <?= $form->field($model, 'analog_note')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
