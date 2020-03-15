<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\search\ConstNomen */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Комплект номенклатуры';
$this->params['breadcrumbs'][] = ['label' => 'Ед. измерения', 'url' => ['/measure-unit/index']];
$this->params['breadcrumbs'][] = ['label' => 'Номенклатура', 'url' => ['/nomenclature/index']];
$this->params['breadcrumbs'][] = ['label' => 'Состав комплекта', 'url' => ['/const-nomen/index']];
//$model = $nomen;
$nomen = new \app\models\ConstNomen();
$this->title = 'Комплекты';
?>
<h3><?= Html::encode($this->title) ?></h3>
    <div class="col-md-10">
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
//        'filterModel' => $searchModel,
        'options' => [ 'style' => 'table-layout:fixed;' ],
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
//            'NomenName',
            [
                'attribute' => 'ComplectName',
                'options' => ['style' => 'width: 85%'],
            ],
//            'MeasName',
            ['class' => 'yii\grid\ActionColumn',
                'buttons' => [
                    'upd'=>function($url,$model){
                        $url=Yii::$app->getUrlManager()->createAbsoluteUrl(['/const-nomen/updatemod','id'=>$model->id]);
                        return Html::a('<span class="glyphicon glyphicon-arrow-up"></span>', '#const_upd_edit', [
                            'title' => 'Выдать',
                            'data-toggle'=>'modal',
                            'data-backdrop'=>false,
                            'data-remote'=>$url
                        ]);
                    },
/*                    'delete' => function ($url, $model, $key) {
                        return Html::a('<span class="glyphicon glyphicon-trash"></span>', $url, [
                            'data-method' => 'post',
                            'data-pjax' => 0,
                            'data-confirm' => 'Вы уверены?'
                        ]);
                    },*/
                ]           ,
                'template' =>'{upd}',
            ],
        ],
    ]); ?>
    </div>

</div>
