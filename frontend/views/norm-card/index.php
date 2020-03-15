<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\bootstrap\Modal;


/* @var $this yii\web\View */
/* @var $searchModel app\models\search\NormCard */
/* @var $dataProvider yii\data\ActiveDataProvider */

$js=<<<JS
$(document).on("click","[data-remote]",function(e) {
    e.preventDefault();
    $("div#card_upd_edit .modal-body").load($(this).data('remote'));
});
$('#Assigs').on('hidden.bs.modal', function (e) {
  $("div#card_upd_edit .modal-body").html('');
}); 
JS;
$this->registerJs($js);

$this->title = 'Карточки сотрудников';
//$this->params['breadcrumbs'][] = ['label' => 'Отпуск сотрудникам', 'url' => ['/invoice/index']];
$this->params['breadcrumbs'][] = ['label' => 'Возврат от сотрудников', 'url' => ['/inorder/index-nakl']];
$this->params['breadcrumbs'][] = ['label' => 'Списание со склада', 'url' => ['/invoice/index-destr']];
$this->params['breadcrumbs'][] = ['label' => 'Внутрихозяйственные операции', 'url' => ['/draft/index']];
$this->params['breadcrumbs'][] = ['label' => 'Приход на склад', 'url' => ['/inorder/index']];


//$this->params['breadcrumbs'][] = $this->title;
$model = new \app\models\NormCard();

?>
<div class="norm-card-index">

<div class="modal fade right" id="adsModal">
    <div class="modal-dialog modal-md">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
          <h4 class="modal-title">Добавление карточки сотрудника</h4>
        </div>
        <div class="modal-body">
            <?= $this->render('/norm-card/_form_mod',['model' => $model]); ?>
        </div>
        <!--div class="modal-footer">
          <a href="http://bootstrap-3.ru/forum/" target="_blank" class="btn btn-success">Записать</a>
          <a href="#" data-dismiss="modal" class="btn btn-default">Отменить</a>
        </div-->
      </div>
    </div>
</div>
 
    <h3><?= Html::encode($this->title) ?></h3>

    <p>
        <button type="button" class = "btn btn-success" onclick="$('#adsModal').modal('show');" >Добавить</button>
        <!--?= Html::a('Create Norm Card', ['create'], ['class' => 'btn btn-success']) ?-->
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'options' => [ 'style' => 'table-layout:fixed;' ],
        'formatter' => ['class' => 'yii\i18n\Formatter','nullDisplay' => ''],
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

//            'id',
            'PersName',
/*            [
                'attribute' => 'gender',
                'headerOptions' => ['width' => '120'],
                'options' => ['style => width:15%'],
                'content' => function ($data){
                    return $data->sexes;
                },
//                'attribute' => 'GenderName',
                'filter' => \app\models\NormCard::getGenderArray(),
            ],*/
            'GenderName',
            'StaffName',
/*            [
                'attribute' => 'prof_id',
                'content' => function($data) {
                    return $data->profname;
                },
                'filter' => \app\models\NormCard::getProfs(),
//                'options' => ['style => width:25%']
            ],*/
//            'ProfName',
            'TypeName',
//            'pers_id',
//            'norm_id',

            ['class' => 'yii\grid\ActionColumn', 
            'buttons' => [
                'upd'=>function($url,$model){
                    $url=Yii::$app->getUrlManager()->createAbsoluteUrl(['/norm-card/updatemod','id'=>$model->id]);
                    return Html::a('<span class="glyphicon glyphicon-pencil"></span>', '#card_upd_edit', [
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
                    $customurl=Yii::$app->getUrlManager()->createUrl(['/invoice-spec/create-spec','id'=>$model->id]); //$model->id для AR
                    return \yii\helpers\Html::a( '<span class="glyphicon glyphicon-th-list"></span>', $customurl,
                        ['title' => Yii::t('yii', 'Выдача со склада'), 'data-pjax' => '0']); //,
                },
                ],
                'template' =>' {spec} {delete} ',
//                'template' =>' {upd} {delete} {spec}',
            ],
        ],
    ]); ?>

<!--Корректировка карточки сотрудника------------------------------------------------------>
    <?php
    Modal::begin([
        'options' => [
            'id' => 'card_upd_edit'
            ],
        'header' => '<h3>Корректировка норм сотрудника</h3>',
        ]);
    Modal::end();
    ?>

</div>
