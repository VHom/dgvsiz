<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Sizelist */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="sizelist-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'group_type')->textInput() ?>

    <?= $form->field($model, 'group_name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'size')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'min_val')->textInput() ?>

    <?= $form->field($model, 'max_val')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
