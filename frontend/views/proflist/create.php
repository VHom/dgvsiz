<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Proflist */

$this->title = 'Create Proflist';
$this->params['breadcrumbs'][] = ['label' => 'Proflists', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="proflist-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
