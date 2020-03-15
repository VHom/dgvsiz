<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\ConstNomen */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="const-nomen-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'nomen_id')->textInput() ?>

    <?= $form->field($model, 'const_nomen_id')->textInput() ?>

    <?= $form->field($model, 'quant')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
