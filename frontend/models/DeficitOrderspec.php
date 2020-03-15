<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "deficit_orderspec".
 *
 * @property int $id
 * @property int $statement_id Дефицитная ведомость
 * @property string $nomen_name Номенклатура с размерами
 * @property int $quant Количество
 * @property int $status Статус: 0-не утверждена, 1-утверждена
 * @property int $type Тип заявки: 0-предприятия, 1-сводная
 * @property string $prim Примечание
 * @property int $oper_id Исполнитель
 * @property string $oper_date Дата операции
 * @property int $spec_id Позиция спецификации ведомости
 *
 * @property User $oper
 * @property DeficitStatment $statement
 */
class DeficitOrderspec extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'deficit_orderspec';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['statement_id'], 'required'],
            [['statement_id', 'quant', 'status', 'type', 'oper_id', 'spec_id', 'oper_date'], 'integer'],
            [['nomen_name', 'prim'], 'string', 'max' => 240],
//            [['oper_date'], 'string', 'max' => 45],
            [['oper_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['oper_id' => 'id']],
            [['statement_id'], 'exist', 'skipOnError' => true, 'targetClass' => DeficitStatment::className(), 'targetAttribute' => ['statement_id' => 'id']],
            [['spec_id'], 'exist', 'skipOnError' => true, 'targetClass' => DeficitSpec::className(), 'targetAttribute' => ['spec_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'statement_id' => 'Дефицитная ведомость',
            'nomen_name' => 'Номенклатура',
            'quant' => 'Кол-во',
            'status' => 'Статус',
            'type' => 'Тип',
            'prim' => 'Примечание',
            'oper_id' => 'Oper ID',
            'oper_date' => 'Oper Date',
            'spec_id' => 'Spec_id',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOper()
    {
        return $this->hasOne(User::className(), ['id' => 'oper_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getStatement()
    {
        return $this->hasOne(DeficitStatment::className(), ['id' => 'statement_id']);
    }
    
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSpec()
    {
        return $this->hasOne(DeficitSpec::className(), ['id' => 'spec_id']);
    }    
}
