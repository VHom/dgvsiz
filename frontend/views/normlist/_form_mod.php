<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;


/* @var $this yii\web\View */
/* @var $model app\models\Complist */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="normlist-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'staff_id')->
        dropDownList(ArrayHelper::map(app\models\Stafflist::find()
                ->all(),'id', 'AreaName'),
        ['prompt'=>'']) ?>
    <!--?= $form->field($model, 'prof_id')->textInput() ?-->

    <?= $form->field($model, 'prof_id')->
        dropDownList(ArrayHelper::map(\app\models\search\Proflist::find()
                ->all(),'id', 'name'),
        ['prompt'=>'']) ?>
    
    <!--?= $form->field($model, 'kind_id')->
        dropDownList(ArrayHelper::map(\app\models\search\Nomenkind::find()->all(),'id', 'name'),
        ['prompt'=>'']) ?-->
    <!--?= $form->field($model, 'group_id')->textInput() ?-->

    <?= $form->field($model,'norm_type')->DropDownList([
        '0' => '', 
        '1' => 'По профессиям',
        '2' => 'Индивидуально',]) ?>
        <!--    ['promnt'=>'']*/ ?-->
    <!--?= $form->field($model, 'norm_type')->textInput() ?-->

    <!--?= $form->field($model, 'quant')->textInput() ?-->

    <!--?= $form->field($model, 'period')->textInput() ?-->

    <!--?= $form->field($model, 'code')->textInput(['maxlength' => true]) ?-->

    <!--?= $form->field($model, 'gender')->textInput() ?-->
    <?= $form->field($model,'gender')->DropDownList([
        '0' => '',
        '1' => 'Мужской',
        '2' => 'Женский',]) ?>
    
    <?= $form->field($model,'prim')->textarea(['row' => 3]) ?>
    
    <div class="form-group">
        <?= Html::submitButton('Записать', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-warning']) ?>
        <a href="#" data-dismiss="modal" class="btn btn-default">Отменить</a>
    </div>

    <?php ActiveForm::end(); ?>

</div>
