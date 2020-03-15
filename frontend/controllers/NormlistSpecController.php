<?php

namespace frontend\controllers;

use Yii;
use app\models\NormlistSpec;
use app\models\search\NormlistSpec as NormlistSpecSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\data\ActiveDataProvider;
/**
 * NormlistSpecController implements the CRUD actions for NormlistSpec model.
 */
class NormlistSpecController extends Controller
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
     * Lists all NormlistSpec models.
     * @return mixed
     */
    public function actionIndex($id=null)
    {
        $model = new NormlistSpec();

        if ($model->load(Yii::$app->request->post())) {
            $kind = \app\models\Nomenkind::findOne($model->kind_id);
            $model->period = $kind->period;
            $model->norm_id = $id;
//            throw new NotFoundHttpException('ww0-'. $model->norm_id);
            if( $model->save()) {
                return $this->redirect(['index', 'id' => $model->norm_id]);
            } else {
                Yii::$app->session->setFlash('danger', 'Некорректно введены данные.');
                $this->renderPartial('_form_mod',['model'=>$model]);
            }
        }

        if($id) {
//            throw new NotFoundHttpException('ww'.$id);
            $prof = \app\models\Proflist::find()
                    ->leftJoin('normlist','normlist.prof_id=proflist.id')
                    ->where('normlist.id=:norm',[':norm'=>$id])
                    ->one();
            $prof_name = $prof->name;
        }
        else
            $prof_name = '';
        $query = NormlistSpec::find()->where('norm_id=:norm and actual=:act',
                [':norm'=>$id, ':act'=> NormlistSpec::ACTUALYES]);
        $dataProvider = new ActiveDataProvider([
        'query'=>$query,
        ]);
        
//        $searchModel = new NormlistSpecSearch();
//        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
//            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'prof_name' => $prof_name,
        ]);
    }

    /**
     * Displays a single NormlistSpec model.
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
     * Creates a new NormlistSpec model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new NormlistSpec();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['index', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing NormlistSpec model.
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
//        throw new NotFoundHttpException('qq '.$id);
        $model = $this->findModel($id);
        if ($model->load(Yii::$app->request->post())) 
        {
            if (!$model->save()) {
                \Yii::$app->session->setFlash('error','Некорректные данные');
                return $this->redirect(['/normlist-spec/_form_updatemod', 
                    'id' => $id ,
                    'model'=>$model,
                ]);
            }  else {
                $norm = \app\models\Normlist::findOne($model->norm_id);
            return 
                $this->redirect(['/normlist-spec/index', 
                'id' => $norm->id ,
                'model'=>$model,
                ]);
            }
        } else {
            return $this->renderPartial('/normlist-spec/_form_mod', [
//                'id' => $id ,
                'model'=>$model,
                ]);
        }
    }

    /**
     * Deletes an existing NormlistSpec model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
//        throw new NotFoundHttpException('delete');
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    public function actionDeleteNorm($id)
    {
        $norm = \app\models\NormlistSpec::findOne($id);
//        throw new NotFoundHttpException('qq');
        $model = NormlistSpec::findOne($id);
        $old_value = $model->actual;
        $opername = 'Не актуально';
        $model->actual = NormlistSpec::ACTUALNO; 
        $model->save();
        \app\models\Operjournal::Operjournal_insert($model,$opername,$old_value);

        return $this->redirect(['index','id'=>$norm->norm_id]);
    }

    /**
     * Finds the NormlistSpec model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return NormlistSpec the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = NormlistSpec::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
