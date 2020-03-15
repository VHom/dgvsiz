<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Nomengroup */

$this->title = 'Create Nomengroup';
$this->params['breadcrumbs'][] = ['label' => 'Nomengroups', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="nomengroup-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
