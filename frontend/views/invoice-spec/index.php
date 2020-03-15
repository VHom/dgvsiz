<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\bootstrap\Modal;

/* @var $this yii\web\View */
/* @var $searchModel app\models\search\InvoiceSpec */
/* @var $dataProvider yii\data\ActiveDataProvider */

$js=<<<JS
$(document).on("click","[data-remote]",function(e) {
    e.preventDefault();
    $("div#invspec_upd_edit .modal-body").load($(this).data('remote'));
});
$('#Assigs').on('hidden.bs.modal', function (e) {
  $("div#invspec_upd_edit .modal-body").html('');
}); 
JS;
$this->registerJs($js);
//throw new \yii\web\NotFoundHttpException('qq '.$id);
$invoice = app\models\Invoice::findOne($id);
if($invoice && $invoice->FullName)
    $this->title = 'Спецификация расходной накладной. Сотрудник '.$invoice->FullName.' - '.$id;
else
    $this->title = 'Спецификация  расходной накладной.';
$this->params['breadcrumbs'][] = ['label' => 'Отпуск сотрудникам', 'url' => ['/invoice/index']];

$model = new \app\models\InvoiceSpec();
?>
<div class="invoice-spec-index">

<div class="modal fade right" id="adsModal">
    <div class="modal-dialog modal-md">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
          <h4 class="modal-title">Добавление спецификации расходной накладной</h4>
        </div>
        <div class="modal-body">
            <?= $this->render('/invoice-spec/_form_mod',['model' => $model, 'id' => $id]); ?>
        </div>
        <div class="modal-footer">
          <!--a href="http://bootstrap-3.ru/forum/" target="_blank" class="btn btn-primary">Записать</a>
          <a href="#" data-dismiss="modal" class="btn">Отменить</a-->

        </div>
      </div>
    </div>
</div>
 
    <h3><?= Html::encode($this->title) ?></h3>
<?php //throw new \yii\web\NotFoundHttpException('dd '.$id); ?>
    <p>
        <!--button type="button" onclick="$('#adsModal').modal('show');" >Добавить</button-->
        <?= Html::a('Заполнение спецификации накладной', ['create-spec', 'id'=>$id], ['class' => 'btn btn-success']) ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
//        'filterModel' => $searchModel,
        'options' => [ 'style' => 'table-layout:fixed;' ],
        'columns' => [
            ['class' => 'yii\grid\SerialColumn',
//             'options' => ['style' => 'width: 5%'],
            ],
            [
                'attribute' => 'StoreName',
                'options' => ['style' => 'width: 15%'],
            ],
            [
                'attribute' => 'TypeNomen',
                'options' => ['style' => 'width: 5%'],
            ],
            [
                'attribute' => 'NomenName',
                'options' => ['style' => 'width: 55%'],
            ],
            [
                'attribute' => 'MeasName',
                'options' => ['style' => 'width: 5%'],
            ],
            [
                'attribute' => 'quant',
                'options' => ['style' => 'width: 5%'],
            ],
            [
                'attribute' => 'Period',
                'options' => ['style' => 'width: 10%'],
            ],
            
/*            'SizeName',
            'HeightName',
            'FullName',
            'ShirtName',
            'ShoesName',
            'HeadName',
            'GloveName',*/

/*            ['class' => 'yii\grid\ActionColumn', 
            'buttons' => [
                'upd'=>function($url,$model){
                    $url=Yii::$app->getUrlManager()->createAbsoluteUrl(['/invoice-spec/updatemod','id'=>$model->id]);
                    return Html::a('<span class="glyphicon glyphicon-pencil"></span>', '#invspec_upd_edit', [
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
            ],*/
        ],
    ]); ?>

<!--Корректировка  спецификации накладной------------------------------------------------------>
    <?php
    Modal::begin([
        'options' => [
            'id' => 'invspec_upd_edit'
            ],
        'header' => '<h4>Корректировка спецификации накладной</h4>',
        ]);
    Modal::end();
    ?>

</div>
