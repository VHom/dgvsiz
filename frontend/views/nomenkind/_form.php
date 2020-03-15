<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Nomenkind */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="nomenkind-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'nomenkind')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'is_siz')->textInput() ?>

    <?= $form->field($model, 'size_gr')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'height_gr')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'full_gr')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'shirt_gr')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'shoes_gr')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'glove_gr')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
