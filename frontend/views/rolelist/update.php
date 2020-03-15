<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Rolelist */

$this->title = 'Update Rolelist: ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Rolelists', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="rolelist-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
