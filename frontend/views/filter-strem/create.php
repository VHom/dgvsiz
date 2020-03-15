<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\FilterStrem */

$this->title = 'Create Filter Strem';
$this->params['breadcrumbs'][] = ['label' => 'Filter Strems', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="filter-strem-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
