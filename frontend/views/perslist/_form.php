<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Perslist */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="perslist-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'tabnum')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'abbr_name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'family_name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'first_name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'second_name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'gender')->textInput() ?>

    <?= $form->field($model, 'sec_empl')->textInput() ?>

    <?= $form->field($model, 'start_date')->textInput() ?>

    <?= $form->field($model, 'end_date')->textInput() ?>

    <?= $form->field($model, 'decret_start')->textInput() ?>

    <?= $form->field($model, 'decret_end')->textInput() ?>

    <!--?= $form->field($model, 'staff_id')->textInput() ?-->

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
