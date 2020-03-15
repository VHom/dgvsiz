<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\bootstrap\Modal;
/* @var $this yii\web\View */
/* @var $searchModel app\models\search\Userlist */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Список пользователей';
$model = new app\models\Userlist();
//$this->params['breadcrumbs'][] = $this->title;

$js=<<<JS
$(document).on("click","[data-remote]",function(e) {
    e.preventDefault();
    $("div#user_psw_edit .modal-body").load($(this).data('remote'));
});
$('#Assigs').on('hidden.bs.modal', function (e) {
  $("div#user_psw_edit .modal-body").html('');
}); 
JS;
$this->registerJs($js);

$js=<<<JS
$(document).on("click","[data-remote]",function(e) {
    e.preventDefault();
    $("div#user_psw_edit .modal-body").load($(this).data('remote'));
});
$('#Assigs').on('hidden.bs.modal', function (e) {
  $("div#user_psw_edit .modal-body").html('');
}); 
JS;
$this->registerJs($js);
$js=<<<JS
$(document).on("click","[data-remote]",function(e) {
    e.preventDefault();
    $("div#user_stat_edit .modal-body").load($(this).data('remote'));
});
$('#Assigs').on('hidden.bs.modal', function (e) {
  $("div#user_stat_edit .modal-body").html('');
}); 
JS;
$this->registerJs($js);
?>

<div class="modal fade right" id="adsModal">
    <div class="modal-dialog modal-md">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
          <h4 class="modal-title">Добавление пользователя</h4>
        </div>
        <div class="modal-body">
            <?= $this->render('/userlist/_form_mod',['model' => $model]); ?>
        </div>
        <div class="modal-footer">
          <!--a href="http://bootstrap-3.ru/forum/" target="_blank" class="btn btn-primary">Записать</a-->
          <!--a href="#" data-dismiss="modal" class="btn">Отменить</a-->
        </div>
      </div>
    </div>
</div>
 
<div class="userlist-index">

    <h3><?= Html::encode($this->title) ?></h3>

    <p>
        <button type="button" class = "btn btn-success" onclick="$('#adsModal').modal('show');" >Добавить</button>
        <!--?= Html::a('Добавить пользователя', ['/userlist/create'], ['class' => 'btn btn-default']) ?-->
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'options' => [ 'style' => 'table-layout:fixed;' ],
        'columns' => [
//            ['class' => 'yii\grid\SerialColumn'],
            ['class' => 'yii\grid\SerialColumn',
             'options' => ['style' => 'width: 3%'],
            ],
            [
                'attribute' => 'family_name',
                'options' => ['style' => 'width: 10%'],
            ],
            [
                'attribute' => 'first_name',
                'options' => ['style' => 'width: 10%'],
            ],
            [
                'attribute' => 'second_name',
                'options' => ['style' => 'width: 13%'],
            ],
//            'family_name',
//            'first_name',
//            'second_name',
            [
                'attribute' => 'GenderName',
                'options' => ['style' => 'width: 7%'],
            ],
//            'GenderName',
            [
                'attribute' => 'StaffName',
                'options' => ['style' => 'width: 30%'],
            ],
//            'StaffName',
            [
                'attribute' => 'ProfName',
                'options' => ['style' => 'width: 16%'],
            ],
//            'ProfName',
            [
                'attribute' => 'RoleName',
                'options' => ['style' => 'width: 10%'],
            ],
            'Realy',
//            'Realy',
//            'staff_id',
//            'actual',
            //'rename',

            ['class' => 'yii\grid\ActionColumn',
            'buttons' => [
                'psw'=>function($url,$model){
                    $url=Yii::$app->getUrlManager()->createAbsoluteUrl(['/userlist/reset-pswd','id'=>$model->id]);
                    return Html::a('<span class="glyphicon glyphicon-refresh"></span>', '#user_psw_edit', [
                                'title' => 'Изменить пароль',
                                'data-toggle'=>'modal',
                                'data-backdrop'=>false,
                                'data-remote'=>$url
                                ]);
                    },
                'stat'=>function($url,$model){
                    $url=Yii::$app->getUrlManager()->createAbsoluteUrl(['/userlist/change-stat','id'=>$model->id]);
                    return Html::a('<span class="glyphicon glyphicon-user"></span>', '#user_stat_edit', [
                                'title' => 'Изменить статус',
                                'data-toggle'=>'modal',
                                'data-backdrop'=>false,
                                'data-remote'=>$url
                                ]);
                    },
                ],
                'template' =>'{psw} {stat}',
            ],
        ],
    ]); ?>

<!--Корректировка  спецификации приходного ордера------------------------------------------------------>
    <?php
    Modal::begin([
        'options' => [
            'id' => 'inspec_upd_edit'
            ],
        'header' => '<h4>Корректировка спецификации приходного ордера</h4>',
        ]);
    Modal::end();
    ?>

<!--Изменение пароля пользователя------------------------------------------------------>
    <?php
    Modal::begin([
        'options' => [
            'id' => 'user_psw_edit'
            ],
        'header' => '<h4>Изменение пароля пользователя</h4>',
        ]);
    Modal::end();
    ?>

<!--Изменение статуса пользователя------------------------------------------------------>
    <?php
    Modal::begin([
        'options' => [
            'id' => 'user_stat_edit'
            ],
        'header' => '<h4>Изменение статуса пользователя</h4>',
        ]);
    Modal::end();
    ?>

</div>
