<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Nomenclature */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="nomenclature-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'code')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'price')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'kind_id')->textInput() ?>

    <?= $form->field($model, 'gost')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'meas_id')->textInput() ?>

    <?= $form->field($model, 'gender')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
