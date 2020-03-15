<?php

namespace frontend\controllers;

use Yii;
use app\models\DraftSpec;
use app\models\search\DraftSpec as DraftSpecSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * DraftSpecController implements the CRUD actions for DraftSpec model.
 */
class DraftSpecController extends Controller
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
     * Lists all DraftSpec models.
     * @return mixed
     */
    public function actionIndex($id=null)
    {
//        throw new NotFoundHttpException('qq');
//               $nomen_id = null;

        $model = new DraftSpec();
        if ($model->load(Yii::$app->request->post())) 
        {
            $draft = \app\models\Draft::findOne($id);
            $remain = \app\models\Storemain::find()
                    ->where('id=:rem_id and store_id=:store_id',
                            [':rem_id'=>$model->remain_id,':store_id'=>$draft->out_store])
                    ->one();
//            throw new NotFoundHttpException('qq - '.$model->quant.' - '.$draft->out_store.' - '.$model->remain_id); //.' - '.$remain->quant);
            if(($model->quant) > ($remain->quant)) {
                $nomen= \app\models\search\Nomenclature::find()
                        ->leftJoin('storemain','storemain.nomen_id=nomenclature.id')
                        ->where('storemain.id=:rem_id',[':rem_id'=>$remain->id])
                        ->one();
                \Yii::$app->session->setFlash('error','Указанное количество номенклатуры "'.$nomen->name.'" превышает остаток.');
                return $this->redirect(['index', 
                    'id' => $id ,
                ]);
            }
            $model->draft_id = $draft->id;
            if (!$model->save()) {
                \Yii::$app->session->setFlash('error','Некорректные данные номенклатора');
                return $this->redirect(['index', 
                    'id' => $id ,
                ]);
            } else {
                $remain->quant -= $model->quant;
                $remain->save();
                $id_out = $model->id;
                if(!$remain_in = \app\models\Storemain::find()
                    ->where('id=:rem_id and store_id=:store_id',
                            [':rem_id'=>$model->remain_id,':store_id'=>$draft->in_store])
                        ->one())
                {
                    $remain_in = new \app\models\Storemain();
                    $remain_in->nomen_id = $remain->nomen_id;
                    $remain_in->size_id = $remain->size_id;
                    $remain_in->height_id = $remain->height_id;
                    $remain_in->full_id = $remain->full_id;
                    $remain_in->shirt_id = $remain->shirt_id;
                    $remain_in->shoes_id = $remain->shoes_id;
                    $remain_in->glove_id = $remain->glove_id;
                    $remain_in->head_id = $remain->head_id;
                    $remain_in->amout = $remain->amout;
                    $remain_in->is_siz = $remain->is_siz;
                    $remain_in->actual = \app\models\Storemain::REMACTUAL;
                    $remain_in->store_id = $draft->in_store;
                    $remain_in->quant = $model->quant;
                } else {
                    $remain_in->quant = $remain_in->quant + $model->quant;
                }
                $remain_in->save();
                $id_in = $model->id;
                //id - draftspec->id; $stoptype: 0-приход; 1-расход
                $stoptype = \app\models\Stopertype::STREMOUT;
                \app\models\Storejournal::JournalRec($id_out,$stoptype); //списание со склада источника
                $stoptype = \app\models\Stopertype::STREMIN;
                \app\models\Storejournal::JournalRec($id_in,$stoptype); //приход на склад приемника
            }
        }
//throw new NotFoundHttpException('qq1 - '.$id.' - '.$model->remain_id);
        $searchModel = new DraftSpecSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'id' => $id,
        ]);
    }

    /**
     * Displays a single DraftSpec model.
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
     * Creates a new DraftSpec model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new DraftSpec();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing DraftSpec model.
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
     * Deletes an existing DraftSpec model.
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
     * Finds the DraftSpec model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return DraftSpec the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = DraftSpec::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
