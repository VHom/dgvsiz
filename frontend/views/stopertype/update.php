<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Stopertype */

$this->title = 'Update Stopertype: ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Stopertypes', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="stopertype-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
