<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "nomenkind".
 *
 * @property int $id
 * @property string $name Наименование
 * @property int $is_siz ФО/СИЗ
 * @property int $size_gr Размерная группа
 * @property int $height_gr Ростовочная группа
 * @property int $full_gr Полнотная группа
 * @property int $shirt_gr Размер по вороту
 * @property int $shoes_gr Размер обуви
 * @property int $glove_gr Размер перчаток
 * @property int $head_gr Размер головы
 * @property string $cjde Код группы
 * @property int $period Срок носки
 * @property int $actual Актуальность
 * @property string $prim Примечание
 *
 * @property Nomengroup[] $nomengroups
 */
class Nomenkind extends \yii\db\ActiveRecord
{
    const ACTUALYES = 0;
    const ACTUALNO = 1;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'nomenkind';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'is_siz'], 'required'],
            [['is_siz', 'period', 'actual'], 'integer'],
            [['name', 'code'], 'string', 'max' => 45],
            [['prim'], 'string', 'max' => 240],
            [['size_gr', 'height_gr', 'full_gr', 'shirt_gr', 'shoes_gr', 'glove_gr', 'head_gr'], 'integer'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Тип номенклатуры',
            'is_siz' => 'СИЗ/ФО',
            'IsSiz' => 'СИЗ/ФО',
            'size_gr' => 'Размер',
            'Size' => 'Размер',
            'height_gr' => 'Рост',
            'Height' => 'Рост',
            'full_gr' => 'Полнота',
            'Full' => 'Полнота',
            'shirt_gr' => 'Размер по вороту',
            'Shirt' => 'Размер по вороту',
            'shoes_gr' => 'Размер обуви',
            'Shoes' => 'Размер обуви',
            'glove_gr' => 'Размер перчаток',
            'Glove' => 'Размер перчаток',
            'head_gr' => 'Размер головы',
            'Head' => 'Размер головы',
            'code' => 'Код группы',
            'period' => 'Срок',
            'actual' => 'Актуальность',
            'prim' => 'Примечание',
        ];
    }

    public function getIsSiz()
    {
        if($this->is_siz == 0)
            return '';
        elseif($this->is_siz == 1)
            return 'ФО';
        else
            return 'СИЗ';
    }

    public function getSize()
    {
        if($this->size_gr == 0)
            return 'Нет';
        else
            return 'Да';
    }

    public function getHeight()
    {
        if($this->height_gr == 0)
            return 'Нет';
        else
            return 'Да';
    }

    public function getFull()
    {
        if($this->full_gr == 0)
            return 'Нет';
        else
            return 'Да';
    }

    public function getShirt()
    {
        if($this->shirt_gr == 0)
            return 'Нет';
        else
            return 'Да';
    }

    public function getShoes()
    {
        if($this->shoes_gr == 0)
            return 'Нет';
        else
            return 'Да';
    }

    public function getGlove()
    {
        if($this->glove_gr == 0)
            return 'Нет';
        else
            return 'Да';
    }

    public function getHead()
    {
        if($this->head_gr == 0)
            return 'Нет';
        else
            return 'Да';
    }

    /**
     * @return \yii\db\ActiveQuery
     */
/*    public function getNomengroups()
    {
        return $this->hasMany(Nomengroup::className(), ['nomen_kind' => 'id']);
    }*/
}
