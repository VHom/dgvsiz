<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Perslist */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Perslists', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="perslist-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id], [
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
            'tabnum',
            'abbr_name',
            'family_name',
            'first_name',
            'second_name',
            'gender',
            'sec_empl',
            'start_date',
            'end_date',
            'decret_start',
            'decret_end',
            'staff_id',
            'size_id',
        ],
    ]) ?>

</div>
