<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\search\StatSpec */
/* @var $dataProvider yii\data\ActiveDataProvider */

$model = new app\models\StatSpec();
?>
<div class="modal fade right" id="adsModal">
    <div class="modal-dialog modal-md">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
          <h4 class="modal-title">Выбор подразделения</h4>
        </div>
        <div class="modal-body">
            <?= $this->render('/stat-spec/_form_mod',['model' => $model]); ?>
        </div>
        <!--div class="modal-footer">
          <a href="http://bootstrap-3.ru/forum/" target="_blank" class="btn btn-primary">Записать</a>
          <a href="#" data-dismiss="modal" class="btn">Отменить</a>
        </div-->
      </div>
    </div>
</div>
<?php 
if($stat_id) {
    $stat = \app\models\StatSpec::findOne($stat_id);
    $area = \app\models\Arealist::find()
            ->leftJoin('stafflist','stafflist.area_id=arealist.id')
            ->where('stafflist.id=:staff',[':staff'=>$stat->staff_id])
//            ->leftJoin('stafflist','stafflist.area_id=arealist.id')
//            ->where('stafflist.id=:staff_id',[':staff_id'=>$stat_id])
            ->one();
    $doc_date = \Yii::$app->formatter->asDate($stat->date_report, 'dd.MM.Y');
//    $this->title = 'Обеспечение сотрудников подразделения "'.$area->name.'" СИЗ и ФО на '.$doc_date.'г.';
} else {
    $area = null;
}
//else
//    $this->title = 'Обеспечение сотрудников подразделения СИЗ и ФО';
$this->params['breadcrumbs'][] = ['label' => 'Дефицитные ведомости подразделения', 'url' => ['/deficit-statment/index']];
//$this->params['breadcrumbs'][] = ['label' => 'Обеспеченность сотрудников СИЗ и ФО', 'url' => ['/stat-spec/index-provision']];

?>
<div class="stat-spec-index">
    <?php if($area) { ?>
        <p><font size=5>  Обеспечение СИЗ и ФО сотрудников подразделения "<font color="blue"><?= $area->name ?></font>" на <font color="blue"><?= $doc_date ?></font> г.</font></p>
    <?php } else ?>
        <p><font size=5>  Обеспечение СИЗ и ФО сотрудников подразделения </font></p>
    <p>
        <button type="button" class = "btn btn-info" onclick="$('#adsModal').modal('show');" >Сформировать</button>
        <!--?= Html::a('Добавить пользователя', ['/userlist/create'], ['class' => 'btn btn-default']) ?-->
    </p>

    <?php //throw new \yii\web\NotFoundHttpException('qq - '.$stat_id); ->orderBy['pers_id,nomen_type,nomen_id'],?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
//        'filterModel' => $searchModel,
        'formatter' => ['class' => 'yii\i18n\Formatter','nullDisplay' => ''],
        'options' => [ 'style' => 'table-layout:fixed;' ],
        'rowOptions' => function($model,$key,$index,$grid){
                    if($model->sign_choice == 1)
                        return ['style' => 'background-color:#ffb2b2;']; //['class'=>'test'];
                    else //if ($model->sign_choice == 0)
                        return ['style' => 'background-color:#fff;']; //['class'=>'test'];        
        },
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
/*            [
                'class' => 'yii\grid\CheckboxColumn',
                'checkboxOptions' => function ($model, $key, $index, $column) {
                    return ['value' => $model->sign_choice];
                }
            ],  */          
            
            [
                'attribute' => 'PersName',
                'options' => ['style' => 'width: 10%']
            ],
            
            [
                'attribute' => 'NomenTypeName',
                'options' => ['style' => 'width: 3%'],
            ],
            [
                'attribute' => 'NomenName',
                'options' => ['style' => 'width: 30%'],
            ],
            [
                'attribute' => 'quant',
                'options' => ['style' => 'width: 3%'],
            ],
            [
                'attribute' => 'RemainName',
                'options' => ['style' => 'width: 30%'],
            ],
            [
                'attribute' => 'FactQuant',// 'quant_fact',
                'options' => ['style' => 'width: 3%'],
            ],
/*            [
                'attribute' => 'NomenMeasName',
                'options' => ['style' => 'width: 7%'],
            ],*/
            [
                'attribute' => 'date_out',
//                'format' => ['date', 'php:d.m.Y'],
                'options' => ['style => width:5%']
            ],
            
/*            [
                'attribute' => 'date_end',
                'options' => ['style' => 'width: 7%'],
            ], 
            [
                'attribute' => 'date_report',
                'options' => ['style' => 'width: 7%'],
            ], */
//            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>


</div>
