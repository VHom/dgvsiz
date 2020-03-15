<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\FilterStrem */

$this->title = 'Update Filter Strem: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Filter Strems', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="filter-strem-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
