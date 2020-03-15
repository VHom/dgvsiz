<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\search\StatSpec */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="stat-spec-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'stat_id') ?>

    <?= $form->field($model, 'sign_choice') ?>

    <?= $form->field($model, 'nomen_type') ?>

    <?= $form->field($model, 'nomen_id') ?>

    <?php // echo $form->field($model, 'amort') ?>

    <?php // echo $form->field($model, 'date_end') ?>

    <?php // echo $form->field($model, 'quant') ?>

    <?php // echo $form->field($model, 'pers_id') ?>

    <?php // echo $form->field($model, 'prof_id') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-outline-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
