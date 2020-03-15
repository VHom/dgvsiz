<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Nomengroup */

$this->title = 'Update Nomengroup: ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Nomengroups', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="nomengroup-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
