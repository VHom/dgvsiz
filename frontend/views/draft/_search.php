<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\search\Draft */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="draft-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'out_store') ?>

    <?= $form->field($model, 'in_store') ?>

    <?= $form->field($model, 'oper_id') ?>

    <?= $form->field($model, 'comp_id') ?>

    <?php // echo $form->field($model, 'oper_date') ?>

    <?php // echo $form->field($model, 'doc_numb') ?>

    <?php // echo $form->field($model, 'doc_date') ?>

    <?php // echo $form->field($model, 'note') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-outline-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
