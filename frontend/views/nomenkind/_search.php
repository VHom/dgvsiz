<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\search\Nomenkind */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="nomenkind-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'nomenkind') ?>

    <?= $form->field($model, 'is_siz') ?>

    <?= $form->field($model, 'size_gr') ?>

    <?= $form->field($model, 'height_gr') ?>

    <?php // echo $form->field($model, 'full_gr') ?>

    <?php // echo $form->field($model, 'shirt_gr') ?>

    <?php // echo $form->field($model, 'shoes_gr') ?>

    <?php // echo $form->field($model, 'glove_gr') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-outline-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
