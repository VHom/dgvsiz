<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Stafflist */

$this->title = 'Create Stafflist';
$this->params['breadcrumbs'][] = ['label' => 'Stafflists', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="stafflist-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
