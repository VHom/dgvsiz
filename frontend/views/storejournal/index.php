<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\search\Storejournal */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Журнал складских операций';
$this->params['breadcrumbs'][] = ['label' => 'Остатки на складе', 'url' => ['/storemain/index']];

?>
<div class="storejournal-index">

    <h3><?= Html::encode($this->title) ?></h3>

    <p>
        <!--?= Html::a('Create Storejournal', ['create'], ['class' => 'btn btn-success']) ?-->
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
//        'filterModel' => $searchModel,
        'options' => [ 'style' => 'table-layout:fixed;' ],
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

/*            [
                'attribute' => 'CompName',
                'options' =>['style => width:30%']
            ],*/
            [
                'attribute' => 'StoreName',
                'options' =>['style => width:15%']
            ],
            [
                'attribute' => 'NomenName',
                'options' =>['style => width:45%']
            ],
            [
                'attribute' => 'StoperName',
                'options' =>['style => width:10%']
            ],
            [
                'attribute' => 'StoreOper',
                'options' =>['style => width:10%']
            ],
            [
                'attribute' => 'quant',
                'options' =>['style => width:5%']
            ],
            [
                'attribute' => 'oper_date',
                'format' => ['date', 'php:d.m.Y'],
                'options' => ['style => width:10%']
            ],
/*            [
                'attribute' => 'oper_date',
                'options' =>['style => width:10%']
            ],*/

//            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>


</div>
