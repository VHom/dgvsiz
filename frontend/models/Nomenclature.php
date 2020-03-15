<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "nomenclature".
 *
 * @property int $id
 * @property string $code Обозначение
 * @property string $name Наименование
 * @property string $price Цена
 * @property string $gost
 * @property int $meas_id Единицы измерения
 * @property int $gender Пол
 * @property string $sertif Сертификат
 * @property int $kind_id Размерная группа
 * @property MeasureUnit $meas

 */
class Nomenclature extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'nomenclature';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['price'], 'number'],
            [['meas_id', 'gender', 'code', 'kind_id'], 'integer'],
            [['sertif'], 'string', 'max' => 45],
            [['GenderName', 'KindName'], 'safe'],
            [['name', 'gost'], 'string', 'max' => 240],
            [['meas_id'], 'exist', 'skipOnError' => true, 'targetClass' => MeasureUnit::className(), 'targetAttribute' => ['meas_id' => 'id']],
            [['kind_id'], 'exist', 'skipOnError' => true, 'targetClass' => Nomenkind::className(), 'targetAttribute' => ['kind_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'code' => 'Тип',
            'CodeName' => 'Тип',
            'name' => 'Наименование',
            'price' => 'Цена',
            'sertif' => 'Сертификат',
            'gost' => 'ГОСТ',
            'meas_id' => 'Ед. изм.',
            'MeasName' => 'Ед. изм.',
            'MeasCode' => 'Ед. изм.',
            'gender' => 'Пол',
            'GenderName' => 'Пол',
            'kind_id' => 'Размерная группа',
            'KindName' => 'Размерная группа',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getKind()
    {
        return $this->hasOne(Nomenkind::className(), ['id' => 'kind_id']);
    }

    public function getKindName()
    {
        if($this->kind)
        {
            return $this->kind->name;
        } else {
            return '';
        }
    }

    public function getMeas()
    {
        return $this->hasOne(MeasureUnit::className(), ['id' => 'meas_id']);
    }

    public function getMeasName()
    {
        if($this->meas)
        {
            return $this->meas->name;
        } else {
            return '';
        }
    }

    public function getMeasCode()
    {
        if($this->meas)
        {
            return $this->meas->abbr;
        } else {
            return '';
        }
    }

    public function getCodeName()
    {
        if($this->code == 0)
            return '';
        elseif($this->code == 1)
            return 'ФО';
        else
            return 'СИЗ';
    }

    public function getGenderName()
    {
        if($this->gender)
            if($this->gender == 0)
                return 'Общий';
            elseif($this->gender == 1)
                return 'Мужской';
                elseif ($this->gender == 2) 
                    return 'Женский';
        else
            return '';
    }
}
