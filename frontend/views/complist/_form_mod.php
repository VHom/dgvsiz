<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;


/* @var $this yii\web\View */
/* @var $model app\models\Complist */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="complist-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'code')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'branch_id')->
        dropDownList(ArrayHelper::map(\app\models\Branchlist::find()->all(),'id', 'name'),
        ['prompt'=>'']) ?>
    <!--?= $form->field($model, 'branch_id')->textInput() ?-->

    <div class="form-group">
        <?= Html::submitButton('Записать', ['class' => 'btn btn-default']) ?>
        <a href="#" data-dismiss="modal" class="btn">Отменить</a>
    </div>

    <?php ActiveForm::end(); ?>

</div>
