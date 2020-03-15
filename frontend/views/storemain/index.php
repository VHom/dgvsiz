<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\search\Storemain */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Остатки на складе';
$this->params['breadcrumbs'][] = ['label' => 'Журнал складских операций', 'url' => ['/storejournal/index']];
//$this->params['breadcrumbs'][] = ['label' => 'Остатки на складе', 'url' => ['/storemain/index']];

?>

<script>
    function CallPrint(strid) {
        console.log('qq');
        var prtContent = document.getElementById(strid);
        var prtCSS = '<link rel="stylesheet" href="/templates/css/template.css" type="text/css" />';
        var WinPrint = window.open('','','left=50,top=50,width=860,height=640,toolbar=0,scrollbars=1,status=0');          WinPrint.document.write('<div id="print" class="contentpane">');
//        console.log('prtContent.innerHTML);
        WinPrint.document.write(prtCSS);
        WinPrint.document.write(prtContent.innerHTML);
        WinPrint.document.write('</div>');
        WinPrint.document.close();
        WinPrint.focus();
        WinPrint.print();
        WinPrint.close();
//        prtContent.innerHTML= strOldOne;
    }
</script>

    <h3><?= Html::encode($this->title) ?></h3>

    <p>
        <?= Html::a('Печать остатков', ['store-print'], ['class' => 'btn btn-info']) ?>
    </p>

    <!--a onClick="CallPrint('print-content');" title="Распечатать проект">Распечатать</a-->
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>
<div id="print-content">

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'options' => [ 'style' => 'table-layout:fixed;' ],
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

//            'StoreName',
//            'NomenSize',
//            'quant',
            [
                'attribute' => 'StoreName',
                'options' =>['style => width: 50%; max-width: 50%']
            ],
            [
                'attribute' => 'NomenName',
                'options' =>['style' => 'width: 85%; max-width: 85%;'],
            ],
            [
                'attribute' => 'FullSize',
//                'options' =>['style => width:85%']
                'options' =>['style' => 'width: 15%; max-width: 15%;'],
            ],
            [
                'attribute' => 'quant',
                'options' =>['style => width:5%']
            ],

//            ['class' => 'yii\grid\ActionColumn',
//                'template' =>'',
//            ],
        ],
    ]); ?>
</div>

</div>
