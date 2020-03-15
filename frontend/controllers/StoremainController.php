<?php

namespace frontend\controllers;

use Yii;
use app\models\Storemain;
use app\models\search\Storemain as StoremainSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * StoremainController implements the CRUD actions for Storemain model.
 */
class StoremainController extends Controller
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
     * Lists all Storemain models.
     * @return mixed
     */
    public function actionIndex()
    {
//        throw new NotFoundHttpException('index');
        $searchModel = new StoremainSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionStorePrint()
    {
//        throw new NotFoundHttpException('qq');
        return $this->render('storemain_print');
    }

    /**
     * Displays a single Storemain model.
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
     * Creates a new Storemain model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Storemain();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model-> id]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Storemain model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model-> id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Storemain model.
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

    public function actionDelmod($id)
    {
        $remain = Storemain::findOne($id);
        $rem_quant = $remain->quant;
        $oper_id = Yii::$app->user->id;
        $invspec = \app\models\InvoiceSpec::find()
                ->where('oper_id=:oper and remain_id is null',
                        [':oper'=>$oper_id])
                ->one();
//Проверка на превышение остатка
        if ($remain->load(Yii::$app->request->post())) { 
//        throw new NotFoundHttpException('qq1 - '.$id.' - '.$oper_id.' - '.$invspec->id);
            if($rem_quant  < $invspec->quant) { 
                $nomen = \app\models\Nomenclature::findOne($remain->nomen_id);
                \Yii::$app->session->setFlash('error','Количество списания номенклатуры "'.$nomen->name.'" превышает остаток на складе');
                return $this->render('/storemain/_form_del_mod');
            } else {
//Запись спецификации акта списания
                $invspec->store_id = $remain->store_id;
                $invspec->quant = $remain->quant;
                $invspec->remain_id = $remain->id;
                $invspec->oper_id = Yii::$app->user->id;
                $invspec->oper_date = time();
                $invspec->save();
//Запись скорректированных остатков на складе
                $remain->quant = $rem_quant - $invspec->quant;
                $remain->save();
//Запись в журнал складских операций
                $stopetype = \app\models\Stopertype::STDEL;
                \app\models\Storejournal::JournalRec($invspec->id, $stopetype);

                return $this->redirect(['/invoice-spec/index-destr', 'id' => $invspec->invoice_id]);
            }
        }
        return $this->renderPartial('/storemain/_form_del_mod',[
            'model' => $remain,
        ]);
    }
    /**
     * Finds the Storemain model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Storemain the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Storemain::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
