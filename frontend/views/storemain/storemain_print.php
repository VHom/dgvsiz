<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\search\Storemain */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Остатки на складе';
//$this->params['breadcrumbs'][] = $this->title;
?>
<head>
    <title>Остатки на складе</title>
    <meta charset="utf-8">
    <style>
            html {
              line-height: 1.15; 
              -webkit-text-size-adjust: 100%; 
            }
/*            main {
              display: block;
            }  */                       
            table {
                    margin: auto;
                    border: 1px solid #333;
                    table-layout: fixed;
                    border-collapse: collapse;
                    font-size: 9px;
            }
            td, th {
                    border: 1px solid #555;
                    padding: 3px 3px;
            }
            th {
                    border-color: #333;
                    font-size: 10px;
            }
            tr:nth-child(odd) {
                    background: #e9e9e9;
            }
            tr:hover {
                    background: #ff0;
            }
    </style>

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
</head>

<h3><?= Html::encode($this->title) ?></h3>

<a onClick="CallPrint('print-content');" title="Распечатать проект">Распечатать</a>
<?php // echo $this->render('_search', ['model' => $searchModel]); ?>


<?php
    $role = app\models\Rolelist::find()
            ->leftJoin('userlist','userlist.role_id=rolelist.id')
            ->where('userlist.user_id=:usr',[':usr'=> Yii::$app->user->id])
            ->one();
//    throw new yii\web\NotFoundHttpException('qq - '.$role->code);
    if($role->code == 'supervisor') {
        $query = \app\models\Storemain::find()
            ->select(['quant', 'nomen_id', \app\models\Nomenclature::tableName().'.name',
                'size_id','height_id','full_id','head_id','shoes_id','shirt_id','glove_id'])
            ->joinWith('nomen')
            ->where('quant>0');                
//                ->limit(50);
    $query->orderBy(['nomenclature.name'=>SORT_ASC]);
    ?>
<div id="print-content">
<?php
    $tab = '<table border=1><tr><th>Номенклатура</th><th>Размер</th>'
            . '<th>Рост</th><th>Полнота</th><th>Ворот</th><th>Убор</th>'
            . '<th>Обувь</th><th>Кол-во</th></tr>';
            
    foreach ($query->all() as $rec)
        {
            if($sizeGr=app\models\Sizelist::findOne($rec->size_id))
                    $size_val = $sizeGr->size;
            else $size_val='';
            if($heightGr=app\models\Sizelist::findOne($rec->height_id))
                    $height_val = $heightGr->size;
            else $height_val='';
            if($fullGr=app\models\Sizelist::findOne($rec->full_id))
                    $full_val = $fullGr->size;
            else $full_val='';
            if($shirtGr=app\models\Sizelist::findOne($rec->shirt_id))
                    $shirt_val = $shirtGr->size;
            else $shirt_val='';
            if($shoesGr=app\models\Sizelist::findOne($rec->shoes_id))
                    $shoes_val = $shoesGr->size;
            else $shoes_val='';
            if($headGr=app\models\Sizelist::findOne($rec->head_id))
                    $head_val = $headGr->size;
            else $head_val='';
            $tab .= '<tr><td>'.$rec->nomen->name. //$st_group.
                    '</th><td>'.$size_val. //$sizeGr->size.
                    '</td><td>'.$height_val.
                    '</td><td>'.$full_val.
                    '</td><td>'.$shirt_val.
                    '</td><td>'.$shoes_val.
                    '</td><td>'.$head_val.
                    '</td><td>'.$rec->quant. //$st_group.
                    '</td></tr>'; 
        }
    echo $tab.'</table>';
    }
    ?>
</div>

