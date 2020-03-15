<?php

namespace frontend\controllers;

use Yii;
use app\models\DeficitStatment;
use app\models\search\DeficitStatment as DeficitStatmentSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * DeficitStatmentController implements the CRUD actions for DeficitStatment model.
 */
class DeficitStatmentController extends Controller
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
     * Lists all DeficitStatment models.
     * @return mixed
     */
    public function actionIndex()
    {
        $model = new DeficitStatment();
        if ($model->load(Yii::$app->request->post())) {
//Запись дефицитной ведомости
            $model->date_report = strtotime($model->date_report_temp);
            $model->oper_date = time();
            $model->oper_id = \Yii::$app->user->id;
            $model->status = DeficitStatment::STAT_UNDEFINED;
            $model->stat_type = DeficitStatment::STAT_TYPE_DIV;
            If(!$count = DeficitStatment::find()
                    ->where('staff_id=:staff',[':staff'=>$model->staff_id])
                    ->count())
                    $count= 1;
            else $count ++;
            $model->number_report = $model->staff_id.' - '.$count;
/*throw new NotFoundHttpException($model->staff_id.' - '.$model->date_report.
        ' - '.$model->date_report_temp.' - '.$model->oper_id.' - '.
        $model->number_report.' - '.$model->oper_date.' - '.$model->oper_id);*/
            if (!$model->save()) {
                \Yii::$app->session->setFlash('error','Некорректные данные дефицитной ведомости.');
            } 
        }
        $searchModel = new DeficitStatmentSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single DeficitStatment model.
     * @param integer $id
     * @param integer $oper_date
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id, $oper_date)
    {
        return $this->render('view', [
            'model' => $this->findModel($id, $oper_date),
        ]);
    }

    /**
     * Creates a new DeficitStatment model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new DeficitStatment();

        if ($model->load(Yii::$app->request->post())) {
                if($model->save()) {
                return $this->redirect(['view', 'id' => $model->id, 'oper_date' => $model->oper_date]);
            }
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing DeficitStatment model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @param integer $oper_date
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id, $oper_date)
    {
        $model = $this->findModel($id, $oper_date);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id, 'oper_date' => $model->oper_date]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing DeficitStatment model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @param integer $oper_date
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id, $oper_date)
    {
        $this->findModel($id, $oper_date)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the DeficitStatment model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @param integer $oper_date
     * @return DeficitStatment the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id, $oper_date)
    {
        if (($model = DeficitStatment::findOne(['id' => $id, 'oper_date' => $oper_date])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
