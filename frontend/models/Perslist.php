<?php

namespace app\models;

use PhpOffice\PhpSpreadsheet\Shared\Date;
use Yii;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "perslist".
 *
 * @property int $id
 * @property string $tabnum Табельный номер
 * @property string $abbr_name Фамилия И.О.
 * @property string $family_name Фамилия
 * @property string $first_name Имя
 * @property string $second_name Отчество
 * @property int $gender Пол: 1-мужской, 2-женский
 * @property int $sec_empl Прием после увольнения
 * @property int $start_date Дата приема
 * @property int $end_date Дата увольнения
 * @property int $decret_start Дата начала декретного отпуска
 * @property int $decret_end Дата окончания декретного отпуска
 * @property int $staff_id
 * @property int $prof_id Профессия 
 * 
 *  * @property User[] $users
 */
class Perslist extends \yii\db\ActiveRecord
{
    public $start_date_temp;
    public $end_date_temp;
    public $decret_start_temp;
    public $decret_end_temp;
    public $errormod;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'perslist';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['gender', 'sec_empl', 'start_date', 'end_date', 'decret_start', 'decret_end', 'staff_id', 'prof_id'], 'safe'], //integer'],
            [['tabnum', 'abbr_name'], 'string', 'max' => 45],
            [['gender','tabnum', 'family_name', 'first_name', 'second_name', 'start_date_temp', 'staff_id', 'prof_id'], 'required', 'message'=>'Поле обязательно для заполнения'],
            [['start_date_temp', 'end_date_temp', 'decret_start_temp', 'decret_end_temp'], 'safe'],
            [['family_name', 'first_name', 'second_name'], 'string', 'max' => 40],
//            [['prof_id'], 'exist', 'skipOnError' => true, 'targetClass' => Proflist::className(), 'targetAttribute' => ['prof_id' => 'id']],
//            [['staff_id'], 'exist', 'skipOnError' => true, 'targetClass' => Stafflist::className(), 'targetAttribute' => ['staff_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'tabnum' => 'Табельный номер',
            'abbr_name' => 'ФИО',
            'family_name' => 'Фамилия',
            'first_name' => 'Имя',
            'second_name' => 'Отчество',
            'FullName' => 'Сотрудник',
            'gender' => 'Пол',
            'GenderName' => 'Пол',
            'sec_empl' => 'Повторный прием',
            'start_date' => 'Дата приема',
            'start_date_temp' => 'Дата приема',
            'end_date' => 'Дата увольнения',
            'end_date_temp' => 'Дата увольнения',
            'decret_start' => 'Начало дикретного отпуска',
            'decret_start_temp' => 'Начало дикретного отпуска',
            'decret_end' => 'Окончание дикретного отпуска',
            'decret_end_temp' => 'Окончание дикретного отпуска', 
            'staff_id' => 'Подразделение',
            'StaffName' => 'Подразделение',
            'prof_id' => 'Должность',
            'ProfName' => 'Должность',
        ];
    }

    public function getFullName()
    {
        if($this->second_name)
            return $this->family_name.' '.$this->first_name.' '.$this->second_name;
        else
            return $this->family_name.' '.$this->first_name;
    }

        /** 
    * @return \yii\db\ActiveQuery 
    */ 
   public function getNormCards() 
   { 
       return $this->hasMany(NormCard::className(), ['pers_id' => 'id']); 
   } 
 
   /** 
    * @return \yii\db\ActiveQuery 
    */ 
   public function getProf() 
   { 
       return $this->hasOne(Proflist::className(), ['id' => 'prof_id']); 
   } 
 
   public function getProfName()
   {
       if($this->prof)
           return $this->prof->name;
       else
           return '';
   }
   /** 
    * @return \yii\db\ActiveQuery 
    */ 
   public function getStaff() 
   { 
       return $this->hasOne(Stafflist::className(), ['id' => 'staff_id']); 
   }
   
   public function getStaffName()
   {
       if($this->staff)
           return $this->staff->AreaName;
       else
           return '';
   }
   
    public function getGenderName()
    {
        if($this->gender == 0) 
            return '';
        elseif ($this->gender == '1')
            return 'Мужской';
        else
            return 'Женский';
    }

    public function getEndDate()
    {
        if($this->end_date == 0)
            return '';
        else
            return $this->end_date;
    }
    
/*    public function getDecretStart()
    {
        if($this->decret_start == 0)
            return '';
        else
            return $this->decret_start;
    }
    
    public function getDecretEnd()
    {
        if($this->decret_end == 0)
            return '';
        else
            return $this->decret_end;
    }*/

    public static function getGenderArray()
    {
        return [
            0 => 'Не указан',
            1 => 'Мужской',
            2 => 'Женский',
        ];
    }

    public function getSexes()
    {
        return $this->genderArray[$this->gender];
    }

    public static function ValiteDate($date)
    {
        $test_data = preg_replace('/[^0-9\.]/u','',trim($date));
        $test_data_ar = explode('.',$test_data);
        if(@checkdate($test_data_ar[1],$test_data_ar[0],$test_data_ar[2])) {
            return true;
        }
        return false;
    }
    /**
 
       return $this->hasMany(User::className(), ['pers_id' => 'id']);
   }
    * 
    */
}
