<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "storelist".
 *
 * @property int $id
 * @property string $code
 * @property string $name
 * @property int $is_siz Тип номенклатуры
 * @property int $comp_id Предприятие
 * @property int $owner_id Владелиц
 *
 * @property Complist $comp
 * @property Complist $owner
 */
class Storelist extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'storelist';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['code', 'name'], 'required'],
            [['is_siz', 'comp_id', 'owner_id'], 'integer'],
            [['code'], 'string', 'max' => 20],
            [['name'], 'string', 'max' => 80],
            [['comp_id'], 'exist', 'skipOnError' => true, 'targetClass' => Complist::className(), 'targetAttribute' => ['comp_id' => 'id']],
            [['owner_id'], 'exist', 'skipOnError' => true, 'targetClass' => Complist::className(), 'targetAttribute' => ['owner_id' => 'id']],
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
            'is_siz' => 'Тип номенклатуры',
            'comp_id' => 'Предприятие',
            'CompName' => 'Предприятие',
            'owner_id' => 'Владелец',
            'OwnerName' => 'Владелец',
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
            return $this->comp->name;
        else
            return '';
    }

        /**
     * @return \yii\db\ActiveQuery
     */
    public function getOwner()
    {
        return $this->hasOne(Complist::className(), ['id' => 'owner_id']);
    }
    
    public function getOwnerName()
    {
        if($this->owner)
            return $this->owner->name;
        else
            return '';
    }
}
