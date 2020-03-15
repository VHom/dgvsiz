<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\NormCard */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="norm-card-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'pers_id')->textInput() ?>

    <?= $form->field($model, 'norm_id')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
