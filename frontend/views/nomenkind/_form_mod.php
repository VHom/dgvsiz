<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;


/* @var $this yii\web\View */
/* @var $model app\models\Complist */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="complist-form">

    <?php $form = ActiveForm::begin(); ?>
    
    <!--?= $form->field($model, 'code')->textInput(['maxlength' => true]) ?-->

    <div class="col-md-5">
        <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>
    </div>
    <div class="col-md-2">
        <?= $form->field($model, 'is_siz')->dropDownList([
            '0' => '',
            '1' => 'ФО',
            '2' => 'СИЗ'
        ]) ?>
    </div>
    <!--?= $form->field($model, 'is_siz')->textInput() ?-->
    <div class="col-md-2">
        <?= $form->field($model, 'period')->textInput() ?>
    </div>
    <div class="col-md-3">
        <?= $form->field($model, 'size_gr')->dropDownList([
            0 => 'Нет',
            1 => 'Да'
        ]) ?>
    </div>
    <!--?= $form->field($model, 'size_gr')->textInput(['maxlength' => true]) ?-->
    <div class="col-md-4">
        <?= $form->field($model, 'height_gr')->dropDownList([
            0 => 'Нет',
            1 => 'Да'
        ]) ?>
    </div>
    <!--?= $form->field($model, 'height_gr')->textInput(['maxlength' => true]) ?-->

    <div class="col-md-4">
        <?= $form->field($model, 'full_gr')->dropDownList([
            0 => 'Нет',
            1 => 'Да'
        ]) ?>
    </div>
    <!--?= $form->field($model, 'full_gr')->textInput(['maxlength' => true]) ?-->

    <div class="col-md-4">
    <?= $form->field($model, 'shirt_gr')->dropDownList([
            0 => 'Нет',
            1 => 'Да'
        ]) ?>
    </div>
    <!--?= $form->field($model, 'shirt_gr')->textInput(['maxlength' => true]) ?-->

    <div class="col-md-4">
        <?= $form->field($model, 'shoes_gr')->dropDownList([
            0 => 'Нет',
            1 => 'Да'
        ]) ?>
    </div>
    <!--?= $form->field($model, 'shoes_gr')->textInput(['maxlength' => true]) ?-->

    <div class="col-md-4">
        <?= $form->field($model, 'glove_gr')->dropDownList([
            0 => 'Нет',
            1 => 'Да'
        ]) ?>
    </div>
    <!--?= $form->field($model, 'glove_gr')->textInput(['maxlength' => true]) ?-->

    <div class="col-md-4">
        <?= $form->field($model, 'head_gr')->dropDownList([
            0 => 'Нет',
            1 => 'Да'
        ]) ?>
    </div>
    <div class="col-md-12">
        <?= $form->field($model, 'prim')->textarea(['row' => 3]) ?>
    </div>
    <div class="form-group">
        <?= Html::submitButton('Записать', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-warning']) ?>
        <a href="#" data-dismiss="modal" class="btn btn-default">Отменить</a>
    </div>

    <?php ActiveForm::end(); ?>

</div>
