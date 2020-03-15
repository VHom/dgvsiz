<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Invoice */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="invoice-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'store_id')->textInput() ?>

    <?= $form->field($model, 'pers_id')->textInput() ?>

    <?= $form->field($model, 'comp_id')->textInput() ?>

    <?= $form->field($model, 'doc_numb')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'doc_date')->textInput() ?>

    <?= $form->field($model, 'note')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'oper_id')->textInput() ?>

    <?= $form->field($model, 'oper_date')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
