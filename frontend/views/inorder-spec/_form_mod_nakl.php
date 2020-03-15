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

<!--script>
    $(function() {
        if(typeof $.fn.select2() !== "underfind") {
            console.log($.fn.select2);
            $("select.select2").select2();
        }
        
        function selectTypeSize() {
            alert($(this).val());
            
//            alert(window.baseUrl + "get-type-size");
            
            $.ajax({
                url: '/inorder-spec/get-type-size',
//                url: window.baseUrl + "get-type-size",
                delay: 250,
                type: "post",
                dataType: "json",
                cache: true,
                data:function(params) {
                    return {
                       //console.log(data),
                        result:data.type,
                    }
                }
                data: data,
                success: function(res){
                    console.log(res);
                },
                error: function(){
                    alert('Error!');
                }                
            });
//            $(this).select2(
//                minimumInputLength: 1,
//                allowClear: true,
//                placeholder:"-",
//                ajax: {
//            })
        }
        
        $("#inorderspec-nomen_id").on("change", selectTypeSize);
    })
</script-->    
<div class="inorder-spec-form">

    <?php $form = ActiveForm::begin(); 
        if($id) {
            $model->nomen_id = $id;
            $kind = app\models\Nomenkind::find()
                    ->leftJoin('nomenclature','nomenclature.kind_id=nomenkind.id')
                    ->where('nomenclature.id=:id',[':id'=>$id])
                    ->one();
        } else
            $kind = new \app\models\Nomenkind();
    ?>

    <div class="col-md-12">
        <?= $form->field($model,'nomen_id')->widget(Select2::classname(),[
//                'value' => ['name'],
                'data' => ArrayHelper::map(\app\models\Nomenclature::find() //->orderBy('name')
                        ->all(),'id','name'),
//                'disabled' => false, //$model->partner_id?false:true,
//                'name' => 'nomen_id',
                'options' => [
                    'placeholder' => 'Выберите номенклатуру',
//                    'depends' =>['nomen']
                ],
                'pluginOptions' => [
                    'allowClear' => true
                ],                
        ]) ?>
    </div>
    <div class="col-md-4">
        <?= $form->field($model, 'quant')->textInput() ?>
    </div>
    <div class="col-md-4">
        <?= $form->field($model, 'store_id')->
            dropDownList(ArrayHelper::map(app\models\Storelist::find()
                    ->all(),'id', 'name'),
            ['prompt'=>'']) ?>
    </div>
    <div class="form-group">
        <?= Html::submitButton('Записать', ['class' => 'btn btn-warning']) ?>
        <a href="#" data-dismiss="modal" class="btn btn-default">Отменить</a>
    </div>

    <?php ActiveForm::end(); ?>

</div>
