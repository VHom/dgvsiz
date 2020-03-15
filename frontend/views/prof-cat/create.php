<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\ProfCat */

$this->title = 'Create Prof Cat';
$this->params['breadcrumbs'][] = ['label' => 'Prof Cats', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="prof-cat-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
