<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\ConstNomen */

$this->title = 'Create Const Nomen';
$this->params['breadcrumbs'][] = ['label' => 'Const Nomens', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="const-nomen-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
