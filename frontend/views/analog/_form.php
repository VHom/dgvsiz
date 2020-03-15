<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Analog */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="analog-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'comp_id')->textInput() ?>

    <?= $form->field($model, 'nomen_gr')->textInput() ?>

    <?= $form->field($model, 'analog_gr')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
