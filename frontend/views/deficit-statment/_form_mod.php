<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\date\DatePicker;
use kartik\datetime\DateTimePicker;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $model app\models\DeficitStatment */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="deficit-statment-form">

    <?php $form = ActiveForm::begin(); 
 //throw new \yii\web\NotFoundHttpException('qq '.$model->id);
    ?>

    <!--?= $form->field($model, 'staff_id')->textInput() ?-->
    <div class="col-md-8">
        <?= $form->field($model, 'staff_id')->
            dropDownList(ArrayHelper::map(app\models\Stafflist::find()->all(),'id', 'AreaName'),
            ['prompt'=>'']) ?>
        <!--?= $form->field($model, 'kind_id')->textInput(['maxlength' => true]) ?-->
    </div>
    
    <div class="col-md-4">
    <?php
     if($model->date_report) {
            $model->date_report_temp = date("d.m.Y", (integer) $model->date_report);
        }    
        echo $form->field($model, 'date_report_temp')->widget(DatePicker::className(),[
            'name' => 'dp_7',
            'type' => DateTimePicker::TYPE_INPUT,
            'options' => ['placeholder' => 'Дата ведомости'],
            'language' => 'ru',
            'convertFormat' => true,
            'value'=> date("d.m.Y ",(integer) $model->date_report),
            'pluginOptions' => [
                'format' => 'dd.MM.yyyy',
                'autoclose'=>true,
                'weekStart'=>1, //неделя начинается с понедельника
//                'startDate' => '01.05.2015 00:00', //самая ранняя возможная дата
                'todayBtn'=>true, //снизу кнопка "сегодня"
            ]
        ]); 
    ?>
    </div>
    <div class="col-md-12">
        <?= $form->field($model, 'prim')->textarea(['rews' => '4']) ?>
    </div>
    <div class="form-group">
        <?= Html::submitButton('Сформировать', ['class' => 'btn btn-default']) ?>
        <a href="#" data-dismiss="modal" class="btn">Отменить</a>
        
    </div>

    <?php ActiveForm::end(); ?>

</div>
