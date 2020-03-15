<?php

namespace frontend\controllers;

use app\models\NormCard;
use app\models\Perslist;
use Yii;
use app\models\NormCardspec;
use app\models\search\NormCardspec as NormCardspecSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * NormCardspecController implements the CRUD actions for NormCardspec model.
 */
class NormCardspecController extends Controller
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
     * Lists all NormCardspec models.
     * @return mixed
     */
    public function actionIndex($id,$norm_id=null)
    {
        if($norm_id) {
            $model = \app\models\NormCard::find()
                    ->leftJoin('norm_cardspec','norm_cardspec.card_id=norm_card.id')
                    ->where('norm_cardspec.id=:spec',[':spec'=>$norm_id])
                    ->one();
        } else {
            $model = \app\models\NormCard::findOne($id);
        }
        $title = 'Карточка сотрудника '.$model->PersName;
        $query = NormCardspec::find()->where('card_id=:card',[':card'=>$id]);
        $dataProvider = new \yii\data\ActiveDataProvider([
                'query' => $query]);

        $card = \app\models\NormCard::findOne($id);
        return $this->render('index', [
            'dataProvider' => $dataProvider,
            'card' => $card,
            'title' => $title,
        ]);
    }


    public function actionCardnormNew($id=null)
    {
//        throw new NotFoundHttpException('qq');
        if(!NormCard::CardStaff(id)) {
            \Yii::$app->session->setFlash('error', 'Отсутствуют нормы на выбранную должность.');
            $query = NormCardspec::find()->where('card_id=0');
            $card = null;
        } else {
            $card = NormCard::find()->where('pers_id=:pers',[':pers'=>$id])->one();
            $model = NormCardspec::find()->where('card_id=:card', [':card' => $card->id])->all();
            $model = new NormCardspec();
            $query = NormCardspec::find()->where('card_id=:card and actual=:act',
                [':card' => $card->id, ':act' => NormCardspec::CARDSPECYES]);
        }
        $pers = Perslist::findOne($id);
        $title = 'Сотрудник '.$pers->abbr_name.'. Карточка сотрудника.';
        $dataProvider = new \yii\data\ActiveDataProvider([
            'query' => $query]);
        return $this->render('/norm-cardspec/card_norm', [
            'dataProvider' => $dataProvider,
            'card' => $card,
            'title' =>$title,
        ]);
    }

    public function actionCardNorm($id)
    {
        $pers = Perslist::findOne($id);
        $title = 'Сотрудник '.$pers->abbr_name.'. Карточка сотрудника.';
        if($card = NormCard::find()->where('pers_id=:pers',[':pers'=>$id])->one()) {
            $model = NormCardspec::find()->where('card_id=:card', [':card' => $card->id])->all();
            $model = new NormCardspec();
            $query = NormCardspec::find()->where('card_id=:card and actual=:act',
                [':card' => $card->id, ':act' => NormCardspec::CARDSPECYES]);
        } else {
            if(!NormCard::CardStaff($id)) {
                \Yii::$app->session->setFlash('error', 'Отсутствуют нормы на должность '.$pers->ProfName);
                $query = NormCardspec::find()->where('card_id=0');
            }
        }
        $dataProvider = new \yii\data\ActiveDataProvider([
            'query' => $query]);
        return $this->render('/norm-cardspec/card_norm', [
            'dataProvider' => $dataProvider,
            'card' => $card,
            'title' =>$title,
            'model' => $pers,
        ]);
    }

    public function actionIndexNorm($id, $norm_id=null)
    {
        if($norm_id) {
            $card = \app\models\NormCard::find()
                    ->leftJoin('norm_cardspec','norm_cardspec.card_id=norm_card.id')
                    ->where('norm_cardspec.id=:id',[':id'=>$norm_id])
                    ->one();
        } else {
            $card = \app\models\NormCard::findOne($id);
        }
        $title = 'Сотрудник '.$card->PersName.'. Спецификация нормы.';
        $model = new NormCardspec();
        if($model->load(Yii::$app->request->post())) {
//            throw new NotFoundHttpException('qq '.$norm_id.' - '.$id);
            $norm = \app\models\NormlistSpec::find()
                    ->where('nomen_id=:nomen',[':nomen'=>$model->nomen_id])
                    ->one();
            $model->period = $norm->period;
            $model->card_id=$card->id;
            $model->save();
            $card = \app\models\NormCard::find()
                    ->leftJoin('norm_cardspec','norm_cardspec.card_id=norm_card.id')
                    ->where('norm_cardspec.id=:id',[':id'=>$model->id])
                    ->one();
        }
        $query = NormCardspec::find()->where('card_id=:card and actual=:act',
                [':card'=>$card->id, ':act'=> NormCardspec::CARDSPECYES]);
//        $searchModel = new NormCardspecSearch();
//        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $dataProvider = new \yii\data\ActiveDataProvider([
                'query' => $query]);

        $card = \app\models\NormCard::findOne($id);
        return $this->render('index_norm', [
//            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'card' => $card,
            'title' =>$title,
        ]);
    }


    /**
     * Displays a single NormCardspec model.
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
     * Creates a new NormCardspec model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new NormCardspec();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['index', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    public function actionInsertmod($id)
    {
//        throw new NotFoundHttpException('insertmod '.$id.' - ');
        if(!$model = InvoiceSpec::findOne($id))
                $model = new InvoiceSpec ();
        if($nomen->load(Yii::$app->request->post()) && $model->save()) 
            return $this->render('create_spec', ['model' => $model,]);
        
        return $this->renderPartial('/invoice-spec/create_mod', [
            'model' => $model
            ]);
    }

    public function actionCreateSpec($id=null)
    {
//        throw new NotFoundHttpException('createspec '.$id);
        $invoice = \app\models\Invoice::findOne($id);
        if (!$invoice->load(Yii::$app->request->post()) && $invoice->save()) {
            \Yii::$app->session->setFlash('error','Некорректные данные номенклатора');
        }
//Антропологические параметры
        $anthrop = \app\models\PersAnthrop::find()
                ->where('pers_id=:pers',[':pers'=>$invoice->pers_id]);
//Карточка сотрудника
        $card = \app\models\NormCardspec::find()
                ->leftJoin('norm_card','norm_card.id=norm_cardspec.card_id')
                ->where('norm_card.pers_id=:pers',[':pers'=>$invoice->pers_id]);
//Наличие на складе
        $card_nom = $card->one();
        $remain = \app\models\Storemain::find()
                ->where('nomen_id=:nomen',[':nomen'=>$card_nom->nomen_id]);
//        throw new NotFoundHttpException('inspec-create: '.$id.' - '.$invoice->pers_id);

        return $this->render('create_spec', [
            'anthrop' => $anthrop,
            'card' => $card,
            'remain' => $remain,
            'id' => $id,
        ]);
    }

    /**
     * Updates an existing NormCardspec model.
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
                return $this->redirect(['/norm-cardspec/updatemod', 
//                return $this->redirect(['/inorder-cardspec/updatemod', 
                    'id' => $id ,
                    'model'=>$model,
                ]);
            }  else {
            return 
                $this->redirect(['/norm-cardspec/index', 
//                $this->redirect(['/inorder-cardspec/index', 
                'norm_id' => $model->id ,
                'id' => $model->card_id,
                'model'=>$model,
                ]);
            }
        } else {
//            return $this->renderPartial('/inorder-cardspec/_form_mod', [
            return $this->renderPartial('/norm-cardspec/_form_mod', [
                'id' => $id ,
                'model'=>$model,
                ]);
        }
    }

    public function actionUpdatemodNorm($id)
    {
//        throw new NotFoundHttpException('qq '.$id);
        $model = $this->findModel($id);
        
        if ($model->load(Yii::$app->request->post())) 
        {
            if (!$model->save()) {
                \Yii::$app->session->setFlash('error','Некорректные данные');
                return $this->redirect(['/norm-cardspec/updatemod-norm', 
//                return $this->redirect(['/inorder-cardspec/updatemod', 
                    'id' => $id ,
                    'model'=>$model,
                ]);
            }  else {
            return 
                $this->redirect(['/norm-cardspec/index-norm', 
//                $this->redirect(['/inorder-cardspec/index', 
                'id' => $model->card_id,
                'norm_id' => $model->id ,
                'model'=>$model,
                ]);
            }
        } else {
//            return $this->renderPartial('/inorder-cardspec/_form_mod', [
            return $this->renderPartial('/norm-cardspec/_form_mod_norm', [
                'id' => $id ,
                'model'=>$model,
                ]);
        }
    }

    /**
     * Deletes an existing NormCardspec model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index', 'id'=>$id]);
    }

    public function actionDeleteNorm($id)
    {
//        throw new NotFoundHttpException('qq '.$id);
        $model = NormCardspec::findOne($id);
        $old_value = $model->actual;
        $opername = 'Не актуально';
        $card_id = $model->card_id;
//        throw new NotFoundHttpException('qq '.$id.' - '.$card_id);
        $model->actual = NormCardspec::CARDSPECNO; //  delete();
        $model->save();
        \app\models\Operjournal::Operjournal_insert($model,$opername,$old_value);
//        $this->findModel($id)->delete();

        return $this->redirect(['index-norm', 'id'=>$card_id]);
    }

    /**
     * Finds the NormCardspec model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return NormCardspec the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = NormCardspec::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
