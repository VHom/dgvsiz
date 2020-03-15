<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Rolelist */
/* @var $form yii\widgets\ActiveForm */

//$model = new \app\models\Rolelist();
?>

<div class="rolelist-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'code')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton('Записать', ['class' => 'btn btn-default']) ?>
        <a href="#" data-dismiss="modal" class="btn">Отменить</a>
    </div>

    <?php ActiveForm::end(); ?>

</div>
