<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $model app\models\Stafflist */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="stafflist-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'comp_id')->
        dropDownList(ArrayHelper::map(\app\models\Complist::find()->all(),'id', 'name'),
        ['prompt'=>'']) ?>
    <!--?= $form->field($model, 'comp_id')->textInput() ?-->

    <?= $form->field($model, 'branch_id')->
        dropDownList(ArrayHelper::map(\app\models\Branchlist::find()->all(),'id', 'name'),
        ['prompt'=>'']) ?>
    <!--?= $form->field($model, 'branch_id')->textInput() ?-->

    <?= $form->field($model, 'area_id')->
        dropDownList(ArrayHelper::map(\app\models\Arealist::find()->all(),'id', 'name'),
        ['prompt'=>'']) ?>
    <!--?= $form->field($model, 'area_id')->textInput() ?-->

    <?= $form->field($model, 'prof_id')->
        dropDownList(ArrayHelper::map(\app\models\Proflist::find()->all(),'id', 'prof_name'),
        ['prompt'=>'']) ?>
    <!--?= $form->field($model, 'prof_id')->textInput() ?-->

    <div class="form-group">
        <?= Html::submitButton('Записать', ['class' => 'btn btn-defoult']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
