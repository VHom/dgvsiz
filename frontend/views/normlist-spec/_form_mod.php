<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;


/* @var $this yii\web\View */
/* @var $model app\models\Complist */
/* @var $form yii\widgets\ActiveForm */
//throw new yii\web\NotFoundHttpException('qq-'.$model->id);
?>

<div class="normlist-spec-form">

    <?php $form = ActiveForm::begin(); ?>

    <!--?= $form->field($model, 'norm_id')->textInput() ?-->

    <?= $form->field($model, 'nomen_id')->
        dropDownList(ArrayHelper::map(\app\models\search\Nomenclature::find()->all(),'id', 'name'),
        ['prompt'=>'']) ?>
    <!--?= $form->field($model, 'nomen_id')->textInput() ?-->

    <?= $form->field($model, 'kind_id')->
        dropDownList(ArrayHelper::map(\app\models\search\Nomenkind::find()->all(),'id', 'name'),
        ['prompt'=>'']) ?>
    <!--?= $form->field($model, 'kind_id')->textInput() ?-->

    <?= $form->field($model, 'quant')->textInput() ?>
    
    <?= $form->field($model,'prim')->textarea(['row' => 3]) ?>

    <!--?= $form->field($model, 'norm_id')=$norm_id ?-->

    <!--?= $form->field($model, 'code')->textInput(['maxlength' => true]) ?-->

    <!--?= $form->field($model, 'doc_osn')->textInput(['maxlength' => true]) ?-->

    <div class="form-group">
        <?= Html::submitButton('Записать', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-warning']) ?>
        <a href="#" data-dismiss="modal" class="btn btn-default">Отменить</a>
    </div>

    <?php ActiveForm::end(); ?>

</div>
