<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Storemain */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="storemain-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'store_id')->textInput() ?>

    <?= $form->field($model, 'nomen_id')->textInput() ?>

    <?= $form->field($model, 'size_gr')->textInput() ?>

    <?= $form->field($model, 'height_gr')->textInput() ?>

    <?= $form->field($model, 'full_gr')->textInput() ?>

    <?= $form->field($model, 'shirt_gr')->textInput() ?>

    <?= $form->field($model, 'shoes_gr')->textInput() ?>

    <?= $form->field($model, 'glove_gr')->textInput() ?>

    <?= $form->field($model, 'rem_cost')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'amout')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'quant')->textInput() ?>

    <?= $form->field($model, 'sertif')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
