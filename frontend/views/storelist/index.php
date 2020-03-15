<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\bootstrap\Modal;

/* @var $this yii\web\View */
/* @var $searchModel app\models\search\Storelist */
/* @var $dataProvider yii\data\ActiveDataProvider */

$js=<<<JS
$(document).on("click","[data-remote]",function(e) {
    e.preventDefault();
    $("div#store_upd_edit .modal-body").load($(this).data('remote'));
});
$('#Assigs').on('hidden.bs.modal', function (e) {
  $("div#store_upd_edit .modal-body").html('');
}); 
JS;
$this->registerJs($js);

$this->title = 'Список складов';
$this->params['breadcrumbs'][] = ['label' => 'Организации', 'url' => ['/complist/index']];
$this->params['breadcrumbs'][] = ['label' => 'Филиалы', 'url' => ['/branchlist/index']];
$this->params['breadcrumbs'][] = ['label' => 'Подразделения', 'url' => ['/arealist/index']];
$this->params['breadcrumbs'][] = ['label' => 'Штатное расписание', 'url' => ['/proflist/index']];
$this->params['breadcrumbs'][] = ['label' => 'Категории должностей', 'url' => ['/prof-cat/index']];
//$this->params['breadcrumbs'][] = ['label' => 'Склады', 'url' => ['/storelist/index']];

$model = new \app\models\Storelist();
?>

<div class="modal fade right" id="adsModal">
    <div class="modal-dialog modal-md">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
          <h4 class="modal-title">Добавление организации</h4>
        </div>
        <div class="modal-body">
            <?= $this->render('/storelist/_form_mod',['model' => $model]); ?>
        </div>
        <div class="modal-footer">

        </div>
      </div>
    </div>
</div>
<div class="storelist-index">
 
    <h3><?= Html::encode($this->title) ?></h3>

    <p>
        <button type="button" onclick="$('#adsModal').modal('show');" >Добавить</button>
        <!--?= Html::a('Create Storelist', ['create'], ['class' => 'btn btn-success']) ?-->
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
//            'is_siz',
            'CompName',
            'OwnerName',
            //'comp_id',
            //'owner_id',

            ['class' => 'yii\grid\ActionColumn', 
            'buttons' => [
                'upd'=>function($url,$model){
                    $url=Yii::$app->getUrlManager()->createAbsoluteUrl(['/storelist/updatemod','id'=>$model->id]);
                    return Html::a('<span class="glyphicon glyphicon-pencil"></span>', '#store_upd_edit', [
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

<!--Корректировка склада------------------------------------------------------>
    <?php
    Modal::begin([
        'options' => [
            'id' => 'store_upd_edit'
            ],
        'header' => '<h3>Корректировка склада</h3>',
        ]);
    Modal::end();
    ?>


</div>
