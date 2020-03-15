<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "prof_cat".
 *
 * @property int $id
 * @property string $code Код категории
 * @property string $znak Описание знака
 *
 * @property Proflist[] $proflists
 */
class ProfCat extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'prof_cat';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['code'], 'string', 'max' => 45],
            [['znak'], 'string', 'max' => 400],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'code' => 'Категория',
            'znak' => 'Описание знака отличия',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProflists()
    {
        return $this->hasMany(Proflist::className(), ['kat_id' => 'id']);
    }
}
