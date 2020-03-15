<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\DraftSpec */

$this->title = 'Create Draft Spec';
$this->params['breadcrumbs'][] = ['label' => 'Draft Specs', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="draft-spec-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
