<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\bootstrap\Modal;

/* @var $this yii\web\View */
/* @var $searchModel app\models\search\Nomenclature */
/* @var $dataProvider yii\data\ActiveDataProvider */

$js=<<<JS
$(document).on("click","[data-remote]",function(e) {
    e.preventDefault();
    $("div#nomen_upd_edit .modal-body").load($(this).data('remote'));
});
$('#Assigs').on('hidden.bs.modal', function (e) {
  $("div#nomen_upd_edit .modal-body").html('');
}); 
JS;
$this->registerJs($js);

$this->title = 'Номенклатура';
$this->params['breadcrumbs'][] = ['label' => 'Ед. измерения', 'url' => ['/measure-unit/index']];
//$this->params['breadcrumbs'][] = ['label' => 'Номенклатура', 'url' => ['/nomenclature/index']];
$this->params['breadcrumbs'][] = ['label' => 'Комплекты', 'url' => ['/const-nomen/index-const']];

$nomen = new \app\models\Nomenclature();
?>
<div class="nomenclature-index">

<div class="modal fade right" id="adsModal">
    <div class="modal-dialog modal-md">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
          <h4 class="modal-title">Добавление номенклатуры</h4>
        </div>
        <div class="modal-body">
            <?= $this->render('/nomenclature/_form_mod',['model' => $nomen]); ?>
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
        <!--?= Html::a('Create Nomenclature', ['create'], ['class' => 'btn btn-success']) ?-->
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'formatter' => ['class' => 'yii\i18n\Formatter','nullDisplay' => ''],
        'options' => [ 'style' => 'table-layout:fixed;' ],
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            [
                'attribute' => 'CodeName',
                'options' => ['style' => 'width: 5%'],
            ],
//            'CodeName',
//            'code',
//            'name',
            [
                'attribute' => 'KindName',
                'options' => ['style' => 'width: 20%'],
            ],
            [
                'attribute' => 'name',
                'options' => ['style' => 'width: 60%'],
            ],
            /*            [
                            'attribute' => 'price',
                            'options' => ['style' => 'width: 5%'],
                        ],
            //            'price',
          //            'NomengrName',
            //            'nomen_gr',
            /*            [
                            'attribute' => 'gost',
                            'options' => ['style' => 'width: 5%'],
                        ],
            //            'gost',
                        [
                            'attribute' => 'sertif',
                            'options' => ['style' => 'width: 5%'],
                        ],*/
            [
                'attribute' => 'MeasName',
                'options' => ['style' => 'width: 5%'],
            ],
//            'MeasName',
            [
                'attribute' => 'GenderName',
                'options' => ['style' => 'width: 5%'],
            ],
//            'GenderName',

            ['class' => 'yii\grid\ActionColumn',
                'options' => ['style' => 'width: 10%'],
                'buttons' => [
                'upd'=>function($url,$model){
                    $url=Yii::$app->getUrlManager()->createAbsoluteUrl(['/nomenclature/updatemod','id'=>$model->id]);
                    return Html::a('<span class="glyphicon glyphicon-pencil"></span>', '#nomen_upd_edit', [
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

<!--Корректировка номенклатуры------------------------------------------------------>
    <?php
    Modal::begin([
        'options' => [
            'id' => 'nomen_upd_edit'
            ],
        'header' => '<h3>Корректировка номенклатуры</h3>',
        ]);
    Modal::end();
    ?>

</div>
