<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Inorder */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="inorder-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'store_id')->textInput() ?>

    <?= $form->field($model, 'supplier_id')->textInput() ?>

    <?= $form->field($model, 'comp_id')->textInput() ?>

    <?= $form->field($model, 'accepted_id')->textInput() ?>

    <?= $form->field($model, 'doc_numb')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'doc_date')->textInput() ?>

    <?= $form->field($model, 'doc_type')->textInput() ?>

    <?= $form->field($model, 'note')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'income_date')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
