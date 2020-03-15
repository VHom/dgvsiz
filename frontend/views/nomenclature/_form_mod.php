<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use kartik\select2\Select2;


/* @var $this yii\web\View */
/* @var $model app\models\Complist */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="complist-form">

    <?php $form = ActiveForm::begin(); ?>
    <?php if($model->id) { ?>
        <div class="col-md-8">
            <?= $form->field($model, 'name')->textInput(['readonly' => true]) ?>
        </div>
    <?php } else { ?>
        <div class="col-md-8">
            <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>
        </div>
    <?php } ?>
    <div class="col-md-4"-->
        <?= $form->field($model, 'gender')->dropDownList([
            '0' => '',
            '1' => 'Мужской',
            '2' => 'Женский',
        ]) ?>
    </div>
    <div class="col-md-3">
        <?= $form->field($model, 'code')->dropDownList([
            '0' => '',
            '1' => 'ФО',
            '2' => 'СИЗ',
        ]) ?>
    </div>
    <div class="col-md-4">
        <?= $form->field($model, 'meas_id')->
        dropDownList(ArrayHelper::map(\app\models\search\MeasureUnit::find()->all(),'id', 'name'),
            ['prompt'=>'']) ?>
    </div>
    <div class="col-md-5">
        <?= $form->field($model, 'kind_id')->
        dropDownList(ArrayHelper::map(\app\models\Nomenkind::find()
            ->all(),'id', 'name'),
            ['prompt'=>'']) ?>
    </div>

    <!--div class="col-md-3"-->
        <!--?= $form->field($model, 'price')->textInput(['maxlength' => true]) ?>
    </div>
    <div class="col-md-3"-->
        <!--?= $form->field($model, 'sertif')->textInput(['maxlength' => true]) ?>
    </div-->
    <div class="form-group">
        <?= Html::submitButton('Записать', ['class' => 'btn btn-default']) ?>
        <a href="#" data-dismiss="modal" class="btn">Отменить</a>
    </div>

    <?php ActiveForm::end(); ?>

</div>
