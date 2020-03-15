<?php

//use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
//use kartik\date\DatePicker;
use kartik\select2\Select2;
use yii\helpers\Html; //   kartik\helpers\Html;
//use yii\bootstrap\Modal;

//use kartik\datetime\DateTimePicker;

/* @var $this yii\web\View */
/* @var $model app\models\Complist */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="inorder-spec-form">

<?php
//throw new \yii\web\NotFoundHttpException('qq');
/*    yii\bootstrap\Modal::begin([
        'options' => [
            'id' => 'nomen_add',
        ],
        'header' => '<h4>Добавление номенклатуры</h4>',
    //    'size' => 'modal-lg',
        ]);
        ?>
    <?php
        $nomen = new \app\models\Nomenclature();
        echo $this->render('/nomenclature/_form_create',['model'=>$nomen]); 
    Modal::end ();*/
    ?>    
    <?php $form = ActiveForm::begin(); 
/*        if($id) {
            $model->nomen_id = $id;
            $kind = app\models\Nomenkind::find()
                    ->leftJoin('nomenclature','nomenclature.kind_id=nomenkind.id')
                    ->where('nomenclature.id=:id',[':id'=>$id])
                    ->one();
//throw new \yii\web\NotFoundHttpException('view '.$id.' - '.$kind->size_gr);
        } else
            $kind = new \app\models\Nomenkind();*/
    ?>

    <div class="col-md-12">
        <?= $form->field($model, 'NomenName')->textarea(['row'=>'4', 
            'readonly' => true,
        ])
         ?>
    </div>
    <div class="col-md-3">
        <?= $form->field($model, 'quant')->textInput() ?>
    </div>
    <div class="col-md-4">
        <?= $form->field($model,'placed')->dropDownList([
            '0' => 'На складе',
            '1' => 'В пути',
        ], array("disabled" => "disabled")) ?>
    </div>

    <div class="col-md-5">
        <?= $form->field($model, 'store_id')->
            dropDownList(ArrayHelper::map(app\models\Storelist::find()
                    ->all(),'id', 'name'), array("disabled" => "disabled"),
            ['prompt'=>'']) ?>
    </div>
    <!--div class="col-md-3"-->
        <!--?= $form->field($model, 'price')->textInput(['maxlength' => true]) ?>
    </div-->

    <!--div class="col-md-3"-->
        <!--?= $form->field($model,'is_siz')->dropDownList([
            '0' => 'СИЗ',
            '1' => 'ФО',
        ]) ?>
    </div-->

    <?php //if($kind && $kind->size_gr==1) {; ?>
        <div class="col-md-3">
        <?= $form->field($model, 'size_id')->
            dropDownList(ArrayHelper::map(\app\models\Sizelist::find()
                    ->where('group_name=:size',[':size'=> app\models\Sizelist::size])
                    ->all(),'id', 'size'), array("disabled" => "disabled"),
            ['prompt'=>'']) ?>
        </div>
    <?php //} ?>
    
    <?php //if($kind && $kind->height_gr==1) {; ?>
        <div class="col-md-3">
            <?= $form->field($model, 'height_id')->
                dropDownList(ArrayHelper::map(\app\models\Sizelist::find()
                        ->where('group_name=:height',[':height'=> app\models\Sizelist::height])
                        ->all(),'id', 'size'), array("disabled" => "disabled"),
                ['prompt'=>'']) ?>
        </div>
    <?php //} ?>
    
    <?php //if($kind && $kind->full_gr==1) {; ?>
        <div class="col-md-3">
            <?= $form->field($model, 'full_id')->
                dropDownList(ArrayHelper::map(\app\models\Sizelist::find()
                        ->where('group_name=:full',[':full'=> app\models\Sizelist::full])
                        ->all(),'id', 'size'), array("disabled" => "disabled"),
                ['prompt'=>'']) ?>
        </div>
    <?php //} ?>
    
    <?php //if($kind && $kind->head_gr==1) {; ?>
        <div class="col-md-3">
            <?= $form->field($model, 'head_id')->
                dropDownList(ArrayHelper::map(\app\models\Sizelist::find()
                        ->where('group_name=:head',[':head'=> app\models\Sizelist::head])
                        ->all(),'id', 'size'), array("disabled" => "disabled"),
                ['prompt'=>'']) ?>
        </div>
    <?php //} ?>
    
    <?php //if($kind && $kind->shirt_gr==1) {; ?>
        <div class="col-md-4">
            <?= $form->field($model, 'shirt_id')->
                dropDownList(ArrayHelper::map(\app\models\Sizelist::find()
                        ->where('group_name=:shirt',[':shirt'=> app\models\Sizelist::shirt])
                        ->all(),'id', 'size'), array("disabled" => "disabled"),
                ['prompt'=>'']) ?>
        </div>
    <?php //} ?>
    
    <?php //if($kind && $kind->shoes_gr==1) {; ?>
        <div class="col-md-4">
            <?= $form->field($model, 'shoes_id')->
                dropDownList(ArrayHelper::map(\app\models\Sizelist::find()
                        ->where('group_name=:shoes',[':shoes'=> app\models\Sizelist::shoes])
                        ->all(),'id', 'size'), array("disabled" => "disabled"),
                ['prompt'=>'']) ?>
        </div>
    <?php //} ?>
    
    <?php //if($kind && $kind->glove_gr==1) {; ?>
        <div class="col-md-4">
            <?= $form->field($model, 'glove_id')->
                dropDownList(ArrayHelper::map(\app\models\Sizelist::find()
                        ->where('group_name=:glove',[':glove'=> app\models\Sizelist::glove])
                        ->all(),'id', 'size'), array("disabled" => "disabled"),
                ['prompt'=>'']) ?>
        </div>
    <?php //} ?>
    

    <div class="form-group">
        <?= Html::submitButton('Записать', ['class' => 'btn btn-warning']) ?>
        <a href="#" data-dismiss="modal" class="btn btn-default">Отменить</a>
    </div>

    <?php ActiveForm::end(); ?>

</div>
