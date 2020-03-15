<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\bootstrap\Modal;

/* @var $this yii\web\View */
/* @var $searchModel app\models\search\DeficitSpec */
/* @var $dataProvider yii\data\ActiveDataProvider */

$js=<<<JS
$(document).on("click","[data-remote]",function(e) {
    e.preventDefault();
    $("div#difspec_upd_edit .modal-body").load($(this).data('remote'));
});
$('#Assigs').on('hidden.bs.modal', function (e) {
  $("div#difspec_upd_edit .modal-body").html('');
}); 
JS;
$this->registerJs($js);

$this->title = 'Спецификация дефицитной ведомости';
$this->params['breadcrumbs'][] = ['label' => 'Дефицитные ведомости подразделения', 'url' => ['/deficit-statment/index']];

$model = new \app\models\DeficitSpec();
//\kartik\select2\Select2Asset::register($this);
?>
<div class="modal fade right" id="adsModal">
    <div class="modal-dialog modal-md">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
          <h4 class="modal-title">Выбор подразделения</h4>
        </div>
        <div class="modal-body">
            <?= $this->render('/stat-spec/_form_mod',['model' => $model]); ?>
        </div>
        <!--div class="modal-footer">
          <a href="http://bootstrap-3.ru/forum/" target="_blank" class="btn btn-primary">Записать</a>
          <a href="#" data-dismiss="modal" class="btn">Отменить</a>
        </div-->
      </div>
    </div>
</div>
<div class="deficit-spec-index">

    <h3><?= Html::encode($this->title) ?></h3>
<?php  //  throw new \yii\web\NotFoundHttpException('aa '.$model->id.' - '.$id); ?>
    <p>
        <!--button type="button" onclick="$('#adsModal').modal('show');" >Сформиировать заявку</button-->
        <!--?= Html::a('Сформиировать заявку', ['/deficit-orderspec/index-create', 'id'=>$id], ['class' => 'btn btn-success']) ?-->
    </p>

    <?php $form = yii\widgets\ActiveForm::begin([
        'action'=>['addselect','id'=>$id],
        'method' => "post"
        ]); ?>
    <?= \yii\bootstrap\Html::submitButton('Добавить заявку', ['class'=>'btn btn-success']); ?>

    <?= GridView::widget([
        'options' => [
            'style' => 'font-size:small'
        ],
        'dataProvider' => $dataProvider,
//        'filterModel' => $searchModel,
        'rowOptions' => function($model,$key,$index,$grid){
                    if($model->quant_deficit > 0)
                        return ['style' => 'background-color:#ffb2b2;']; 
                    else 
                        return ['style' => 'background-color:#fff;'];        
        },
        
        'formatter' => ['class' => 'yii\i18n\Formatter','nullDisplay' => ''],
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
//                ['class' => 'yii\grid\CheckboxColumn', 'checkboxOptions' => ['onclick' => 'js:addItems(this.value, this.checked)']],
//                'class' => 'yii\grid\CheckboxColumn',
//                'checkboxOptions' => ['onclick' => 'js:addItems(this.value,this.checked)', //],
                ['class' => 'yii\grid\CheckboxColumn','checkboxOptions' => //[//
                    function ($model, $key, $index, $column) {
                        return ($model->sign_choice == 1)?['checked'=>"checked"]:[];
                        },
                    'options'=>['onclick' => 'js:addItems(this.value, this.checked)'],            
                    'headerOptions' => [
                        'onclick' => 'js:addItems(this.value,this.checked)'
                    ],
//                    ],
                   ], 
//                    Html::checkBox('selection_all', false, [
//        'class' => 'select-on-check-all',
//        'label' => 'Выбор',
//    ]),
                    
/*                    'contentOptions' => [
                        'checked' => function ($model, $key, $index, $column) {
                        return $model->sign_choice ? ['checked' => "checked"] : [];
                        }
                    ],
//                    'checked' => $model->sign_choice != 1 ? true : false,

//                            'onclick' => 'js:addItems(this.value,this.checked)'
                            
/*                    'onclick' => function ($model, $key, $index, $column) {
                    return $model->sign_choice ? ['checked' => "checked"] : [];
                    },
                    'js:addItems(this.value,this.checked)'
                ],*/
//                            ],
            'sign_choice',
            [
                    'attribute' => 'Просмотр',
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
                $.get("'.\yii\helpers\Url::to(['/deficit-spec/index-list']).'?id="+'.$data->id.', function( data ) {
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
//            'NomenName',
//            'size_pers',
            'def_name',
            'quant',
            'quant_fact',
            'date_end',
            'quant_store',
//            'DeficitName',
            'quant_deficit',
            ['class' => 'yii\grid\ActionColumn',
                'buttons' => [
                'upd'=>function($url,$model){
                    $url=Yii::$app->getUrlManager()->createAbsoluteUrl(['/deficit-spec/updatemod','id'=>$model->id]);
                    return Html::a('<span class="glyphicon glyphicon-pencil"></span>', '#difspec_upd_edit', [
                                'title' => 'Изменить',
                                'data-toggle'=>'modal',
                                'data-backdrop'=>false,
                                'data-remote'=>$url
                                ]);
                    },
                ],
                'template' =>' {upd} ',
                            
            ],
        ],
    ]); ?>
    <!--?= \yii\bootstrap\Html::submitButton('Сформировать', ['class'=>'btn btn-success']); ?-->
    <?php yii\widgets\ActiveForm::end(); ?>
<!--Корректировка карточки сотрудника------------------------------------------------------>
    <?php
    Modal::begin([
        'options' => [
            'id' => 'difspec_upd_edit'
            ],
        'header' => '<h3>Корректировка позиции заявки</h3>',
        ]);
    Modal::end();
    ?>

<script type="text/javascript">
  // action for all selected rows
  function submit(){
//    var dialog = confirm("Are you sure to submit the installment?");
//    if (dialog == true) {
        var keys = $('#grid').yiiGridView('getSelectedRows');
         console.log(keys);
        var ajax = new XMLHttpRequest();
        $.ajax({
            type: "POST",
            url: 'index.php?r=index', // installment/submit', // Your controller action
            data: {keylist: keys},
            success: function(result){
              console.log(result);
            }
          });
//    }
  }
</script>
<script>
    $('element').one('click',function() {
    function addItems(item_id,checked) {
        alert(item_id+"--"+checked);
        if(checked) {
            $.ajax({
                url:'addselect?id='+item_id,
                type: 'POST',
                dataType:'text',
                data: item_id,
            success:function() {
                console.log('OK');
            },
            error:function() {
                alert('Error');
            }
            });
            return false;
        }
        else {
            $.ajax({
                url:'deselect?id='+item_id,
                type: 'POST',
                dataType:'text',
                data: item_id,
            success:function() {
                console.log('OK');
            },
            error:function() {
                alert('Error');
            }
            });
            return false;
        }
    }
    }
</script>
</div>
