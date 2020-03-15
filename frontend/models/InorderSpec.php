<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "inorder_spec".
 *
 * @property int $id
 * @property int $inorder_id Приходный ордер
 * @property int $nomen_id Номенклатура
 * @property int $comp_id Предприятие
 * @property int $store_id Склад
 * @property int $quant Количество
 * @property int $placed Местонахождение: 1-на складе, 0-не на складе
 * @property string $sertif Сертификат
 * @property string $price Цена
 * @property int $size_id Размер
 * @property int $height_id Рост
 * @property int $full_id Полнота
 * @property int $hirt_id Размер по вороту
 * @property int shoes_id Размер обуви
 * @property int $head_id Размер головы
 * @property int $glove_id Размер перчаток
 * @property int $is_siz Тип номенклатуры
 * @property int $actual Актуальность записи 1-актуальна
 *
 * @property Inorder $inorder
 * @property Nomenclature $nomen
 * @property Storelist $store
 */
class InorderSpec extends \yii\db\ActiveRecord
{
    const SPECATC = 1;
    const SPECNOTACT = 0;
    const SPECDEF = 2;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'inorder_spec';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['inorder_id', 'nomen_id', 'store_id', 'quant'], 'required'],
            [['inorder_id', 'nomen_id', 'comp_id', 'store_id', 'quant', 'placed','actual'], 'integer'],
            [['is_siz', 'size_id', 'height_id', 'full_id', 'shirt_id', 'shoes_id', 'glove_id', 'head_id'], 'number'],
            [['price'], 'number'],
            [['sertif'], 'string', 'max' => 45],
            [['inorder_id'], 'exist', 'skipOnError' => true, 'targetClass' => Inorder::className(), 'targetAttribute' => ['inorder_id' => 'id']],
//            [['kind_id'], 'exist', 'skipOnError' => true, 'targetClass' => Nomenkind::className(), 'targetAttribute' => ['kind_id' => 'id']],
            [['nomen_id'], 'exist', 'skipOnError' => true, 'targetClass' => Nomenclature::className(), 'targetAttribute' => ['nomen_id' => 'id']],
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
            'inorder_id' => 'Приходный ордер',
            'InorderName' => 'Приходный ордер',
            'nomen_id' => 'Номенклатура',
            'NomenName' => 'Номенклатура',
            'comp_id' => 'Предприятие',
            'CompName' => 'Предприятие',
            'store_id' => 'Склад',
            'StoreName' => 'Склад',
            'quant' => 'Кол-во',
            'placed' => 'Место',
            'sertif' => 'Сертификат',
            'price' => 'Цена',
            'KindName' => 'Размерная группа',
            'is_siz' => 'Тип',
            'IsSiz' => 'Тип',
            'size_id' => 'Размер',
            'SizeVal' => 'Размер',
            'height_id' => 'Рост',
            'HeightVal' => 'Рост',
            'full_id' => 'Полнота',
            'FullVal' => 'Полнота',
            'shirt_id' => 'Размер по вороту',
            'ShirtVal' => 'Размер по вороту',
            'shoes_id' => 'Размер обуви',
            'ShoesVal' => 'Размер обуви',
            'glove_id' => 'Размер перчаток',
            'GloveVal' => 'Размер перчаток',
            'head_id' => 'Размер головы',
            'HeadVal' => 'Размер головы',
            'actual' => 'Актуальность',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getInorder()
    {
        return $this->hasOne(Inorder::className(), ['id' => 'inorder_id']);
    }

    public function getInorderName()
    {
        if($this->inorder)
            return $this->inorder->DoctypeName.' № '.$this->inorder->doc_numb;
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

    public function getKindName()
    {
        If($this->nomen)
            return $this->nomen->KindName;
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
    
    public function getIsSiz()
    {
        if($this->is_siz == 1)
            return 'ФО';
        elseif($this->is_siz == 2)
            return 'СИЗ';
        else
            return '';
    }
    
    public function getSize()
    {
        return $this->hasOne(Sizelist::className(), ['id' => 'size_id']);
    }
    
    public function getSizeVal()
    {
        if($this->size)
            return $this->size->size;
        else
            return '';
    }
    public function getHeight()
    {
        return $this->hasOne(Sizelist::className(), ['id' => 'height_id']);
    }
    
    public function getHeightVal()
    {
        if($this->height) 
        {
            return  $this->height->size;
        }
    }
    public function getFull()
    {
        return $this->hasOne(Sizelist::className(), ['id' => 'full_id']);
    }
    
    public function getFullVal()
    {
        if($this->full)
            return $this->full->size;
        else
            return '';
    }
    public function getShirt()
    {
        return $this->hasOne(Sizelist::className(), ['id' => 'shirt_id']);
    }
    
    public function getShirtVal()
    {
        if($this->shirt)
            return $this->shirt->size;
        else
            return '';
    }
    public function getShoes()
    {
        return $this->hasOne(Sizelist::className(), ['id' => 'shoes_id']);
    }
    
    public function getShoesVal()
    {
        if($this->shoes)
            return $this->shoes->size;
        else
            return '';
    }
    public function getGlove()
    {
        return $this->hasOne(Sizelist::className(), ['id' => 'glove_id']);
    }
    
    public function getGloveVal()
    {
        if($this->glove)
            return $this->glove->size;
        else
            return '';
    }
    public function getHead()
    {
        return $this->hasOne(Sizelist::className(), ['id' => 'head_id']);
    }
    
    public function getHeadVal()
    {
        if($this->head)
            return $this->head->size;
        else
            return '';
    }
}
