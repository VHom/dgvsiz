<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Doctypelist */

$this->title = 'Update Doctypelist: ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Doctypelists', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="doctypelist-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
