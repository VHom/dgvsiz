<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\search\NormlistSpec */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="normlist-spec-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'norm_id') ?>

    <?= $form->field($model, 'quant') ?>

    <?= $form->field($model, 'period') ?>

    <?= $form->field($model, 'code') ?>

    <?php // echo $form->field($model, 'nomen_id') ?>

    <?php // echo $form->field($model, 'doc_osn') ?>

    <?php // echo $form->field($model, 'kind_id') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-outline-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
