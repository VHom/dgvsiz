<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Proflist */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="proflist-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'prof_code')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'prof_name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'kat_name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'znak')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
