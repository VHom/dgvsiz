<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\search\DeficitSpec */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="deficit-spec-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'statement_id') ?>

    <?= $form->field($model, 'nomen_id') ?>

    <?= $form->field($model, 'kind_id') ?>

    <?= $form->field($model, 'def_name') ?>

    <?php // echo $form->field($model, 'def_quant') ?>

    <?php // echo $form->field($model, 'store_quant') ?>

    <?php // echo $form->field($model, 'store_note') ?>

    <?php // echo $form->field($model, 'analog_quant') ?>

    <?php // echo $form->field($model, 'analog_note') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-outline-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
