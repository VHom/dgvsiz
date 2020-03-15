<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\search\DeficitSpec */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Антропологические данные';
//$this->params['breadcrumbs'][] = $this->title;
//$model = new \app\models\DeficitSpec();
?>
<div class="anthrop-list">

    <h4><?= Html::encode($this->title) ?></h4>

<?php

    echo $anthrop;
?>


</div>
