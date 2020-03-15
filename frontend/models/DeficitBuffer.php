<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "deficit_buffer".
 *
 * @property int $id
 * @property int $nomen_id Номенклатура
 * @property int $quant Количество по норме
 * @property int $kind_id Разметочная таблица
 * @property int $pers_id Сотрудник
 * @property int $statement_id Заявка
 * @property string $def_name Потребность - наименование
 * @property int $def_quant Потребность - количество
 * @property int $def_date Срок использования
 * @property int $quant_fact Количество по факту
 * @property string $def_name_fact В использовании - наименование
 * @property int $nomen_fact Номенклатура по факту
 *
 * @property Nomenkind $kind
 * @property Nomenclature $nomen
 * @property Perslist $pers
 * @property DeficitStatment $statement
 */
class DeficitBuffer extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'deficit_buffer';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['nomen_id', 'pers_id', 'statement_id'], 'required'],
            [['nomen_id', 'kind_id', 'pers_id', 'statement_id', 'def_quant', 'def_date', 'quant_fact', 
                'nomen_fact', 'quant'], 'integer'],
            [['def_name', 'def_name_fact'], 'string', 'max' => 360],
            [['kind_id'], 'exist', 'skipOnError' => true, 'targetClass' => Nomenkind::className(), 'targetAttribute' => ['kind_id' => 'id']],
            [['nomen_id'], 'exist', 'skipOnError' => true, 'targetClass' => Nomenclature::className(), 'targetAttribute' => ['nomen_id' => 'id']],
            [['pers_id'], 'exist', 'skipOnError' => true, 'targetClass' => Perslist::className(), 'targetAttribute' => ['pers_id' => 'id']],
            [['statement_id'], 'exist', 'skipOnError' => true, 'targetClass' => DeficitStatment::className(), 'targetAttribute' => ['statement_id' => 'id']],
            [['nomen_fact'], 'exist', 'skipOnError' => true, 'targetClass' => Storemain::className(), 'targetAttribute' => ['nomen_fact' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'nomen_id' => 'Номенклатура по норме',
            'quant' => 'План',
            'kind_id' => 'Kind ID',
            'pers_id' => 'Pers ID',
            'PersName' => 'Сотрудник',
            'ProfName' => 'Должность',
            'statement_id' => 'Statement ID',
            'def_name' => 'Номенклатура по плану',
            'NomenName' => 'Номенклатура дефицита',
            'def_quant' => 'Дефицит',
            'def_date'=> 'Срок использования',
            'def_name_fact' => 'Номенклатура по факту',
            'quant_fact' => 'Факт',
            'nomen_fact' => 'Номенклатура по факту',
            'NomenNameFact' => 'Номенклатура по факту',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getKind()
    {
        return $this->hasOne(Nomenkind::className(), ['id' => 'kind_id']);
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

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getNomenfact()
    {
        return $this->hasOne(Storemain::className(), ['id' => 'nomen_fact']);
    }

    public function getNomenNameFact()
    {
        if($this->nomenfact)
            return $this->nomenfact->nomen->name;
        else
            return '';
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPers()
    {
        return $this->hasOne(Perslist::className(), ['id' => 'pers_id']);
    }

    public function getPersName()
    {
        if($this->pers)
            return $this->pers->FullName;
        else
            return '';
    }

    public function getProfName()
    {
        if($this->pers_id)
            return $this->pers->ProfName;
        else
            return '';
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getStatement()
    {
        return $this->hasOne(DeficitStatment::className(), ['id' => 'statement_id']);
    }
}
