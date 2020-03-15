<?php

namespace frontend\controllers;

use app\models\MeasureUnit;
use app\models\Nomenkind;
use Yii;
use app\models\InorderSpec;
use app\models\search\InorderSpec as InorderSpecSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\data\ActiveDataProvider;

/**
 * InorderSpecController implements the CRUD actions for InorderSpec model.
 */
class InorderSpecController extends Controller
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

    public function actionGetTypeSize($nomen_id)
    {
        $model = InorderSpec::find()->one();
// Устанавливаем формат ответа JSON
        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        // Если пришёл AJAX запрос
        if (Yii::$app->request->post() && Yii::$app->request->isAjax) { 
                $kind = \app\models\Nomenkind::find()
                    ->leftJoin('nomenclature','nomenclature.kind_id=nomenkind.id')
                    ->where('nomenclature.id=:nomen_id',
                            [':nomen_id'=>$nomen_id]) //  $this->idsToint($id)])
                    ->one();
                //Если всё успешно, отправляем ответ с данными
//                Yii::error(print_r($Data, true));
                
               return $this->renderAjax('/inorder-spec/_form_mod',[
//                    'data' => $kind, //->id,
//                    'error' => null,
                    'id' => $kind->id,
                ]);
/*            } else {
                // Если нет, отправляем ответ с сообщением об ошибке
                return $this->renderAjax('_form_mod',[
                    "data" => null,
                    "error" => "error1"
                ]);
            }*/
        } else {
            // Если это не AJAX запрос, отправляем ответ с сообщением об ошибке
//            Yii::error(print_r($Data, true));
            return $this->renderAjax('/inorder-spec/_form_mod',[
//                'data' => null,
//                'error' => "error2",
                'id' => null, //$kind->id,
//                'model' => $model,
            ]);
        }
/*         if(\Yii::$app->request->isAjax){
            return 'Запрос принят!';
        }
       if(Yii::$app->request->getIsPost() && Yii::$app->request->getIsAjax()) {
            Yii::$app->response->format= \yii\web\Response::FORMAT_JSON;
            $NomenId = Yii::$app->request->post('nomen_id');
            $TypeSizeId = \app\models\Nomenkind::find()
                    ->leftJoin('nomenclature','nomenclature.kibd_id = nomenkind.id')
                    ->where('nomenclature.id=:nomen',[':nomen'=>$NomenId])
                    ->one();
            return $TypeSizeId;
        } else
            return '';*/
//        if($form_model->load(\Yii::$app->request->post())){
//            var_dump($form_model);
//        }        
//        return $this->render('page', compact('form_model'));
    }

        /**
     * Lists all InorderSpec models.
     * @return mixed
     */
    public function actionIndex($id=null)
    {
/*
        //        throw new NotFoundHttpException('qq');
        $model = new InorderSpec();
        if($id) {
            $model = InorderSpec::findOne($id);
            return $this->renderPartial('/inorder-spec/_form_mod', [
                'id' => $id ,
                'model'=>$model,
            ]);
        }*/

        $nomen_id = null;
        $nomen = new \app\models\Nomenclature();
        if ($nomen->load(Yii::$app->request->post())) 
        {
            if (!$nomen->save()) {
                \Yii::$app->session->setFlash('error','Некорректные данные номенклатора');
                return $this->render('/nomenclature/_form_updatemod', [
                    'id' => $id ,
                    'model'=>$model,
                ]);
            } else
                $nomen_id = $nomen->id;
            return $this->render('/inorder-spec/_form_spec', [
                'id' => $nomen_id,
                'model' => $nomen,
                'inspec' => $model,
                ]);
        } 
        
        $model = new \app\models\InorderSpec(); 

        if ($model->load(Yii::$app->request->post())) {
            $model->inorder_id = $id;
            $nomen = \app\models\Nomenclature::findOne($model->nomen_id);
            $model->is_siz = $nomen->code;
//определение разметочной группы
/*            $kind = Nomenkind::findOne($nomen->kind_id);
            if($kind->size_gr == 1)
                $model->s*/
            if(!$model->save()) {
                \Yii::$app->session->setFlash('error','Некорректные данные спецификации приходного ордера.');
                return $this->renderPartial('/inordrrspec/_form_mod',['id'=>$id]);
            }
            else {
//Запись складской операции в журнал складских операций
                $nomen_id = $model->nomen_id;
                $stoptype = \app\models\Stopertype::STADD;
                if(!\app\models\Storejournal::JournalRec($model->id,$stoptype))
                {
                    \Yii::$app->session->setFlash('error','Некорректные данные для Журнала операций');
                    return $this->renderPartial('/inordrrspec/_form_mod',['id'=>$id]);
                }
//Остатки с учетом склада, размеров и степени износа номенклатуры  
                $inorder = \app\models\Inorder::findOne($id);
                $store_id = $inorder->stoper_id;  
                $remain_id = \app\models\Storemain::RemainId($model->id,$store_id); 
                if($remain_id == 0) 
                {
//записи об остатках номенклатуры на складе нет, записываем первый приход
                    $remain = new \app\models\Storemain();
                    $remain->quant = $model->quant;
                    $remain->is_siz = $model->is_siz;
                    $remain->store_id = $inorder->store_id;
                    $remain->nomen_id = $model->nomen_id;
                    $remain->size_id = $model->size_id;
                    $remain->height_id = $model->height_id;
                    $remain->full_id = $model->full_id;
                    $remain->shirt_id = $model->shirt_id;
                    $remain->shoes_id = $model->shoes_id;
                    $remain->glove_id = $model->glove_id;
                    $remain->head_id = $model->head_id;
                    $remain->amout = 0;
        //================================================                
                } else 
                {
//определяем остатки номенклатуры на складе
                    $remain = \app\models\Storemain::findOne($remain_id);
//корректируем остатки номенклатуры на складе
                    $remain->quant = $remain->quant + $model->quant;
                }
                if(!$remain->save()) {
                    \Yii::$app->session->setFlash('error','Некорректные данные спецификации приходного ордера.');
                    return $this->render('/inorder-spec/_form_spec',['id'=>$id]);
                }
            }
        }
        $query = InorderSpec::find()
                ->where('inorder_id=:ord and actual=:act',[':ord'=>$id, ':act'=> InorderSpec::SPECATC]);
        $dataProvider = new ActiveDataProvider([
            'query'=>$query,
        ]);
        return $this->render('/inorder-spec/index', [
//            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'id' => $id, //$nomen_id,
        ]);
    }

    public function actionIndexNakl($id=null)
    {
        $order = \app\models\Inorder::findOne($id);
//Запись спецификации возвратной накладной
        $model = new \app\models\InorderSpec(); 
        if ($model->load(Yii::$app->request->post())) {
            $model->inorder_id = $id;
            $nomen = \app\models\Nomenclature::findOne($model->nomen_id);
            $model->is_siz = $nomen->code;
            if(!$model->save()) {
                \Yii::$app->session->setFlash('error','Некорректные данные спецификации приходного ордера.');
                return $this->renderPartial('/inordrrspec/_form_mod_nakl',['id'=>$id]);
            }
            else {
//Запись складской операции в журнал складских операций 
                $nomen_id = $model->nomen_id;
                $stoptype = \app\models\Stopertype::STRET;
                if(!\app\models\Storejournal::JournalRec($model->id,$stoptype))
                {
                    \Yii::$app->session->setFlash('error','Некорректные данные для Журнала операций');
                    return $this->renderPartial('/inordrrspec/_form_mod',['id'=>$id]);
                }
//Остатки с учетом склада, размеров и степени износа номенклатуры  
                $store_id = $model->store_id;  
                $remain_id = \app\models\Storemain::RemainId($model->id,$model->store_id); 
//        throw new \yii\web\NotFoundHttpException('remain_id: '.$id.' - '.$store_id.' - '.$remain_id);
                if($remain_id == 0) 
                {
                    $remain = new \app\models\Storemain();
                    $remain->quant = $model->quant;
                    $remain->is_siz = $model->is_siz;
                    $remain->store_id = $inorder->store_id;
                    $remain->nomen_id = $model->nomen_id;
                    $remain->size_id = $model->size_id;
                    $remain->height_id = $model->height_id;
                    $remain->full_id = $model->full_id;
                    $remain->shirt_id = $model->shirt_id;
                    $remain->shoes_id = $model->shoes_id;
                    $remain->glove_id = $model->glove_id;
                    $remain->head_id = $model->head_id;
                    $remain->amout = 0;
        //================================================                
                } else 
                {
                    $remain = \app\models\Storemain::findOne($remain_id);
                    $storem = \app\models\Storemain::findOne($remain_id);
                    $remain->quant += $model->quant;
                }
                if(!$remain->save()) {
                    \Yii::$app->session->setFlash('error','Некорректные данные спецификации приходного ордера.');
                    return $this->render('/inorder-spec/_form_spec_nakl',['id'=>$id]);
                }
//списать с карточки сотрудника возвращенное количество
//                throw new NotFoundHttpException('qq '.$order->id.' - '.$order->pers_id);
                $card = \app\models\NormCard::find()
                        ->where('pers_id=:pers',[':pers'=> $order->pers_id])
                        ->one();
                if(!$cardsp = \app\models\NormCardspec::find()
                        ->where('card_id=:card and nomen_id=:nomen and actual=:act',
                                [':nomen' => $model->nomen_id,
                                 ':card'=>$card->id,
                                 ':act' => InorderSpec::SPECATC])
                        ->one())
                {
                    \Yii::$app->session->setFlash('error',
                            'Указанной номенклатуры за сотрудником не числится.');
                } else {
                    $cardsp->quant_fct -= $model->quant;
                    $cardsp->save();
                }
            }
        }
        
        $query = InorderSpec::find()
                ->where('inorder_id=:ord and actual=:act',[':ord'=>$id, ':act'=> InorderSpec::SPECATC]);
        $dataProvider = new ActiveDataProvider([
            'query'=>$query,
        ]);
        return $this->render('/inorder-spec/index_nakl', [
//            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'id' => $id, 
        ]);
    }

    /**
     * Displays a single InorderSpec model.
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
     * Creates a new InorderSpec model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new InorderSpec();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['index', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing InorderSpec model.
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
        $quant_old = $model->quant;
        if ($model->load(Yii::$app->request->post())) 
        {
//Проверка остатков           
            $inorder = \app\models\Inorder::findOne($model->inorder_id);
            $store_id = $inorder->store_id;
            $remstore = \app\models\Storemain::RemainTest($id, $store_id);
            $journal = \app\models\Storejournal::find() //проверка складских операций с данной спецификацией
                    ->where('inordspec_id=:id and stoper_type=:tp',[':id'=>$id,':tp'=> \app\models\Storejournal::OPER_OUT])
                    ->all();
            if($journal or $remstore < $model->quant)
            {
                \Yii::$app->session->setFlash('error','По данной номенклатуре проведена складская операция. Удаление не допустимо.');
            } else 
            {
                if (!$model->save()) {
                    \Yii::$app->session->setFlash('error','Некорректные данные');
                    return $this->redirect(['/inorder-spec/updatemod', 
                        'id' => $id ,
                        'model'=>$model,
                    ]);
                }
//Запись складской операции в журнал складских операций 
                $nomen_id = $model->nomen_id;
                $stoptype = \app\models\Stopertype::STSPED;
                if(!\app\models\Storejournal::JournalRec($model->id,$stoptype))
                    \Yii::$app->session->setFlash('error','Некорректные данные для Журнала операций');
//Корректировка остатков на складе
                $remain_id = \app\models\Storemain::RemainId($model->id,$inorder->store_id);
                if($remain_id == 0)
                    \Yii::$app->session->setFlash('error','Остатков данной номенклатуры на складе нет.');
                else {
                    $remain = \app\models\Storemain::findOne($remain_id);
                    $remain->quant = $remain->quant + ($model->quant - $quant_old);
                    $remain->save();
                    
                }    
            }
                    return $this->redirect(['index','id'=>$model->inorder_id]);
        }
        return $this->renderPartial('/inorder-spec/_form_upd', [
//        return $this->redirect(['/inorder-spec/index',
                'model' => $model,
                'id' => $id,
            ]);
    }

    /**
     * Deletes an existing InorderSpec model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
//        throw new NotFoundHttpException('qq - '.$id);
//Остатки с учетом склада, размеров и степени износа номенклатуры  
        $spec = InorderSpec::findOne($id);
        $inorder = \app\models\Inorder::findOne($spec->inorder_id);
        $store_id = $inorder->store_id;
        $remstore = \app\models\Storemain::RemainTest($id, $store_id);
        $journal = \app\models\Storejournal::find()
                ->where('inordspec_id=:id and stoper_type=:tp',[':id'=>$id,':tp'=> \app\models\Storejournal::OPER_OUT])
                ->all();
        if($journal or $remstore < $spec->quant)
        {
            \Yii::$app->session->setFlash('error','По данной номенклатуре проведена складская операция. Удаление не допустимо.');
        } else 
        {
            $spec->actual = 0;
            $spec->quant = $spec->quant - $remstore;
            $spec->save(false);
//Запись складской операции в журнал складских операций 
            $nomen_id = $spec->nomen_id;
            $stoptype = \app\models\Stopertype::STSPDEL;
            if(!\app\models\Storejournal::JournalRec($spec->id,$stoptype))
                \Yii::$app->session->setFlash('error','Некорректные данные для Журнала операций');
//Корректировка остатков на складе
            $remain_id = \app\models\Storemain::RemainId($spec->id,$inorder->store_id);
            if($remain_id == 0)
                \Yii::$app->session->setFlash('error','Остатков данной номенклатуры на складе нет.');
            else {
                $remain = \app\models\Storemain::findOne($remain_id);
                $remain->quant = $remain->quant - $spec->quant;
                $remain->save();
            }    
        }
            
        return $this->redirect(['index','id'=>$spec->inorder_id]);
    }

    /**
     * Finds the InorderSpec model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return InorderSpec the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = InorderSpec::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
