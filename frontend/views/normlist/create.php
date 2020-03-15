<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Normlist */

$this->title = 'Create Normlist';
$this->params['breadcrumbs'][] = ['label' => 'Normlists', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="normlist-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
