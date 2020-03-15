<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\bootstrap\Modal;


/* @var $this yii\web\View */
/* @var $searchModel app\models\search\Invoice */
/* @var $dataProvider yii\data\ActiveDataProvider */

$js=<<<JS
$(document).on("click","[data-remote]",function(e) {
    e.preventDefault();
    $("div#inv_upd_edit .modal-body").load($(this).data('remote'));
});
$('#Assigs').on('hidden.bs.modal', function (e) {
  $("div#inv_upd_edit .modal-body").html('');
}); 
JS;
$this->registerJs($js);

$this->params['breadcrumbs'][] = ['label' => 'Отпуск сотрудникам', 'url' => ['/norm-card/index']];
//$this->params['breadcrumbs'][] = ['label' => 'Возврат от сотрудников', 'url' => ['/inorder/index-nakl']];
$this->params['breadcrumbs'][] = ['label' => 'Списание со склада', 'url' => ['/invoice/index-destr']];
$this->params['breadcrumbs'][] = ['label' => 'Внутрихозяйственные операции', 'url' => ['/draft/index']];
$this->params['breadcrumbs'][] = ['label' => 'Приход на склад', 'url' => ['/inorder/index']];

$inv = new \app\models\Invoice();
?>
<div class="invoice-index">

<div class="modal fade right" id="adsModal">
    <div class="modal-dialog modal-md">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
          <h4 class="modal-title">Добавление накладной</h4>
        </div>
        <div class="modal-body">
            <?= $this->render('/invoice/_form_mod_destr',['model' => $inv]); ?>
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
        <button type="button" class = "btn btn-success" onclick="$('#adsModal').modal('show');" >Добавить</button>
        <!--?= Html::a('Create Invoice', ['create'], ['class' => 'btn btn-success']) ?-->
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            'DoctypeName',
            'doc_numb',
            [
                'attribute' => 'doc_date',
                'format' => ['date', 'php:d.m.Y'],
//                'options' => ['style => width:5%']
            ],
//            'FullName',
            ['class' => 'yii\grid\ActionColumn', 
            'buttons' => [
                'upd'=>function($url,$model){
                    $url=Yii::$app->getUrlManager()->createAbsoluteUrl(['/invoice/updatemod-destr','id'=>$model->id]);
                    return Html::a('<span class="glyphicon glyphicon-pencil"></span>', '#inv_upd_edit', [
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
                'spec' => function ($url, $model) { //download-alt
                    $customurl=Yii::$app->getUrlManager()->createUrl(['/invoice-spec/index-destr','id'=>$model->id]); //$model->id для AR
                    return \yii\helpers\Html::a( '<span class="glyphicon glyphicon-th-list"></span>', $customurl,
                        ['title' => Yii::t('yii', 'Спецификация акта списания'), 'data-pjax' => '0']); //,
                },
                ],
                'template' =>'{upd} {spec}',
//                'template' =>'{upd} {delete} {spec}',
            ],
        ],
    ]); ?>

<!--Корректировка  накладной------------------------------------------------------>
    <?php
    Modal::begin([
        'options' => [
            'id' => 'inv_upd_edit'
            ],
        'header' => '<h3>Корректировка накладной</h3>',
        ]);
    Modal::end();
    ?>

</div>
