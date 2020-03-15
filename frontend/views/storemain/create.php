<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Storemain */

$this->title = 'Create Storemain';
$this->params['breadcrumbs'][] = ['label' => 'Storemains', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="storemain-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
