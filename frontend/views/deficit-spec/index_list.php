<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\search\DeficitSpec */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Спецификация дефицитной ведомости';
//$this->params['breadcrumbs'][] = $this->title;
//$model = new \app\models\DeficitSpec();
?>
<div class="deficit-list">

    <h3><?= Html::encode($this->title) ?></h3>

<?php

    $dataProvider = new yii\data\ActiveDataProvider([
        'query' => \app\models\DeficitBuffer::find()
            ->leftJoin('deficit_spec','deficit_spec.nomen_id=deficit_buffer.nomen_id '
                    . 'and deficit_spec.statement_id=deficit_buffer.statement_id')
            ->where('deficit_spec.id=:id',[':id'=>$id])
    ]);
    echo GridView::widget([
        'dataProvider' => $dataProvider,
        'options' => [
            'style' => 'font-size:small'
        ],
//        'filterModel' => $searchModel,
        'formatter' => ['class' => 'yii\i18n\Formatter','nullDisplay' => ''],
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
//            'id',
            'ProfName',
            'PersName',
            'NomenName',
            'def_quant',
            ['class' => 'yii\grid\ActionColumn',
                'template' =>'',                      
            ],
        ],
    ]); 
?>


</div>
