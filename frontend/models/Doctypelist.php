<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "doctypelist".
 *
 * @property int $id
 * @property string $code Обозначение
 * @property string $name Наименование
 *
 * @property Inorder[] $inorders
 */
class Doctypelist extends \yii\db\ActiveRecord
{
    const DOCPO = "ПО"; //приходный ордер
    const DOCRN = "РН"; //Расходная накладная на отпуск сотрудникам
    const DOCVN = "ВН"; //Возвратная накладная
    const DOCAD = "АС"; //Акт списания
    const DOCVP = "ВП"; //Накладная на внутреннее перемещение

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'doctypelist';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
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
    public function getInorders()
    {
        return $this->hasMany(Inorder::className(), ['doc_type' => 'id']);
    }
}
