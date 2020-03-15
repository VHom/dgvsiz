<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\bootstrap\Modal;

/* @var $this yii\web\View */
/* @var $searchModel app\models\search\Arealist */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Список подразделений';
//$this->params['breadcrumbs'][] = $this->title;

$model = new app\models\Arealist();
?>

<?php
$js=<<<JS
$(document).on("click","[data-remote]",function(e) {
    e.preventDefault();
    $("div#area_upd_edit .modal-body").load($(this).data('remote'));
});
$('#Assigs').on('hidden.bs.modal', function (e) {
  $("div#area_upd_edit .modal-body").html('');
}); 
JS;
$this->registerJs($js);
?>

<div class="arealist-index">

    <h3><?= Html::encode($this->title) ?></h3>
<?php
$this->params['breadcrumbs'][] = ['label' => 'Организации', 'url' => ['/complist/index']];
$this->params['breadcrumbs'][] = ['label' => 'Филиалы', 'url' => ['/branchlist/index']];
//$this->params['breadcrumbs'][] = ['label' => 'Подразделения', 'url' => ['/arealist/index']];
$this->params['breadcrumbs'][] = ['label' => 'Штатное расписание', 'url' => ['/proflist/index']];
$this->params['breadcrumbs'][] = ['label' => 'Категории должностей', 'url' => ['/prof-cat/index']];
$this->params['breadcrumbs'][] = ['label' => 'Склады', 'url' => ['/storelist/index']];
?>

<div class="modal fade right" id="adsModal">
    <div class="modal-dialog modal-md">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
          <h4 class="modal-title">Добавление подразделения</h4>
        </div>
        <div class="modal-body">
            <?= $this->render('/arealist/_form_mod',['model' => $model]); ?>
        </div>
        <div class="modal-footer">
          <!--a href="http://bootstrap-3.ru/forum/" target="_blank" class="btn btn-primary">Записать</a>
          <a href="#" data-dismiss="modal" class="btn">Отменить</a-->
        </div>
      </div>
    </div>
</div>
 
    <p>
        <button type="button" onclick="$('#adsModal').modal('show');" >Добавить</button>
        <!--?= Html::a('Добавить подразделение', ['create'], ['class' => 'btn btn-default']) ?-->
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?php \yii\widgets\Pjax::begin(['id'=>'pjax_grid_events']); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

//            'id',
            'code',
            'name',
//            'comp_id',
            'CompName',

            ['class' => 'yii\grid\ActionColumn', 
            'buttons' => [
                'upd'=>function($url,$model){
                    $url=Yii::$app->getUrlManager()->createAbsoluteUrl(['/arealist/updatemod','id'=>$model->id]);
                    return Html::a('<span class="glyphicon glyphicon-pencil"></span>', '#area_upd_edit', [
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
                'template' =>'{upd} {delete}',
            ],
        ],
    ]); ?>

    <?php \yii\widgets\Pjax::end(); ?>

<!--Корректировка подразделения------------------------------------------------------>
    <?php
    Modal::begin([
        'options' => [
            'id' => 'area_upd_edit'
            ],
        'header' => '<h3>Корректировка подразделения</h3>',
        ]);
    Modal::end();
    ?>


</div>
