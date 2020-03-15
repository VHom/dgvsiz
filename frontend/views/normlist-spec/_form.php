<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\NormlistSpec */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="normlist-spec-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'norm_id')->textInput() ?>

    <?= $form->field($model, 'quant')->textInput() ?>

    <?= $form->field($model, 'period')->textInput() ?>

    <?= $form->field($model, 'code')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'nomen_id')->textInput() ?>

    <?= $form->field($model, 'doc_osn')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'kind_id')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
