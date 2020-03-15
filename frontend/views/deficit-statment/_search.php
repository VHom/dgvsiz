<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\search\DeficitStatment */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="deficit-statment-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'sign_choice') ?>

    <?= $form->field($model, 'staff_id') ?>

    <?= $form->field($model, 'nomen_type') ?>

    <?= $form->field($model, 'amort') ?>

    <?php // echo $form->field($model, 'date_end') ?>

    <?php // echo $form->field($model, 'quant') ?>

    <?php // echo $form->field($model, 'meas_id') ?>

    <?php // echo $form->field($model, 'date_report') ?>

    <?php // echo $form->field($model, 'oper_date') ?>

    <?php // echo $form->field($model, 'oper_user') ?>

    <?php // echo $form->field($model, 'nomen_id') ?>

    <?php // echo $form->field($model, 'pers_id') ?>

    <?php // echo $form->field($model, 'prof_id') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-outline-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
