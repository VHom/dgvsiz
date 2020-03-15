<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use kartik\select2\Select2;

/* @var $this yii\web\View */
/* @var $model app\models\Userlist */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="userlist-form">

    <?php $form = ActiveForm::begin(); ?>
    
    <div class="col-md-7">
        <?= $form->field($model,'pers_id')
            ->widget(Select2::classname(),[
                'data' => ArrayHelper::map(app\models\Perslist::find()->orderBy('abbr_name')->all(),
                        'id','abbr_name'),
                'disabled' => false, //$model->partner_id?false:true,
                'name' => 'pers_id',
                'options' => ['placeholder' => 'Выберите сотрудника'],
                    'pluginOptions' => [
                        'allowClear' => true
                    ],                
/*                'addon' => [
                    'prepend' => [
                        'content' => Html::a(\yii\bootstrap\Html::icon('plus'),
//                            ['#'],
                            ['/nomenclature/updatemod','id' => $model->id], 
                                ['data-toggle' => 'modal',
                                'data-target' => '#nomen_add', // 'select2-inorderspec-nomen_id-container', //  '#nomen_add',
                            ])
                    ],
                ],*/
                
        ]) ?>
    </div>

        <!--div class="col-md-4"-->
            <!--?= $form->field($model, 'family_name')->textInput(['maxlength' => true]) ?>
        </div-->
        <!--div class="col-md-4"-->
            <!--?= $form->field($model, 'first_name')->textInput(['maxlength' => true]) ?>
        </div>
        <div class="col-md-4"-->
            <!--?= $form->field($model, 'second_name')->textInput(['maxlength' => true]) ?>
        </div-->
        <!--div class="col-md-6"-->
             <!--?= $form->field($model, 'staff_id')->
                dropDownList(ArrayHelper::map(\app\models\search\Stafflist::find()->all(),'id', 'AreaName'),
                ['prompt'=>'']) 
            ?>
        </div-->
            <!--?= $form->field($model, 'staff_id')->textInput() ?-->
        <!--div class="col-md-6"-->
             <!--?= $form->field($model, 'prof_id')->
                dropDownList(ArrayHelper::map(\app\models\search\Proflist::find()->all(),'id', 'name'),
                ['prompt'=>'']) 
            ?>
        </div-->
        <div class="col-md-5">
             <?= $form->field($model, 'role_id')->
                dropDownList(ArrayHelper::map(\app\models\Rolelist::find()->all(),'id', 'name'),
                ['prompt'=>'']) 
            ?>
            <!--?= $form->field($model, 'role_id')->textInput() ?-->
        </div>
        <div class="col-md-4">
            <?= $form->field($model, 'login')->textInput(['maxlength' => true]) ?>
        </div>
        <div class="col-md-4">
            <?= $form->field($model, 'pass1')->passwordInput(['maxlength' => true]) ?>
        </div>
        <div class="col-md-4">
            <?= $form->field($model, 'pass2')->passwordInput(['maxlength' => true]) ?>
        </div>
        <!--div class="col-md-3"-->
            <!--?= $form->field($model, 'gender')->DropDownList([
                '0' => '',
                '1' => 'Мужской',
                '2' => 'Женский',
            ]) ?>
        </div-->
        <!--div class="col-md-6"-->
            <!--?= $form->field($model, 'actual')->dropDownList([0 => 'Действителен', 1 => 'Заблокирован'],
                ['prompt'=>'Действителен']) ?-->
            <!--?= $form->field($model, 'actual')->textInput() ?-->
        <!--/div-->
    <!--?= $form->field($model, 'rename')->textInput() ?-->

    <div class="form-group">
        <?= Html::submitButton('Записать', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-warning']) ?>
        <a href="#" data-dismiss="modal" class="btn btn-default">Отменить</a>
    </div>

    <?php ActiveForm::end(); ?>

</div>
