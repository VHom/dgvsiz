<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\search\InorderSpec */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="inorder-spec-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'inorder_id') ?>

    <?= $form->field($model, 'nomen_id') ?>

    <?= $form->field($model, 'kind_id') ?>

    <?= $form->field($model, 'store_id') ?>

    <?php // echo $form->field($model, 'quant') ?>

    <?php // echo $form->field($model, 'placed') ?>

    <?php // echo $form->field($model, 'sertif') ?>

    <?php // echo $form->field($model, 'price') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-outline-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
