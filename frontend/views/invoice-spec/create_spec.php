<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\bootstrap\Modal;
use yii\data\ActiveDataProvider;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $searchModel app\models\search\InvoiceSpec */
/* @var $dataProvider yii\data\ActiveDataProvider */

$js=<<<JS
$(document).on("click","[data-remote]",function(e) {
    e.preventDefault();
    $("div#invspec_add_insert .modal-body").load($(this).data('remote'));
});
$('#Assigs').on('hidden.bs.modal', function (e) {
  $("div#invspec_add_insert .modal-body").html('');
});
JS;
$this->registerJs($js);

$this->title = 'Спецификация расходной накладной.Сотрудник '.$pers_name;
$this->params['breadcrumbs'][] = ['label' => 'Отпуск сотрудникам', 'url' => ['/norm-card/index']];
$this->params['breadcrumbs'][] = ['label' => 'Возврат от сотрудников', 'url' => ['/inorder/index-nakl']];
$this->params['breadcrumbs'][] = ['label' => 'Списание со склада', 'url' => ['/invoice/index-destr']];
$this->params['breadcrumbs'][] = ['label' => 'Внутрихозяйственные операции', 'url' => ['/draft/index']];
$this->params['breadcrumbs'][] = ['label' => 'Приход на склад', 'url' => ['/inorder/index']];
$model = new \app\models\InvoiceSpec();
?>
<style>
    #card-pers, #rem-spec {
        overflow-y: scroll;
        Height:300px;
    }
</style>
<div class="invoice-spec-index">

<div class="modal fade right" id="adsModal">
    <div class="modal-dialog modal-md">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
          <h4 class="modal-title">Добавление спецификации расходной накладной</h4>
        </div>
        <div class="modal-body">
            <?= $this->render('/invoice-spec/_form_mod',['model' => $model, 'id' => $id]); ?>
        </div>
        <div class="modal-footer">
          <!--a href="http://bootstrap-3.ru/forum/" target="_blank" class="btn btn-primary">Записать</a>
          <a href="#" data-dismiss="modal" class="btn">Отменить</a-->

        </div>
      </div>
    </div>
</div>
 
    <h3><?= Html::encode($this->title) ?></h3>

    <p>
        <!--button type="button" onclick="$('#adsModal').modal('show');" >Добавить</button-->
        <!--?= Html::a('Заполнение спецификации накладной', ['create-spec', 'id'=>$id], ['class' => 'btn btn-success']) ?-->
    </p>

    <?php  /*$dataProvider = new ActiveDataProvider([
            'query'=>$anthrop,
        ]); */?>
<!--    <div class="col-md-4">
        <h4>Антропологические параметры</h4>
    <?/*= GridView::widget([
        'dataProvider' => $dataProvider,
//        'filterModel' => $searchModel,
        'options' => [ 'style' => 'table-layout:fixed;' ],
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            [
                'attribute' => 'name',
                'options' => ['style' => 'width: 75%'],
            ],
            [
                'attribute' => 'val',
                'options' => ['style' => 'width: 5%'],
            ],
//            ['class' => 'yii\grid\ActionColumn'], 
        ],
//        ],
    ]);
    */?>
    </div>
-->    <div class="col-sm-12">
        <h4>Карточка сотрудника</h4>
        <div id="card-pers">
    <?php  $dataProvider = new ActiveDataProvider([
            'query'=>$card,
/*            'pagination' => [
                'forcePageParam' => false,
                'pageSizeParam' => false,
                'pageSize' => 5,
            ],   */
        ]); 
    ?>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'summary' => false,
