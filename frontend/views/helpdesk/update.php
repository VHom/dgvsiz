<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Helpdesk */

$this->title = 'Update Helpdesk: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Helpdesks', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="helpdesk-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
