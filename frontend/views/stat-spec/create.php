<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\StatSpec */

$this->title = 'Create Stat Spec';
$this->params['breadcrumbs'][] = ['label' => 'Stat Specs', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="stat-spec-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
