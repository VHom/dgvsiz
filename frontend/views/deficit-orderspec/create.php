<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\DeficitOrderspec */

$this->title = 'Create Deficit Orderspec';
$this->params['breadcrumbs'][] = ['label' => 'Deficit Orderspecs', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="deficit-orderspec-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
