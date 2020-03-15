<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
//use kartik\date\DatePicker;
//use kartik\datetime\DateTimePicker;
use kartik\select2\Select2;

/* @var $this yii\web\View */
/* @var $model app\models\Complist */
/* @var $form yii\widgets\ActiveForm */
\kartik\select2\Select2Asset::register($this);
?>

<div class="deficit-spec-form">

    <?php $form = ActiveForm::begin(); ?>

    <!--?=  $form->field($model,'nomen_deficit')->widget(Select2::classname(),
        [
            'data' => ArrayHelper::map(\app\models\Nomenclature::find()
                    ->orderBy('name')->all(),'id','name'),
//            'language' => 'ru',
//            'theme' => 'krajee',
            'disabled' => false, //$model->partner_id?false:true,
            'name' => 'nomen_deficit',
            'options' => ['placeholder' => 'Выберите номенклатуру',
                'id'=>'deficit-spec-nomen_deficit'],
            'pluginOptions' => [
//                'initialize' => true,
//                'style'=> 'display: block',
//                'style'=>['; display:inline !important'],
                'allowClear' => true,
//                'maximumInputLength' => 360,
            ],                
/*            'addon' => [
                'prepend' => [
                    'content' => Html::a(\yii\bootstrap\Html::icon('plus'),
//                            ['#'],
                        ['/nomenclature/updatemod','id' => $model->id], 
                            ['data-toggle' => 'modal',
                            'data-target' => '#nomen_add', // 'select2-inorderspec-nomen_id-container', //  '#nomen_add',
                        ])
                ],
            ],*/
        ]) 
    ?-->
    <!--?= $form->field($model, 'nomen_deficit')->
        dropDownList(ArrayHelper::map(app\models\Nomenclature::find()->all(),'id', 'name'),
        ['prompt'=>'']) ?-->
    
    <?= $form->field($model, 'def_quant')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Записать', ['class' => 'btn btn-warning']) ?>
        <a href="#" data-dismiss="modal" class="btn">Отменить</a>
    </div>

    <?php ActiveForm::end(); ?>

</div>
