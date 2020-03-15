<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "stopertype".
 *
 * @property int $id
 * @property int $type Тип операции: 0-приход, 1-расход
 * @property string $name Наименование
 */
class Stopertype extends \yii\db\ActiveRecord
{
    const STADD = 0; //Приход на склад
    const STRET = 1; //Возврат на склад от сотрудников
    const STREM = 2; //ВХО
    const STSUB = 3; //Выдача со склада сотрудникам
    const STDEL = 4; //Списание со склада
    const STSPED  = 5; //Корретировка спецификации
    const STSPDEL = 6; //Удаление спецификации
    const STREMOUT = 7; //ВХО списание
    const STREMIN = 8; //ВХО приход



    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'stopertype';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['type'], 'integer'],
            [['name'], 'string', 'max' => 80],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'type' => 'Код',
            'name' => 'Наименование операции',
        ];
    }
}
