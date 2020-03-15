<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Arealist */

$this->title = 'Create Arealist';
$this->params['breadcrumbs'][] = ['label' => 'Arealists', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="arealist-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
