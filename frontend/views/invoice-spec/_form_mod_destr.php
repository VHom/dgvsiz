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
?>

<div class="inorder-spec-form">

<?php
//throw new \yii\web\NotFoundHttpException('qq: '.$id); 
    ?>    
    <?php $form = ActiveForm::begin(); 
        if($id) {
//            $nomen->nomen_id = $id;
            $query= app\models\Nomenkind::find()
                    ->leftJoin('nomenclature','nomenclature.kind_id=nomenkind.id')
                    ->where('nomenclature.id=:id',[':id'=>$id])
                    ->one();
//throw new \yii\web\NotFoundHttpException('view '.$id.' - '.$kind->size_gr);
        } else
            $kind = new \app\models\Nomenkind();
    ?>

    <!--div class="col-md-12">
        <!--?= $form->field($model,'remain_id')
            ->widget(Select2::classname(),[
                'data' => ArrayHelper::map(\app\models\Nomenclature::find()->orderBy('name')->all(),
                        'id','name'),
                'disabled' => false, //$model->partner_id?false:true,
                'name' => 'nomenid_id',
                'options' => ['placeholder' => 'Выберите номенклатуру'],
                    'pluginOptions' => [
                        'allowClear' => true
                    ],                
                'addon' => [
                    'prepend' => [
                        'content' => Html::a(\yii\bootstrap\Html::icon('plus'),
//                            ['#'],
                            ['/nomenclature/updatemod','id' => $model->id], 
                                ['data-toggle' => 'modal',
                                'data-target' => '#nomen_add', // 'select2-inorderspec-nomen_id-container', //  '#nomen_add',
                            ])
                    ],
                ],
                
        ]) ?>
    </div-->
    <div class="col-md-4">
        <?= $form->field($model, 'quant')->textInput() ?>
    </div>

    <div class="form-group">
        <?= Html::submitButton('Записать', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-warning']) ?>
        <a href="#" data-dismiss="modal" class="btn btn-default">Отменить</a>
    </div>

    <?php ActiveForm::end(); ?>

</div>
