<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\bootstrap\Modal;

/* @var $this yii\web\View */
/* @var $searchModel app\models\search\ConstNomen */
/* @var $dataProvider yii\data\ActiveDataProvider */

$js=<<<JS
$(document).on("click","[data-remote]",function(e) {
    e.preventDefault();
    $("div#const_upd_edit .modal-body").load($(this).data('remote'));
});
$('#Assigs').on('hidden.bs.modal', function (e) {
  $("div#const_upd_edit .modal-body").html('');
}); 
JS;
$this->registerJs($js);

$this->title = 'Состав комплекта';
$this->params['breadcrumbs'][] = ['label' => 'Ед. измерения', 'url' => ['/measure-unit/index']];
$this->params['breadcrumbs'][] = ['label' => 'Номенклатура', 'url' => ['/nomenclature/index']];
$this->params['breadcrumbs'][] = ['label' => 'Комплекты', 'url' => ['/const-nomen/index-const']];
//$this->params['breadcrumbs'][] = ['label' => 'Состав комплекта', 'url' => ['/const-nomen/index']];
//$model = $nomen;
$nomen = new \app\models\ConstNomen();
?>
<div class="const-nomen-index">
    <h3><?= Html::encode($this->title) ?></h3>
    <div class="modal fade right" id="adsModal">
        <div class="modal-dialog modal-md">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                    <h4 class="modal-title">Добавление номенклатуры комплекта.{{$model->name}}</h4>
                </div>
                <div class="modal-body">
                    <?= $this->render('/const-nomen/_form_mod'); ?>
                </div>
                <div class="modal-footer">
                    <!--a href="http://bootstrap-3.ru/forum/" target="_blank" class="btn btn-primary">Записать</a>
                    <a href="#" data-dismiss="modal" class="btn">Отменить</a-->

                </div>
            </div>
        </div>
    </div>

    <p>
        <button type="button" class="btn btn-success" onclick="$('#adsModal').modal('show');" >Добавить</button>
        <!--?= Html::a('Добавить', ['create'], ['class' => 'btn btn-success']) ?-->
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>
    <div class="col-md-10">
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
//        'filterModel' => $searchModel,
        'options' => [ 'style' => 'table-layout:fixed;' ],
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            [
                'attribute' => 'ComplectName',
                'options' => ['style' => 'width: 85%'],
            ],
            'quant',
            ['class' => 'yii\grid\ActionColumn',
                'options' => ['style' => 'width: 7%'],
                'buttons' => [
                    'upd'=>function($url,$model){
                        $url=Yii::$app->getUrlManager()->createAbsoluteUrl(['/const-nomen/updatemod','id'=>$model->id]);
                        return Html::a('<span class="glyphicon glyphicon-pencil"></span>', '#const_upd_edit', [
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
                ]           ,
                'template' =>'{upd} {delete}',
            ],
        ],
    ]); ?>
    </div>
    <!--Корректировка  спецификации приходного ордера------------------------------------------------------>
    <?php
    Modal::begin([
        'options' => [
            'id' => 'const_upd_edit'
        ],
        'header' => '<h4>Корректировка комплекта</h4>',
    ]);
    Modal::end();
    ?>

</div>
