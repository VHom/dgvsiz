<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\InvoiceSpec */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="invoice-create_mod">

    <?php $form = ActiveForm::begin([
        'id' => 'create-mod-form',
        'enableAjaxValidation' => true,  
    ]); ?>
    
    <?php $model->id = $id; ?>

    <div class="col-sm-12">
        <?= $form->field($model, 'id')->hiddenInput()->label(false) ?>
        <?= $form->field($model, 'cardspec_id')->hiddenInput()->label(false) ?>
        <?= $form->field($model, 'quant')->textInput() ?>
    </div>
    <div class="form-group">
        <?= Html::submitButton('Записать', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-warning']) ?>
        <a href="#" data-dismiss="modal" class="btn btn-default">Отменить</a>
    </div>
    <?php ActiveForm::end(); ?>
</div>