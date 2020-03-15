<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\search\ConstNomen */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Комплект номенклатуры';
$this->params['breadcrumbs'][] = ['label' => 'Ед. измерения', 'url' => ['/measure-unit/index']];
$this->params['breadcrumbs'][] = ['label' => 'Номенклатура', 'url' => ['/nomenclature/index']];
//$this->params['breadcrumbs'][] = ['label' => 'Состав комплекта', 'url' => ['/const-nomen/index']];
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
            'CodeName',
            [
                'attribute' => 'name',
                'options' => ['style' => 'width: 85%'],
            ],
            'MeasName',
            ['class' => 'yii\grid\ActionColumn',
            'buttons' => [
                'spec' => function ($url, $model) { //download-alt
                    $customurl=Yii::$app->getUrlManager()->createUrl(['/const-nomen/index','id'=>$model->id]); //$model->id для AR
                    return \yii\helpers\Html::a( '<span class="glyphicon glyphicon-th-list"></span>', $customurl,
                        ['title' => Yii::t('yii', 'Состав комплекта'), 'data-pjax' => '0']); //,
                },
            ],
                'template' =>'{spec}',
            ],
        ],
    ]); ?>
    </div>

</div>
