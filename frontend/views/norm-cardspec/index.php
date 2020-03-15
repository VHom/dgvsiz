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

//$this->title = 'Сотрудник '.$title.' Спецификация карточки СИЗ и ФО.';
$this->params['breadcrumbs'][] = ['label' => 'Карточки сотрудников', 'url' => ['/norm-card/index']];
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
 
    <h3><?= Html::encode($title) ?></h3>

    <p>
        <!--button type="button" onclick="$('#adsModal').modal('show');" >Добавить</button-->
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
//        'filterModel' => $searchModel,
        'formatter' => ['class' => 'yii\i18n\Formatter','nullDisplay' => ''],
        'options' => [ 'style' => 'table-layout:fixed;' ],
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

//            'id',
            [
                'attribute' => 'NomenName',
                'options' =>['style => width:30%']
            ],
            
//            'card_id',
            [
                'attribute' => 'quant',
                'options' => ['style => width:55%']
            ],
            
            [
                'attribute' => 'quant_fct',
                'options' => ['style => width:10%']
            ],
            
            [
                'attribute' => 'date_in',
                'format' => ['date', 'php:d.m.Y'],
                'options' => ['style => width:5%']
            ],
//            'date_in',
            [
                'attribute' => 'date_out',
                'format' => ['date', 'php:d.m.Y'],
                'options' => ['style => width:5%']
            ],
//            'date_out',
            //'nomen_id',

            ['class' => 'yii\grid\ActionColumn', 
            'buttons' => [
                'upd'=>function($url,$model){
                    $url=Yii::$app->getUrlManager()->createAbsoluteUrl(['/norm-cardspec/updatemod','id'=>$model->id]);
                    return Html::a('<span class="glyphicon glyphicon-pencil"></span>', '#cardsp_upd_edit', [
                                'title' => 'Изменить',
                                'data-toggle'=>'modal',
                                'data-backdrop'=>false,
                                'data-remote'=>$url
                                ]);
                    },


                'nomadd'=>function($url,$model){
                    $url=Yii::$app->getUrlManager()->createAbsoluteUrl([
                        '/invoice-spec/create-spec',
                        'spec_id'=>$model->id,
//                        'id'=>$model->id,
                    ]);
                    return \yii\helpers\Html::a( '<span class="glyphicon glyphicon-plus"></span>', $url,
                        ['title' => Yii::t('yii', 'Выдать сотруднику'), 'data-pjax' => '0']);
/*                    return Html::a('<span class="glyphicon glyphicon-plus"></span>', '#invspec_add_insert',
                        [
                        'title' => 'Выдать сотруднику',
//                                        'data-toggle'=>'modal',
                        'data-backdrop'=>false,
                        'data-remote'=>$url
                    ]);*/
                },
            ],
            'template' =>' {upd} {nomadd} ',
//                'template' =>' {upd} {delete} ',
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
