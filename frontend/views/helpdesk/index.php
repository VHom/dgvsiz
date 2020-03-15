<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\search\Helpdesk */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Техническая поддержка';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="helpdesk-index">

    <h3><?= Html::encode($this->title) ?></h3>

    <p>
        <?= Html::a('Добавить сообщение', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            [
                'attribute' => 'date',
                'format' =>  ['date', 'dd.MM.Y'],
                'options' => ['width' => '100'],
                'filter' => false
            ],

            'AuthorName',
            'content',
/*            [
                'attribute' => 'status',
                'filter' => $stat_filter,
            ],*/
            'helpdesksCount',
            'currentAuthor',
            ['class' => 'yii\grid\ActionColumn',
              'template' => '{view}'
            ],
        ],
    ]); ?>


</div>
