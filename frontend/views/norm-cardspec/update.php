<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\NormCardspec */

$this->title = 'Update Norm Cardspec: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Norm Cardspecs', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="norm-cardspec-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
