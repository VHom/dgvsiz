<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \frontend\models\ResetPasswordForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$model = app\models\Userlist::findOne($id);
?>
<div class="userlist-change-stat">

    <div class="row">
        <div class="col-lg-12">
            <?php $form = ActiveForm::begin([
                'action' => Yii::$app->urlManager->createUrl(['/userlist/change-stat','id'=>$id]),
                'options' => ['method' => 'post']
                ]); ?>

            <div class="col-md-12">
                <!--?= $form->field($model, 'actual')->passwordInput(['autofocus' => true]) ?-->
                <?= $form->field($model,'actual')->DropDownList([
                    '0' => 'Актуален', 
                    '1' => 'Заблокирован',
                    ]) ?>
                
            </div>
            <div class="form-group">
                <?= Html::submitButton('Записать', ['class' => 'btn btn-warning']) ?>
                <a href="#" data-dismiss="modal" class="btn btn-default">Отменить</a>
            </div>

            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>
