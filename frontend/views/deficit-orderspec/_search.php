<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\search\DeficitOrderspec */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="deficit-orderspec-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'statement_id') ?>

    <?= $form->field($model, 'nomen_name') ?>

    <?= $form->field($model, 'quant') ?>

    <?= $form->field($model, 'status') ?>

    <?php // echo $form->field($model, 'type') ?>

    <?php // echo $form->field($model, 'prim') ?>

    <?php // echo $form->field($model, 'oper_id') ?>

    <?php // echo $form->field($model, 'oper_date') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-outline-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
