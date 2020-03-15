<?php

namespace frontend\controllers;

use Yii;
use app\models\NormCard;
use app\models\search\NormCard as NormCardSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * NormCardController implements the CRUD actions for NormCard model.
 */
class NormCardController extends Controller
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
     * Lists all NormCard models.
     * @return mixed
     */
    public function actionIndex()
    {
        $model = new NormCard();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['index', 'id' => $model->id]);
        }
        
        $searchModel = new NormCardSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('/norm-card/index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionIndexNorm()
    {
        $model = new NormCard();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['index', 'id' => $model->id]);
        }
        
        $searchModel = new NormCardSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('/norm-card/index_norm', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single NormCard model.
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
     * Creates a new NormCard model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new NormCard();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['index', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing NormCard model.
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
                return $this->redirect(['/norm-card/_form_updatemod', 
                    'id' => $id ,
                    'model'=>$model,
                ]);
            }  else {
            return 
                $this->redirect(['/norm-card/index', 
                'id' => $id ,
                'model'=>$model,
                ]);
            }
        } else {
            return $this->renderPartial('/norm-card/_form_mod', [
//                'id' => $id ,
                'model'=>$model,
                ]);
        }
    }

    public function actionUpdatemodNorm($id)
    {
        $model = $this->findModel($id);
        $title = 'Нормы сотрудника '.$model->PersName;
        if ($model->load(Yii::$app->request->post())) 
        {
            if (!$model->save()) {
                \Yii::$app->session->setFlash('error','Некорректные данные');
                return $this->redirect(['/norm-card/_form_updatemod', 
                    'id' => $id ,
                    'model'=>$model,
                ]);
            }  else {
            return 
                $this->redirect(['/norm-card/index_norm', 
                'id' => $id ,
                'model'=>$model,
                ]);
            }
        } else {
            return $this->renderPartial('/norm-card/_form_mod', [
//                'id' => $id ,
                'model'=>$model,
                'title' => $title,
                ]);
        }
    }

    /**
     * Deletes an existing NormCard model.
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
    public function actionDeleteNorm($id)
    {
        $model = NormCard::findOne($id);
        $old_value = $model->actual;
        $opername = 'Не актуально';
        $model->actual = NormCard::NORMCARDNO; 
        $model->save();
        \app\models\Operjournal::Operjournal_insert($model,$opername,$old_value);

        return $this->redirect(['index-norm']);
    }

    /**
     * Finds the NormCard model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return NormCard the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = NormCard::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
