<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\search\Storejournal */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="storejournal-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'comp_id') ?>

    <?= $form->field($model, 'store_id') ?>

    <?= $form->field($model, 'nomen_id') ?>

    <?= $form->field($model, 'stoper_id') ?>

    <?php // echo $form->field($model, 'stoper_type') ?>

    <?php // echo $form->field($model, 'inordspec_id') ?>

    <?php // echo $form->field($model, 'invoicespec_id') ?>

    <?php // echo $form->field($model, 'drafspec_id') ?>

    <?php // echo $form->field($model, 'quant(11)') ?>

    <?php // echo $form->field($model, 'oper_id') ?>

    <?php // echo $form->field($model, 'oper_date') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-outline-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
