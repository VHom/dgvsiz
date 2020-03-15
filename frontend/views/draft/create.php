<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Draft */

$this->title = 'Create Draft';
$this->params['breadcrumbs'][] = ['label' => 'Drafts', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="draft-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
