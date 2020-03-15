<?php

namespace frontend\controllers;

use app\models\NormCard;
use Yii;
use app\models\Perslist;
use app\models\search\Perslist as PerslistSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\data\ActiveDataProvider;

/**
 * PerslistController implements the CRUD actions for Perslist model.
 */
class PerslistController extends Controller
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
     * Lists all Perslist models.
     * @return mixed
     */
    public function actionIndex($errormod=null,$id=null)
    {
        if($id)
            $model=Perslist::findOne($id);
        else
            $model = new Perslist();
        if ($model->load(Yii::$app->request->post())) {
//Запись персональных данных
/*            $fio = $fio.mb_substr($model->first_name,0,1)||'. ';*/
            $model->family_name = trim($model->family_name);
            $model->first_name = trim($model->first_name);
            $model->second_name = trim($model->second_name);
            $fio = $model->family_name.' '.mb_substr($model->first_name,0,1).'.';
            If($model->second_name)
                $fio = $fio.mb_substr($model->second_name, 0,1).'.';
            $model->abbr_name = $fio;
            $model->start_date = strtotime($model->start_date_temp);
            $model->end_date = strtotime($model->end_date_temp);
            $model->decret_start = strtotime($model->decret_start_temp);
            $model->decret_end = strtotime($model->decret_end_temp);
            if($model->save()) {
//Запись нормы по должности
                if(!NormCard::CardStaff($model->id)) {
                    \Yii::$app->session->setFlash('error','Отсутствуют нормы на выбранную должность.');

/*                $norm = \app\models\Normlist::find()
                        ->where('prof_id=:prof and staff_id=:staff and actual=:type',[
                            ':prof'=>$model->prof_id,
                            ':staff'=>$model->staff_id,
                            ':type'=> \app\models\Normlist::PROF])
                        ->one();
                if($norm) {
                $card = new \app\models\NormCard();
                $card->pers_id = $model->id;
                $card->norm_id = $norm->id;
                $card->save();
                foreach (\app\models\NormlistSpec::find()
                        ->where('norm_id=:card',[':card'=>$card->norm_id])
                        ->all() as $rec)
                {
//Запись спецификации нормы                
                    $spec = new \app\models\NormCardspec();
                    $spec->card_id = $card->id;
                    $spec->nomen_id = $rec->nomen_id;
                    $spec->quant = $rec->quant;
                    $spec->period = $rec->period;
                    $spec->save();*/
//Запись показателей антропологических данных сотрудников
/*                    $kind = \app\models\Nomenkind::findOne($rec->kind_id);
//                    throw new NotFoundHttpException('zz '.$rec->kind_id.' '.$model->id.' '.$kind->name);
                    if($kind->size_gr == 1) {
                        $anth = \app\models\PersAnthrop::find()
                            ->where('pers_id=:pers and name=:ant',
                                    [':pers'=>$model->id, ':ant'=> \app\models\PersAnthrop::size])
                            ->count();
                        if($anth == 0) {
                            $ant = new \app\models\PersAnthrop();
                            $ant->pers_id = $model->id;
                            $ant->name = \app\models\PersAnthrop::size;
                            $ant->save();
                        }
                    }
                    if($kind->height_gr == 1) {
                        $anth = \app\models\PersAnthrop::find()
                            ->where('pers_id=:pers and name=:ant',
                                    [':pers'=>$model->id, ':ant'=> \app\models\PersAnthrop::height])
                            ->count();
                        if($anth == 0) {
                            $ant = new \app\models\PersAnthrop();
                            $ant->pers_id = $model->id;
                            $ant->name = \app\models\PersAnthrop::height;
                            $ant->save();
                        }
                    }
                    if($kind->full_gr == 1) {
                        $anth = \app\models\PersAnthrop::find()
                            ->where('pers_id=:pers and name=:ant',
                                    [':pers'=>$model->id, ':ant'=> \app\models\PersAnthrop::full])
                            ->count();
                        if($anth == 0) {
                            $ant = new \app\models\PersAnthrop();
                            $ant->pers_id = $model->id;
                            $ant->name = \app\models\PersAnthrop::full;
                            $ant->save();
                        }
                    }
                    if($kind->shirt_gr == 1) {
                        $anth = \app\models\PersAnthrop::find()
                            ->where('pers_id=:pers and name=:ant',
                                    [':pers'=>$model->id, ':ant'=> \app\models\PersAnthrop::shirt])
                            ->count();
                        if($anth == 0) {
                            $ant = new \app\models\PersAnthrop();
                            $ant->pers_id = $model->id;
                            $ant->name = \app\models\PersAnthrop::shirt;
                            $ant->save();
                        }
                    }
                    if($kind->shoes_gr == 1) {
                        $anth = \app\models\PersAnthrop::find()
                            ->where('pers_id=:pers and name=:ant',
                                    [':pers'=>$model->id, ':ant'=> \app\models\PersAnthrop::shoes])
                            ->count();
                        if($anth == 0) {
                            $ant = new \app\models\PersAnthrop();
                            $ant->pers_id = $model->id;
                            $ant->name = \app\models\PersAnthrop::shoes;
                            $ant->save();
                        }
                    }
                    if($kind->glove_gr == 1) {
                        $anth = \app\models\PersAnthrop::find()
                            ->where('pers_id=:pers and name=:ant',
                                    [':pers'=>$model->id, ':ant'=> \app\models\PersAnthrop::glove])
                            ->count();
                        if($anth == 0) {
                            $ant = new \app\models\PersAnthrop();
                            $ant->pers_id = $model->id;
                            $ant->name = \app\models\PersAnthrop::glove;
                            $ant->save();
                        }
                    }
                    if($kind->head_gr == 1) {
                        $anth = \app\models\PersAnthrop::find()
                            ->where('pers_id=:pers and name=:ant',
                                    [':pers'=>$model->id, ':ant'=> \app\models\PersAnthrop::head])
                            ->count();
                        if($anth == 0) {
                            $ant = new \app\models\PersAnthrop();
                            $ant->pers_id = $model->id;
                            $ant->name = \app\models\PersAnthrop::head;
                            $ant->save();
                        }
                    }*/
//                }
//                return $this->redirect(['index', 'id' => $model->id]);
                } else {
                    \Yii::$app->session->setFlash('error','Некорректно введена дата - '.$model->start_date_temp);
                    $errormod = 'qq';
                }
            } else {
                \Yii::$app->session->setFlash('error','Некорректно введена дата - '.$model->start_date_temp);
                $errormod = 'qq';
            }
        }
        $searchModel = new PerslistSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'errormod' => $errormod,
            'model' => $model,
            'id' => $id,
        ]);
    }

    /**
     * Displays a single Perslist model.
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
     * Creates a new Perslist model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Perslist();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['index', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Perslist model.
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
//        $model = Perslist::findOne($id);
        $model = $this->findModel($id);
        if ($model->load(Yii::$app->request->post())) 
        {
            if(!Perslist::ValiteDate($model->start_date_temp)) {
                $errormod = 100;
//                throw new NotFoundHttpException('ww '.$errormod);
                \Yii::$app->session->setFlash('error','Некорректно введена дата - '.$model->start_date_temp);
                return $this->redirect(['/perslist/index',
                    'model'=>$model,
                    'id'=>$id,
                    'errormod' => $errormod,
                ]);
            }
//throw new NotFoundHttpException('Корректно введена дата - '.$model->start_date_temp);
            if (!$model->save()) {
                \Yii::$app->session->setFlash('error','Некорректные данные');
//                return $this->redirect(['/perslist/_form_updatemod',
                $model->errormod = true;
                return $this->redirect(['/perslist/index',
                    'id' => $id ,
                    'model'=>$model,
                    'errormod' => 100,
                ]);
            }  else {
                $errormod = 0;
                $model->errormod = false;
                return $this->redirect(['/perslist/index',
                    'id' => $id ,
                    'model'=>$model,
                    'errormod' => 0,
                ]);
            }
        } else {
            $model->errormod = false;
//            return $this->renderPartial('/perslist/_form_mod', [
            return $this->renderPartial('/perslist/_form_update_mod', [
                'id' => $id ,
                'model'=>$model,
                'errormod'=> 0,
                ]);
        }
    }

    /**
     * Deletes an existing Perslist model.
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
     * Finds the Perslist model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Perslist the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Perslist::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
