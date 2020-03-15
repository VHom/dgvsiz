<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\bootstrap\Modal;

/* @var $this yii\web\View */
/* @var $searchModel app\models\search\MeasureUnit */
/* @var $dataProvider yii\data\ActiveDataProvider */
$js=<<<JS
$(document).on("click","[data-remote]",function(e) {
    e.preventDefault();
    $("div#meas_upd_edit .modal-body").load($(this).data('remote'));
});
$('#Assigs').on('hidden.bs.modal', function (e) {
  $("div#meas_upd_edit .modal-body").html('');
}); 
JS;
$this->registerJs($js);

$this->title = 'Единицы измерения';
//$this->params['breadcrumbs'][] = ['label' => 'Ед. измерения', 'url' => ['/measure-unit/index']];
$this->params['breadcrumbs'][] = ['label' => 'Номенклатура', 'url' => ['/nomenclature/index']];
$this->params['breadcrumbs'][] = ['label' => 'Комплекты', 'url' => ['/const-nomen/index-const']];

$model = new app\models\MeasureUnit();
?>
<div class="measure-unit-index">

<div class="modal fade right" id="adsModal">
    <div class="modal-dialog modal-md">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
          <h4 class="modal-title">Добавление организации</h4>
        </div>
        <div class="modal-body">
            <?= $this->render('/measure-unit/_form_mod',['model' => $model]); ?>
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
        <button type="button" onclick="$('#adsModal').modal('show');" >Добавить</button>
        <!--?= Html::a('Create Measure Unit', ['create'], ['class' => 'btn btn-success']) ?-->
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

//            'id',
            'code',
            'name',
            'OKEI',

            ['class' => 'yii\grid\ActionColumn', 
            'buttons' => [
                'upd'=>function($url,$model){
                    $url=Yii::$app->getUrlManager()->createAbsoluteUrl(['/measure-unit/updatemod','id'=>$model->id]);
                    return Html::a('<span class="glyphicon glyphicon-pencil"></span>', '#meas_upd_edit', [
                                'title' => 'Изменить',
                                'data-toggle'=>'modal',
                                'data-backdrop'=>false,
                                'data-remote'=>$url
                                ]);
                    },
                'delete' => function ($url, $model, $key) {
                    return Html::a('<span class="glyphicon glyphicon-trash"></span>', $url, [
                        'data-method' => 'post',
                        'data-pjax' => 0,
                        'data-confirm' => 'Вы уверены?'
                    ]);
                },                        
                ],
                'template' =>'{upd} {delete}',
            ],
        ],
    ]); ?>
<!--Корректировка ед. измерения------------------------------------------------------>
    <?php
    Modal::begin([
        'options' => [
            'id' => 'meas_upd_edit'
            ],
        'header' => '<h3>Корректировка ед. измерения</h3>',
        ]);
    Modal::end();
    ?>

</div>
