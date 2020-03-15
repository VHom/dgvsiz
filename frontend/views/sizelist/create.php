<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Sizelist */

$this->title = 'Create Sizelist';
$this->params['breadcrumbs'][] = ['label' => 'Sizelists', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="sizelist-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
