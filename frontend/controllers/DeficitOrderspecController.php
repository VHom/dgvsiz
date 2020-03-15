<?php

namespace frontend\controllers;

use Yii;
use app\models\DeficitOrderspec;
use app\models\search\DeficitOrderspec as DeficitOrderspecSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\data\ActiveDataProvider;

/**
 * DeficitOrderspecController implements the CRUD actions for DeficitOrderspec model.
 */
class DeficitOrderspecController extends Controller
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
     * Lists all DeficitOrderspec models.
     * @return mixed
     */
    public function actionIndex($id=null)
    {
        $searchModel = new DeficitOrderspecSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'id' => $id,
        ]);
    }

    /**
     * Lists all DeficitOrderspec models.
     * @return mixed
     */
    public function actionIndexCreate($id,$id_check=null)
    {
//         { $check=Yii::$app->request->post('selection');
//                throw new NotFoundHttpException('qq - '.$id.' - '.$id_check);
//         }
        $spec = new \app\models\DeficitSpec();
        if(!$spec->load(Yii::$app->request->post()) && $spec->save()) 
        {
//        $spec = \app\models\DeficitSpec::find()
//                ->where('statement_id=:stat and sign_choice=1',
//                        [':stat'=>$id])
//                ->count();
//        if ($spec==0) 
//        {
            \Yii::$app->session->setFlash('error','Не выбраны позиции спецификации. Формирование заявки не допустимо.');
            $order_spec = \app\models\DeficitSpec::find()
                    ->where('statement_id=:dif',[':dif'=>$id]);
            $dataProvider = new ActiveDataProvider([
                'query' => $order_spec]);

            return $this->render('/deficit-spec/index', [
    //            'searchModel' => $searchModel,
                'dataProvider' => $dataProvider,
                'id' => $id,
            ]);            
        } else {
//        throw new NotFoundHttpException('check: '.$spec->id.' - '.$spec->sign_choice);
        foreach (\app\models\DeficitSpec::find()
                ->where('statement_id=:stat and sign_choice=1',
                        [':stat'=>$id])
                ->all() as $spec)
        {
//            throw new NotFoundHttpException('check: '.$spec->id.' - '.$spec->sign_choice);
//            console.log('check: '.$spec->id.' - '.$spec->sign_choice);
            $order= new DeficitOrderspec();
            $order->statement = $id;
            $order->nomen_name = $spec->def_name;
            $order->quant = $spec->quanr_deficit;
            $order->oper_id = \Yii::$app->user->id;
            $order->oper_date = time();
            $order->save();
        }
        $searchModel = new DeficitOrderspecSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
        }
    }

    /**
     * Displays a single DeficitOrderspec model.
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
     * Creates a new DeficitOrderspec model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new DeficitOrderspec();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing DeficitOrderspec model.
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
     * Deletes an existing DeficitOrderspec model.
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
     * Finds the DeficitOrderspec model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return DeficitOrderspec the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = DeficitOrderspec::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
