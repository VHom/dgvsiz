<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $model app\models\Storemain */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="storemain-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'id')->hiddenInput(['id'])->label(false) ?>

    <?= $form->field($model,'nomen_id')
            ->dropDownList(ArrayHelper::map(app\models\Nomenclature::find()->all(),'id', 'name'),
            ['prompt'=>'']) ?>
        
    <?= $form->field($model, 'quant')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Записать', ['class' => 'btn btn-default']) ?>
        <a href="#" data-dismiss="modal" class="btn">Отменить</a>
    </div>

    <?php ActiveForm::end(); ?>

</div>
