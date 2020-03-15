<?php

namespace frontend\controllers;

use Yii;
use app\models\Invoice;
use app\models\search\Invoice as InvoiceSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\data\ActiveDataProvider;

/**
 * InvoiceController implements the CRUD actions for Invoice model.
 */
class InvoiceController extends Controller
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
     * Lists all Invoice models.
     * @return mixed
     */
    public function actionIndex()
    {
        $model = new Invoice();
        if ($model->load(Yii::$app->request->post())) {
            $model->doc_date = strtotime($model->doc_date_temp);
            $model->oper_date = time();
            $model->oper_id = Yii::$app->user->id;
            $doctype = \app\models\Doctypelist::find()
                    ->where('code=:doc',[':doc'=> \app\models\Doctypelist::DOCRN])
                    ->one();
            $model->doc_type = $doctype->id;
            $model->save();
            
//удаление висячих позиций спецификации карточки
            foreach (\app\models\NormCardspec::find()
                    ->where('actual=:status',
                        [':status'=> \app\models\NormCardspec::CARDSPECUND])
                    ->all() as $spec)
            {
//                if($spec)
                    $spec->delete();
            }
//формирование новой позиции спецификации карточки            
            $cardspec = new \app\models\NormCardspec();
            $cardspec->invoice_id =$model->id;
            $cardspec->actual = \app\models\NormCardspec::CARDSPECUND;
            $cardspec->save();
            
            return $this->redirect(['index', 'id' => $model->id]);
        }
        $searchModel = new InvoiceSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
/*        $query = Invoice::find()
                ->where(['not',['pers_id'=>null]]);
        $dataProvider = new ActiveDataProvider([
            'query'=>$query,
        ]);*/


        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionIndexDestr()
    {
        $model = new Invoice();
        if ($model->load(Yii::$app->request->post())) {
            $model->doc_date = strtotime($model->doc_date_temp);
            $model->oper_date = time();
            $model->oper_id = Yii::$app->user->id;
            $doctype = \app\models\Doctypelist::find()
                    ->where('code=:doc',[':doc'=> \app\models\Doctypelist::DOCAD])
                    ->one();
            $model->doc_type = $doctype->id;
//        throw new NotFoundHttpException('qq1');
            $model->save();
            return $this->redirect(['index-destr', 'id' => $model->id]);
        }
//        throw new NotFoundHttpException('qq');
        $searchModel = new InvoiceSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $query = Invoice::find()
                ->where(['pers_id'=>null]);
        $dataProvider = new ActiveDataProvider([
            'query'=>$query,
        ]);


        return $this->render('index_destr', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Invoice model.
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
     * Creates a new Invoice model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Invoice();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['index', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Invoice model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['index', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    public function actionUpdatemod($id)
    {
        $model = $this->findModel($id);
        if ($model->load(Yii::$app->request->post())) 
        {
            if (!$model->save()) {
                \Yii::$app->session->setFlash('error','Некорректные данные');
                return $this->redirect(['/invoice/updatemod', 
                    'id' => $id ,
                    'model'=>$model,
                ]);
            }  else {
            return 
                $this->redirect(['/invoice/index', 
                'id' => $id ,
                'model'=>$model,
                ]);
            }
        } else 
        {
            return $this->renderPartial('/invoice/_form_upd', [
                'id' => $id ,
                'model'=>$model,
            ]);
        }
    }

    public function actionUpdatemodDestr($id)
    {
        $model = $this->findModel($id);
        if ($model->load(Yii::$app->request->post())) 
        {
            if (!$model->save()) {
                \Yii::$app->session->setFlash('error','Некорректные данные');
                return $this->redirect(['/invoice/updatemod-destr', 
                    'id' => $id ,
                    'model'=>$model,
                ]);
            }  else {
            return 
                $this->redirect(['/invoice/index-destr', 
                'id' => $id ,
                'model'=>$model,
                ]);
            }
        } else 
        {
            return $this->renderPartial('/invoice/_form_upd_destr', [
                'id' => $id ,
                'model'=>$model,
            ]);
        }
    }

    /**
     * Deletes an existing Invoice model.
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
     * Finds the Invoice model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Invoice the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Invoice::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
