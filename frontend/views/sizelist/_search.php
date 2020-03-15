<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\search\Sizelist */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="sizelist-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'group_type') ?>

    <?= $form->field($model, 'group_name') ?>

    <?= $form->field($model, 'size') ?>

    <?= $form->field($model, 'min_val') ?>

    <?php // echo $form->field($model, 'max_val') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-outline-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
