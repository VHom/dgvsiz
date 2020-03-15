<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Perslist */

$this->title = 'Update Perslist: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Perslists', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="perslist-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
