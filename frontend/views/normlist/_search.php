<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\search\Normlist */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="normlist-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'pers_id') ?>

    <?= $form->field($model, 'prof_id') ?>

    <?= $form->field($model, 'group_id') ?>

    <?= $form->field($model, 'norm_type') ?>

    <?php // echo $form->field($model, 'quant') ?>

    <?php // echo $form->field($model, 'period') ?>

    <?php // echo $form->field($model, 'code') ?>

    <?php // echo $form->field($model, 'gender') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-outline-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
