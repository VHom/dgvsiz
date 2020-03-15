<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\FilterStrem */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="filter-strem-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'nomen_id')->textInput() ?>

    <?= $form->field($model, 'is_siz')->textInput() ?>

    <?= $form->field($model, 'store_id')->textInput() ?>

    <?= $form->field($model, 'size_id')->textInput() ?>

    <?= $form->field($model, 'heigth_id')->textInput() ?>

    <?= $form->field($model, 'full_id')->textInput() ?>

    <?= $form->field($model, 'shirt_id')->textInput() ?>

    <?= $form->field($model, 'glove_id')->textInput() ?>

    <?= $form->field($model, 'amort')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'head_id')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
