<?php

namespace frontend\controllers;

use Yii;
use app\models\Userlist;
use app\models\search\Userlist as UserlistSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use app\models\User;

/**
 * UserlistController implements the CRUD actions for Userlist model.
 */
class UserlistController extends Controller
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
     * Lists all Userlist models.
     * @return mixed
     */
    public function actionIndex()
    {
        $model = new Userlist();
        if ($model->load(Yii::$app->request->post())) {
//Регистрация пользователя            
            $usr = new User();
            $usr->username = $model->login;
            $usr->auth_key = \Yii::$app->security->generateRandomString();
            $usr->password_hash = Yii::$app->security->generatePasswordHash($model->pass1);
            $usr->create_at = time();
            $usr->pers_id = $model->pers_id;
            $usr->save();
//Запись пользователя
            $pers = \app\models\Perslist::findOne($model->pers_id);
            $model->family_name = $pers->family_name;
            $model->first_name = $pers->first_name;
            $model->second_name = $pers->second_name;
            $model->staff_id = $pers->staff_id;
            $model->prof_id = $pers->prof_id;
            $model->actual = 0;
            $model->user_id = $usr->id;
            if($model->save()) 
                return $this->redirect(['index', 'id' => $model->id]);
            else 
                \Yii::$app->session->setFlash('error', 'Не корректно введены данные');
        }
        
        $searchModel = new UserlistSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Userlist model.
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
     * Creates a new Userlist model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Userlist();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Userlist model.
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
     * Requests password reset.
     *
     * @return mixed
     */
    public function actionResetPswd($id)
    {
        $usrl = \app\models\search\Userlist::findOne($id);
        $model = \app\models\User::findOne($usrl->user_id);
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($model->newPass1===$model->newPass2 && $model->newPass1) {
                $model->password_hash = Yii::$app->security->generatePasswordHash($model->newPass1);
                $model->auth_key = Yii::$app->security->generateRandomString();        
//throw new NotFoundHttpException('qq - '.$model->newPass1.' - '.$model->password_hash.' - '.$model->id.' - '.$model->auth_key);
                $model->save();
                return $this->redirect('/userlist/index');
//                return $this->goHome();
            } else {
                Yii::$app->session->setFlash('error', 'Некорректно введен паспорт.');
                return $this->renderPartial('/userlist/reset_pswd',['id' => $usrl->user_id]);
            }
        }
        return $this->renderPartial('/userlist/reset_pswd',['id' => $usrl->user_id]);
    }
    public function actionChangeStat($id)
    {
//        throw new NotFoundHttpException('qq - '.$id);
        $model = \app\models\Userlist::findOne($id);
        if ($model->load(Yii::$app->request->post())) {
            
            if ($model->save()) {
                $searchModel = new UserlistSearch();
                $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

                return $this->render('index', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
                ]);
                
//                return $this->redirect('/userlist/index');
//                return $this->goHome();
            } else {
                Yii::$app->session->setFlash('error', 'Некорректно указан статус.');
                return $this->renderPartial('/userlist/change_stat',['id' => $id]);
            }
        }
        return $this->renderPartial('/userlist/change_stat',['id' => $id]);
    }


    /**
     * Deletes an existing Userlist model.
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
     * Finds the Userlist model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Userlist the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Userlist::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
