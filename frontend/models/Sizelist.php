<?php

namespace app\models;

use Yii;
use yii\helpers\ArrayHelper;


/**
 * This is the model class for table "sizelist".
 *
 * @property int $id
 * @property int $group_type Тип группы размеров
 * @property string $group_name Наименование группы размеров
 * @property string $size Размер
 * @property int $min_val Минимальное значение
 * @property int $max_val Максимальное значение
 * @property int $actual Актуальность
 * @property string $prim Примечание
 */
class Sizelist extends \yii\db\ActiveRecord
{
    const size = 'Размер';
    const height = 'Рост';
    const full = 'Полнота';
    const shirt = 'Размер по вороту';
    const shoes = 'Размер обуви';
    const glove = 'Размер перчаток';
    const head = 'Размер головы';
    
    const ACTUALYES = 0;
    const ACTUALNO =1;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'sizelist';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['group_type', 'group_name', 'size'], 'required'],
            [['group_type', 'min_val', 'max_val', 'actual'], 'integer'],
            [['group_name'], 'string', 'max' => 80],
            [['size'], 'string', 'max' => 20],
            [['prim'], 'string', 'max' => 240],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'group_type' => 'Тип группы',
            'TypeName'  => 'Тип группы',
            'group_name' => 'Наименование',
            'size' => 'Размер',
            'min_val' => 'Мин. размер',
            'max_val' => 'Мах. размер',
            'actual' => 'Актуальность',
            'prim' => 'Примечание',
        ];
    }
    
    public function getTypeName()
    {
        if($this->group_type == 0)
            return 'СИЗ';
        elseif($this->group_type == 1)
            return 'ФО';
        else
            return 'Общая';
    }

    //Размерные группы
    static public function getSize()
    {
        return ArrayHelper::map(Sizelist::find()
            ->where('group_name = "Размер"')
            ->all(), 'id', 'size');
    }


}
