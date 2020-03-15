<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "const_nomen".
 *
 * @property int $id
 * @property int $nomen_id Номенклатура комплекта
 * @property int $const_nomen_id Номенклатура элемента комплекта
 * @property int $quant Количество
 *
 * @property Nomenclature $constNomen
 * @property Nomenclature $nomen
 */
class ConstNomen extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'const_nomen';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['nomen_id', 'const_nomen_id'], 'required'],
            [['nomen_id', 'const_nomen_id', 'quant'], 'integer'],
//            [['const_nomen_id'], 'exist', 'skipOnError' => true, 'targetClass' => Nomenclature::className(), 'targetAttribute' => ['const_nomen_id' => 'id']],
//            [['nomen_id'], 'exist', 'skipOnError' => true, 'targetClass' => Nomenclature::className(), 'targetAttribute' => ['nomen_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'nomen_id' => 'Номенклатура',
            'NomenName' => 'Номенклатура',
            'const_nomen_id' => 'Номенклатура комплекта',
            'ComplectName' => 'Номенклатура комплекта',
            'quant' => 'Кол-во',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getConstNomen()
    {
        return $this->hasOne(Nomenclature::className(), ['id' => 'const_nomen_id']);
    }

    public function getComplectName()
    {
        if($this->constNomen)
            return $this->constNomen->name;
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

}
