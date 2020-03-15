<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Nomengroup */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="nomengroup-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'code')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'nomen_kind')->textInput() ?>

    <?= $form->field($model, 'nomen_type')->textInput() ?>

    <?= $form->field($model, 'nomen_season')->textInput() ?>

    <?= $form->field($model, 'siz_type')->textInput() ?>

    <?= $form->field($model, 'close_type')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
