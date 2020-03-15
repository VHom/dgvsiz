<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "storejournal".
 *
 * @property int $id
 * @property int $comp_id Предприятие
 * @property int $store_id Склад
 * @property int $nomen_id Номенклатура
 * @property int $stoper_id Складская операция
 * @property int $stoper_type Тип операции: 0-приход, 1-расход
 * @property int $inordspec_id Спецификация приходного ордера
 * @property int $invoicespec_id Спецификация расходной накладной
 * @property int $drafspec_id Спецификация ВХО
 * @property string $quant Количество
 * @property int $oper_id Исполнитель
 * @property int $oper_date Дата операции
 *
 * @property Complist $comp
 * @property DraftSpec $drafspec
 * @property InorderSpec $inordspec
 * @property InvoiceSpec $invoicespec
 * @property Nomenclature $nomen
 * @property Userlist $oper
 * @property Stopertype $stoper
 * @property Storelist $store
 * @property User $usr
 */
class Storejournal extends \yii\db\ActiveRecord
{
    const OPER_IN = 0;
    const OPER_OUT = 1;
    
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'storejournal';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['comp_id', 'store_id', 'nomen_id', 'stoper_id', 'stoper_type', 'inordspec_id', 'invoicespec_id', 'drafspec_id', 'oper_id', 
                'oper_date', 'quant'], 'integer'],
            [['comp_id'], 'exist', 'skipOnError' => true, 'targetClass' => Complist::className(), 'targetAttribute' => ['comp_id' => 'id']],
            [['drafspec_id'], 'exist', 'skipOnError' => true, 'targetClass' => DraftSpec::className(), 'targetAttribute' => ['drafspec_id' => 'id']],
            [['inordspec_id'], 'exist', 'skipOnError' => true, 'targetClass' => InorderSpec::className(), 'targetAttribute' => ['inordspec_id' => 'id']],
            [['invoicespec_id'], 'exist', 'skipOnError' => true, 'targetClass' => InvoiceSpec::className(), 'targetAttribute' => ['invoicespec_id' => 'id']],
            [['nomen_id'], 'exist', 'skipOnError' => true, 'targetClass' => Nomenclature::className(), 'targetAttribute' => ['nomen_id' => 'id']],
            [['oper_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['oper_id' => 'id']],
            [['stoper_id'], 'exist', 'skipOnError' => true, 'targetClass' => Stopertype::className(), 'targetAttribute' => ['stoper_id' => 'id']],
            [['store_id'], 'exist', 'skipOnError' => true, 'targetClass' => Storelist::className(), 'targetAttribute' => ['store_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'comp_id' => 'Организация',
            'CompName' => 'Организация',
            'store_id' => 'Склад',
            'StoreName' => 'Склад',
            'nomen_id' => 'Номенклатура',
            'NomenName' => 'Номенклатура',
            'stoper_id' => 'Операция',
            'StoperName' => 'Операция',
//            'stoper_type' => 'Тип операции',
            'StoreOper' => 'Тип операции',
            'StoperName' => 'Тип операции',
            'inordspec_id' => 'Спецификация ПО',
            'invoicespec_id' => 'Спецификация РО',
            'drafspec_id' => 'ВСО',
            'quant' => 'Кол-во',
            'oper_id' => 'Oper ID',
            'oper_date' => 'Дата',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getComp()
    {
        return $this->hasOne(Complist::className(), ['id' => 'comp_id']);
    }
    public function getCompName()
    {
        if($this->comp)
            return $this->comp->name;
        else
            return '';
    }
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDrafspec()
    {
        return $this->hasOne(DraftSpec::className(), ['id' => 'drafspec_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getInordspec()
    {
        return $this->hasOne(InorderSpec::className(), ['id' => 'inordspec_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getInvoicespec()
    {
        return $this->hasOne(InvoiceSpec::className(), ['id' => 'invoicespec_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getNomen()
    {
        return $this->hasOne(Nomenclature::className(), ['id' => 'nomen_id']);
    }
    public function getNomenName()
    {
        if($this->nomen)
            return $this->nomen->name;
        else
            return '';
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOper()
    {
        return $this->hasOne(Userlist::className(), ['id' => 'oper_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSttype()
    {
        return $this->hasOne(Stopertype::className(), ['id' => 'stoper_id']);
    }
    public function getStoperName()
    {
        if($this->sttype)
            return $this->sttype->name;
        else
            return '';
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getStore()
    {
        return $this->hasOne(Storelist::className(), ['id' => 'store_id']);
    }
    public function getStoreName()
    {
        if($this->store)
            return $this->store->name;
        else
            return '';
    }

    public function getStoreOper()
    {
        if($this->stoper_type == 0)
            return 'Приход';
            elseif ($this->stoper_type == 1) 
                return 'Расход';
            else
                return '';
            
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUsr()
    {
        return $this->hasOne(User::className(), ['id' => 'oper_id']);
    }
 
//Запись складской операции    
    public static function JournalRec($id,$stoptype)
    {
        $journal = new \app\models\Storejournal();
        
        if($stoptype == \app\models\Stopertype::STADD) { //Приход
                $store_oper = Storejournal::OPER_IN;
                $model = InorderSpec::findOne($id);
                $nomen_id = $model->nomen_id;
                $indoc = Inorder::findOne($model->inorder_id);
                $store_id = $indoc->store_id;
                $store = Storelist::findOne($store_id);
                $comp_id = $store->comp_id;
                $journal->inordspec_id = $id;
                $journal->comp_id = $indoc->comp_id;
        } elseif($stoptype == \app\models\Stopertype::STRET) {//Возврат
                $store_oper = Storejournal::OPER_IN;
                $model = InorderSpec::findOne($id);
                $nomen_id = $model->nomen_id;
                $indoc = Inorder::findOne($model->inorder_id);
                $store_id = $indoc->store_id;
                $store = Storelist::findOne($store_id);
                $comp_id = $store->comp_id;
                $journal->inordspec_id = $id;
                $journal->comp_id = $indoc->comp_id;
        } elseif($stoptype == \app\models\Stopertype::STSUB) { //Выдача
                $store_oper = Storejournal::OPER_OUT;
                $model = InvoiceSpec::findOne($id);
                $indoc = Storemain::find()
                        ->leftJoin('invoice_spec','invoice_spec.remain_id=storemain.id')
                        ->where('invoice_spec.id=:id',[':id'=>$id])
                        ->one();
                $store_id = $indoc->store_id;
                $nomen_id = $indoc->nomen_id;
                $store = Storelist::findOne($indoc->store_id);
                $comp_id = $store->comp_id;
                $journal->comp_id = $store->comp_id;
                $journal->invoicespec_id = $id;
        }
        elseif($stoptype == \app\models\Stopertype::STDEL) {//Списание
                $store_oper = Storejournal::OPER_OUT;
                $model = InvoiceSpec::findOne($id);
                $indoc = Storemain::find()
                        ->leftJoin('invoice_spec','invoice_spec.remain_id=storemain.id')
                        ->where('invoice_spec.id=:id',[':id'=>$id])
                        ->one();
                $store_id = $indoc->store_id;
                $nomen_id = $indoc->nomen_id;
                $store = Storelist::findOne($indoc->store_id);
                $comp_id = $store->comp_id;
                $journal->invoicespec_id = $id;
        }
        elseif ($stoptype == \app\models\Stopertype::STREMOUT) { //ВХО
                $store_oper = Storejournal::OPER_OUT;
//                throw new \yii\web\NotFoundHttpException($id);
                $model = DraftSpec::findOne($id);
                $remaim = Storemain::findOne($model->remain_id);
                $nomen_id = $remaim->nomen_id;
//                throw new \yii\web\NotFoundHttpException('qq - '.$id.' - '.$model->draft_id);
                $draft = Draft::findOne($model->draft_id);
                $store = Storelist::findOne($draft->out_store);
                $comp_id = $store->comp_id;
                $store_id = $draft->out_store;
        }
        elseif ($stoptype == \app\models\Stopertype::STREMIN) { //ВХО
                $store_oper = Storejournal::OPER_IN;
                $model = DraftSpec::findOne($id);
                $remaim = Storemain::findOne($model->remain_id);
                $nomen_id = $remaim->nomen_id;
                $draft = Draft::findOne($model->draft_id);
                $store = Storelist::findOne($draft->out_store);
                $comp_id = $store->comp_id;
                $store_id = $draft->in_store;
        }
        elseif($stoptype == \app\models\Stopertype::STSPDEL) //Удаление спецификации
                $store_oper = Storejournal::OPER_OUT;
        elseif($stoptype == \app\models\Stopertype::STSPED) { //Корректировка спецификации
            
        }
        $journal->nomen_id = $nomen_id;
        $journal->store_id = $store_id; //$indoc->store_id;
        $journal->comp_id = $comp_id;
        $opertype = \app\models\Stopertype::find()
                        ->where('type=:oper',[':oper'=>$stoptype]) 
                        ->one();
        $journal->stoper_type = $store_oper; 
        $journal->stoper_id = $opertype->id;
        $journal->quant = $model->quant;
        $journal->oper_date = time();
        $journal->oper_id = Yii::$app->user->id;
//        throw new \yii\web\NotFoundHttpException('qq '.$journal->stoper_type.' - '.$journal->stoper_id.' - '.$journal->oper_id
//                .' - '.$journal->nomen_id.' - '.$journal->comp_id.' - '.$journal->store_id.' - '.$journal->invoicespec_id);
        if($journal->save())
            return true;
        else
            return false;
    }
}