//        'filterModel' => $searchModel,
        'formatter' => ['class' => 'yii\i18n\Formatter','nullDisplay' => ''],
        'rowOptions' => function($model,$key,$index,$grid) {
            if($model->active == 1)
                return ['style' => 'background-color:#778899;',
                        'data-id' => $model->id];

            return ['data-id' => $model->id];
        },

        'options' => [ 'style' => 'table-layout:fixed;' ],
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            [
                'attribute' => 'Размеры',
                'options' => ['style' => 'width: 2%'],
                'format'=>'raw',
                'value' => function ($data){
                    return Html::a('','#',
                        ['onclick'=>
                            'var a = this; // get element anchor
            var td = $(a).parent(); // get parent dari element anchor = td
            var tr = $(td).parent(); // get element tr
            var tdCount = $(tr).children().length; // get quant of td in tr
            var table = $(tr).parent(); // get element table
            if($(table).children(".trSubDetail").length){
                $(a).attr("class","glyphicon glyphicon-triangle-bottom");
//                $("#work_"+work_id).remove(); // initialise, drop all of child with class trDetail 
                $(table).children(".trSubDetail").remove(); // initialise, drop all of child with class trDetail 
            }
            else
			{
                $(a).attr("class","glyphicon glyphicon-triangle-top");
                
                var trSubDetail = document.createElement("tr"); // create element tr for detail
                $(trSubDetail).attr("class","trSubDetail"); // add class trDetail for element tr 
//                $(trSubDetail).attr("id",1);
                $(trSubDetail).attr("style","background:#7e7e7e);border: 4px double black"); // add class trDetail for element tr
//                $(trSubDetail).attr("style","background-image:url(/images/bckgrnd.png);border: 4px double black"); // add class trDetail for element tr
                var tdSubDetail = document.createElement("td"); // create element td for detail tr
                $(tdSubDetail).attr("colspan",tdCount); // add element coolspan at td
//alert("qq1 "+'.$data->id.');
                // get content via ajax
                $.get("'.\yii\helpers\Url::to(['/invoice-spec/anthrop-list']).'?id="+'.$data->id.', function( data ) {
//                    +work_id, function( data ) {
                    $(tdSubDetail).html( data );
                    }).fail(function() {alert( "error" );
                });
                $(trSubDetail).append(tdSubDetail); // add td to tr
                $(tr).after(trSubDetail);  // add tr to table
            };return false;',
                            'class' => 'glyphicon glyphicon-triangle-bottom']);//btn-warning
                }

            ],


            [
                'attribute' => 'NomenName',
                'options' => ['style' => 'width: 75%'],
            ],
            [
                'attribute' => 'quant',
                'options' => ['style' => 'width: 7%'],
            ],
            [
                'attribute' => 'period',
                'options' => ['style' => 'width: 7%'],
            ],
            [
                'attribute' => 'quant_fct',
                'options' => ['style' => 'color: #bebebe', 'width: 7%'],
            ],
            [
                'attribute' => 'DateOut',
                'format' => ['date', 'php:d.m.Y'],
                'options' => ['style' => 'width: 15%'],
            ],
/*            [
                'attribute' => 'date_out',
                'format' => ['date', 'php:d.m.Y'],
                'options' => ['style => width:5%']
            ],*/
        ],
    ]); ?>
    </div>
    </div>
    <div class="col-sm-12">
        <h4>Наличие на складе</h4>
    <div id="rem-spec">
    <?php  $dataProvider = new ActiveDataProvider([
            'query'=>$remain,
/*            'pagination' => [
                'forcePageParam' => false,
                'pageSizeParam' => false,
                'pageSize' => 3,
            ],*/

    ]); ?>
<?php //throw new \yii\web\NotFoundHttpException('ef '.$id); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'summary' => false,
//        'filterModel' => $searchModel,
        'options' => [ 'style' => 'table-layout:fixed;' ],
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            [
                'attribute' => 'NomenName',
                'options' => ['style' => 'width: 75%'],
            ],
/*            [
                'attribute' => 'id',
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
/*            [
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
            ],*/
            ['class' => 'yii\grid\ActionColumn',
                'options' => ['style' => 'width: 7%'],
                'buttons' => [
                'nomadd'=>function($url,$model){
                    $url=Yii::$app->getUrlManager()->createAbsoluteUrl([
                        '/invoice-spec/insertmod',
                        'id'=>$model->id,
                        'spec_id'=>$model->cardspec_id,
                    ]);
                    
                    return Html::a('<span class="glyphicon glyphicon-arrow-up"></span>', '#invspec_add_insert', [
                                'title' => 'Выдать',
                                'data-toggle'=>'modal',
                                'data-backdrop'=>false,
                                'data-remote'=>$url
                                ]);
                    },
                    'spec' => function ($url, $model) { //download-alt
                        $customurl=Yii::$app->getUrlManager()->createUrl(['/const-nomen/index-detaile','id'=>$model->id]); //$model->id для AR
                        return \yii\helpers\Html::a( '<span class="glyphicon glyphicon-arrow-down"></span>', $customurl,
                            ['title' => Yii::t('yii', 'Разукомплектовать'), 'data-pjax' => '0']); //,
                    },

                ],
                'template' =>'{nomadd} {spec}',
            ], 
        ],
    ]); 
?>
    </div>
    </div>
<!--Добавление  спецификации накладной------------------------------------------------------>
    <?php
    Modal::begin([
        'options' => [
            'id' => 'invspec_add_insert'
            ],
        'header' => '<h4>Добавление спецификации в расходную накладную</h4>',
        ]);
    Modal::end();
    ?>

<?php
/*$this->registerJs("
    $('td').click(function (e) {
    var id = $(this).closest('tr').data('id');
    if(e.target == this)
    location.href = '" . Url::to(['invoice-spec/create-spec']) . "?spec_id=' + id;
    });

");*/
//(function ($) {
/* $('.block_link').click(function() {    
    "use strict";
    $('body').on('click','tr', function (e) {
        $(this).toggleClass('selected');
    });
})(jQuery);*/
$this->registerJs("
    $('td').click(function (e) {
//    this.style.backgroundColor = 'yellow';
    var id = $(this).closest('tr').data('id');
    if (id !== undefined) {
    if(e.target == this)
    location.href = '" . Url::to(['invoice-spec/create-spec']) . "?spec_id=' + id;
        }
    });
");
 ?>
 
</div>
