<?php

namespace frontend\controllers;

use app\models\Perslist;
use app\models\Rolelist;
use app\models\Userlist;
use Yii;
use app\models\StatSpec;
use app\models\search\StatSpec as StatSpecSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\data\ActiveDataProvider;

/**
 * StatSpecController implements the CRUD actions for StatSpec model.
 */
class StatSpecController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all StatSpec models.
     * @return mixed
     */
    public function actionIndex($id)
    {
//        throw new NotFoundHttpException('qq '.$id);
        if(!$stat = StatSpec::find()
                ->where('stat_id=:stat',[':stat'=>$id])
                ->all())
        {
            $staff = \app\models\Stafflist::find()
                    ->leftJoin('deficit_statment','deficit_statment.staff_id=stafflist.id')
                    ->where('deficit_statment.id=:staff',[':staff'=>$id])
                    ->one();
            foreach ($pers = \app\models\Perslist::find()
//                    ->leftJoin('proflist','proflist.id=perslist.prof_id')
                    ->where('staff_id=:staff',[':staff'=>$staff->id])
                    ->all() as $pers_div)
            {
                foreach ($spec = \app\models\NormCardspec::find()
                    ->leftJoin('norm_card','norm_card.id=norm_cardspec.card_id')
                    ->where('norm_card.pers_id=:pers',[':pers'=>$pers_div->id])
                    ->all() as $norm) //карточка сотрудника
                {
//Определение нормативных показателей (номенклатуры и количества)            
//                throw new NotFoundHttpException('ww - '.$norm->nomen_id.' - '.$pers_div->prof_id.' - '.$pers_div->id);
                    $normspec = \app\models\NormlistSpec::find ()
                        ->leftJoin ('normlist','normlist.id=normlist_spec.norm_id')
                        ->where('normlist.prof_id=:prof and normlist.staff_id=:staff',
                                [':prof'=>$pers_div->prof_id,':staff'=>$pers_div->staff_id])
                        ->andWhere ('normlist_spec.nomen_id=:nomen',
                                [':nomen'=>$norm->nomen_id])
                        ->one();
                        $nomen = \app\models\Nomenclature::findOne($norm->nomen_id);
                        $stat = new StatSpec;
                        $stat->stat_id = $id;
                        $stat->sign_choice = \app\models\StatSpec::CHOICE_NO;
                        $stat->nomen_id = $normspec->nomen_id;
                        $stat->quant = $normspec->quant;
                        $stat->prof_id = $pers_div->prof_id;
                        $stat->nomen_type = $nomen->code;
                        $stat->pers_id = $pers_div->id;
//Определение фактических показателей (номенклатура с размерами и количество)
                    if($norm)
                    { if($norm->invoice_id)
                    {
                        $rem = \app\models\Storemain::find()
                                ->leftJoin('invoice_spec','invoice_spec.remain_id=storemain.id')
                                ->where('invoice_spec.invoice_id=:inv and nomen_id=:nomen',
                                        [':inv'=>$norm->invoice_id,':nomen'=>$norm->nomen_id])
                                ->one(); //номенклатура с размерами 
    //Определение даты окончания срока носки                    
                        $invoice = \app\models\Invoice::findOne($norm->invoice_id);
                        $date_test = date('Y-m-d',$invoice->doc_date);
                        
//                        $period = 15;
                        $tYear = substr($date_test, 0,4);
                        $tMonth = substr($date_test,5,2);
//                        $nMonth =$tMonth + $normspec->period;
                        $tDay = substr($date_test,8,2);
//                        $nYear = floor(($tMonth + $period) / 12);
                        $nYear = floor(($tMonth + $normspec->period) / 12);
//                        throw new NotFoundHttpException('aa = '.$nYear.' - '.$tMonth.' - '.$period.' - '.$tMonth);
                        $nMonth = $tMonth  + ($normspec->period - (12 * $nYear));
//                        $nMonth = $tMonth  + ($period - (12 * $nYear));
                        if($nMonth>12)
                            $nMonth = $nMonth - 12;
                        else if($nMonth == 0) 
                            {
                                $nMonth = 12;
                                $nYear = $nYear -1;
                            }
                        $tYear = $nYear + $tYear;
                        $test = $tYear.'-'.$nMonth.'-'.$tDay;
//                        $_date_test;
                        $_date_test = Yii::$app->formatter->asDate($test,'php:d.m.Y');
//Выборка плановых показателей из normlist по prof_id,staff_id и normlist_spec                        
                        
                        $stat->date_end = strtotime($_date_test);
                        $stat->nomen_fact_id = $rem->nomen_id;
                        $stat->quant_fact = $norm->quant;
                        $stat->remain_id = $rem->id;
//throw new NotFoundHttpException('qq - '.$stat->date_end.' - '.$stat->nomen_fact_id.' - '.$stat->quant_fact.' - '.$stat->remain_id);
                    } }
                    $stat->save();
                }
            }
        }
        $query = StatSpec::find()
                ->where('stat_id=:id',[':id'=>$id]);
        $dataProvider = new ActiveDataProvider([
            'query' => $query
        ]);

//        $searchModel = new StatSpecSearch();
//        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
//            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'stat_id' => $id,
        ]);
    }

    public function actionIndexProvision()
    {
        $model = new StatSpec();
        $staff_id = '';
        $stat = new StatSpec;
        $stat_id = null;
        if ($model->load(Yii::$app->request->post())) {
            $staff_id = $model->staff_id;
            $tdate = strtotime($model->date_end_temp);
            foreach (StatSpec::find()
                         ->where('staff_id=:staff',[':staff'=>$model->staff_id])
                         ->all() as $rec)
            {
                $rec->delete();
            }
//            throw new NotFoundHttpException('qq - '.$staff_id);
            foreach ($pers = \app\models\Perslist::find()
                ->where('staff_id=:staff',[':staff'=>$staff_id])
                ->all() as $pers_div)
            {
                foreach ($spec = \app\models\NormCardspec::find()
                    ->leftJoin('norm_card','norm_card.id=norm_cardspec.card_id')
                    ->where('norm_card.pers_id=:pers',[':pers'=>$pers_div->id])
                    ->all() as $norm) //карточка сотрудника
                {
//Определение нормативных показателей (номенклатуры и количества)
//                    throw new NotFoundHttpException('qq');
                    $normspec = \app\models\NormlistSpec::find ()
                        ->leftJoin ('normlist','normlist.id=normlist_spec.norm_id')
                        ->where('normlist.prof_id=:prof and normlist.staff_id=:staff',
                            [':prof'=>$pers_div->prof_id,':staff'=>$pers_div->staff_id])
                        ->andWhere ('normlist_spec.nomen_id=:nomen',
                            [':nomen'=>$norm->nomen_id])
                        ->one();
                    $nomen = \app\models\Nomenclature::findOne($norm->nomen_id);
//                    $stat = new StatSpec;
                    $stat->staff_id = $staff_id;
//                        $stat->sign_choice = \app\models\StatSpec::CHOICE_NO;
                    $stat->nomen_type = $nomen->code;
                    $stat->nomen_id = $normspec->nomen_id;
                    $stat->quant = $normspec->quant;
                    $stat->prof_id = $pers_div->prof_id;
                    $stat->nomen_type = $nomen->code;
                    $stat->pers_id = $pers_div->id;
                    $stat->date_report = $tdate;
//Определение фактических показателей (номенклатура с размерами и количество)
                    $rem = \app\models\Storemain::find()
                        ->leftJoin('invoice_spec','invoice_spec.remain_id=storemain.id')
                        ->where('invoice_spec.invoice_id=:inv and nomen_id=:nomen',
                            [':inv'=>$norm->invoice_id,':nomen'=>$norm->nomen_id])
                        ->one(); //номенклатура с размерами
//Определение даты окончания срока использования
                    if($norm->invoice_id)
                    {
                        $invoice = \app\models\Invoice::findOne($norm->invoice_id);
                        $stat->date_out = \app\models\NormCardspec::DateEnd($invoice->doc_date,$norm->period);
                        $stat->date_end = strtotime($stat->date_out );
                    }
                    //Выборка плановых показателей из normlist по prof_id,staff_id и normlist_spec
                    if($stat->date_out)
                    {
                        $stat->nomen_fact_id = $norm->nomen_id;
                        $stat->quant_fact = $norm->quant;
                    } else {
                        $stat->nomen_fact_id = '';
                        $stat->quant_fact = '';
                    }
                    if($rem)
                        $stat->remain_id = $rem->id;

                    if($stat->date_end)
                    {
//throw new NotFoundHttpException('qq - '.$stat->date_end.' - '.$stat->date_report);
                        if($stat->date_end < $stat->date_report) // or (!$stat->date_end))
                        {
                            $stat->sign_choice = 1;
                            $stat->deficit = $stat->quant;
                        }
                        else {
                            $stat->sign_choice = 0;
                            $stat->deficit = 0;
                        }
                    } else {
                        $stat->sign_choice = 1;
                        $stat->deficit =  $stat->quant;
                    }
                    $stat->save();
                    $stat_id = $stat->id;
                    $stat = new StatSpec();
                }
            }
        }
//        throw new NotFoundHttpException('qq - '.$stat->date_end.' - '.$stat->date_report);
        $stat_staff = StatSpec::find()
            ->where('staff_id=:staff',[':staff'=>$model->staff_id]);
//                ->orderBy['pers_id,nomen_type,nomen_id'];
        $dataProvider = new ActiveDataProvider([
            'query' => $stat_staff,
            'sort' => [
                'defaultOrder' => [
                    'pers_id' => SORT_ASC,
                    'nomen_type' => SORT_DESC,
                    'nomen_id' => SORT_ASC
                ]
            ]
        ]);
//        $searchModel = new StatSpecSearch;
//        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        return $this->render('index_provision', [
//            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'stat_id' => $stat_id,
        ]);
    }

    /**
     * Displays a single StatSpec model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new StatSpec model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new StatSpec();
        if ($model->load(Yii::$app->request->post()))
        {
            if ($model->save()) {
                return $this->redirect(['view', 'id' => $model->id]);
            }
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    public function actionCreateStat($stat_id)
    {
        $model = new StatSpec();
        $tmp = 0;
        $model->load(Yii::$app->request->post());
        foreach ($model->find()->where('stat_id=:stat',[':stat'=>$stat_id])
                ->all() as $rec) {
            $tmp ++;
        }
        throw new NotFoundHttpException('Итого: '.$tmp);
        if(!$stat = $model->find()
                    ->where('stat_id=:stat and sign_choice = 1',[':stat'=>$stat_id])
                    ->all())
            {
                \Yii::$app->session->setFlash('error','Нет отмеченных позиций. Заявка не сформирована.');
        $query = StatSpec::find()
                ->where('stat_id=:id',[':id'=>$stat_id]);
        $dataProvider = new ActiveDataProvider([
            'query' => $query
        ]);

//        $searchModel = new StatSpecSearch();
//        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
//            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'stat_id' => $stat_id,
        ]);
        } else {
            $stat = StatSpec::find()
                    ->where('stat_id=:stat and sign_choice = 1',[':stat'=>$stat_id])
                    ->count();
            throw new NotFoundHttpException('Всего - '.$stat.' позиций.');            
            if ($model->save()) {
                return $this->redirect(['view', 'id' => $model->id]);
            }
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing StatSpec model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing StatSpec model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the StatSpec model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return StatSpec the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = StatSpec::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
