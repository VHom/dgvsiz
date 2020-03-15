<?php

namespace app\models;

use Yii;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "proflist".
 *
 * @property int $id
 * @property string $code
 * @property string $name
 * @property int $kat_id 
 *
 * @property ProfCat[] $proflist
 */
class Proflist extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'proflist';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['code'], 'required'],
            [['code'], 'string', 'max' => 20],
            [['name'], 'string', 'max' => 80],
            [['kat_id'], 'integer'],
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
            'kat_id' => 'Категория',
            'KatName' => 'Категория',
            'KatZnak' => 'Знак отличия',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getKat()
    {
        return $this->hasOne(ProfCat::className(), ['id' => 'kat_id']);
    }
    
    public function getKatName()
    {
        if($this->kat)
            return $this->kat->code;
        else
            return '';
    }
    
    public function getKatZnak()
    {
        if($this->kat)
            return $this->kat->znak;
        else
            return '';
    }

    public static function getProfs()
    {
        return ArrayHelper::map(Proflist::find()
            ->where('code <> "Супервизор" and code <> "Сисадм"')
            ->orderBy(['name' => SORT_ASC])
            ->all(), 'id', 'name');
    }
}
