<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use kartik\date\DatePicker;
use kartik\datetime\DateTimePicker;


/* @var $this yii\web\View */
/* @var $model app\models\Complist */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="norm-cardspec-form">

    <?php $form = ActiveForm::begin(); ?>

    <div class="col-md-9">
        <?= $form->field($model, 'nomen_id')->
            dropDownList(ArrayHelper::map(\app\models\Nomenclature::find()->all(),'id', 'name'),
            ['prompt'=>'']) ?>
    </div>
        <!--?= $form->field($model, 'nomen_id')->textInput() ?-->
        <div class="col-md-3">
            <?= $form->field($model, 'quant_fct')->textInput() ?>
        </div>
        <!--?= $form->field($model, 'card_id')->textInput() ?-->

        <div class="col-md-12">
            <?= $form->field($model, 'prim')->textarea(['row' => 3]) ?>
        </div>
    <div class="form-group">
        <?= Html::submitButton('Записать', ['class' =>$model->isNewRecord ? 'btn btn-success' : 'btn btn-warning']) ?>
        <a href="#" data-dismiss="modal" class="btn btn-default">Отменить</a>
    </div>

    <?php ActiveForm::end(); ?>

</div>
