<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\search\DeficitOrderspec */
/* @var $dataProvider yii\data\ActiveDataProvider */

//$this->params['breadcrumbs'][] = $this->title;
$stat = app\models\DeficitStatment::findOne($id);
//throw new \yii\web\NotFoundHttpException('qq- '.$id.' - '.$stat->StaffName.' - '.$stat->DateReport);
$this->title = 'Спецификация заявки подразделения "'.$stat->StaffName.'" от '.$stat->DateReport.'г.';
$this->params['breadcrumbs'][] = ['label' => 'Дефицитные ведомости подразделения', 'url' => ['/deficit-statment/index']];


?>
<div class="deficit-orderspec-index">

    <h3><?= Html::encode($this->title) ?></h3>

    <p>
        <!--?= Html::a('Create Deficit Orderspec', ['create'], ['class' => 'btn btn-success']) ?-->
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'options' => [ 'style' => 'table-layout:fixed;' ],
        'formatter' => ['class' => 'yii\i18n\Formatter','nullDisplay' => ''],
        
        'columns' => [
//            ['class' => 'yii\grid\SerialColumn'],

//            'id',
//            'statement_id',
            ['class' => 'yii\grid\SerialColumn',
             'options' => ['style' => 'width: 3%'],
            ],
//            'nomen_name',
            [
                'attribute' => 'nomen_name',
                'options' => ['style' => 'width: 60%'],
            ],            
//            'quant',
            [
                'attribute' => 'quant',
                'options' => ['style' => 'width: 7%'],
            ],            
            
//            'status',
            //'type',
            [
                'attribute' => 'prim',
                'options' => ['style' => 'width: 25%'],
            ],            

            //'prim',
            //'oper_id',
            //'oper_date',
/*
            ['class' => 'yii\grid\ActionColumn',
                'template' =>'{update} {delete}',
            ],*/
        ],
    ]); ?>


</div>
