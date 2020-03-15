<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Doctypelist */

$this->title = 'Create Doctypelist';
$this->params['breadcrumbs'][] = ['label' => 'Doctypelists', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="doctypelist-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
