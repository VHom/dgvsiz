<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use kartik\select2\Select2;

/* @var $this yii\web\View */
/* @var $model app\models\ConstNomen */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="const-nomen-form">

    <?php $form = ActiveForm::begin(); ?>
    <?php  $model = new \app\models\ConstNomen(); ?>
    <div class="col-md-12">
        <?= $form->field($model,'const_nomen_id')->widget(Select2::className(),
             [
                'data' => ArrayHelper::map(\app\models\Nomenclature::find()
                        ->orderBy('name')->all(),'id','name'),
                'disabled' => false,
                'name' => 'nomen_id',
                'options' => ['placeholder' => 'Выберите номенклатуру'],
                    'pluginOptions' => [
                        'allowClear' => true
                    ],
            ]);
        ?>
    </div>
    <div class="col-md-12">
        <?= $form->field($model, 'quant')->textInput()->label('Количество в комплекте') ?>
    </div>
    <!--?= $form->field($model, 'nomen_id')->textInput() ?-->
    <div class="form-group">
        <?= Html::submitButton('Записать', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-warning']) ?>
        <a href="#" data-dismiss="modal" class="btn btn-default">Отменить</a>
    </div>

    <?php ActiveForm::end(); ?>

</div>
