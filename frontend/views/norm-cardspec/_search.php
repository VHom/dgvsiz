<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\search\NormCardspec */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="norm-cardspec-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'card_id') ?>

    <?= $form->field($model, 'quant') ?>

    <?= $form->field($model, 'date_in') ?>

    <?= $form->field($model, 'date_out') ?>

    <?php // echo $form->field($model, 'nomen_id') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-outline-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
