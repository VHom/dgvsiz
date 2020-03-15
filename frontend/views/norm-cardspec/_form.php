<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\NormCardspec */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="norm-cardspec-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'card_id')->textInput() ?>

    <?= $form->field($model, 'quant')->textInput() ?>

    <?= $form->field($model, 'quant_fct')->textInput() ?>

    <?= $form->field($model, 'date_in')->textInput() ?>

    <?= $form->field($model, 'date_out')->textInput() ?>

    <?= $form->field($model, 'nomen_id')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
