<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\bootstrap\Modal;
use kartik\date\DatePicker;

/* @var $this yii\web\View */
/* @var $searchModel app\models\search\Perslist */
/* @var $dataProvider yii\data\ActiveDataProvider */


$js=<<<JS
$(document).on("click","[data-remote]",function(e) {
    e.preventDefault();
    $("div#pers_upd_edit .modal-body").load($(this).data('remote'));
});
$('#Assigs').on('hidden.bs.modal', function (e) {
  $("div#pers_upd_edit .modal-body").html('');
}); 
JS;
$this->registerJs($js);

$js=<<<JS
$(document).on("click","[data-remote]",function(e) {

    e.preventDefault();
    $("div#personlist_update .modal-body").load($(this).data('remote'));
});
$('#Assigs').on('hidden.bs.modal', function (e) {
  $("div#personlist_update .modal-body").html('');
}); 
JS;
$this->registerJs($js);

$this->title = 'Список сотрудников';
//$this->params['breadcrumbs'][] = ['label' => 'Список сотрудников', 'url' => ['index']];
//$this->params['breadcrumbs'][] = ['label' => 'Карточки сотрудников', 'url' => ['/norm-card/index']];

//$this->params['breadcrumbs'][] = $this->title;
$model = new \app\models\Perslist();

?>
<style>
    .datepicker {
        z-index: 1060 !important;
    }
</style>

<?php //throw new \yii\web\NotFoundHttpException('qq '.$id);
//$errormod=0;
if($errormod==100) {
    $model = \app\models\Perslist::findOne($id);
    ?>
<?php $this->registerJs('$("#updModal").modal("show");') ?>
<div class="modal fade right" id="updModal">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h4 class="modal-title">Корректировка сотрудника</h4>
            </div>
            <div class="modal-body">
                <?= $this->render('/perslist/_form_update_mod',['model' => $model]); ?>
            </div>
            <!--div class="modal-footer">
                <a href="http://bootstrap-3.ru/forum/" target="_blank" class="btn btn-warning">Записать</a>
                <a href="#" data-dismiss="modal" class="btn">Отменить</a>
            </div-->
        </div>
    </div>
</div>
<?php } ?>

<div class="perslist-index">

<div class="modal fade right" id="adsModal">
    <div class="modal-dialog modal-md">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
          <h4 class="modal-title">Добавление сотрудника</h4>
        </div>
        <div class="modal-body">
            <?= $this->render('/perslist/_form_mod',['model' => $model]); ?>
        </div>
        <!--div class="modal-footer">
            <a href="http://bootstrap-3.ru/forum/" target="_blank" class="btn btn-success">Записать</a>
            <a href="#" data-dismiss="modal" class="btn">Отменить</a>
        </div-->
      </div>
    </div>
</div>
 
    <h3><?= Html::encode($this->title) ?></h3>

    <p>
        <button type="button" class = "btn btn-success" onclick="$('#adsModal').modal('show');" >Добавить</button>
    </p>

<div class="col-sm-12">
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'options' => [ 'style' => 'table-layout:fixed;' ],
        'formatter' => ['class' => 'yii\i18n\Formatter','nullDisplay' => ''],
        'columns' => [
            ['class' => 'yii\grid\SerialColumn',
                'header'=>'№ п/п'],

            [
                'attribute'=>'tabnum',
//                'options' => ['style => width:7%'],
            ],
            [
                'attribute'=>'abbr_name',
            ],
            
            [
                'attribute' => 'gender',
//                'headerOptions' => ['width' => '120'],
//                'options' => ['style => width:15%'],
                'content' => function ($data){
                    return $data->sexes;
                },

                'filter' => \app\models\Perslist::getGenderArray(),
            ],
            
//            [
//               'attribute' => 'staff_id',
//                'content' => function ($data){
//                    return $data->areas;
//                },

/*                 'filter' => \app\models\Stafflist::getAreaArray()
            ],

            [
                'attribute' => 'staff_id',
                'content' => function($data) {
                    return $data->AreaName;
                },
                'filter' =>\app\models\Stafflist::getAreaArray(),*/
/*                'options' => ['style => width:25%',
                'contentOptions'=>['style'=>'white-space: normal;']
                ]*/
//            ],
            [
                'attribute' => 'prof_id',
//                'options' => ['style => width:55%'],
                'content' => function($data) {
                    return $data->profname;
                },
                'filter' => \app\models\Proflist::getProfs(),
                'options' => ['style => width:55%']
            ],
            [
                'attribute' => 'start_date',
                'format' => ['date', 'php:d.m.Y'],
                'value' => function ($model) {
                    if (!$model->start_date) {
                        return null;
                    }
                    return $model->start_date;
                },
                'filter' => \kartik\date\DatePicker::widget([
                    'model' => $searchModel,
                    'value' => $searchModel->start_date,
                    'language' => 'ru',
                    'convertFormat' => true,
                    'attribute' => 'start_date',
                    'pluginOptions' => [
                        'format' => 'dd.MM.yyyy',
                        'style' => 'width: 60px;' ,
                    ]
                ]),
            ],

            ['class' => 'yii\grid\ActionColumn', 
            'buttons' => [
                'anthrop' => function ($url, $model) { //download-alt
                    $customurl=Yii::$app->getUrlManager()->createUrl(['/pers-anthrop/index','id'=>$model->id]); //$model->id для AR
                    return \yii\helpers\Html::a( '<span class="glyphicon glyphicon-eye-open"></span>', $customurl,
                    ['title' => Yii::t('yii', 'Антропологические параметры'), 'data-pjax' => '0']); //,
                },
                
                'upd'=>function($url,$model){
                    $url=Yii::$app->getUrlManager()->createAbsoluteUrl(['/perslist/updatemod','id'=>$model->id]);
                    return Html::a('<span class="glyphicon glyphicon-pencil"></span>', '#pers_upd_edit', [
                                'title' => 'Изменить',
                                'data-toggle'=>'modal',
                                'data-backdrop'=>false,
                                'data-remote'=>$url
                                ]);
                    },
                'card' => function ($url, $model) {
                    $customurl=Yii::$app->getUrlManager()->createUrl(['/norm-cardspec/card-norm','id'=>$model->id]);
                    return Html::a('<span class="glyphicon glyphicon-th-list"></span>', $customurl, [
                        'data-method' => 'post',
                        'data-pjax' => 0,
                        'title' => 'Карточка сотрудника',
                    ]);
                },                        
                ],
//                'header'=>'Действия',
                'headerOptions' => ['width' => '60'],
                'template' =>' {anthrop} {upd} {card}',
            ],
        ],
    ]); ?>
</div>
<!--Корректировка сотрудника------------------------------------------------------>
    <?php
    Modal::begin([
        'options' => [
            'id' => 'pers_upd_edit'
            ],
        'header' => '<h3>Корректировка сотрудника</h3>',
        ]);
    Modal::end();
    ?>

</div>
