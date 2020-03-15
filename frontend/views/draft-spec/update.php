<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\DraftSpec */

$this->title = 'Update Draft Spec: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Draft Specs', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="draft-spec-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
