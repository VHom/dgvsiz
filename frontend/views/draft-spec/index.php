<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\bootstrap\Modal;

/* @var $this yii\web\View */
/* @var $searchModel app\models\search\DraftSpec */
/* @var $dataProvider yii\data\ActiveDataProvider */
$js=<<<JS
$(document).on("click","[data-remote]",function(e) {
    e.preventDefault();
    $("div#draft_upd_edit .modal-body").load($(this).data('remote'));
});
$('#Assigs').on('hidden.bs.modal', function (e) {
  $("div#draft_upd_edit .modal-body").html('');
}); 
JS;
$this->registerJs($js);

$this->params['breadcrumbs'][] = ['label' => 'Внутрихозяйственные операции', 'url' => ['/draft/index']];

$model = new app\models\DraftSpec();
$draft = app\models\Draft::findOne($id) ;
echo  '<div style="font-size:1.8em;">Спецификация накладной на внутрискладские операции.<br/> Склад источник: 
            <span style="font-size:1.0em;color:blue;">'.$draft->OutStoreName.'</span> - Склад приемник: <span style="font-size:1.0em;color:blue;">'.$draft->InStoreName.'</span></div>'
            //"> '<div style="font-size:2.0em;">".Склад приемник: "</div>"'.$draft->InStoreName;
?>

<div class="draft-spec-index">

    <div class="modal fade right" id="adsModal">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
          <h4 class="modal-title">Добавление спецификации</h4>
        </div>
        <div class="modal-body">
            <?= $this->render('/draft-spec/_form_mod',['model' => $model, 'id' => $id]); ?>
        </div>
        <div class="modal-footer">
          <!--a href="http://bootstrap-3.ru/forum/" target="_blank" class="btn btn-primary">Записать</a>
          <a href="#" data-dismiss="modal" class="btn">Отменить</a-->

        </div>
      </div>
    </div>
</div>
 

    <!--h3>Html::encode($this->title)</h3-->

    <p>
        <button type="button" onclick="$('#adsModal').modal('show');" >Добавить</button>
        <!--?= Html::a('Добавить спецификацию', ['create'], ['class' => 'btn btn-default']) ?-->
    </p>

    <?php //throw new \yii\web\NotFoundHttpException('qq2'); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
/*            [
                'attribute' => 'OutStoreName',
                'options' => ['style' => 'width: 25%'],
            ],
            [
                'attribute' => 'InStoreName',
                'options' => ['style' => 'width: 25%'],
            ],*/
            [
                'attribute' => 'NomenName',
                'options' => ['style' => 'width: 850%'],
            ],
            [
                'attribute' => 'quant',
                'options' => ['style' => 'width: 5%'],
            ],
            [
                'attribute' => 'amout',
                'options' => ['style' => 'width: 5%'],
            ],

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
<!--Корректировка  спецификации накладной------------------------------------------------------>
    <?php
    Modal::begin([
        'options' => [
            'id' => 'inspec_upd_edit'
            ],
        'header' => '<h4>Корректировка спецификации накладной</h4>',
        ]);
    Modal::end();
    ?>

</div>
