<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Branchlist */

$this->title = 'Update Branchlist: ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Branchlists', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="branchlist-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
