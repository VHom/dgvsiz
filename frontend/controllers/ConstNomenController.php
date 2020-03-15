<?php

namespace frontend\controllers;

use app\models\Nomenclature;
use Yii;
use app\models\ConstNomen;
use app\models\search\ConstNomen as ConstNomenSearch;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * ConstNomenController implements the CRUD actions for ConstNomen model.
 */
class ConstNomenController extends Controller
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
     * Lists all ConstNomen models.
     * @return mixed
     */
    public function actionIndex($id=null)
    {
        $model = new ConstNomen();
        if($model->load(Yii::$app->request->post())) {
            $model->nomen_id = $id;
            $model->save();
        }
        $query = ConstNomen::find()->where('nomen_id=:nomen',[':nomen'=>$id]);
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);
        return $this->render('/const-nomen/index', [
//            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
//            'nomen' => $nomen,
        ]);
    }

    public function actionUpdatemod($id)
    {
        $model = $this->findModel($id);
//        throw new NotFoundHttpException('qq - '.$id.'- '.$model->nomen_id);
        if ($model->load(Yii::$app->request->post()))
        {
            if($model->save())
                return $this->redirect(['const-nomen/index-const','id'=>$model->nomen_id]);
        }
        return $this->renderPartial('/const-nomen/_form_upd', [
            'model' => $model,
            'id' => $id,
        ]);
    }

    public function actionIndexDetaile($id)
    {
//        throw new NotFoundHttpException(('qq - '.$id));
//        $const = ConstNomen::findOne($id);
        $query = ConstNomen::find()
            ->leftJoin('storemain','storemain.nomen_id=const_nomen.nomen_id')
            ->where('storemain.id=:rem', [':rem'=>$id]);

/*        $query = Nomenclature::find()
            ->leftJoin('measure_unit','measure_unit.id=nomenclature.meas_id')
            ->where('measure_unit.abbr=:compl',[':compl'=>'комп']);*/

//        throw new NotFoundHttpException('constnomen1 '.$model->const_nomen_id.' - '.$model->quant.' - '.$id);
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);
        return $this->render('/const-nomen/index_detaile', [
//            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionIndexConst($id=null)
    {

        $query = Nomenclature::find()
        ->leftJoin('measure_unit','measure_unit.id=nomenclature.meas_id')
        ->where('measure_unit.abbr=:compl',[':compl'=>'комп']);

//        throw new NotFoundHttpException('constnomen1 '.$model->const_nomen_id.' - '.$model->quant.' - '.$id);
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);
        return $this->render('/const-nomen/index_const', [
//            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single ConstNomen model.
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
     * Creates a new ConstNomen model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new ConstNomen();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing ConstNomen model.
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
     * Deletes an existing ConstNomen model.
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
     * Finds the ConstNomen model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return ConstNomen the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = ConstNomen::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
