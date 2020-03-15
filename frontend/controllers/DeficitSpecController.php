<?php

namespace frontend\controllers;

use Yii;
use app\models\DeficitSpec;
use app\models\search\DeficitSpec as DeficitSpecSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\data\ActiveDataProvider;

/**
 * DeficitSpecController implements the CRUD actions for DeficitSpec model.
 */
class DeficitSpecController extends Controller
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
    
    public function actionIndexList($id)
    {
//        throw new NotFoundHttpException('qq '.$id);
         $list= \app\models\DeficitBuffer::find()
                 ->leftJoin('deficit_spec','deficit_spec.statement_id=deficit_buffer.statement_id and '
                         . 'deficit_spec.nomen_id=deficit_buffer.nomen_id')
                ->where('deficit_spec.id=:id',[':id'=>$id])
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
    
    public function actionAddselect($id)
    {
//        throw new NotFoundHttpException('qq - '.$id);
        foreach(\app\models\DeficitOrderspec::find()
                ->where('statement_id=:ord',[':ord'=>$id])
                ->all() as $ord)
        {
            $ord->delete();
        }
        foreach (DeficitSpec::find()->where('statement_id=:ord',[':ord'=>$id])
                ->all() as $spec)
        {
            $spec->sign_choice = 0;
            $spec->save();
        }
        $check = \Yii::$app->request->post('selection');
//        var_dump($check);
        foreach ($check as $item)
        {
//            throw new NotFoundHttpException('qq - '.$item);
            $spec = DeficitSpec::findOne($item);
            $spec->sign_choice = 1;
            $spec->save();
            $order = new \app\models\DeficitOrderspec();
            $order->statement_id = $id;
            $order->nomen_name = $spec->def_name;
            $order->quant = $spec->def_quant;
            $order->status = 1;
            $order->type = 0;
            $order->oper_id = \Yii::$app->user->id;
            $order->oper_date = time();
            $order->spec_id = $spec->id;
            if(!$order->save())
                throw new NotFoundHttpException('qq: '.$order->statement_id.' - '.$order->nomen_name.' - '
                        .$order->quant.' - '.$order->status.' - '.$order->type.' - '.$order->oper_id
                        .' - '.$order->oper_date.' - '.$order->spec_id);
        }
        return $this->redirect([
            '/deficit-orderspec/index',
            'id'=>$id]); 
    }

/*    public function actionDeselect($id)
    {
        $model = DeficitSpec::findOne($id);
            $model->sign_choice= 0;
            $model->save();
        return; 
    }*/

    /**
     * Lists all DeficitSpec models.
     * @return mixed
     */
    public function actionIndex($id)
    {
        $statement = \app\models\DeficitStatment::findOne($id);
        
        if(!$model = DeficitSpec::find()
                ->where('statement_id=:stat',[':stat'=>$id])
                ->all())
        {
//        throw new NotFoundHttpException('qq '.$id.' - '.$model->date_report);
//Формирование буфера (развернутой спецификации)

            foreach (\app\models\NormCardspec::find()
                    ->leftJoin('norm_card','norm_card.id=norm_cardspec.card_id')
                    ->leftJoin('perslist','perslist.id=norm_card.pers_id')
                    ->leftJoin('deficit_statment','deficit_statment.staff_id=perslist.staff_id')
                    ->where('deficit_statment.id=:id and (norm_cardspec.date_out is null or norm_cardspec.date_out < :tdate)',
                            [':id'=>$id, ':tdate'=>$statement->date_report])
                    ->orderBy('norm_cardspec.nomen_id')
                    ->all() as $rec)
//            $check=Yii::$app->request->post('selection');
//            foreach ($check as $rec)
            {
//плановые номенклатура и количество из карточки                        
                $nomen = \app\models\Nomenclature::findOne($rec->nomen_id);
                $card = \app\models\NormCard::findOne($rec->card_id);
                $def_name = \app\models\DeficitSpec::DeficitNomenSize($card->pers_id, $rec->nomen_id);

                $buff = new \app\models\DeficitBuffer();
                $buff->nomen_id = $rec->nomen_id;
                $buff->quant = $rec->quant;
                $buff->kind_id = $nomen->kind_id;
                $buff->pers_id = $card->pers_id;
                $buff->def_name = $def_name;
                $buff->def_quant = $rec->quant_fct;
                $buff->statement_id = $id;
                $buff->def_date = $rec->date_out; 
//фактическая номенклатураи количество из карточки
                if($rec->analog_id)
                {
                    $nomen_fact = \app\models\Nomenclature::find()
                            ->leftJoin('storemain','storemain.nomen_id=nomenclature.id')
                            ->where('storemain.id=:remain',[':remain'=>$rec->analog_id])
                            ->one();
//                    $buff = new \app\models\DeficitBuffer();
                    $buff->def_name_fact = \app\models\DeficitSpec::DeficitNomenSizeFact($rec->analog_id);
                    $buff->quant_fact = $rec->quant_fct;
                    $buff->nomen_fact = $rec->analog_id;
                } else {
                    $buff->quant_fact = '';
                    $buff->nomen_fact = '';
                    $buff->def_name_fact = '';
                }
/*                if($rec->nomen_id==2)
                    throw new NotFoundHttpException('qq '.$buff->nomen_fact.' - '.$buff->kind_id.' - '.
                            $buff->nomen_id.' - '.$buff->pers_id.' - '.$buff->statement_id);*/
                $buff->save();
            }
//Формирование свернутой ведомости            
            $quant = 0;
            $nomen_id = '';
            $name_fact_id = '';
            $old_statement_id = '';
            foreach (\app\models\DeficitBuffer::find()
                    ->where('statement_id=:stat',[':stat'=>$id])
                    ->orderBy('def_name')
                    ->all() as $buff)
            {               
                if(!$old_statement_id)
                {
//                    $old_size_deficit = DeficitSpec::DeficitNomenSize($$buff->pers_id, $buff->nomen_id);
                    $old_kind_id = $buff->kind_id;
                    $old_nomen_id = $buff->nomen_id;
                    $old_quant = $buff->quant;
                    $old_def_name = $buff->def_name;
                    $old_analog_id = $rec->analog_id;
                    $old_quant_fact = $buff->quant_fact;
                    $old_def_name = $buff->def_name;
                    $old_nomen_deficit = $buff->nomen_id;
                    $old_quant_deficit = $buff->quant;
                    $old_quant_store = DeficitSpec::RemainQuant($buff->pers_id,$old_nomen_id);
                }
                if($nomen_id == $rec->nomen_id) // && $name_fact_id == $buff->nomen_fact)
                {
                    $quant =+ $old_quant;
                } else 
                {
                    $spec = new DeficitSpec();
//                    $spec->size_deficit = $old_size_deficit;
                    $spec->statement_id = $old_statement_id;
                    $spec->kind_id = $old_kind_id;
                    $spec->nomen_id = $old_nomen_id;
                    $spec->quant = $old_quant;
                    $spec->def_name = $old_def_name;
                    $spec->nomen_fact = $old_analog_id;
                    $spec->quant_fact = $old_quant_fact;
                    $spec->def_name = $buff->def_name;
                    $spec->nomen_deficit = $old_nomen_id;
                    if($old_quant_store - $old_quant < 0)
                        $spec->quant_deficit = ($old_quant_store - $old_quant)*(-1);
                    else
                        $spec->quant_deficit = 0;
                    $spec->def_quant = $spec->quant_deficit;
                    $spec->nomen_deficit = $old_nomen_deficit;
                    $spec->quant_store = $old_quant_store;
                    if($old_statement_id)
                        $spec->save();
//                    $old_size_deficit = DeficitSpec::DeficitNomenSize($buff->pers_id, $buff->nomen_id);
                    $old_statement_id = $buff->statement_id;
                    $old_kind_id = $buff->kind_id;
                    $old_nomen_id = $buff->nomen_id;
                    $old_quant = $buff->quant;
                    $old_def_name = $buff->def_name;
                    $old_analog_id = $rec->analog_id;
                    $old_quant = $buff->quant;
                    $old_def_name = $old_def_name;
                    $old_quant_fact = $buff->quant_fact;
                    $quant = $old_quant;
                    $nomen_id = $old_nomen_id;
                    $old_nomen_deficit = $buff->nomen_id;
                    $old_quant_store = DeficitSpec::RemainQuant($buff->pers_id,$old_nomen_id);                    
                }
            }
            if($old_statement_id)
            {
                $spec = new DeficitSpec();
                $spec->statement_id = $old_statement_id;
                $spec->kind_id = $old_kind_id;
                $spec->nomen_id = $old_nomen_id;
                $spec->quant = $old_quant;
                $spec->def_name = $old_def_name;
                $spec->nomen_fact = $old_analog_id;
                $spec->quant_fact = $old_quant_fact;
//                    $spec->def_name = $buff->def_name;
                $spec->nomen_deficit = $old_nomen_id;
                $spec->quant_deficit = $quant;
                if($old_quant_store - $old_quant < 0)
                    $spec->quant_deficit = ($old_quant_store - $old_quant)*(-1);
                else
                    $spec->quant_deficit = 0;
                $spec->def_quant = $spec->quant_deficit;
                $spec->nomen_deficit = $old_nomen_deficit;
                $spec->quant_store = $old_quant_store;
                $spec->save();
            }
        } else {
                $model = new DeficitSpec();
                if($model->load(Yii::$app->request->post())) {
                    $model->save();
                }
        }
        $spec = DeficitSpec::find()
                ->where('statement_id=:dif',[':dif'=>$id]);
        $dataProvider = new ActiveDataProvider([
            'query' => $spec]);

        return $this->render('index', [
//            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'id' => $id,
        ]);
    }
    
    /**
     * Displays a single DeficitSpec model.
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
     * Creates a new DeficitSpec model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new DeficitSpec();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing DeficitSpec model.
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

    public function actionUpdatemod($id)
    {
        $model = $this->findModel($id);
        
        if ($model->load(Yii::$app->request->post())) 
        {
            if (!$model->save()) {
                \Yii::$app->session->setFlash('error','Некорректные данные');
                return $this->redirect(['/deficit-spec/updatemod', 
                    'id' => $id ,
                    'model'=>$model,
                ]);
            }  else {
            return 
                $this->redirect(['/deficit-spec/index', 
                'id' => $id ,
                'model'=>$model,
                ]);
            }
        } else {
            return $this->renderPartial('/deficit-spec/_form_mod', [
//                'id' => $id ,
                'model'=>$model,
                ]);
        }
    }

    
    /**
     * Deletes an existing DeficitSpec model.
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
     * Finds the DeficitSpec model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return DeficitSpec the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = DeficitSpec::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
