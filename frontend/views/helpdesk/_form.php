<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Helpdesk */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="helpdesk-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'content')->textarea(['maxlength'=>true,'rows' => 4])//textInput(['maxlength' => true])
    ?>
    <?php
    if ($model->help_id)
        echo $form->field($model, 'state')->dropDownList($model->getStatuses());
    ?>

    <div class="form-group">
        <?= Html::submitButton('Отправить', ['class' => 'btn btn-info']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
