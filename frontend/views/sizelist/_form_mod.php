<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;


/* @var $this yii\web\View */
/* @var $model app\models\Complist */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="sizelist-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'group_type')->dropDownList([
                0=>'СИЗ',
                1=>'ФО',
                2=>'Общая'],
        ['prompt'=>'']); ?>
    <!--?= $form->field($model, 'group_type')->textInput() ?-->

    <?= $form->field($model, 'group_name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'size')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'min_val')->textInput() ?>

    <?= $form->field($model, 'max_val')->textInput() ?>
    
    <?= $form->field($model,'prim')->textarea(['row' => 3]) ?>

    <div class="form-group">
        <?= Html::submitButton('Записать', ['class' => 'btn btn-default']) ?>
        <a href="#" data-dismiss="modal" class="btn">Отменить</a>
    </div>

    <?php ActiveForm::end(); ?>

</div>
