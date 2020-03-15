<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\NormCardspec */

$this->title = 'Create Norm Cardspec';
$this->params['breadcrumbs'][] = ['label' => 'Norm Cardspecs', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="norm-cardspec-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
