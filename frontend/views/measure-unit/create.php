<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\MeasureUnit */

$this->title = 'Create Measure Unit';
$this->params['breadcrumbs'][] = ['label' => 'Measure Units', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="measure-unit-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
