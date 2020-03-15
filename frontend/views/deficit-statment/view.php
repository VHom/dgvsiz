<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\DeficitStatment */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Deficit Statments', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="deficit-statment-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id, 'oper_date' => $model->oper_date], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id, 'oper_date' => $model->oper_date], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'sign_choice',
            'staff_id',
            'nomen_type',
            'amort',
            'date_end',
            'quant',
            'meas_id',
            'date_report',
            'oper_date',
            'oper_user',
            'nomen_id',
            'pers_id',
            'prof_id',
        ],
    ]) ?>

</div>
