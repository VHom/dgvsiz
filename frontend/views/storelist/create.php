<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Storelist */

$this->title = 'Create Storelist';
$this->params['breadcrumbs'][] = ['label' => 'Storelists', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="storelist-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
