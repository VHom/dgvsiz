<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\bootstrap\Modal;

/* @var $this yii\web\View */
/* @var $searchModel app\models\search\DeficitStatment */
/* @var $dataProvider yii\data\ActiveDataProvider */

//$this->params['breadcrumbs'][] = $this->title;
$js=<<<JS
$(document).on("click","[data-remote]",function(e) {
    e.preventDefault();
    $("div#inord_upd_edit .modal-body").load($(this).data('remote'));
});
$('#Assigs').on('hidden.bs.modal', function (e) {
  $("div#inord_upd_edit .modal-body").html('');
}); 
JS;
$this->registerJs($js);
//throw new \yii\web\NotFoundHttpException('qq: '.$id);
$this->title = 'Дефицитные ведомости подразделений';
$this->params['breadcrumbs'][] = ['label' => 'Обеспеченность сотрудников СИЗ и ФО', 'url' => ['/stat-spec/index-provision']];
//$this->params['breadcrumbs'][] = ['label' => 'Дефицитные ведомости подразделения', 'url' => ['/deficit-statment/index']];
$dstat = new \app\models\DeficitStatment();
?>
<div class="deficit-statment-index">

<div class="modal fade right" id="adsModal">
    <div class="modal-dialog modal-md">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
          <h4 class="modal-title">Формирование дефицитной ведомости</h4>
        </div>
        <div class="modal-body">
            <?= $this->render('/deficit-statment/_form_mod',['model' => $dstat]); ?>
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
        <button type="button" class = "btn btn-info" onclick="$('#adsModal').modal('show');" >Сформировать</button>
        <!--?= Html::a('Create Deficit Statment', ['create'], ['class' => 'btn btn-default']) ?-->
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
/*            [
                'class' => 'yii\grid\CheckboxColumn',
                'header' => 'Выбор',
                'checkboxOptions' => function ($model, $key, $index, $column) {
                    return $model->sign_choice ? ['checked' => "checked"] : [];
                }
            ],*/
            [
                'attribute' => 'number_report',
                'options' => ['style => width:5%'],
            ],
            
            [
                'attribute' => 'date_report',
                'format' => ['date', 'php:d.m.Y'],
                'options' => ['style => width:10%']
            ],
//            'staff_id',
            [
                'attribute' => 'StaffName',
                'options' => ['style => width:40%']
            ],
            [
                'attribute' => 'prim',
                'options' => ['style => width:40%']
            ],
            

            ['class' => 'yii\grid\ActionColumn', 
            'buttons' => [
/*                'upd'=>function($url,$model){
                    $url=Yii::$app->getUrlManager()->createAbsoluteUrl(['/inorder/updatemod','id'=>$model->id]);
                    return Html::a('<span class="glyphicon glyphicon-pencil"></span>', '#inord_upd_edit', [
                                'title' => 'Изменить',
                                'data-toggle'=>'modal',
                                'data-backdrop'=>false,
                                'data-remote'=>$url
                                ]);
                },*/
                'delete' => function ($url, $model, $key) {
                    return Html::a('<span class="glyphicon glyphicon-trash"></span>', $url, [
                        'data-method' => 'post',
                        'data-pjax' => 0,
                        'data-confirm' => 'Вы уверены?'
                    ]);
                },                        
                'spec' => function ($url, $model) { //download-alt
                    $customurl=Yii::$app->getUrlManager()->createUrl(['/deficit-spec/index','id'=>$model->id]); //$model->id для AR
                    return \yii\helpers\Html::a( '<span class="glyphicon glyphicon-th-list"></span>', $customurl,
                        ['title' => Yii::t('yii', 'Спецификация ведомости'), 'data-pjax' => '0']); //,
                },
                'order' => function ($url, $model) { //download-alt
                    $customurl=Yii::$app->getUrlManager()->createUrl(['/deficit-orderspec/index','id'=>$model->id]); //$model->id для AR
                    return \yii\helpers\Html::a( '<span class="glyphicon glyphicon-list-alt"></span>', $customurl,
                        ['title' => Yii::t('yii', 'Заявка на поставку'), 'data-pjax' => '0']); //,
                },
                        
                ],
                'template' =>'{spec} {order} {delete}',
//                'template' =>'{upd} {delete} {spec}',
            ],
        ],
    ]); ?>

<!--Корректировка дефицитной ведомости------------------------------------------------------>
    <?php
    Modal::begin([
        'options' => [
            'id' => 'inord_upd_edit'
            ],
        'header' => '<h3>Корректировка приходного ордера</h3>',
        ]);
    Modal::end();
    ?>

</div>
