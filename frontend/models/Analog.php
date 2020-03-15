<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "analog".
 *
 * @property int $id
 * @property int staff_id Организация
 * @property int $nomen_gr Номенклатурная группа оригинала
 * @property int $analog_gr Номенклатурная группа аналога
 *
 * @property Nomengroup $analogGr
 * @property Complist $comp
 * @property Nomengroup $nomenGr
 */
class Analog extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'analog';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['staff_id', 'nomen_id', 'analog_id'], 'integer'],
            [['analog_id'], 'exist', 'skipOnError' => true, 'targetClass' => Nomenclature::className(), 'targetAttribute' => ['analog_id' => 'id']],
            [['staff_id'], 'exist', 'skipOnError' => true, 'targetClass' => Stafflist::className(), 'targetAttribute' => ['staff_id' => 'id']],
            [['nomen_id'], 'exist', 'skipOnError' => true, 'targetClass' => Nomenclature::className(), 'targetAttribute' => ['nomen_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'staff_id' => 'Организация',
            'CompName' => 'Организация',
            'nomen_id' => 'Номенклатура',
            'NomenName' => 'Номенклатура',
            'analog_id' => 'Аналог',
            'AnalogName' => 'Аналог',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
/*    public function getAnalogGr()
    {
        return $this->hasOne(Nomengroup::className(), ['id' => 'analog_gr']);
    }

    public function getAnalogName()
    {
        if($this->analogGr)
            return $this->analogGr->name;
        else
            return '';
    }*/

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getStaff()
    {
        return $this->hasOne(Stafflist::className(), ['id' => 'staff_id']);
    }

    public function getStaffName()
    {
        if($this->staff)
        {
            return $this->staff->CompName;
        } else {
            return '';
        }
    }
        

    /**
     * @return \yii\db\ActiveQuery
     */
/*    public function getNomenGr()
    {
        return $this->hasOne(Nomengroup::className(), ['id' => 'nomen_gr']);
    }
    
    public function getNomenName()
    {
        if($this->nomenGr)
            return $this->nomenGr->name;
        else
            return '';
    }*/
}
