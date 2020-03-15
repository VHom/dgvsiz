<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\InorderSpec */

$this->title = 'Create Inorder Spec';
$this->params['breadcrumbs'][] = ['label' => 'Inorder Specs', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="inorder-spec-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
