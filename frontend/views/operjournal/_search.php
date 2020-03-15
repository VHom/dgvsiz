<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\search\Operjournal */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="operjournal-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'oper_id') ?>

    <?= $form->field($model, 'oper_date') ?>

    <?= $form->field($model, 'oper_name') ?>

    <?= $form->field($model, 'oper_obj') ?>

    <?php // echo $form->field($model, 'oper_val') ?>

    <?php // echo $form->field($model, 'oper_val_id') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-outline-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
