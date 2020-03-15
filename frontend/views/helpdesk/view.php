<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $model app\models\Helpdesk */

$this->title = 'Запрос № '.$model->id;
$this->params['breadcrumbs'][] = ['label' => 'Сообщения в техподдержку', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="helpdesk-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <div class="col-lg-4">

        <?php
        if (!$model->helpdesks && !$model->state)
        {
            ?>
            <div class="pull-left">
                <p>
                    <?= Html::a('Исправить', ['#'], [
                        'title' => 'Исправить сообщение в техподдержку',
                        'data-toggle' => 'modal',
                        'data-target' => '#helpdesk_modal',
                        'data-backdrop'=>false,
                        'data-remote'=>Yii::$app->getUrlManager()->createAbsoluteUrl(['/helpdesk/update','id'=>$model->id]),
                        'class' => 'btn btn-success'
                    ]);?>
                    <?= Html::a('Аннулировать', ['cancel', 'id' => $model->id], ['class' => 'btn btn-danger']);?>
                </p>
            </div>
            <?php
        }
        ?>
        <div class="pull-right">
            <p>
                <?php
                if ($model->state != 1 && $model->state != 4)
                    echo Html::a('Закрыть запрос', ['close', 'id' => $model->id], ['class' => 'btn btn-primary']);
                ?>
            </p>
        </div>
        <?= DetailView::widget([
            'model' => $model,
            'attributes' => [
                'id',
                //'help_id',
                [
                    'attribute' => 'date',
                    'format' =>  ['date', 'dd.MM.Y H:m:ss'],
                ],
                //'date',
                'author',
                'content',
                'status',
                [
                    'attribute' => 'state_date',
                    'format' =>  ['date', 'dd.MM.Y H:m:ss'],
                ],
                /*'state_date',
                'sort_field',
                'help_number',*/
            ],
        ]) ?>
    </div>
    <div class="col-lg-8">
        <h3>Связанные сообщения</h3>
        <div class="pull-right">
            <p>
                <?php
                if ($model->state != 5 && $model->state != 1)
                    echo Html::a('Добавить связанное сообщение', ['#'], [
                        'title' => 'Отправить сообщение в техподдержку',
                        'data-toggle' => 'modal',
                        'data-target' => '#helpdesk_modal',
                        'data-backdrop'=>false,
                        'data-remote'=>Yii::$app->getUrlManager()->createAbsoluteUrl(['/helpdesk/create-dep','id'=>$model->id]),
                        'class' => 'btn btn-primary'
                    ]);
                ?>
            </p>
        </div>
        <?= GridView::widget([
            'dataProvider' => $dataProvider,
            //'filterModel' => $searchModel,
            'columns' => [
                ['class' => 'yii\grid\SerialColumn'],
                [
                    'attribute' => 'date',
                    'format' =>  ['date', 'dd.MM.Y'],
                    'options' => ['width' => '100'],
                    'filter' => false
                ],
                'author',
                'content',
                /*[
                    'attribute' => 'status',
                    'filter' => app\models\Helpdesk::getStatuses()
                ],

                ['class' => 'yii\grid\ActionColumn'],*/
            ],
        ]); ?>
    </div>

</div>
