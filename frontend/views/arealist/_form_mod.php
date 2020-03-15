<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $model app\models\Rolelist */
/* @var $form yii\widgets\ActiveForm */

//$model = new \app\models\Rolelist();
?>

<div class="arealist-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'comp_id')->
        dropDownList(ArrayHelper::map(\app\models\Complist::find()->all(),'id', 'name'),
        ['prompt'=>'']) ?>

    <?= $form->field($model, 'code')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton('Записать', ['class' => 'btn btn-default']) ?>
        <a href="#" data-dismiss="modal" class="btn">Отменить</a>
    </div>

    <?php ActiveForm::end(); ?>

</div>
