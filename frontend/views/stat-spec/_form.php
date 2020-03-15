<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\StatSpec */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="stat-spec-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'id')->textInput() ?>

    <?= $form->field($model, 'stat_id')->textInput() ?>

    <?= $form->field($model, 'sign_choice')->textInput() ?>

    <?= $form->field($model, 'nomen_type')->textInput() ?>

    <?= $form->field($model, 'nomen_id')->textInput() ?>

    <?= $form->field($model, 'amort')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'date_end')->textInput() ?>

    <?= $form->field($model, 'quant')->textInput() ?>

    <?= $form->field($model, 'pers_id')->textInput() ?>

    <?= $form->field($model, 'prof_id')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
