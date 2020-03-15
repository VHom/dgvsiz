<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "measure_unit".
 *
 * @property int $id
 * @property string $code Код
 * @property string $name Наименование
 * @property string $OKEI
 * @property string $abbr Обозначение
 *
 * @property Nomenclature[] $nomenclatures
 */
class MeasureUnit extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'measure_unit';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['code', 'name'], 'required'],
            [['code'], 'string', 'max' => 20],
            [['name'], 'string', 'max' => 50],
            [['OKEI'], 'string', 'max' => 45],
            [['abbr'], 'string', 'max' => 10],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'code' => 'Код ЕИ',
            'name' => 'Наименование ЕИ',
            'OKEI' => 'Okei',
            'abbr' => 'Обозначение',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getNomenclatures()
    {
        return $this->hasMany(Nomenclature::className(), ['meas_id' => 'id']);
    }
}
