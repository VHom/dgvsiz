<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\search\FilterStrem */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="filter-strem-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'nomen_id') ?>

    <?= $form->field($model, 'is_siz') ?>

    <?= $form->field($model, 'store_id') ?>

    <?= $form->field($model, 'size_id') ?>

    <?php // echo $form->field($model, 'heigth_id') ?>

    <?php // echo $form->field($model, 'full_id') ?>

    <?php // echo $form->field($model, 'shirt_id') ?>

    <?php // echo $form->field($model, 'glove_id') ?>

    <?php // echo $form->field($model, 'amort') ?>

    <?php // echo $form->field($model, 'head_id') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-outline-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
