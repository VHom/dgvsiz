<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\ConstNomen */

$this->title = 'Update Const Nomen: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Const Nomens', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="const-nomen-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
