<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\ProfCat */

$this->title = 'Update Prof Cat: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Prof Cats', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="prof-cat-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
