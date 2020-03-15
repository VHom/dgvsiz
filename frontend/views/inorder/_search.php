<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\search\Inorder */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="inorder-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'store_id') ?>

    <?= $form->field($model, 'supplier_id') ?>

    <?= $form->field($model, 'comp_id') ?>

    <?= $form->field($model, 'accepted_id') ?>

    <?php // echo $form->field($model, 'doc_numb') ?>

    <?php // echo $form->field($model, 'doc_date') ?>

    <?php // echo $form->field($model, 'doc_type') ?>

    <?php // echo $form->field($model, 'note') ?>

    <?php // echo $form->field($model, 'income_date') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-outline-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
