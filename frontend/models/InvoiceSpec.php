<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "invoice_spec".
 *
 * @property int $id
 * @property int $invoice_id Накладная
 * @property int $remain_id Номенклатура остатков на складе
 * @property int $quant Количество
 * @property int $store_id Склад
 * @property int $oper_id Исполнитель
 * @property int $oper_date Дата операции
 *
 * @property Invoice $invoice
 * @property Storemain $remain
 * @property Storejournal[] $storejournals
 * @property Storelist [] $store
 * @property User[] $oper
 */
class InvoiceSpec extends \yii\db\ActiveRecord
{
    public $cardspec_id;


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'invoice_spec';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['invoice_id', 'remain_id', 'quant', 'store_id', 'oper_id', 'oper_date'], 'integer'],
//            [['size_id', 'height_id', 'full_id',' shirt_id', 'shoes_id','head_id', 'glove_id'], 'safe'],
            [['invoice_id'], 'exist', 'skipOnError' => true, 'targetClass' => Invoice::className(), 'targetAttribute' => ['invoice_id' => 'id']],
            [['remain_id'], 'exist', 'skipOnError' => true, 'targetClass' => Storemain::className(), 'targetAttribute' => ['remain_id' => 'id']],
            [['store_id'], 'exist', 'skipOnError' => true, 'targetClass' => Storelist::className(), 'targetAttribute' => ['store_id' => 'id']],
            [['oper_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['oper_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'invoice_id' => 'Накладная',
            'remain_id' => 'Номенклатура',
            'NomenName' => 'Номенклатура',
            'MeasName' => 'Ед. изм.',
            'quant' => 'Кол-во',
            'store_id' => 'Склад',
            'StoreName' => 'Склад',
            'oper_id' => 'Исполнитель',
            'oper_date' => 'Дата операции',
//            'size_id' => 'Размер',
            'SizeName' => 'Размер',
//            'height_id' => 'Рост',
            'HeightName' => 'Рост',
//            'full_id' => 'Полнота',
            'FullName' => 'Полнота',
//            'shirt_id' => 'Размер по вороту',
            'ShirtName' => 'Размер по вороту',
//            'shoes_id' => 'Размер обуви',
            'ShoesName' => 'Размер обуви',
//            'head_id' => 'Размер головы',
            'HeadName' => 'Размер головы',
//            'glove_id' => 'Размер перчаток',
            'GloveName' => 'Размер перчаток',
            'Period' => 'Период использования',
            'TypeNomen' => 'Тип',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getInvoice()
    {
        return $this->hasOne(Invoice::className(), ['id' => 'invoice_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRemain()
    {
        return $this->hasOne(Storemain::className(), ['id' => 'remain_id']);
    }

    public function getPeriod()
    {
        if($this->remain)
            return $this->remain->nomen->kind->period;
        else
            return '';
    }

    public function getTypeNomen()
    {
        if($this->remain) {
            if($this->remain->nomen->code == 2)
                return 'СИЗ';
            else if($this->remain->nomen->code == 1)
                return 'ФО';
            else
                return 'Общая';
        }
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

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOper()
    {
        return $this->hasOne(User::className(), ['id' => 'oper_id']);
    }

    public function getSizeName()
    {
        if($this->remain)
            return $this->remain->SizeName;
        else
            return '';
    }

    public function getHeightName()
    {
        if($this->remain)
            return $this->remain->HeightName;
        else
            return '';
    }

    public function getFullName()
    {
        if($this->remain)
            return $this->remain->FullName;
        else
            return '';
    }

    public function getShirtName()
    {
        if($this->remain)
            return $this->remain->ShirtName;
        else
            return '';
    }

    public function getShoesName()
    {
        if($this->remain)
            return $this->remain->ShoesName;
        else
            return '';
    }

    public function getHeadName()
    {
        if($this->remain)
            return $this->remain->HeadName;
        else
            return '';
    }

    public function getGloveName()
    {
        if($this->remain)
            return $this->remain->GloveName;
        else
            return '';
    }

    public function getNomenName()
    {
        if($this->remain)
            return $this->remain->NomenSize; //NomenName;//MeasName
        else
            return '';
    }

    public function getMeasName()
    {
        if($this->remain)
            return $this->remain->MeasName;
        else
            return '';
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getStorejournals()
    {
        return $this->hasMany(Storejournal::className(), ['invoicespec_id' => 'id']);
    }
}
