<?php

//use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
//use kartik\date\DatePicker;
use kartik\select2\Select2;
use yii\helpers\Html; //   kartik\helpers\Html;
//use yii\bootstrap\Modal;

//use kartik\datetime\DateTimePicker;

/* @var $this yii\web\View */
/* @var $model app\models\Complist */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="inorder-spec-form">
    <?php $form = ActiveForm::begin(); ?>
    <div class="col-md-9">
        <?= $form->field($model, 'const_nomen_id')
            ->dropDownList(ArrayHelper::map(\app\models\Nomenclature::find()->all(),'id', 'name'),
                ['prompt'=>'']);
         ?>
    </div>
    <div class="col-md-3">
        <?= $form->field($model, 'quant')->textInput() ?>
    </div>

    <div class="form-group">
        <?= Html::submitButton('Записать', ['class' => 'btn btn-warning']) ?>
        <a href="#" data-dismiss="modal" class="btn btn-default">Отменить</a>
    </div>

    <?php ActiveForm::end(); ?>

</div>
