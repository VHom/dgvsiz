<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\search\Helpdesk */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="helpdesk-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'help_id') ?>

    <?= $form->field($model, 'date') ?>

    <?= $form->field($model, 'author') ?>

    <?= $form->field($model, 'content') ?>

    <?php // echo $form->field($model, 'state') ?>

    <?php // echo $form->field($model, 'state_date') ?>

    <?php // echo $form->field($model, 'sort_field') ?>

    <?php // echo $form->field($model, 'help_number') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-outline-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
