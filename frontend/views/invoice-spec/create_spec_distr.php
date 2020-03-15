<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\bootstrap\Modal;
use yii\data\ActiveDataProvider;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $searchModel app\models\search\InvoiceSpec */
/* @var $dataProvider yii\data\ActiveDataProvider */

$js=<<<JS
$(document).on("click","[data-remote]",function(e) {
    e.preventDefault();
    $("div#invspec_del_insert .modal-body").load($(this).data('remote'));
});
$('#Assigs').on('hidden.bs.modal', function (e) {
  $("div#invspec_del_insert .modal-body").html('');
});
JS;
$this->registerJs($js);

//throw new \yii\web\NotFoundHttpException('qq '.$id);
$invoice = app\models\Invoice::findOne($id);
$this->title = 'Спецификация акта списания.';
//$this->params['breadcrumbs'][] = $this->title;
/*if($id)
    $model = app\models\InvoiceSpec::findOne($id);
else*/
    $model = new \app\models\InvoiceSpec();
//    $rem = new app\models\Storemain()

?>
<div class="invoice-spec-index">
 
    <h3><?= Html::encode($this->title) ?></h3>

    <?php //throw new \yii\web\NotFoundHttpException('qq - '.$filter->id); 
        if(!$filter)
            $filter = new app\models\FilterStrem();
    ?>

    <div class="col-md-12 alert-info">
        <?php $form= \yii\widgets\ActiveForm::begin(); ?>
        <div class="col-md-12">
            <?= $form->field($filter,'nomen_id')->widget(Select2::classname(),
                [
                    'data' => ArrayHelper::map(\app\models\Nomenclature::find()
                            ->orderBy('name')->all(),'id','name'),
                    'disabled' => false, //$model->partner_id?false:true,
                    'name' => 'nomen_id',
                    'options' => ['placeholder' => 'Выберите номенклатуру'],
                        'pluginOptions' => [
                            'allowClear' => true
                ],                
            ]) ?>
        </div>
        <div class="col-md-4">
            <?= $form->field($filter,'store_id')
                ->dropDownList(yii\helpers\ArrayHelper::map(
                        app\models\Storelist::find()->all(),
                        'id','name'))
                //['prompt'=>''] ?>
        </div>
        <div class="col-md-4">
            <?= $form->field($filter,'is_siz')
                ->dropDownList([
                        0 => '',
                        1=>'ФО',
                        2=>'СИЗ']);
            ?>
        </div>
        <div class="col-md-4">
            <?= $form->field($filter,'amort')->textInput() ?>
        </div>
        <div class="col-md-12">
            <?= \yii\bootstrap\Html::submitButton('Найти', [
                'name'=>'submit','value'=>'findrec',
                'class'=>'btn btn-default pull-left'
            ]) ?>
            <?= \yii\bootstrap\Html::submitButton('Очистить', [
                'name'=>'submit','value'=>'clearrec',
                'class'=>'btn btn-default pull-right'
            ]) ?>
        </div>
        <?php $form = \yii\widgets\ActiveForm::end() ?>
    </div>
    <?php //throw new \yii\web\NotFoundHttpException('qq1 - '.$filter->id); ?>
    
    <?php  
//        $searchModel = new app\models\search\Storemain();
//        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
//        $dataProvider = new ActiveDataProvider([
//            'query'=>$remain,
//        ]); 
    ?>
    <h4>Наличие на складе</h4>
<!--?php throw new \yii\web\NotFoundHttpException('ef '.$id); ?-->

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
//        'filterModel' => $searchModel,
        'options' => [ 'style' => 'table-layout:fixed;' ],
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            [
                'attribute' => 'NomenName',
                'options' => ['style' => 'width: 40%'],
            ],
/*            [
                'attribute' => 'id', //номенклатура
                'options' => ['style' => 'width: 5%'],
            ],*/
            [
                'attribute' => 'quant',
                'options' => ['style' => 'width: 5%'],
            ],
            [
                'attribute' => 'SizeName',
                'options' => ['style' => 'width: 5%'],
            ],
            [
                'attribute' => 'HeightName',
                'options' => ['style' => 'width: 5%'],
            ],
            [
                'attribute' => 'FullName',
                'options' => ['style' => 'width: 5%'],
            ],
            [
                'attribute' => 'ShirtName',
                'options' => ['style' => 'width: 5%'],
            ],
            [
                'attribute' => 'ShoesName',
                'options' => ['style' => 'width: 5%'],
            ],
            [
                'attribute' => 'HeadName',
                'options' => ['style' => 'width: 5%'],
            ],
            [
                'attribute' => 'GloveName',
                'options' => ['style' => 'width: 5%'],
            ],
            [
                'attribute' => 'amout',
                'options' => ['style' => 'width: 5%'],
            ],
            ['class' => 'yii\grid\ActionColumn',
                'buttons' => [
                'nomdel'=>function($url,$model){
                    $url=Yii::$app->getUrlManager()->createAbsoluteUrl([
                        '/storemain/delmod','id'=>$model->id
                    ]);
                    
                    return Html::a('<span class="glyphicon glyphicon-trash"></span>', '#invspec_del_insert', [
                                'title' => 'Списать',
                                'data-toggle'=>'modal',
                                'data-backdrop'=>false,
                                'data-remote'=>$url
                                ]);
                    },
                ],
                'template' =>'{nomdel}',
            ], 
        ],
    ]); ?>
<!--Добавление  спецификации акта списания------------------------------------------------------>
    <?php
    Modal::begin([
        'options' => [
            'id' => 'invspec_del_insert'
            ],
        'header' => '<h4>Укажите количество списываемой номенклатуры</h4>',
        ]);
    Modal::end();
    ?>
    
</div>
