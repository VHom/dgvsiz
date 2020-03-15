<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Draft */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="draft-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'out_store')->textInput() ?>

    <?= $form->field($model, 'in_store')->textInput() ?>

    <?= $form->field($model, 'oper_id')->textInput() ?>

    <?= $form->field($model, 'comp_id')->textInput() ?>

    <?= $form->field($model, 'oper_date')->textInput() ?>

    <?= $form->field($model, 'doc_numb')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'doc_date')->textInput() ?>

    <?= $form->field($model, 'note')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
