<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Operjournal */

$this->title = 'Update Operjournal: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Operjournals', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="operjournal-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
