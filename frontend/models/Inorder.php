<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "inorder".
 *
 * @property int $id
 * @property int $store_id Склад
 * @property int $supplier_id Поставщик
 * @property int $comp_id Предприятие
 * @property int $accepted_id Кладовщик
 * @property string $doc_numb Номер документа
 * @property int $doc_date Дата документа
 * @property int $doc_type Тип документа
 * @property string $note Примечание
 * @property int $income_date Дата ввода
 * @property int $stoper_id Складская операция
 * @property string $suppl_name Номер документа поставщика
 * @property int $pers_id Сотрудник
 *
 * @property Userlist $accepted
 * @property Complist $comp
 * @property Doctypelist $docType
 * @property Storelist $store
 * @property Supplier $supplier
 * @property Perslist $perslist
 * @property InorderSpec[] $inorderSpecs
 */
class Inorder extends \yii\db\ActiveRecord
{
    public $doc_date_temp;
//    public $doc_sign; //0-Приходный ордер, 1-Возвратная накладная

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'inorder';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['store_id', 'comp_id', 'accepted_id'], 'required'],
            [['store_id', 'supplier_id', 'comp_id', 'accepted_id', 'doc_date', 
                'doc_type', 'income_date', 'stoper_id', 'pers_id'], 'integer'],
            [['doc_numb', 'suppl_numb'], 'string', 'max' => 20],
            [['note'], 'string', 'max' => 240],
            [['doc_date_temp'], 'date', 'format'=>'php:d.m.Y'],
            [['accepted_id'], 'exist', 'skipOnError' => true, 'targetClass' => Userlist::className(), 'targetAttribute' => ['accepted_id' => 'id']],
            [['comp_id'], 'exist', 'skipOnError' => true, 'targetClass' => Complist::className(), 'targetAttribute' => ['comp_id' => 'id']],
            [['doc_type'], 'exist', 'skipOnError' => true, 'targetClass' => Doctypelist::className(), 'targetAttribute' => ['doc_type' => 'id']],
            [['store_id'], 'exist', 'skipOnError' => true, 'targetClass' => Storelist::className(), 'targetAttribute' => ['store_id' => 'id']],
            [['supplier_id'], 'exist', 'skipOnError' => true, 'targetClass' => Supplier::className(), 'targetAttribute' => ['supplier_id' => 'id']],
            [['pers_id'], 'exist', 'skipOnError' => true, 'targetClass' => Perslist::className(), 'targetAttribute' => ['pers_id' => 'id']],
            [['stoper_id'], 'exist', 'skipOnError' => true, 'targetClass' => Stopertype::className(), 'targetAttribute' => ['stoper_id' => 'id']],
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
            'StoreName' => 'Склад',
            'supplier_id' => 'Поставщик',
            'SupplName' => 'Поставщик',
            'comp_id' => 'Предприятие',
            'CompName' => 'Предприятие',
            'accepted_id' => 'Кладовщик',
            'AcceptName' => 'Кладовщик',
            'doc_numb' => '№ документа',
            'doc_date' => 'Дата',
            'doc_date_temp' => 'Дата',
            'doc_type' => 'Тип',
            'DoctypeName' => 'Тип',
            'note' => 'Примечание',
            'income_date' => 'Дата ввода',
            'stoper' => 'Складская операция',
            'StoperName' => 'Складская операция',
            'suppl_numb' => 'Номер документа поставщика ',
            'pers_id' => 'Сотрудник',
            'PersName' => 'Сотрудник',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAccepted()
    {
        return $this->hasOne(Userlist::className(), ['id' => 'accepted_id']);
    }

    public function getAcceptName()
    {
        if($this->accepted)
            return $this->accepted->family_name.' '.
                mb_substr($this->accepted->first_name,0,1).
                '.'.mb_substr($this->accepted->second_name,0,1).'.';
        else
            return '';
    }

    public function getStoper()
    {
        return $this->hasOne(Stopertype::className(), ['id' => 'stoper_id']);
    }

    public function getStoperName()
    {
        if($this->stoper)
            return $this->stoper->name;
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
    public function getDocType()
    {
        return $this->hasOne(Doctypelist::className(), ['id' => 'doc_type']);
    }

    public function getDoctypeName()
    {
        if($this->docType)
            return $this->docType->name;
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
    public function getSupplier()
    {
        return $this->hasOne(Supplier::className(), ['id' => 'supplier_id']);
    }

    public function getSupplName()
    {
        if($this->supplier)
            return $this->supplier->name;
        else
            return '';
    }

    public function getPers()
    {
        if($this->pers_id)
            return $this->hasOne(Perslist::className(), ['id' => 'pers_id']);
    }

    public function getPersName()
    {
        if($this->pers)
            return $this->pers->FullName;
        else
            return '';
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getInorderSpecs()
    {
        return $this->hasMany(InorderSpec::className(), ['inorder_id' => 'id']);
    }
}
