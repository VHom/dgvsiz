<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "deficit_statment".
 *
 * @property int $id
 * @property int $staff_id Организация, филиал, подразделение
 * @property int $date_report Дата ведомости
 * @property int $oper_date
 * @property int $oper_id Исполнитель
 * @property int $number_report Номер ведомости
 * @property int $prim Примечание
 * @property int $status Статус
 * @property int $stat_type Тип ведомости
 *
 * @property Perslist $pers
 * @property Stafflist $staff
 */
class DeficitStatment extends \yii\db\ActiveRecord
{
    public $date_report_temp;
    
    const STAT_UNDEFINED = 0; //неопределен
    const STAT_READY = 1; //оформлен
    const STAT_OPDER = 2; //заказан
    const STAT_DEL = 3; //аннулирован
    
    const STAT_TYPE_DIV = 0; //ведомость подразделения
    const STAT_TYPE_SVOD = 1; //сводная ведомость

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'deficit_statment';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['date_report', 'staff_id'], 'required'],
            [['staff_id', 'date_report', 'oper_date', 'oper_id', 'stat_type'], 'integer'],
            [['number_report'], 'string', 'max' => 45],
            [['prim'], 'string', 'max' =>240],
            [['date_report_temp'], 'safe'],
            [['oper_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['oper_id' => 'id']],
            [['staff_id'], 'exist', 'skipOnError' => true, 'targetClass' => Stafflist::className(), 'targetAttribute' => ['staff_id' => 'id']],
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
            'StaffName' => 'Подразделение',
            'date_report' => 'Дата отчета',
            'DateReport' => 'Дата отчета',
            'date_report_temp' => 'Дата отчета',
            'oper_date' => 'Дата формирования',
            'oper_id' => 'Исполнитель',
            'prim' => 'Примечание',
            'number_report' => 'Номер вед-ти',
            'status' => 'Статус',
            'stat_type' => 'Тип ведомости',
            'StatType' => 'Тип ведомости',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUsr()
    {
        return $this->hasOne(User::className(), ['id' => 'oper_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getStaff()
    {
        return $this->hasOne(Stafflist::className(), ['id' => 'staff_id']);
    }
    
    public function getStaffName() {
        if($this->staff)
            return $this->staff->AreaName;
        else
            return "";
    }
    
    public function getStatType() {
        if($this->stat_type == 0)
            return "Ведомость подразделения";
        else
            return "Сводная ведомость";
    }
    
    public function getDateReport()
    {
        if($this->date_report)
            return date('d.m.Y',  $this->date_report);
        else
            return '';
    }
}
