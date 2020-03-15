<?php

use yii\helpers\Html;
use yii\web\NotFoundHttpException;

/* @var $this yii\web\View */
/* @var $model app\models\Nomenclature */

$this->title = 'Create Nomenclature';
$this->params['breadcrumbs'][] = ['label' => 'Nomenclatures', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

$model = new \app\models\Nomenclature();
//throw new NotFoundHttpException('qq1');
?>
<div class="nomenclature-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
