<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\search\Operjournal */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Журнал операций';
//$this->params['breadcrumbs'][] = $this->title;
?>
<div class="operjournal-index">

    <h3><?= Html::encode($this->title) ?></h3>

    <p>
        <!--?= Html::a('Create Operjournal', ['create'], ['class' => 'btn btn-success']) ?-->
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
//        'filterModel' => $searchModel,
        'options' => [ 'style' => 'table-layout:fixed;' ],
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            [
                'attribute' => 'ModelName',
                'options' =>['style => width:65%']
            ],
//            'ModelName',
//            'oper_name',
            [
                'attribute' => 'oper_name',
                'options' =>['style => width:20%']
            ],
//            'oper_date',
            [
                'attribute' => 'oper_date',
                'format' => ['date', 'php:d.m.Y'],
                'options' => ['style => width:10%']
            ],
//            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>


</div>
