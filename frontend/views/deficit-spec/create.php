<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\DeficitSpec */

$this->title = 'Create Deficit Spec';
$this->params['breadcrumbs'][] = ['label' => 'Deficit Specs', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="deficit-spec-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
