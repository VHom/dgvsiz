<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use kartik\date\DatePicker;
use kartik\select2\Select2;
//use kartik\datetime\DateTimePicker;

/* @var $this yii\web\View */
/* @var $model app\models\Complist */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="inorder-form">

    <?php $form = ActiveForm::begin(); ?>

    <div class="col-md-6">
        <?= $form->field($model, 'doc_numb')->textInput(['maxlength' => true]) ?>
    </div>
    
    <div class="col-md-6">
        
    <?php
        if($model->doc_date) {
            $model->doc_date_temp = date("d.m.Y", (integer) $model->doc_date);
        }    
        echo $form->field($model, 'doc_date_temp')->widget(DatePicker::className(),[
            'name' => 'dp_1',
            'type' => DatePicker::TYPE_INPUT,
//            'options' => ['placeholder' => 'Дата документа'],
            'language' => 'ru',
            'convertFormat' => true,
            'value'=> date("d.m.Y ",(integer) $model->doc_date),
            'pluginOptions' => [
                'format' => 'dd.MM.yyyy',
                'autoclose'=>true,
                'weekStart'=>1, //неделя начинается с понедельника
//                'startDate' => '01.05.2015 00:00', //самая ранняя возможная дата
               'todayBtn'=>true, //снизу кнопка "сегодня"
            ]
        ]); 
    ?>
    <!--?= $form->field($model, 'doc_date_temp')->textInput() ?-->
    </div>
    <div class="col-md-12">
        <?= $form->field($model, 'note')->textarea(['row' => 3]) ?>
    </div>

    <div class="form-group">
        <?= Html::submitButton('Записать', ['class' => 'btn btn-warning']) ?>
        <a href="#" data-dismiss="modal" class="btn btn-default">Отменить</a>
    </div>

    <?php ActiveForm::end(); ?>

</div>
