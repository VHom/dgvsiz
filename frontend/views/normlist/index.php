<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\bootstrap\Modal;
//use yii\data\ActiveDataProvider;

/* @var $this yii\web\View */
/* @var $searchModel app\models\search\Normlist */
/* @var $dataProvider yii\data\ActiveDataProvider */
$js=<<<JS
        
$(document).on("click","[data-remote]",function(e) {
    e.preventDefault();
    $("div#norm_upd_edit .modal-body").load($(this).data('remote'));
});
$('#Assigs').on('hidden.bs.modal', function (e) {
  $("div#norm_upd_edit .modal-body").html('');
}); 
JS;
$this->registerJs($js);

$this->title = 'Список норм';
$this->params['breadcrumbs'][] = ['label' => 'Нормы по сотрудникам', 'url' => ['/norm-card/index-norm']];
$this->params['breadcrumbs'][] = ['label' => 'Размерные группы', 'url' => ['/nomenkind/index']];
//$this->params['breadcrumbs'][] = ['label' => 'Нормы по должностям', 'url' => ['/normlist/index']];
//$this->params['breadcrumbs'][] = $this->title;
$model = new app\models\Normlist();

/*if($id) {
    $norm = \app\models\Normlist::findOne($id);
    $prof = \app\models\Proflist::findOne($norm->prof_id);
    $this->title = 'Список норм по профессии "'.$prof->name.'"';
}
else {
    $this->title = 'Список норм по профессии';
}*/

?>
<div class="normlist-index">

<div class="modal fade right" id="adsModal">
    <div class="modal-dialog modal-md">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
          <h4 class="modal-title">Добавление нормы</h4>
        </div>
        <div class="modal-body">
            <?= $this->render('/normlist/_form_mod',['model' => $model]); ?>
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
        <!--?= Html::a('Create Normlist', ['create'], ['class' => 'btn btn-success']) ?-->
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <div class="col-md-12">
        <!--div class="col-md-6"-->
            <?= GridView::widget([
                'dataProvider' => $dataProvider,
                'filterModel' => $searchModel,
                'options' => [ 'style' => 'table-layout:fixed;' ],
                'columns' => [
                    ['class' => 'yii\grid\SerialColumn'],
                    [
                        'attribute' => 'StaffName',
                        'options' => ['style' => 'width: 40%'],
                    ],
//                    'StaffName',
                    [
                        'attribute' => 'ProfName',
                        'options' => ['style' => 'width: 30%'],
                    ],
//                    'ProfName',
                    [
                        'attribute' => 'TypeName',
                        'options' => ['style' => 'width: 12%'],
                    ],
//                    'TypeName',
                    [
                        'attribute' => 'GenderName',
                        'options' => ['style' => 'width: 10%'],
                    ],
//                    'GenderName',
                    ['class' => 'yii\grid\ActionColumn', 
                    'buttons' => [
                        'upd'=>function($url,$model){
                            $url=Yii::$app->getUrlManager()->createAbsoluteUrl(['/normlist/updatemod','id'=>$model->id]);
                            return Html::a('<span class="glyphicon glyphicon-pencil"></span>', '#norm_upd_edit', [
                                        'title' => 'Изменить',
                                        'data-toggle'=>'modal',
                                        'data-backdrop'=>false,
                                        'data-remote'=>$url
                                        ]);
                            },
                        'delnorm' => function ($url, $model, $key) {
                            return Html::a('<span class="glyphicon glyphicon-trash"></span>', 
                            $url=Yii::$app->getUrlManager()->createAbsoluteUrl(['/normlist/delete-norm','id'=>$model->id]), 
                            [
                                'title' => 'Удалить',
                                'data-method' => 'post',
                                'data-pjax' => 0,
                                'data-confirm' => 'Вы уверены?'
                            ]);
                        },          
                        'group' => function ($url, $model) { //download-alt
                        $customurl=Yii::$app->getUrlManager()->createUrl(['/normlist-spec/index','id'=>$model->id]); //$model->id для AR
                        return \yii\helpers\Html::a( '<span class="glyphicon glyphicon-th-list"></span>', $customurl,
                            ['title' => Yii::t('yii', 'Нормы по должности'), 'data-pjax' => '0']); //,
                        },
                        ],
                        'template' =>'{upd} {group} {delnorm}',
                    ],
                ],
            ]); ?>
    </div>
<!--Корректировка нормы------------------------------------------------------>
    <?php
    Modal::begin([
        'options' => [
            'id' => 'norm_upd_edit'
            ],
        'header' => '<h3>Корректировка нормы</h3>',
        ]);
    Modal::end();
    ?>

</div>
