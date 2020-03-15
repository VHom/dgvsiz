<?php

namespace frontend\controllers;

use Yii;
use app\models\Inorder;
use app\models\search\Inorder as InorderSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\data\ActiveDataProvider;

/**
 * InorderController implements the CRUD actions for Inorder model.
 */
class InorderController extends Controller
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
     * Lists all Inorder models.
     * @return mixed
     */
    public function actionIndex()
    {
        $model = new Inorder();
        if ($model->load(Yii::$app->request->post())) {
//            $model->doc_date =  date_format(from_unixtime(1569880800), '%d.%m.%Y');
            $model->doc_date = strtotime($model->doc_date_temp);
            $model->income_date = time();
            $doctype = \app\models\Doctypelist::find()
                    ->where('code=:doc',[':doc'=> \app\models\Doctypelist::DOCPO])
                    ->one();
            $model->doc_type = $doctype->id;
            $model->save();
            return $this->redirect(['index', 'id' => $model->id]);
        }
        
        $searchModel = new InorderSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $query = Inorder::find()
                ->where(['not',['supplier_id'=>null]]);
        $dataProvider = new ActiveDataProvider([
            'query'=>$query,
        ]);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionIndexNakl($id=null)
    {
        $model = new Inorder();
        if ($model->load(Yii::$app->request->post())) {
//            $model->doc_date =  date_format(from_unixtime(1569880800), '%d.%m.%Y');
            $model->doc_date = strtotime($model->doc_date_temp);
            $model->income_date = time();
            $doctype = \app\models\Doctypelist::find()
                    ->where('code=:doc',[':doc'=> \app\models\Doctypelist::DOCVN])
                    ->one();
            $model->doc_type = $doctype->id;
            $model->save();
            return $this->redirect(['index-nakl', 'id' => $model->id]);
        }
        
        $searchModel = new InorderSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $query = Inorder::find()
                ->where(['not',['pers_id'=>null]]);
        $dataProvider = new ActiveDataProvider([
            'query'=>$query,
        ]);
        return $this->render('index_nakl', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Inorder model.
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
     * Creates a new Inorder model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Inorder();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['index', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Inorder model.
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
//        $model->doc_date_temp = date("d.m.Y", (integer) $model->doc_date);
        if ($model->load(Yii::$app->request->post())) 
        {
            if (!$model->save()) {
                \Yii::$app->session->setFlash('error','Некорректные данные');
                return $this->redirect(['/inorder/updatemod', 
                    'id' => $id ,
                    'model'=>$model,
                ]);
            }  else {
            return $this->redirect(['/inorder/index',
                'id' => $id ,
                'model'=>$model,
                ]);
            }
        } else {
            return $this->renderPartial('/inorder/_form_upd', [
                'id' => $id ,
                'model'=>$model,
                ]);
        }
    }

    public function actionUpdatemodNakl($id)
    {
        $model = $this->findModel($id);
//        $model->doc_date_temp = date("d.m.Y", (integer) $model->doc_date);
        if ($model->load(Yii::$app->request->post())) 
        {
            if (!$model->save()) {
                \Yii::$app->session->setFlash('error','Некорректные данные');
                return $this->redirect(['/inorder/updatemod-nakl', 
                    'id' => $id ,
                    'model'=>$model,
                ]);
            }  else {
            return 
                $this->redirect(['/inorder/index-nakl', 
                'id' => $id ,
                'model'=>$model,
                ]);
            }
        } else {
            return $this->renderPartial('/inorder/_form_upd_nakl', [
                'id' => $id ,
                'model'=>$model,
                ]);
        }
    }

    /**
     * Deletes an existing Inorder model.
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
     * Finds the Inorder model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Inorder the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Inorder::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
