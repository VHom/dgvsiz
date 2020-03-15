<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\bootstrap\Modal;

/* @var $this yii\web\View */
/* @var $searchModel app\models\search\NormCardspec */
/* @var $dataProvider yii\data\ActiveDataProvider */

$js=<<<JS
$(document).on("click","[data-remote]",function(e) {
    e.preventDefault();
    $("div#cardsp_upd_edit .modal-body").load($(this).data('remote'));
});
$('#Assigs').on('hidden.bs.modal', function (e) {
  $("div#cardsp_upd_edit .modal-body").html('');
}); 
JS;
$this->registerJs($js);

//$this->title = 'Сотрудник '.$card->PersName.' Спецификация карточки СИЗ и ФО.';
$this->params['breadcrumbs'][] = ['label' => 'Список сотрудников', 'url' => ['/perslist/index']];
$model = new app\models\NormCardspec();
?>
<div class="norm-cardspec-index">

<div class="modal fade right" id="adsModal">
    <div class="modal-dialog modal-md">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
          <h4 class="modal-title">Добавление номенклатуры</h4>
        </div>
        <div class="modal-body">
            <?= $this->render('/norm-cardspec/_form_mod',['model' => $model]); ?>
        </div>
        <div class="modal-footer">
          <!--a href="http://bootstrap-3.ru/forum/" target="_blank" class="btn btn-primary">Записать</a>
          <a href="#" data-dismiss="modal" class="btn">Отменить</a-->

        </div>
      </div>
    </div>
</div>

    <h3><?= $title ?></h3>
<?php if($card)  { ?>
    <p>
        <button type="button" class = "btn btn-success" onclick="$('#adsModal').modal('show');" >Добавить</button>
    </p>
<?php  } ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
//        'filterModel' => $searchModel,
        'options' => [ 'style' => 'table-layout:fixed;' ],
        'formatter' => ['class' => 'yii\i18n\Formatter','nullDisplay' => ''],
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

//            'id',
            [
                'attribute' => 'NomenName',
                'options' =>['style => width:80%']
            ],
            
//            'card_id',
            [
                'attribute' => 'quant',
                'options' => ['style => width:5%']
            ],
            
            [
                'attribute' => 'period',
                'options' => ['style => width:10%']
            ],
/*
            [
                'attribute' => 'quant_fct',
                'options' => ['style => width:5%']
            ],
            
            [
                'attribute' => 'date_in',
                'format' => ['date', 'php:d.m.Y'],
                'options' => ['style => width:5%']
            ],
            [
                'attribute' => 'date_out',
                'format' => ['date', 'php:d.m.Y'],
                'options' => ['style => width:5%']
            ],
*/
            ['class' => 'yii\grid\ActionColumn',
            'buttons' => [
                'upd'=>function($url,$model){
                    $url=Yii::$app->getUrlManager()->createAbsoluteUrl(['/norm-cardspec/updatemod-norm','id'=>$model->id]);
                    return Html::a('<span class="glyphicon glyphicon-pencil"></span>', '#cardsp_upd_edit', [
                                'title' => 'Изменить',
                                'data-toggle'=>'modal',
                                'data-backdrop'=>false,
                                'data-remote'=>$url
                                ]);
                    },
                'del' => function ($url, $model, $key) {
                    return Html::a('<span class="glyphicon glyphicon-trash"></span>', 
                        $url=Yii::$app->getUrlManager()->createAbsoluteUrl(['/norm-cardspec/delete-norm','id'=>$model->id]), 
                        [
                            'title' => 'Удалить',
                            'data-method' => 'post',
                            'data-pjax' => 0,
                            'data-confirm' => 'Вы уверены?'
                        ]);
                },                        
                ],
                'template' =>' {upd} {del} ',
            ],
        ],
    ]); ?>

<!--Корректировка номенклатуры карточки сотрудника------------------------------------------------------>
    <?php
    Modal::begin([
        'options' => [
            'id' => 'cardsp_upd_edit'
            ],
        'header' => '<h3>Корректировка номенклатуры карточки сотрудника</h3>',
        ]);
    Modal::end();
    ?>

</div>
