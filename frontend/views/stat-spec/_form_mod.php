<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use kartik\date\DatePicker;

/* @var $this yii\web\View */
/* @var $model app\models\StatSpec */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="stat-spec-form">

    <?php $form = ActiveForm::begin(); ?>

    <div class="col-md-8">
        <?= $form->field($model, 'staff_id')->
            dropDownList(ArrayHelper::map(app\models\Stafflist::find()->all(),'id', 'AreaName'),
            ['prompt'=>'']) ?>
    </div>
    <div class="col-md-4">
    <?php
        if($model->date_end) {
            $model->date_end_temp = date("d.m.Y", (integer) $model->date_end);
        }    
        echo $form->field($model, 'date_end_temp')->widget(DatePicker::className(),[
            'name' => 'dp_1',
            'type' => DatePicker::TYPE_INPUT,
//            'options' => ['placeholder' => 'Дата документа'],
            'language' => 'ru',
            'convertFormat' => true,
            'value'=> date("d.m.Y ",(integer) $model->date_end),
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

    <div class="form-group">
        <?= Html::submitButton('Записать', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-warning']) ?>
        <a href="#" data-dismiss="modal" class="btn btn-default">Отменить</a>
    </div>

    <?php ActiveForm::end(); ?>

</div>
