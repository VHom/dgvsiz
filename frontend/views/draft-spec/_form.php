<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\DraftSpec */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="draft-spec-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'draft_id')->textInput() ?>

    <?= $form->field($model, 'remain_id')->textInput() ?>

    <?= $form->field($model, 'quant')->textInput() ?>

    <?= $form->field($model, 'amout')->textInput() ?>

    <?= $form->field($model, 'placed')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
