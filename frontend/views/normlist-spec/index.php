<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\bootstrap\Modal;

/* @var $this yii\web\View */
/* @var $searchModel app\models\search\NormlistSpec */
/* @var $dataProvider yii\data\ActiveDataProvider */

$js=<<<JS
        
$(document).on("click","[data-remote]",function(e) {
    e.preventDefault();
    $("div#spec_upd_edit .modal-body").load($(this).data('remote'));
});
$('#Assigs').on('hidden.bs.modal', function (e) {
  $("div#spec_upd_edit .modal-body").html('');
}); 
JS;
$this->registerJs($js);


$this->title = 'Перечень норм по профессии "'.$prof_name.'"';
$this->params['breadcrumbs'][] = ['label' => 'Нормы по сотрудникам', 'url' => ['/norm-card/index-norm']];
$this->params['breadcrumbs'][] = ['label' => 'Размерные группы', 'url' => ['/nomenkind/index']];
$this->params['breadcrumbs'][] = ['label' => 'Нормы по должностям', 'url' => ['/normlist/index']];
$model = new app\models\NormlistSpec();

?>
<div class="normlist-spec-index">

<div class="modal fade right" id="adsModal">
    <div class="modal-dialog modal-md">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
          <h4 class="modal-title">Добавление размера</h4>
        </div>
        <div class="modal-body">
            <?= $this->render('/normlist-spec/_form_mod',['model' => $model]); ?>
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
        <!--?= Html::a('Create Normlist Spec', ['create'], ['class' => 'btn btn-success']) ?-->
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
//            'norm_id',
            
            [
                'attribute' => 'NomenName',
                'options' => ['style' => 'width: 55%'],
            ],
//            'NomenName',
            [
                'attribute' => 'KindName',
                'options' => ['style' => 'width: 27%'],
            ],
//            'KindName',
            [
                'attribute' => 'quant',
                'options' => ['style' => 'width: 5%'],
            ],
//            'quant',
            [
                'attribute' => 'period',
                'options' => ['style' => 'width: 5%'],
            ],
//            'period',
//            'code',
            //'nomen_id',
            //'doc_osn',
            //'kind_id',

                    ['class' => 'yii\grid\ActionColumn', 
                    'buttons' => [
                        'upd'=>function($url,$model){
                            $url=Yii::$app->getUrlManager()->createAbsoluteUrl(['/normlist-spec/updatemod','id'=>$model->id]);
                            return Html::a('<span class="glyphicon glyphicon-pencil"></span>', '#spec_upd_edit', [
                                        'title' => 'Изменить',
                                        'data-toggle'=>'modal',
                                        'data-backdrop'=>false,
                                        'data-remote'=>$url
                                        ]);
                            },
                        'delnorm' => function ($url, $model, $key) {
                            return Html::a('<span class="glyphicon glyphicon-trash"></span>', 
                            $url=Yii::$app->getUrlManager()->createAbsoluteUrl(['/normlist-spec/delete-norm','id'=>$model->id]), 
                            [
                                'data-method' => 'post',
                                'data-pjax' => 0,
                                'data-confirm' => 'Вы уверены?'
                            ]);
                        },  
                        ],
                        'template' =>'{upd} {delnorm}',
                    ],
                ],
            ]); ?>

<!--Корректировка размера------------------------------------------------------>
    <?php
    Modal::begin([
        'options' => [
            'id' => 'spec_upd_edit'
            ],
        'header' => '<h3>Корректировка размера</h3>',
        ]);
    Modal::end();
    ?>

</div>
