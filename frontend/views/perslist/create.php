<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Perslist */

$this->title = 'Create Perslist';
$this->params['breadcrumbs'][] = ['label' => 'Perslists', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="perslist-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
