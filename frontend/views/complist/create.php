<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Complist */

$this->title = 'Create Complist';
$this->params['breadcrumbs'][] = ['label' => 'Complists', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="complist-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
