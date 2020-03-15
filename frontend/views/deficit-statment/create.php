<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\DeficitStatment */

$this->title = 'Create Deficit Statment';
$this->params['breadcrumbs'][] = ['label' => 'Deficit Statments', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="deficit-statment-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
