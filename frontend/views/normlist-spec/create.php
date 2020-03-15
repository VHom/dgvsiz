<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\NormlistSpec */

$this->title = 'Create Normlist Spec';
$this->params['breadcrumbs'][] = ['label' => 'Normlist Specs', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="normlist-spec-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
