<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\search\StatSpec */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Обеспечение сотрудников подразделения СИЗ и ФО';
//$this->params['breadcrumbs'][] = $this->title;
?>
<div class="stat-spec-index">

    <h3><?= Html::encode($this->title) ?></h3>

    <p>
        <?= Html::a('Сформировать заявку', ['create-stat','stat_id'=>$stat_id], 
                ['class' => 'btn btn-default']) ?>
    </p>

    <?php //throw new \yii\web\NotFoundHttpException('qq - '.$stat_id); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
//        'filterModel' => $searchModel,
        'options' => [ 'style' => 'table-layout:fixed;' ],
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            [
                'class' => 'yii\grid\CheckboxColumn',
                'checkboxOptions' => function ($model, $key, $index, $column) {
                    return ['value' => $model->sign_choice];
                }
            ],            
            
            [
                'attribute' => 'PersName',
                'options' => ['style' => 'width: 15%']
            ],
            
            [
                'attribute' => 'NomenTypeName',
                'options' => ['style' => 'width: 5%'],
            ],
            [
                'attribute' => 'NomenName',
                'options' => ['style' => 'width: 30%'],
            ],
            [
                'attribute' => 'quant',
                'options' => ['style' => 'width: 3%'],
            ],
            [
                'attribute' => 'RemainName',
                'options' => ['style' => 'width: 35%'],
            ],
            [
                'attribute' => 'FactQuant',// 'quant_fact',
                'options' => ['style' => 'width: 3%'],
            ],
            [
                'attribute' => 'NomenMeasName',
                'options' => ['style' => 'width: 7%'],
            ],
            [
                'attribute' => 'date_end',
                'format' => ['date', 'php:d.m.Y'],
                'options' => ['style => width:5%']
            ],
/*            [
                'attribute' => 'DeficitQuant',
                'options' => ['style' => 'width: 7%'],
            ], 
            [
                'attribute' => 'RemainQuant',
                'options' => ['style' => 'width: 5%'],
            ], */
//            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>


</div>
