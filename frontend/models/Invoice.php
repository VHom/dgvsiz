<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "invoice".
 *
 * @property int $id
 * @property int $store_id Склад
 * @property int $pers_id Сотрудник
 * @property int $comp_id Предприятие
 * @property string $doc_numb Номер документа
 * @property int $doc_date Дата документа
 * @property string $note Примечание
 * @property int $oper_id Исполнитель
 * @property int $oper_date Дата операции
 * @property int $doc_type Тип документа
 *
 * @property Complist $comp
 * @property Userlist $oper
 * @property Perslist $pers
 * @property Storelist $store
 * @property InvoiceSpec[] $invoiceSpecs
 */
class Invoice extends \yii\db\ActiveRecord
{
    public $doc_date_temp;
    
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'invoice';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['store_id', 'pers_id', 'comp_id', 'doc_date', 'oper_id', 'oper_date', 'doc_type'], 'integer'],
            [['doc_numb'], 'string', 'max' => 20],
            [['doc_date_temp'], 'safe'],
            [['note'], 'string', 'max' => 240],
//            [['comp_id'], 'exist', 'skipOnError' => true, 'targetClass' => Complist::className(), 'targetAttribute' => ['comp_id' => 'id']],
            [['oper_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['oper_id' => 'id']],
            [['pers_id'], 'exist', 'skipOnError' => true, 'targetClass' => Perslist::className(), 'targetAttribute' => ['pers_id' => 'id']],
            [['store_id'], 'exist', 'skipOnError' => true, 'targetClass' => Storelist::className(), 'targetAttribute' => ['store_id' => 'id']],
            [['doc_type'], 'exist', 'skipOnError' => true, 'targetClass' => Doctypelist::className(), 'targetAttribute' => ['doc_type' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'store_id' => 'Склад',
            'pers_id' => 'Сотрудник',
            'FullName' => 'Сотрудник',
            'comp_id' => 'Предприятие',
            'doc_numb' => 'Номер документа',
            'doc_date' => 'Дата документа',
            'note' => 'Примечание',
            'oper_id' => 'Исполнитель',
            'oper_date' => 'Дата операции',
            'doc_type' => 'Тип документа',
            'DoctypeName' => 'Тип документа',
            'doc_date_temp' => 'Дата документа',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUsr()
    {
        return $this->hasOne(User::className(), ['id' => 'oper_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDoctype()
    {
        return $this->hasOne(Doctypelist::className(), ['id' => 'doc_type']);
    }

    public function getDoctypeName()
    {
        if($this->doctype)
            return $this->doctype->name;
        else
            return '';
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getComp()
    {
        return $this->hasOne(Complist::className(), ['id' => 'comp_id']);
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
    public function getPers()
    {
        return $this->hasOne(Perslist::className(), ['id' => 'pers_id']);
    }

    public function getFullName()
    {
        if($this->pers)
            return $this->pers->FullName;
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

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getInvoiceSpecs()
    {
        return $this->hasMany(InvoiceSpec::className(), ['invoce_id' => 'id']);
    }
}
