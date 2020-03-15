<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;


/* @var $this yii\web\View */
/* @var $model app\models\Complist */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="complist-form">

    <?php $form = ActiveForm::begin(); ?>
    <div class="col-md-3">
        <?= $form->field($model, 'code')->dropDownList([
            '0' => '',
            '1' => 'ФО',
            '2' => 'СИЗ',
        ]) ?>
    </div>
    <div class="col-md-6">
        <?= $form->field($model, 'kind_id')->
            dropDownList(ArrayHelper::map(app\models\Nomenkind::find()->all(),'id', 'name'),
            ['prompt'=>'']) ?>
        <!--?= $form->field($model, 'kind_id')->textInput(['maxlength' => true]) ?-->
    </div>
    
    <div class="col-md-3">
        <?= $form->field($model, 'sertif')->textInput(['maxlength' => true]) ?>
    </div>
    <?= $form->field($model, 'name')->textarea(['row'=>3]) ?>

    <div class="col-md-3">
        <?= $form->field($model, 'price')->textInput(['maxlength' => true]) ?>
    </div>
    <!--?= $form->field($model, 'nomen_gr')->textInput() ?-->
    <div class="col-md-3">
        <?= $form->field($model, 'gost')->textInput(['maxlength' => true]) ?>
    </div>
    <div class="col-md-3">
        <?= $form->field($model, 'meas_id')->
            dropDownList(ArrayHelper::map(\app\models\search\MeasureUnit::find()->all(),'id', 'name'),
            ['prompt'=>'']) ?>
        <!--?= $form->field($model, 'meas_id')->textInput() ?-->
    </div>
    <div class="col-md-3">
        <!--?= $form->field($model, 'gender')->textInput() ?-->
        <?= $form->field($model, 'gender')->dropDownList([
            '0' => '',
            '1' => 'Мужской',
            '2' => 'Женский',
        ]) ?>
    </div>
    <div class="form-group">
        <?= Html::submitButton('Записать', ['class' => 'btn btn-default']) ?>
        <a href="#" data-dismiss="modal" class="btn">Отменить</a>
    </div>

    <?php ActiveForm::end(); ?>

</div>
