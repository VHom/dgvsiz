<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Userlist */

$this->title = 'Create Userlist';
$this->params['breadcrumbs'][] = ['label' => 'Userlists', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="userlist-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
