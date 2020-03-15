<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \frontend\models\ResetPasswordForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = 'Смена пароля';
//$this->params['breadcrumbs'][] = $this->title;
$model = app\models\User::findOne($id);
$model->newPass1 = '';
$model->newPass2 = '';
?>
<div class="site-reset-password">

    <div class="row">
        <div class="col-lg-12">
            <?php $form = ActiveForm::begin(['id' => 'reset-pswd-form']); ?>

            <div class="col-md-6">
                <?= $form->field($model, 'newPass1')->passwordInput(['autofocus' => true]) ?>
            </div>
            <div class="col-md-6">
                <?= $form->field($model, 'newPass2')->passwordInput(['autofocus' => true]) ?>
            </div>
            <div class="form-group">
                <?= Html::submitButton('Записать', ['class' => 'btn btn-default']) ?>
                <a href="#" data-dismiss="modal" class="btn">Отменить</a>
            </div>

            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>
