<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $model app\models\Complist */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="pers-anthrop-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'val')->
    dropDownList(ArrayHelper::map(\app\models\Sizelist::find()
        ->where('group_name=:tp',[':tp'=>$model->name])
        ->all(),'size', 'size'),
        ['prompt'=>'']) ?>
<footer>
    <div class="form-group">
        <?= Html::submitButton('Записать', ['class' => 'btn btn-warning']) ?>
        <a href="#" class = "btn btn-default" data-dismiss="modal" class="btn">Отменить</a>
    </div>
</footer>
    <?php ActiveForm::end(); ?>

</div>
