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

<div class="norm-card-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'pers_id')->
        dropDownList(ArrayHelper::map(\app\models\Perslist::find()->all(),'id', 'abbr_name'),
        ['prompt'=>'']) ?>
    <!--?= $form->field($model, 'pers_id')->textInput() ?-->

    <?= $form->field($model, 'norm_id')->
        dropDownList(ArrayHelper::map(\app\models\Normlist::find()->all(),'id', 'TypeName'),
        ['prompt'=>'']) ?>
    <!--?= $form->field($model, 'norm_id')->textInput() ?-->
    <?= $form->field($model, 'prim')->textarea(['row' => 3]) ?>

    <div class="form-group">
        <?= Html::submitButton('Записать', ['class' => 'btn btn-success']) ?>
        <a href="#" data-dismiss="modal" class="btn">Отменить</a>
    </div>

    <?php ActiveForm::end(); ?>

</div>
