<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "branchlist".
 *
 * @property int $id
 * @property string $code
 * @property string $name
 *
 * @property Complist[] $complists
 * @property Stafflist[] $stafflists
 */
class Branchlist extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'branchlist';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['code'], 'string', 'max' => 20],
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
            'code' => 'Обозначение',
            'name' => 'Наименование',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getComplists()
    {
        return $this->hasMany(Complist::className(), ['branch_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getStafflists()
    {
        return $this->hasMany(Stafflist::className(), ['branch_id' => 'id']);
    }
}
