<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "rolelist".
 *
 * @property int $id
 * @property string $code
 * @property string $name
 *
 * @property Userlist[] $userlists
 */
class Rolelist extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'rolelist';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['code', 'name'], 'required'],
            [['code'], 'string', 'max' => 20],
            [['name'], 'string', 'max' => 45],
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
    public function getUserlists()
    {
        return $this->hasMany(Userlist::className(), ['role_id' => 'id']);
    }
}
