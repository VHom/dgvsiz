<?php

//use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use kartik\date\DatePicker;
use kartik\select2\Select2;
use yii\helpers\Html; //   kartik\helpers\Html;
use yii\bootstrap\Modal;

//use kartik\datetime\DateTimePicker;

/* @var $this yii\web\View */
/* @var $model app\models\Complist */
/* @var $form yii\widgets\ActiveForm */

$model = new app\models\DraftSpec();
$draft = app\models\Draft::findOne($id);
$model->OutStoreName = $draft->OutStoreName;
$model->InStoreName = $draft->InStoreName;
?>

<div class="draft-spec-form">

    <?php $form = ActiveForm::begin(); ?>

    <!--?= $form->field($model, 'draft_id')->textInput() ?-->

    <!--?= $form->field($model, 'remain_id')->textInput() ?-->

    <div class="col-lg-12">
        <div class="col-lg-12">
            <?= $form->field($model,'remain_id')
                ->widget(Select2::classname(),[
                    'data' => ArrayHelper::map(app\models\Storemain::find()->/*orderBy('NomenName')->*/all(),
                            'id','FullNomenName'),
                    'disabled' => false, 
                    'name' => 'nomenid_id',
                    'options' => ['placeholder' => 'Выберите номенклатуру'],
                        'pluginOptions' => [
                            'allowClear' => true
                        ],                

            ]) ?>
        </div>
        <div class="col-lg-5">
            <?= $form->field($model,'OutStoreName')->textInput(['readonly' => true]) ?>
        </div>
        <div class="col-lg-5">
            <?= $form->field($model,'InStoreName')->textInput(['readonly' => true]) ?>
        </div>
        <div class="col-lg-2">
            <?= $form->field($model, 'quant')->textInput() ?>
        </div>
    </div>
    <div class="form-group">
        <?= Html::submitButton('Записать', ['class' => 'btn btn-default']) ?>
        <a href="#" data-dismiss="modal" class="btn">Отменить</a>
        <!--?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?-->
    </div>
    <?php ActiveForm::end(); ?>
</div>