<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "nomengroup".
 *
 * @property int $id
 * @property string $code Обозначение
 * @property string $name Наименование
 * @property int $nomen_kind Вид номенклатуры
 * @property int $nomen_type Тип номенклатуры: 0-мужская, 1-женская (для заявки)
 * @property int $nomen_season Сезонность номенклатуры: 0-летняя, 1-зимняя
 * @property int $siz_type
 * @property int $close_type Вид спецодежды
 *
 * @property Analog[] $analogs
 * @property Analog[] $analogs0
 * @property Nomenclature[] $nomenclatures
 * @property Nomenkind $nomenKind
 * @property Nomenclature $men_nomen
 * @property Nomenclature $wom_nomen
 */
class Nomengroup extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'nomengroup';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['nomen_kind', 'nomen_type', 'nomen_season', 'siz_type', 'close_type', 'men_nomen', 'wom_nomen'], 'integer'],
            [['code'], 'string', 'max' => 20],
            [['name'], 'string', 'max' => 240],
            [['nomen_kind'], 'exist', 'skipOnError' => true, 'targetClass' => Nomenkind::className(), 'targetAttribute' => ['nomen_kind' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'code' => 'Обозначение',
            'name' => 'Наименование',
            'nomen_kind' => 'Вид номенклатуры',
            'KindName' => 'Вид номенклатуры',
            'nomen_type' => 'Тип номенклатуры',
            'TypeName' => 'Тип номенклатуры',
            'nomen_season' => 'Сезон',
            'siz_type' => 'Типоразмер',
            'close_type' => 'Close Type',
            'men_nomen' => 'Номенклатура',
            'wom_nomen' => 'Номенклатура',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMennomen()
    {
        return $this->hasOne(Nomenclature::className(), ['men_nomen' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getWomnomen()
    {
        return $this->hasOne(Nomenclature::className(), ['wom_nomen' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAnalogs()
    {
        return $this->hasMany(Analog::className(), ['analog_gr' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getNomenclatures()
    {
        return $this->hasMany(Nomenclature::className(), ['nomen_gr' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getNomenKind()
    {
        return $this->hasOne(Nomenkind::className(), ['id' => 'nomen_kind']);
    }
    
    public function getKindName()
    {
        if($this->nomenKind)
        {
            return $this->nomenKind->nomenkind;
        } else {
            return '';
        }
    }
    
    public function getTypeName()
    {
        if($this->nomen_type)
        {
            if($this->nomen_type == 0)
                return 'Женский';
                elseif ($this->nomen_type == 1) 
                    return 'Мужской';
        } else
            return 'Общий';
    }
}
