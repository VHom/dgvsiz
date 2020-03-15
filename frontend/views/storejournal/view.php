<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Storejournal */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Storejournals', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="storejournal-view">

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
            'comp_id',
            'store_id',
            'nomen_id',
            'stoper_id',
            'stoper_type',
            'inordspec_id',
            'invoicespec_id',
            'drafspec_id',
            'quant(11)',
            'oper_id',
            'oper_date',
        ],
    ]) ?>

</div>
