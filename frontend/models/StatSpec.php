<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "stat_spec".
 *
 * @property int $id
 * @property int $staff_id Подразделение
 * @property int $sign_choice Признак выбора: 0-не выбран, 1-выбран
 * @property int $nomen_type Тип номенклатуры: 0-неопределен, 1-ФО, 2-СИЗ
 * @property int $nomen_id Номенклатура плановая
 * @property string $amort Степень износа
 * @property int $date_end Окончание носки
 * @property int $quant Количество
 * @property int $pers_id Сотрудник
 * @property int $prof_id Должность
 * @property int $nomen_fact_id Номенклатура фактическая
 * @property int $remain_id Остатки на складе
 * @property int $quant_fac Количество по факту
 * @property int $date_report Дата расчета
 * @property int $deficit Дефицит
 *
 * @property Nomenclature $nomen
 * @property Nomenclature $analog
 * @property Storemain $remain
 * @property Perslist $pers
 * @property Proflist $prof
 * @property Stafflist $staff
 * @property string $date_out Срок строка
 */
class StatSpec extends \yii\db\ActiveRecord
{
    const CHOICE_NO = 0;
    const CHOICE_YES = 1;

    public $date_end_temp;    
                /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'stat_spec';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['staff_id'], 'required'],
            [['staff_id', 'sign_choice', 'nomen_type', 'nomen_id', 'date_end', 'quant', 'pers_id', 'prof_id', 'nomen_fact_id', 'remain_id', 'quant_fact', 'date_report', 'deficit'], 'integer'],
            [['amort'], 'string', 'max' => 5],
            [['date_out'], 'string', 'max' => 10],
            [['date_end_temp'], 'safe'],
            [['nomen_id'], 'exist', 'skipOnError' => true, 'targetClass' => Nomenclature::className(), 'targetAttribute' => ['nomen_id' => 'id']],
            [['nomen_fact_id'], 'exist', 'skipOnError' => true, 'targetClass' => Nomenclature::className(), 'targetAttribute' => ['nomen_fact_id' => 'id']],
            [['pers_id'], 'exist', 'skipOnError' => true, 'targetClass' => Perslist::className(), 'targetAttribute' => ['pers_id' => 'id']],
            [['prof_id'], 'exist', 'skipOnError' => true, 'targetClass' => Proflist::className(), 'targetAttribute' => ['prof_id' => 'id']],
            [['staff_id'], 'exist', 'skipOnError' => true, 'targetClass' => Stafflist::className(), 'targetAttribute' => ['staff_id' => 'id']],
            [['remain_id'], 'exist', 'skipOnError' => true, 'targetClass' => Storemain::className(), 'targetAttribute' => ['remain_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'staff_id' => 'Подразделение',
            'sign_choice' => 'Выбор',
            'nomen_type' => 'Nomen Type',
            'nomen_id' => 'Номенклатура по норме',
            'NomenTypeName' => 'Тип',
            'NomenMeasName' => 'Ед. изм.',
            'NomenName' => 'Номенклатура по норме',
            'amort' => 'Степень износа',
            'date_end' => 'Срок',
            'quant' => 'Норма',
            'pers_id' => 'Сотрудник',
            'PersName' => 'Сотрудник',
            'prof_id' => 'Профессия',
            'nomen_fact_id' => 'Номенклатура по факту',
            'RemainName' => 'Номенклатура по факту',
            'remain_id' => 'Остатки на складе',
            'quant_fact' => 'Факт',
            'FactQuant' => 'Факт',
            'deficit' => 'Дефицит',
            'DeficitQuant' => 'Дефицит',
            'RemainQuant' => 'Остаток на складе',
            'DivName' => 'Подразделение',
            'date_report' => 'Дата расчета',
            'deficit' => 'Дефицит',
            'date_out' => 'Срок',
            'date_end_temp' => 'Срок',
        ];
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
            return "";
    }
    
    public function getNomenTypeName()
    {
        if($this->nomen)
            return $this->nomen->CodeName;
        else
            return "";
    }

    public function getNomenMeasName()
    {
        if($this->nomen)
            return $this->nomen->MeasName;
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAnalog()
    {
        return $this->hasOne(Nomenclature::className(), ['id' => 'nomen_fact_id']);
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
            return $this->pers->abbr_name;
        else
            return '';
    }

    public function getDivName()
    {
        if($this->pers)
            return $this->pers->StaffName;
        else
            return '';
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProf()
    {
        return $this->hasOne(Proflist::className(), ['id' => 'prof_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getStaff()
    {
        return $this->hasOne(Stafflist::className(), ['id' => 'staff_id']);
    }
    
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRemain()
    {
        return $this->hasOne(Storemain::className(), ['id' => 'remain_id']);
    }
    
    public function getRemainName()
    {
        if($this->remain)
            return $this->remain->NomenSize;
        else
            return "";
    }
    
    public function getRemainQuant()
    {
        if($this->remain)
            return $this->remain->quant;
        else
            return "";
    }

    public function getFactQuant()
    {
        if($this->quant_fact)
            return $this->quant_fact;
        else
            return "";
    }
    
    public function getDeficitQuant()
    {
        if($this->quant_fact)
            return $this->quant-$this->quant_fact;
        else
            return $this->quant;
    }
}
