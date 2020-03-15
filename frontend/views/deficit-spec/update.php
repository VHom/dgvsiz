<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\DeficitSpec */

$this->title = 'Update Deficit Spec: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Deficit Specs', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="deficit-spec-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
