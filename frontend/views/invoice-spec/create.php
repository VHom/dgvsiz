<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\InvoiceSpec */

$this->title = 'Create Invoice Spec';
$this->params['breadcrumbs'][] = ['label' => 'Invoice Specs', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="invoice-spec-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
