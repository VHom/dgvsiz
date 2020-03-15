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

$this->title = 'Нормы сотрудников';
$this->params['breadcrumbs'][] = ['label' => 'Размерные группы', 'url' => ['/nomenkind/index']];
$this->params['breadcrumbs'][] = ['label' => 'Нормы по должностям', 'url' => ['/normlist/index']];
//$this->params['breadcrumbs'][] = ['label' => 'Нормы по сотрудникам', 'url' => ['/norm-card/index-norm']];

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
        <div class="modal-footer">
          <!--a href="http://bootstrap-3.ru/forum/" target="_blank" class="btn btn-primary">Записать</a>
          <a href="#" data-dismiss="modal" class="btn">Отменить</a-->

        </div>
      </div>
    </div>
</div>
 
    <h3><?= Html::encode($this->title) ?></h3>

    <p>
        <!--button type="button" onclick="$('#adsModal').modal('show');" >Добавить</button-->
        <!--?= Html::a('Create Norm Card', ['create'], ['class' => 'btn btn-success']) ?-->
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

//            'id',
            'PersName',
            'GenderName',
            'StaffName',
            'ProfName',
//            'TypeName',
//            'pers_id',
//            'norm_id',

            ['class' => 'yii\grid\ActionColumn', 
            'buttons' => [
                'upd'=>function($url,$model){
                    $url=Yii::$app->getUrlManager()->createAbsoluteUrl(['/norm-card/updatemod-norm','id'=>$model->id]);
                    return Html::a('<span class="glyphicon glyphicon-pencil"></span>', '#card_upd_edit', [
                                'title' => 'Изменить',
                                'data-toggle'=>'modal',
                                'data-backdrop'=>false,
                                'data-remote'=>$url
                                ]);
                    },
                'delnorm' => function ($url, $model, $key) {
                        return Html::a('<span class="glyphicon glyphicon-trash"></span>', 
                        $url=Yii::$app->getUrlManager()->createAbsoluteUrl(['/norm-card/delete-norm','id'=>$model->id]), 
                        [
                            'data-method' => 'post',
                            'data-pjax' => 0,
                            'data-confirm' => 'Вы уверены?'
                        ]);
                },           
                'spec' => function ($url, $model) { //download-alt
                    $customurl=Yii::$app->getUrlManager()->createUrl(['/norm-cardspec/index-norm','id'=>$model->id]); //$model->id для AR
                    return \yii\helpers\Html::a( '<span class="glyphicon glyphicon-th-list"></span>', $customurl,
                        ['title' => Yii::t('yii', 'Спецификация норм сотрудника'), 'data-pjax' => '0']); //,
                },
                ],
                'template' =>' {spec} {delnorm} ',
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
