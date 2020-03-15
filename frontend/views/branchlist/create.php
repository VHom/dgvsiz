<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Branchlist */

$this->title = 'Create Branchlist';
$this->params['breadcrumbs'][] = ['label' => 'Branchlists', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="branchlist-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
