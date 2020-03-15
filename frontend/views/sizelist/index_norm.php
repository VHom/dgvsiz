<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\bootstrap\Modal;

/* @var $this yii\web\View */
/* @var $searchModel app\models\search\Sizelist */
/* @var $dataProvider yii\data\ActiveDataProvider */

$js=<<<JS
$(document).on("click","[data-remote]",function(e) {
    e.preventDefault();
    $("div#size_upd_edit .modal-body").load($(this).data('remote'));
});
$('#Assigs').on('hidden.bs.modal', function (e) {
  $("div#size_upd_edit .modal-body").html('');
}); 
JS;
$this->registerJs($js);

$this->title = 'Список размеров';
//$this->params['breadcrumbs'][] = $this->title;
$model = new \app\models\search\Sizelist();
?>
<div class="sizelist-index">

<div class="modal fade right" id="adsModal">
    <div class="modal-dialog modal-md">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
          <h4 class="modal-title">Добавление размера</h4>
        </div>
        <div class="modal-body">
            <?= $this->render('/sizelist/_form_mod',['model' => $model]); ?>
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
        <!--?= Html::a('Create Sizelist', ['create'], ['class' => 'btn btn-success']) ?-->
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'formatter' => ['class' => 'yii\i18n\Formatter','nullDisplay' => ''],
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

//            'id',
            'TypeName',
//            'group_type',
            'group_name',
            'size',
            'min_val',
            'max_val',

            ['class' => 'yii\grid\ActionColumn', 
            'buttons' => [
                'upd'=>function($url,$model){
                    $url=Yii::$app->getUrlManager()->createAbsoluteUrl(['/sizelist/updatemod','id'=>$model->id]);
                    return Html::a('<span class="glyphicon glyphicon-pencil"></span>', '#size_upd_edit', [
                                'title' => 'Изменить',
                                'data-toggle'=>'modal',
                                'data-backdrop'=>false,
                                'data-remote'=>$url
                                ]);
                    },
                'delnorm' => function ($url, $model, $key) {
                            return Html::a('<span class="glyphicon glyphicon-trash"></span>', 
                            $url=Yii::$app->getUrlManager()->createAbsoluteUrl(['/sizelist/delete-norm','id'=>$model->id]), 
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
            'id' => 'size_upd_edit'
            ],
        'header' => '<h3>Корректировка размера</h3>',
        ]);
    Modal::end();
    ?>

</div>
