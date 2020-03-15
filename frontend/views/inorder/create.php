<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Inorder */

$this->title = 'Create Inorder';
$this->params['breadcrumbs'][] = ['label' => 'Inorders', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="inorder-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
