<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\bootstrap\Modal;

/* @var $this yii\web\View */
/* @var $searchModel app\models\search\Nomenkind */
/* @var $dataProvider yii\data\ActiveDataProvider */

$js=<<<JS
$(document).on("click","[data-remote]",function(e) {
    e.preventDefault();
    $("div#kind_upd_edit .modal-body").load($(this).data('remote'));
});
$('#Assigs').on('hidden.bs.modal', function (e) {
  $("div#kind_upd_edit .modal-body").html('');
}); 
JS;
$this->registerJs($js);
$this->params['breadcrumbs'][] = ['label' => 'Нормы по сотрудникам', 'url' => ['/norm-card/index-norm']];
$this->params['breadcrumbs'][] = ['label' => 'Нормы по должностям', 'url' => ['/normlist/index']];
//$this->params['breadcrumbs'][] = ['label' => 'Размерные группы', 'url' => ['/nomenkind/index']];

$model = new \app\models\Nomenkind();;

$this->title = 'Размерные группы';
//$this->params['breadcrumbs'][] = $this->title;
?>
<div class="nomenkind-index">

<div class="modal fade right" id="adsModal">
    <div class="modal-dialog modal-md">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
          <h4 class="modal-title">Добавление размерной группы</h4>
        </div>
        <div class="modal-body">
            <?= $this->render('/nomenkind/_form_mod',['model' => $model]); ?>
        </div>
        <!--div class="modal-footer"-->
          <!--a href="http://bootstrap-3.ru/forum/" target="_blank" class="btn btn-primary">Записать</a>
          <a href="#" data-dismiss="modal" class="btn">Отменить</a>
        </div-->
      </div>
    </div>
</div>
 
    <h3><?= Html::encode($this->title) ?></h3>

    <p>
        <button type="button" class = "btn btn-success" onclick="$('#adsModal').modal('show');" >Добавить</button>
        <!--?= Html::a('Create Nomenkind', ['create'], ['class' => 'btn btn-success']) ?-->
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            
//            'code',
//            'id',
            'name',
//            'is_siz',
            'IsSiz',
//            'size_gr',
            'Size',
//            'height_gr',
            'Height',
//            'full_gr',
            'Full',
//            'shirt_gr',
            'Shirt',
//            'shoes_gr',
            'Shoes',
//            'glove_gr',
            'Glove',
//            'head_gr',
            'Head',
//            'period',

            ['class' => 'yii\grid\ActionColumn', 
            'buttons' => [
                'upd'=>function($url,$model){
                    $url=Yii::$app->getUrlManager()->createAbsoluteUrl(['/nomenkind/updatemod','id'=>$model->id]);
                    return Html::a('<span class="glyphicon glyphicon-pencil"></span>', '#kind_upd_edit', [
                                'title' => 'Изменить',
                                'data-toggle'=>'modal',
                                'data-backdrop'=>false,
                                'data-remote'=>$url
                                ]);
                    },
                'delnorm' => function ($url, $model, $key) {
                        return Html::a('<span class="glyphicon glyphicon-trash"></span>', 
                        $url=Yii::$app->getUrlManager()->createAbsoluteUrl(['/nomenkind/delete-norm','id'=>$model->id]), 
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

<!--Корректировка размерной группы------------------------------------------------------>
    <?php
    Modal::begin([
        'options' => [
            'id' => 'kind_upd_edit'
            ],
        'header' => '<h3>Корректировка размерной группы</h3>',
        ]);
    Modal::end();
    ?>

</div>
