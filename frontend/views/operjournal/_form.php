<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Operjournal */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="operjournal-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'oper_id')->textInput() ?>

    <?= $form->field($model, 'oper_date')->textInput() ?>

    <?= $form->field($model, 'oper_name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'oper_obj')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'oper_val')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'oper_val_id')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
