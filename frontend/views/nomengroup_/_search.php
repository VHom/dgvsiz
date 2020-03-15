<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\search\Nomengroup */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="nomengroup-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'code') ?>

    <?= $form->field($model, 'name') ?>

    <?= $form->field($model, 'nomen_kind') ?>

    <?= $form->field($model, 'nomen_type') ?>

    <?php // echo $form->field($model, 'nomen_season') ?>

    <?php // echo $form->field($model, 'siz_type') ?>

    <?php // echo $form->field($model, 'close_type') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-outline-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
