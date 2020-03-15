<?php

namespace frontend\controllers;

use app\models\ConstNomen;
use app\models\MeasureUnit;
use app\models\Nomenkind;
use Yii;
use app\models\Nomenclature;
use app\models\search\Nomenclature as NomenclatureSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * NomenclatureController implements the CRUD actions for Nomenclature model.
 */
class NomenclatureController extends Controller
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
     * Lists all Nomenclature models.
     * @return mixed
     */
    public function actionIndex()
    {
        $model = new Nomenclature();
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            $meas = MeasureUnit::findOne($model->meas_id);
            $meas_code = $meas->abbr;
            if($meas_code == 'комп') {
//                $searchModel = new \app\models\search\ConstNomen();
//                $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
//                $complect = new ConstNomen();
                return $this->redirect(['/const-nomen/index', 'id'=>$model->id]);
            }
            return $this->redirect(['/nomenclature/index', 'id' => $model->id, 'meas'=>$meas_code]);
        }
        
        $searchModel = new NomenclatureSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Nomenclature model.
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
     * Creates a new Nomenclature model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        throw new NotFoundHttpException('bbb');
        $model = new Nomenclature();
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['index', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Nomenclature model.
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

    public function actionUpdatemod($id=null)
    {
        if ($id) {
            $model = Nomenclature::findOne($id);
            $meas = MeasureUnit::findOne($model->meas_id);
        }
        else
            $model = new Nomenclature();
        if ($model->load(Yii::$app->request->post()))
        {
            if (!$model->save()) {
                \Yii::$app->session->setFlash('error','Некорректные данные');
                return $this->redirect(['/nomenclature/_form_mod',
                    'id' => $id ,
                    'model'=>$model,
                ]);
            }  else {
                if($meas->id != $model->meas_id) {
                    if($meas->abbr == 'комп') {
                        foreach (ConstNomen::find()
                        ->where('nomen_id=:nomen',[':nomen'=>$model->id])
                        ->all() as $rec) {
                            $rec->delete();
                        }
                    }
                    $meas = \app\models\search\MeasureUnit::findOne($model->meas_id);
                    if($meas->abbr == 'комп') {
                        return $this->redirect(['const-nomen/index', 'id' => $model->id]);
                    }
                }
                return $this->redirect(['/nomenclature/index']);
            }
        }
        return $this->renderPartial('/nomenclature/_form_mod', [
            'id' => $id ,
            'model'=>$model,
        ]);
    }

    /**
     * Deletes an existing Nomenclature model.
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
     * Finds the Nomenclature model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Nomenclature the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Nomenclature::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
