<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Storejournal */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="storejournal-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'comp_id')->textInput() ?>

    <?= $form->field($model, 'store_id')->textInput() ?>

    <?= $form->field($model, 'nomen_id')->textInput() ?>

    <?= $form->field($model, 'stoper_id')->textInput() ?>

    <?= $form->field($model, 'stoper_type')->textInput() ?>

    <?= $form->field($model, 'inordspec_id')->textInput() ?>

    <?= $form->field($model, 'invoicespec_id')->textInput() ?>

    <?= $form->field($model, 'drafspec_id')->textInput() ?>

    <?= $form->field($model, 'quant(11)')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'oper_id')->textInput() ?>

    <?= $form->field($model, 'oper_date')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
