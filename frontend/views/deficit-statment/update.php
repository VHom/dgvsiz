<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\DeficitStatment */

$this->title = 'Update Deficit Statment: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Deficit Statments', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id, 'oper_date' => $model->oper_date]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="deficit-statment-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
