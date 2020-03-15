<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\InorderSpec */

$this->title = 'Update Inorder Spec: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Inorder Specs', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="inorder-spec-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
