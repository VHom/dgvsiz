<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\DeficitOrderspec */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="deficit-orderspec-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'statement_id')->textInput() ?>

    <?= $form->field($model, 'nomen_name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'quant')->textInput() ?>

    <?= $form->field($model, 'status')->textInput() ?>

    <?= $form->field($model, 'type')->textInput() ?>

    <?= $form->field($model, 'prim')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'oper_id')->textInput() ?>

    <?= $form->field($model, 'oper_date')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
