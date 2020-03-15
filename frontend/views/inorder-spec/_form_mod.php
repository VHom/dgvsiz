<?php

use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use kartik\date\DatePicker;
use kartik\select2\Select2;
use yii\helpers\Html;
use yii\bootstrap\Modal;
use yii\helpers\Url;
use yii\web\JsExpression;

/* @var $this yii\web\View */
/* @var $model app\models\Complist */
/* @var $form yii\widgets\ActiveForm */
?>
<script>
    $('#myselect').on("select2:select",function(e) {
        alert('qq');
        }
    );
</script>
<?php
    yii\bootstrap\Modal::begin([
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
    Modal::end ();
    ?>

    <?php
        if($id) {
            $model->nomen_id = $id;
            $kind = app\models\Nomenkind::find()
                ->leftJoin('nomenclature','nomenclature.kind_id=nomenkind.id')
                ->where('nomenclature.id=:id',[':id'=>$id])
                ->one();
        } else {
            $kind = new \app\models\Nomenkind();
        }
    ?>

<div class="inorder-spec-form">
    <?php $form = ActiveForm::begin(); ?>
    <div class="col-md-12">
        <?= $form->field($model,'nomen_id')->widget(Select2::classname(),
            [
                'data' => ArrayHelper::map(\app\models\Nomenclature::find()
                        ->orderBy('name')->all(),'id','name'),
                'disabled' => false,
                'name' => 'nomen_id',
//                'options' => ['placeholder' => 'Выберите номенклатуру'],
                    'pluginOptions' => [
                        'allowClear' => true,
//                        'minimumInputLength' => 3,
/*                        'ajax' => [
                            'url' => Url::to(['inorder-spec/index']), //?id=').'"+$(this).val()])
                            'dataType' => 'json',
//                            'data' => new JsExpression('function(params) { return {q:params.term}; }'),
                            'console.log(data)',
                        ],*/
                    ],
/*                'addon' => [
                    'prepend' => [
                        'content' => Html::a(\yii\bootstrap\Html::icon('plus'),
//                            ['#'],
                            ['/nomenclature/updatemod','id' => $model->id],
                                ['data-toggle' => 'modal',
                                'data-target' => '#nomen_add',
                            ])
                    ],
                ],*/
        ]) ?>
    </div>
    <div class="col-md-4">
        <?= $form->field($model, 'quant')->textInput() ?>
    </div>
    <div class="col-md-4">
        <?= $form->field($model,'placed')->dropDownList([
            '0' => 'На складе',
            '1' => 'В пути',
        ]) ?>
    </div>
    <div class="col-md-4">
        <?= $form->field($model, 'store_id')->
            dropDownList(ArrayHelper::map(app\models\Storelist::find()
                    ->all(),'id', 'name'),
            ['prompt'=>'']) ?>
    </div>
    <div class="col-md-3">
    <?= $form->field($model, 'size_id')->
        dropDownList(ArrayHelper::map(\app\models\Sizelist::find()
                ->where('group_name=:size',[':size'=> app\models\Sizelist::size])
                ->all(),'id', 'size'),
        ['prompt'=>'']) ?>
    </div>
    <div class="col-md-3">
        <?= $form->field($model, 'height_id')->
            dropDownList(ArrayHelper::map(\app\models\Sizelist::find()
                    ->where('group_name=:height',[':height'=> app\models\Sizelist::height])
                    ->all(),'id', 'size'),
            ['prompt'=>'']) ?>
    </div>
    <div class="col-md-3">
        <?= $form->field($model, 'full_id')->
            dropDownList(ArrayHelper::map(\app\models\Sizelist::find()
                    ->where('group_name=:full',[':full'=> app\models\Sizelist::full])
                    ->all(),'id', 'size'),
            ['prompt'=>'']) ?>
    </div>
    <div class="col-md-3">
        <?= $form->field($model, 'head_id')->
            dropDownList(ArrayHelper::map(\app\models\Sizelist::find()
                    ->where('group_name=:head',[':head'=> app\models\Sizelist::head])
                    ->all(),'id', 'size'),
            ['prompt'=>'']) ?>
    </div>
    <div class="col-md-4">
        <?= $form->field($model, 'shirt_id')->
            dropDownList(ArrayHelper::map(\app\models\Sizelist::find()
                    ->where('group_name=:shirt',[':shirt'=> app\models\Sizelist::shirt])
                    ->all(),'id', 'size'),
            ['prompt'=>'']) ?>
    </div>
    <div class="col-md-4">
        <?= $form->field($model, 'shoes_id')->
            dropDownList(ArrayHelper::map(\app\models\Sizelist::find()
                    ->where('group_name=:shoes',[':shoes'=> app\models\Sizelist::shoes])
                    ->all(),'id', 'size'),
            ['prompt'=>'']) ?>
    </div>
    <div class="col-md-4">
        <?= $form->field($model, 'glove_id')->
            dropDownList(ArrayHelper::map(\app\models\Sizelist::find()
                    ->where('group_name=:glove',[':glove'=> app\models\Sizelist::glove])
                    ->all(),'id', 'size'),
            ['prompt'=>'']) ?>
    </div>
    <div class="col-md-10">
        <div class="form-group">
            <?= Html::submitButton('Записать', ['class' => 'btn btn-success']) ?>
            <a href="#" data-dismiss="modal" class="btn btn-default">Отменить</a>
        </div>
    </div>
    <?php ActiveForm::end(); ?>
    <?php
    $this->registerJs("
    $('td').click(function (e) {
//    this.style.backgroundColor = 'yellow';
    var id = $(this).closest('tr').data('id');
    if (id !== undefined) {
    if(e.target == this)
    location.href = '" . Url::to(['inorder-spec/index']) . "?spec_id=' + id;
        }
    });
");
    ?>
</div>
