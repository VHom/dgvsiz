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
<style>
    div.required label:before {
        content: "*";
        color: red;
    }
</style>
<div class="perslist-form">

    <?php $form = ActiveForm::begin(); ?>

    <!--div class="col-md-4"-->
        <!--?= $form->field($model, 'abbr_name')->textInput(['maxlength' => true]) ?>
    </div-->
    <div class="col-md-4">
        <?= $form->field($model, 'family_name')->textInput(['maxlength' => true]) ?>
    </div>
    <div class="col-md-4">
        <?= $form->field($model, 'first_name')->textInput(['maxlength' => true]) ?>
    </div>
    <div class="col-md-4">
        <?= $form->field($model, 'second_name')->textInput(['maxlength' => true]) ?>
    </div>
    <div class="col-md-4">
        <?= $form->field($model, 'tabnum')->textInput(['maxlength' => true]) ?>
    </div>
    <div class="col-md-4">
        <?= $form->field($model,'gender')->DropDownList([
            '0' => '', 
            '1' => 'Мужской',
            '2' => 'Женский',]) ?>
        <!--?= $form->field($model, 'gender')->textInput() ?-->
    </div>
    <div class="col-md-4">
        <?= $form->field($model,'sec_empl')->DropDownList([
            '0' => 'Нет', 
            '1' => 'Да',]) ?>
        <!--?= $form->field($model, 'sec_empl')->textInput() ?-->
    </div>
    <div class="col-md-12">
        <?= $form->field($model, 'staff_id')->
            dropDownList(ArrayHelper::map(app\models\Stafflist::find()->all(),'id', 'AreaName'),
            ['prompt'=>'']) ?>
    <!--?= $form->field($model, 'staff_id')->textInput() ?-->
    </div>
    <div class="col-md-12">
        <?= $form->field($model, 'prof_id')->
            dropDownList(ArrayHelper::map(app\models\Proflist::find()
                ->where('code <> "Сисадм" and code <> "Супервизор"')
            ->all(),'id', 'name'),
            ['prompt'=>'']) ?>
    <!--?= $form->field($model, 'prof_id')->textInput() ?-->
    </div>
    <div class="col-md-6">
    <?php
     if($model->start_date) {
            $model->start_date_temp = date("d.m.Y", (integer) $model->start_date);
        }    
        echo $form->field($model, 'start_date_temp')->widget(DatePicker::className(),[
            'name' => 'dp_1',
            'type' => DateTimePicker::TYPE_INPUT,
            'options' => ['placeholder' => 'Дата приема'],
            'language' => 'ru',
            'convertFormat' => true,
            'value'=> date("d.m.Y ",(integer) $model->start_date),
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
    <div class="col-md-6">
    <?php
        if($model->end_date) {
            $model->end_date_temp = date("d.m.Y", (integer) $model->end_date);
        }    
        echo $form->field($model, 'end_date_temp')->widget(DatePicker::className(),[
            'name' => 'dp_1',
            'type' => DatePicker::TYPE_INPUT,
            'options' => ['placeholder' => 'Дата увольнения'],
            'language' => 'ru',
            'convertFormat' => true,
            'value'=> date("d.m.Y ",(integer) $model->end_date),
            'pluginOptions' => [
                'format' => 'dd.MM.yyyy',
                'autoclose'=>true,
                'weekStart'=>1, //неделя начинается с понедельника
        //        'endDate' => '01.05.2015 00:00', //самая ранняя возможная дата
                'todayBtn'=>true, //снизу кнопка "сегодня"
            ]
        ]); 
    ?>
        <!--?= $form->field($model, 'errormod')->textInput() ?-->
    </div>
    <div class="col-md-6">
    <?php
/*        if($model->decret_start) {
            $model->decret_start_temp = date("d.m.Y", (integer) $model->decret_start);
        }    
        echo $form->field($model, 'decret_start_temp')->widget(DatePicker::className(),[
            'name' => 'dp_1',
            'type' => DatePicker::TYPE_INPUT,
            'options' => ['placeholder' => 'Начало декретного отпуска'],
            'language' => 'ru',
            'convertFormat' => true,
            'value'=> date("d.m.Y ",(integer) $model->decret_start),
            'pluginOptions' => [
                'format' => 'dd.MM.yyyy',
                'autoclose'=>true,
                'weekStart'=>1, //неделя начинается с понедельника
        //        'decret_start' => '01.05.2015 00:00', //самая ранняя возможная дата
                'todayBtn'=>true, //снизу кнопка "сегодня"
            ]
        ]); 
    ?>
        <!--?= $form->field($model, 'decret_start')->textInput() ?-->
    </div>
    <div class="col-md-6">
    <?php
        if($model->decret_end) {
            $model->decret_end_temp = date("d.m.Y", (integer) $model->decret_end);
        }    
        echo $form->field($model, 'decret_end_temp')->widget(DatePicker::className(),[
            'name' => 'dp_1',
            'type' => DatePicker::TYPE_INPUT,
            'options' => ['placeholder' => 'Окончание декретного отпуска'],
            'language' => 'ru',
            'convertFormat' => true,
            'value'=> date("d.m.Y ",(integer) $model->decret_end),
            'pluginOptions' => [
                'format' => 'dd.MM.yyyy',
                'autoclose'=>true,
                'weekStart'=>1, //неделя начинается с понедельника
        //        'decret_end' => '01.05.2015 00:00', //самая ранняя возможная дата
                'todayBtn'=>true, //снизу кнопка "сегодня"
            ]
        ]); */
    ?>
        <!--?= $form->field($model, 'decret_end')->textInput() ?-->
    </div>
    <div class="form-group">
        <?= Html::submitButton('Записать', ['class' => 'btn btn-success']) ?>
        <a href="#" class="btn btn-default" data-dismiss="modal" class="btn">Отменить</a>
    </div>

    <?php ActiveForm::end(); ?>

</div>
