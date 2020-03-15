<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "arealist".
 *
 * @property int $id
 * @property string $code
 * @property string $name
 * @property int $comp_id Организация
 *
 * @property Complist $comp
 * @property Stafflist[] $stafflists
 */
class Arealist extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'arealist';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['code', 'name'], 'required'],
            [['comp_id'], 'integer'],
            [['code'], 'string', 'max' => 20],
            [['name'], 'string', 'max' => 80],
            [['comp_id'], 'exist', 'skipOnError' => true, 'targetClass' => Complist::className(), 'targetAttribute' => ['comp_id' => 'id']],
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
            'comp_id' => 'Организация',
            'CompName' => 'Организация',
        ];
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
        {
            return $this->comp->name;
        } else
            return '';
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getStafflists()
    {
        return $this->hasMany(Stafflist::className(), ['area_id' => 'id']);
    }
}
