<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;


/* @var $this yii\web\View */
/* @var $model app\models\Storelist */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="storelist-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'code')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'is_siz')->textInput() ?>

    <?= $form->field($model, 'comp_id')->
        dropDownList(ArrayHelper::map(\app\models\Complist::find()->all(),'id', 'name'),
        ['prompt'=>'']) ?>
    <!--?= $form->field($model, 'comp_id')->textInput() ?-->

    <!--?= $form->field($model, 'owner_id')->textInput() ?-->

    <?= $form->field($model, 'owner_id')->
        dropDownList(ArrayHelper::map(\app\models\Complist::find()->all(),'id', 'name'),
        ['prompt'=>'']) ?>

    <div class="form-group">
        <?= Html::submitButton('Записать', ['class' => 'btn btn-default']) ?>
        <a href="#" data-dismiss="modal" class="btn">Отменить</a>
    </div>

    <?php ActiveForm::end(); ?>

</div>
