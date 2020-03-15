<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "pers_anthrop".
 *
 * @property int $id
 * @property int $pers_id Сотрудник
 * @property string $name Наименование параметра
 * @property string $val Значение параметра
 *
 * @property Perslist $pers
 */
class PersAnthrop extends \yii\db\ActiveRecord
{
    const size = 'Размер';
    const height = 'Рост';
    const full = 'Полнота';
    const shirt = 'Размер по вороту';
    const shoes = 'Размер обуви';
    const glove = 'Размер перчаток';
    const head = 'Размер головы';

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'pers_anthrop';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['pers_id', 'name'], 'required'],
            [['pers_id'], 'integer'],
            [['name'], 'string', 'max' => 45],
            [['val'], 'string', 'max' => 10],
            [['pers_id'], 'exist', 'skipOnError' => true, 'targetClass' => Perslist::className(), 'targetAttribute' => ['pers_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'pers_id' => 'Сотрудник',
            'PersName' => 'Сотрудник',
            'name' => 'Параметр',
            'val' => 'Значение',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPers()
    {
        return $this->hasOne(Perslist::className(), ['id' => 'pers_id']);
    }
    
    public function getPersName()
    {
        if($this->pers)
            return $this->pers->abbr_name;
        else
            return '';
    }
}
