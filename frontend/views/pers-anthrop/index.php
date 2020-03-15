<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\bootstrap\Modal;

/* @var $this yii\web\View */
/* @var $searchModel app\models\search\PersAnthrop */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Сотрудник '.$fio.'. Антропологические параметры.';
$this->params['breadcrumbs'][] = ['label' => 'Список сотрудников', 'url' => ['/perslist/index']];

$js=<<<JS
$(document).on("click","[data-remote]",function(e) {
    e.preventDefault();
    $("div#anth_upd_edit .modal-body").load($(this).data('remote'));
});
$('#Assigs').on('hidden.bs.modal', function (e) {
  $("div#anth_upd_edit .modal-body").html('');
}); 
JS;
$this->registerJs($js);

$model = new \app\models\PersAnthrop();

?>

<div class="modal fade right" id="adsModal">
    <div class="modal-dialog modal-md">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
          <h4 class="modal-title">Добавление параметра сотрудника</h4>
        </div>
        <div class="modal-body">
            <?= $this->render('/pers-anthrop/_form_mod',['model' => $model]); ?>
        </div>
        <div class="modal-footer">
          <!--a href="http://bootstrap-3.ru/forum/" target="_blank" class="btn btn-primary">Записать</a>
          <a href="#" data-dismiss="modal" class="btn">Отменить</a-->

        </div>
      </div>
    </div>
</div>
 
<div class="pers-anthrop-index">

    <h3><?= Html::encode($this->title) ?></h3>

    <p>
        <button type="button" class = "btn btn-success" onclick="$('#adsModal').modal('show');" >Добавить</button>
    </p>

    <div class ="col-sm-7">
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
//        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            'name',
            'val',
            ['class' => 'yii\grid\ActionColumn',
            'buttons' => [
                'upd'=>function($url,$model){
                    $url=Yii::$app->getUrlManager()->createAbsoluteUrl(['/pers-anthrop/updatemod','id'=>$model->id]);
                    return Html::a('<span class="glyphicon glyphicon-pencil"></span>', '#anth_upd_edit', [
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
                'template' =>' {upd} {delete} ',
            ],
        ],
    ]); ?>
    </div>
<!--Корректировка параметров сотрудника------------------------------------------------------>
    <?php
    Modal::begin([
        'options' => [
            'id' => 'anth_upd_edit'
            ],
        'header' => '<h3>Корректировка параметров сотрудника</h3>',
        ]);
    Modal::end();
    ?>

</div>
