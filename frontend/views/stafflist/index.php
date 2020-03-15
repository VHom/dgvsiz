<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\search\Stafflist */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Список должностей';
//$this->params['breadcrumbs'][] = $this->title;
$model = new app\models\Stafflist();
?>
<div class="modal fade right" id="adsModal">
    <div class="modal-dialog modal-md">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
          <h4 class="modal-title">Добавление должности</h4>
        </div>
        <div class="modal-body">
            <?= $this->render('/stafflist/_form_mod',['model' => $model]); ?>
        </div>
        <div class="modal-footer">
          <a href="http://bootstrap-3.ru/forum/" target="_blank" class="btn btn-primary">Записать</a>
          <a href="#" data-dismiss="modal" class="btn">Отменить</a>
        </div>
      </div>
    </div>
</div>
 

    <h3><?= Html::encode($this->title) ?></h3>

    <p>
        <button type="button" onclick="$('#adsModal').modal('show');" >Добавить</button>
        <!--?= Html::a('Добавить пользователя', ['/userlist/create'], ['class' => 'btn btn-default']) ?-->
    </p>



    <!--h1><!--?= Html::encode($this->title) ?></h1>

    <p>
        <!--?= Html::a('Добавить', ['create'], ['class' => 'btn btn-defoult']) ?>
    </p-->

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

//            'id',
//            'branch_id',
            'BranchName',
//            'comp_id',
            'CompName',
//            'area_id',
            'AreaName',
//            'prof_id',
            'ProfName',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>


</div>
