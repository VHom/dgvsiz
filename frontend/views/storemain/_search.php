<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\search\Storemain */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="storemain-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, ' id') ?>

    <?= $form->field($model, 'store_id') ?>

    <?= $form->field($model, 'nomen_id') ?>

    <?= $form->field($model, 'size_gr') ?>

    <?= $form->field($model, 'height_gr') ?>

    <?php // echo $form->field($model, 'full_gr') ?>

    <?php // echo $form->field($model, 'shirt_gr') ?>

    <?php // echo $form->field($model, 'shoes_gr') ?>

    <?php // echo $form->field($model, 'glove_gr') ?>

    <?php // echo $form->field($model, 'rem_cost') ?>

    <?php // echo $form->field($model, 'amout') ?>

    <?php // echo $form->field($model, 'quant') ?>

    <?php // echo $form->field($model, 'sertif') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-outline-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
