<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\search\Perslist */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="perslist-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'tabnum') ?>

    <?= $form->field($model, 'abbr_name') ?>

    <?= $form->field($model, 'family_name') ?>

    <?= $form->field($model, 'first_name') ?>

    <?php // echo $form->field($model, 'second_name') ?>

    <?php // echo $form->field($model, 'gender') ?>

    <?php // echo $form->field($model, 'sec_empl') ?>

    <?php // echo $form->field($model, 'start_date') ?>

    <?php // echo $form->field($model, 'end_date') ?>

    <?php // echo $form->field($model, 'decret_start') ?>

    <?php // echo $form->field($model, 'decret_end') ?>

    <?php // echo $form->field($model, 'staff_id') ?>

    <?php // echo $form->field($model, 'size_id') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-outline-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
