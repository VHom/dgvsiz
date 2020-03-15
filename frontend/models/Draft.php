<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "draft".
 *
 * @property int $id
 * @property int $out_store Склад отправитель
 * @property int $in_store Склад приемник
 * @property int $oper_id Исполнитель
 * @property int $comp_id Предприятие
 * @property int $oper_date Дата операции
 * @property string $doc_numb Номер документа
 * @property int $doc_date Дата документа
 * @property string $note Примечание
 *
 * @property Complist $comp
 * @property Storelist $inStore
 * @property Userlist $oper
 * @property Storelist $outStore
 */
class Draft extends \yii\db\ActiveRecord
{
    public $doc_date_temp;
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'draft';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['out_store', 'in_store', 'oper_id', 'comp_id', 'oper_date', 
                'doc_date', 'doc_type'], 'integer'],
            [['doc_numb'], 'string', 'max' => 20],
            [['note'], 'string', 'max' => 240],
            [['doc_date_temp'], 'date', 'format'=>'php:d.m.Y'],
            [['comp_id'], 'exist', 'skipOnError' => true, 'targetClass' => Complist::className(), 'targetAttribute' => ['comp_id' => 'id']],
            [['in_store'], 'exist', 'skipOnError' => true, 'targetClass' => Storelist::className(), 'targetAttribute' => ['in_store' => 'id']],
            [['oper_id'], 'exist', 'skipOnError' => true, 'targetClass' => Userlist::className(), 'targetAttribute' => ['oper_id' => 'id']],
            [['out_store'], 'exist', 'skipOnError' => true, 'targetClass' => Storelist::className(), 'targetAttribute' => ['out_store' => 'id']],
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
            'out_store' => 'Склад-отправитель',
            'OutStoreName' => 'Склад-отправитель',
            'in_store' => 'Склад-приемник',
            'InStoreName' => 'Склад-приемник',
            'oper_id' => 'Исполнитель',
            'comp_id' => 'Филиал',
            'oper_date' => 'Дата операции',
            'doc_numb' => 'Номер документа',
            'doc_date' => 'Дата документа',
            'doc_date_temp' => 'Дата документа',
            'note' => 'Примечание',
            'doc_type' => 'Тип документа',
            'DocTypeName' => 'Тип документа',
            
        ];
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
    public function getInStore()
    {
        return $this->hasOne(Storelist::className(), ['id' => 'in_store']);
    }

    public function getInStoreName()
    {
        if($this->inStore)
            return $this->inStore->name;
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

    public function getDocTypeName()
    {
        if($this->docType)
            return $this->docType->name;
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
    public function getOutStore()
    {
        return $this->hasOne(Storelist::className(), ['id' => 'out_store']);
    }
    
    public function getOutStoreName()
    {
        if($this->outStore)
            return $this->outStore->name;
        else
            return '';
    }
}
