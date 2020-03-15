<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\PersAnthrop */

$this->title = 'Create Pers Anthrop';
$this->params['breadcrumbs'][] = ['label' => 'Pers Anthrops', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="pers-anthrop-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
