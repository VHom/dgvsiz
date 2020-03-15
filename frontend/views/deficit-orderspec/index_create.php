<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\search\DeficitOrderspec */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Deficit Orderspecs';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="deficit-orderspec-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Deficit Orderspec', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php $form = ActiveForm::begin(['action'=>['index_create','id_check'=>$id], 'method'=>"post"]);  ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

//            'id',
//            'statement_id',
            'nomen_name',
            'quant',
            'status',
            //'type',
            //'prim',
            //'oper_id',
            //'oper_date',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>


</div>
