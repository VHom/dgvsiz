<?php 

namespace frontend\controllers;

use app\models\Invoice;
use app\models\NormCard;
use app\models\NormCardspec;
use app\models\PersAnthrop;
use app\models\Perslist;
use Symfony\Component\Debug\Exception\ClassNotFoundException;
use Yii;
use app\models\InvoiceSpec;
use app\models\search\InvoiceSpec as InvoiceSpecSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\data\ActiveDataProvider;

/**
 * InvoiceSpecController implements the CRUD actions for InvoiceSpec model.
 */
class InvoiceSpecController extends Controller
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

    public function actionAnthropList($id)
    {
        $card = NormCard::find()
            ->leftJoin('norm_cardspec','norm_cardspec.card_id=norm_card.id')
            ->where('norm_cardspec.id=:spec',[':spec'=>$id])
            ->one();
        $list = '';
        foreach (PersAnthrop::find()->where('pers_id=:pers',[':pers'=>$card->pers_id])
            ->all() as $rec) {
            $list = $list.' '.$rec->name.' '.$rec->val;
        }
        if($list)
        {
            echo $this->renderPartial ('anthrop_list',
                [
//                    'id'=>$id,
                    'anthrop'=>$list,
//                    'work_id'=>$id,
                ]);
        } else
            echo "Сведений нет";
    }


    public function actionIndexList($id)
    {
        $list= $remain = \app\models\search\Storemain::find ()
            ->leftJoin('norm_cardspec','norm_cardspec.nomen_id=storemain.nomen_id')
            ->where('norm_cardspec.id=:cds',[':cds'=>$id])
            ->all();
        if($list)
        {
            echo $this->renderPartial ('index_list',
                [
                    'id'=>$id,
                    'work'=>$list,
                    'work_id'=>$id,
                ]);
        } else
            echo "Сведений нет";
    }


    /**
     * Lists all InvoiceSpec models.
     * @return mixed
     */
    public function actionIndex($id=null)
    {
        if($id) 
            $model = InvoiceSpec::findAll ('inorder_id=:inv',[':inv'=>$id]);
        else
            $model = new InvoiceSpec();
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
            return $this->render('/invoice-spec/_form_spec', [
                'id' => $id,
                'model' => $nomen,
                'inspec' => $model,
                ]);
        } 
        
        $searchModel = new InvoiceSpecSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $query = InvoiceSpec::find()
                ->where('invoice_id=:id',[':id'=>$id]);
        $dataProvider = new ActiveDataProvider([
            'query' => $query
        ]);
        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            
            'id' => $id,
        ]);
    }

    public function actionIndexDestr($id=null)
    {
        if($id)
            $inv = \app\models\Invoice::findOne ($id);
//        $model = new InvoiceSpec();
        $searchModel = new \app\models\search\Storemain();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $query = \app\models\search\InvoiceSpec::find()
                ->andWhere('invoice_id=:inv',[':inv'=>$id]);
        $dataProvider = new ActiveDataProvider([
            'query'=>$query,
        ]);
//        $model = $query->all();
//        $searchModel = new InvoiceSpecSearch();
//        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
//        throw new NotFoundHttpException('qq-'.$id);
        return $this->render('index_destr', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'id' => $id, //$model->id,
//            'filter' => $filter,
        ]);
    }

    public function actionForm_mod()
    {
        $model = new \app\models\Storemain();
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['index', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    public function actionInsertmod($id=null,$spec_id=null)
    {   
        $model = new InvoiceSpec ();
        $speccard = \app\models\NormCardspec::find()
                ->where('actual =:actual',['actual'=> \app\models\NormCardspec::CARDSPECUND]) 
               ->one();
        $invoice_id = $speccard->invoice_id;
        $model->invoice_id = $invoice_id;
        $invoice = \app\models\Invoice::findOne($invoice_id);
        $model->remain_id = $id;
        if($model->load(Yii::$app->request->post())) {
            $remain = \app\models\Storemain::findOne($id);
            if($model->quant > $remain->quant) 
            {
                $nomen = \app\models\search\Nomenclature::find()
                        ->leftJoin('storemain','storemain.nomen_id=nomenclature.id')
                        ->where('storemain.id=:rem_id',[':rem_id'=>$model->remain_id])
                        ->one();
                \Yii::$app->session->setFlash('error','Запрошенное количество номенклатуры "'.$nomen->name.'" превышает остаток на складе.');
                return $this->redirect(['create-spec', 'id'=>$model->invoice_id]);
            }
// Записываем спецификацию накладной                           
            $model->remain_id=$id;
            $model->store_id = $remain->store_id;
            $model->oper_id = Yii::$app->user->id;
            $model->oper_date = time();
            if(!$model->save()) {
                \Yii::$app->session->setFlash('error','Некорректные данные накладной');
                return $this->redirect(['create-spec', 'id'=>$model->invoice_id]);
            } else {
// Запись в спецификацию карточки сотрудника фактически выданного количества
//                $speccard->date_in = $model->oper_date;
                $speccard->quant_fct = $model->quant;
                $speccard->analog_id = $model->remain_id;
                $speccard->invoice_id = $model->invoice_id;
                $date_end = \app\models\NormCardspec::DateEnd ($invoice->doc_date, $speccard->period);
                $date_end = strtotime($date_end);
                $speccard->date_out = $date_end;
                $count = $model->quant;
//                throw new NotFoundHttpException('qq '.$speccard->quant_fct.'- '.$speccard->analog_id.' - '
//                        .$speccard->invoice_id.' - '.$date_end.' - '.$date_end.' - '.$speccard->date_out.
//                        ' - '.$invoice->doc_date.' - '.$speccard->period);
                foreach (\app\models\search\NormCardspec::find()
                    ->where('nomen_id=:nomen and actual=:actual and card_id=:card',
                            [':nomen'=>$speccard->nomen_id,
                             ':actual'=> \app\models\NormCardspec::CARDSPECYES,
                             ':card'=>$speccard->card_id])
                    ->orderBy('date_in')->all() as $rec)
                {
                    if($count>0)
                    {
                        $rec->analog_id = $model->remain_id;
                        $rec->date_in = $invoice->doc_date;
                        $rec->date_out = $date_end;
                        if($rec->quant_fct == 0)
                        {
                            if($rec->quant > $count) {
                                $rec->quant_fct=$rec->quant_fct- $count;
                                $rec->save();
                                $speccard->actual = \app\models\NormCardspec::CARDSPECYES;
                                $count = 0;
                            } else {
                                $rec->quant_fct = $count;
//                                $rec->date_in = $invoice->doc_date;
                                $rec->invoice_id = $model->invoice_id;
                                $rec->save();
                                $count = 0;
                            }
                        } else {
                            if($count > $rec->quant_fct)
                            {
                                $rec->actual = \app\models\NormCardspec::CARDSPECNO;
                                $rec->date_out = $model->oper_date;
                                $rec->save();
                                $count = $count - $rec->quant_fct;
                            } else
                            {
                                if($count == $rec->quant_fct)
                                {
//                                    throw new NotFoundHttpException('qq '.$count.' - '.$rec->quant_fct);
                                    $rec->actual = \app\models\NormCardspec::CARDSPECNO;
                                    $rec->date_out = $model->oper_date;
                                    $rec->save();
                                    $speccard->actual = \app\models\NormCardspec::CARDSPECYES;
                                    $count = 0;
                                } else {
                                    $rec->quant_fct = $rec->quant_fct - $count;
                                    $rec->save();
                                    $speccard->actual = \app\models\NormCardspec::CARDSPECYES;
                                    $count = 0;
                                }  
                            }
                        }
                    }
                }
//                if($count > 0)
//                    $speccard->actual = \app\models\NormCardspec::CARDSPECYES;
                $speccard->date_in = $invoice->doc_date;
                $speccard->actual = \app\models\NormCardspec::CARDSPECUND;
                $speccard->date_in = null;
                $speccard->quant = 0;
                $speccard->nomen_id = null;
                $speccard->quant_fct = 0;
                $speccard->analog_id = null;
                $speccard->period = null;
                $speccard->save();
//                throw new NotFoundHttpException('qq');
// Корректировка остатков на складе 
                $remain->quant = $remain->quant - $model->quant;
                $remain->save();
                
// Регистрация складской операции в журнале
                $invoice_spec_id = $model->id;
                $stopertype = \app\models\Stopertype::STSUB;
                \app\models\Storejournal::JournalRec($invoice_spec_id,$stopertype);
                return $this->redirect(['/invoice-spec/create-spec', 'id'=>$model->invoice_id]);
           }
        }
        return $this->renderPartial('create_mod', [
            'model' => $model, 
            'id' => $id,
            'invoice_id' => $invoice_id, //$id,
            ]);
    }


    /**
     * Displays a single InvoiceSpec model.
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
     * Creates a new InvoiceSpec model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate($id=null)
    {
//        throw new NotFoundHttpException('inspec-create');
        if($id)
            $model = \app\models\InorderSpec::findOne ($id);
        else
            $model = new InvoiceSpec();
        $nomen = new \app\models\Nomenclature();
        if($nomen->load(Yii::$app->request->post()) && $model->save()) 
            return $this->redirect(['index', 'id' => $model->id]);
        else
            return $this->render('create',[
                'model'=>$nomen, //  $model,
//                'nomen'=>$nomen,
            ]);
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['index', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    public function actionCreateMod($id)
    {
        $model = InvoiceSpec::findOne ($id);
        $kind = \app\models\Nomenkind::find()
                ->leftJoin('nomenclature','nomencklature.kind_id=nomenkind.id')
                ->where('nomenclature.id=:nomen',[':nomen'=>$id])
                ->one();
        $nomen = \app\models\Nomenclature::find()
                ->where('kind_id=:kind',[':kind'=>$kind->id])
                ->all();
//------------------------------------------------------------------------------        
        $invoice = \app\models\Invoice::findOne($model->invoice_id);
//Антропологические параметры
        $anthrop = \app\models\PersAnthrop::find()
                ->where('pers_id=:pers',[':pers'=>$invoice->pers_id]);
//Карточка сотрудника
        $card = \app\models\NormCardspec::find()
                ->leftJoin('norm_card','norm_card.id=norm_cardspec.card_id')
                ->where('norm_card.pers_id=:pers',[':pers'=>$invoice->pers_id]); 
        $remain = \app\models\Storemain::find()
                ->leftJoin('nomenclature','nomenclature.id=storemain.nomen_id')
                ->where('nomenclature.kind_id=:kind',
                        [':kind'=>$kind->id])
                ->all();        
        
        return $this->render('create_spec', [
            'anthrop' => $anthrop,
            'card' => $card,
            'remain' => $remain,
            'id' => $model->invoice_id,
            'rem_id' =>$rem_model->id,
        ]);
    }

    public function actionCreateSpec($id=null,$spec_id=null)
    {
        if(!$spec_id) {
            $spec = NormCardspec::find()->where('card_id = :card',[':card'=>$id])->one();
            $cardspec_id = $spec->id;
            $pers = Perslist::find()
                ->leftJoin('norm_card', 'norm_card.pers_id = perslist.id')
                ->where('norm_card.id = :insp', [':insp' => $id])
                ->one();
            $card = \app\models\NormCard::findOne($id);
            $card_id = $id;
        } else {
            $card = \app\models\NormCard::find()
                ->leftJoin('norm_cardspec','norm_cardspec.card_id=norm_card.id')
                ->where('norm_cardspec.id = :insp', [':insp' => $spec_id])
                ->one();
            $pers = Perslist::find()
                ->leftJoin('norm_card', 'norm_card.pers_id = perslist.id')
                ->where('norm_card.id = :insp', [':insp' => $card->id])
                ->one();
            $cardspec_id = $spec_id;
            $card_id = $card->id;
        }
//        throw new NotFoundHttpException('qq - '.$id.' - '.$card_id);
        $pers_name = $pers->abbr_name;
//=============================================================================
//Спецификация карточки сотрудника
        $card_spec = \app\models\NormCardspec::find()
            ->where('card_id=:card and norm_cardspec.actual=:act',[
                ':card'=>$card_id,
                ':act'=> \app\models\NormCardspec::CARDSPECYES]);
        $npp = 0;
        $stat = 0;
        foreach ($card_spec->all() as $rec) {
            if($rec->id == $cardspec_id) {
                $rec->active = 1;
                $stat = 1;
            }
            else {
                $rec->active = 0;
                if($stat == 0)
                    $npp = $npp + 1;
            }
            $rec->save();
        }
        $card_nom = NormCardspec::findOne($cardspec_id);
//        $card_spec->offset($npp);
//throw new NotFoundHttpException('qq - '.$stch.' - '.$stat);
//==============================================================================
//Антропологические параметры
        $anthrop = \app\models\PersAnthrop::find()
            ->where('pers_id=:pers',[':pers'=>$card->pers_id]);
//==============================================================================
//Остатки на складе
        $kind = \app\models\Nomenkind::find()
            ->leftJoin('nomenclature','nomenclature.kind_id = nomenkind.id')
            ->leftJoin('norm_cardspec','norm_cardspec.nomen_id = nomenclature.id')
            ->where('norm_cardspec.nomen_id = :nomen',[':nomen'=>$card_nom->nomen_id])
            ->one();
        $remain = \app\models\search\Storemain::find ()
            ->leftJoin ('nomenclature','nomenclature.id=storemain.nomen_id')
            ->where('nomenclature.kind_id=:kind',[':kind'=>$kind->id]);
//==============================================================================
        return $this->render('/invoice-spec/create_spec', [
            'anthrop' => $anthrop,
            'card' => $card_spec,
            'remain' => $remain,
            'id' => $card->id, //$id,
            'spec_id' =>$spec_id,
            'pers_name' => $pers_name,
//            'npp' => $npp,
        ]);
    }

    public function actionCreateSpecDistr($id=null)
    {
        $user_id = \Yii::$app->user->id;
        
        if($invspec= InvoiceSpec::find()
                ->where('oper_id=:oper and remain_id is null',
                        [':oper'=>$user_id])
                ->all()) {
            foreach ($invspec as $rec) {
                $rec->delete();
            }
        }
        $invspec = new InvoiceSpec();
        $invspec->invoice_id= $id;
        $invspec->oper_id = $user_id;
        $invspec->save();
//        throw new NotFoundHttpException('qq '.$user_id.' - '.$id);
        if(!$filter = \app\models\FilterStrem::find()
                ->where('user_id=:usr',[':usr'=>$user_id])
                ->one())
            $filter = new \app\models\FilterStrem ();
        
/*        $query = \app\models\Storemain::find()
                ->where('actual=0 and user_id=:usr',
                        [':usr'=>$user_id]);*/
        
//Нажата кнопка Найти
        If(\Yii::$app->request->post('submit')=='findrec')
        {
            if($filter->load(\Yii::$app->request->post()))
            {
                $filter->user_id = $user_id;
                $filter->save();
            }
        } else if(\Yii::$app->request->post('submit')=='clearrec')
        {
//            throw new NotFoundHttpException('ee');
            $filter->amort = '';
            $filter->full_id = '';
            $filter->glove_id = '';
            $filter->head_id = '';
            $filter->heigth_id = '';
            $filter->is_siz = '';
            $filter->nomen_id = '';
            $filter->shirt_id = '';
            $filter->size_id = '';
            $filter->store_id = '';
            $filter->save(false);
            $filter->refresh();
        }
                
        if($id) {
        $inv = \app\models\Invoice::findOne($id);
//==============================================================================        
        $remain = \app\models\Storemain::find()
                ->where('store_id=:str',[':str'=>$inv->store_id]);
       } else 
           $remain = new \app\models\Storemain ();
        $searchModel = new \app\models\search\Storemain;
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
       
       return $this->render('create_spec_distr', [
//            'remain' => $remain,
           'searchModel' => $searchModel,
           'dataProvider' => $dataProvider,
           'id' => $id,
           'filter' => $filter,
        ]);
    }

    /**
     * Updates an existing InvoiceSpec model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
//        throw new NotFoundHttpException('inspec-updatemod');
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    public function actionUpdatemod($id)
    {
//        throw new NotFoundHttpException('inspec-updatemod - '.$id);
/*        $inv = \app\models\Invoice::findOne($id);
        $rem = \app\models\search\Storemain::find()
                ->where('store_id=:str',[':str'=>$inv->store_id])
                ->all();*/
/*        $model = InvoiceSpec::find()
                ->where('invoice_id=:inv', [':inv'=>$id])
                ->all();*/
        $model = $this->findModel($id);
        if ($model->load(Yii::$app->request->post())) {
            $remain = \app\models\Storemain::findOne($model->remain_id);
            if($model->quant>$remain->quant) {
                \Yii::$app->session->setFlash('error','Количество превышает остатки на складе');
                return $this->renderPartial('_form_spec', [
//        return $this->render('update', [
                    'model' => $model //$rem, //,
                ]);
            }
            $model->save();
            return $this->redirect(['index', 'id' => $model->id]);
        }
        return $this->renderPartial('_form_spec', [
//        return $this->render('update', [
            'model' => $model //$rem, //,
        ]);
    }

    /**
     * Deletes an existing InvoiceSpec model.
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
     * Finds the InvoiceSpec model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return InvoiceSpec the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = InvoiceSpec::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
