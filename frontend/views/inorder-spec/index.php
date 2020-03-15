<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\bootstrap\Modal;
use yii\web\NotFoundHttpException;

/* @var $this yii\web\View */
/* @var $searchModel app\models\search\InorderSpec */
/* @var $dataProvider yii\data\ActiveDataProvider */

$js=<<<JS
$(document).on("click","[data-remote]",function(e) {
    e.preventDefault();
    $("div#inspec_upd_edit .modal-body").load($(this).data('remote'));
});
$('#Assigs').on('hidden.bs.modal', function (e) {
  $("div#inspec_upd_edit .modal-body").html('');
}); 
JS;
$this->registerJs($js);

$this->title = 'Спецификация приходного ордера';
$model = new \app\models\InorderSpec();

?>
<div class="inorder-spec-index">

<div class="modal fade right" id="adsModal">
    <div class="modal-dialog modal-md">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
          <h4 class="modal-title">Добавление спецификации</h4>
        </div>
        <div class="modal-body">
            <?= $this->render('/inorder-spec/_form_mod',['model' => $model, 'id' => $id]); ?>
        </div>
        <div class="modal-footer">
          <!--a href="http://bootstrap-3.ru/forum/" target="_blank" class="btn btn-primary">Записать</a>
          <a href="#" data-dismiss="modal" class="btn">Отменить</a-->

        </div>
      </div>
    </div>
</div>
 
    <h3><?= Html::encode($this->title) ?></h3>
<?php
    $this->params['breadcrumbs'][] = ['label' => 'Приход на склад', 'url' => ['/inorder/index']];
?>

    <p>
        <button type="button" class="btn btn-success" onclick="$('#adsModal').modal('show');" >Добавить</button>
        <!--?= Html::a('Create Inorder Spec', ['create'], ['class' => 'btn btn-success']) ?-->
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
//        'filterModel' => $searchModel,
        'options' => [ 'style' => 'table-layout:fixed;' ],
        'formatter' => ['class' => 'yii\i18n\Formatter','nullDisplay' => ''],
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'NomenName',
            'StoreName',
            'quant',
            'IsSiz',
            'SizeVal',
            'HeightVal',
            'FullVal',
            'ShirtVal',
            'ShoesVal',
            'GloveVal',
            'HeadVal',

            ['class' => 'yii\grid\ActionColumn', 
            'buttons' => [
                'upd'=>function($url,$model){
                    $url=Yii::$app->getUrlManager()->createAbsoluteUrl(['/inorder-spec/updatemod','id'=>$model->id]);
                    return Html::a('<span class="glyphicon glyphicon-pencil"></span>', '#inspec_upd_edit', [
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

</div>
