<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Stopertype */

$this->title = 'Create Stopertype';
$this->params['breadcrumbs'][] = ['label' => 'Stopertypes', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="stopertype-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
