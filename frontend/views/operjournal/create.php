<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Operjournal */

$this->title = 'Create Operjournal';
$this->params['breadcrumbs'][] = ['label' => 'Operjournals', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="operjournal-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
