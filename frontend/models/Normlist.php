<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "normlist".
 *
 * @property int $id
 * @property int $staff_id Подразделение
 * @property int $norm_type Тип нормы: 0-по профессиям, 1-индивидуальная 
 * @property string $code Статья
 * @property int $gender Пол: 0-женский, 1-мужской, 2-общий
 * @property string $code Статья
 * @property string $doc_osn Документ основание для индивидуальных норм
 * @property int $prof_id Профессия
 * @property string $prim Примечание
 *
 * @property Stafflist $staff_id
 */
class Normlist extends \yii\db\ActiveRecord
{
    const PROF = 0;
    const INDIVID = 1;
    
    const ACTUALYES = 0;
    const ACTUALNO = 1;

        /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'normlist';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['staff_id', 'norm_type', 'gender', 'prof_id'], 'integer'],
            [['code', 'doc_osn'], 'string', 'max' => 45],
            [['prim'], 'string', 'max' => 240],
            [['TypeName', 'GenderName'], 'safe'],
            [['staff_id'], 'exist', 'skipOnError' => true, 'targetClass' => Stafflist::className(), 'targetAttribute' => ['staff_id' => 'id']],
            [['prof_id'], 'exist', 'skipOnError' => true, 'targetClass' => search\Proflist::className(), 'targetAttribute' => ['prof_id' => 'id']],
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
            'norm_type' => 'Тип нормы',
            'TypeName' => 'Тип нормы',
            'code' => 'Код',
            'gender' => 'Пол',
            'GenderName' => 'Пол',
            'doc_osn' =>'Документ основание',
            'prof_id' => 'Профессия',
            'ProfName' => 'Профессия',
            'prim' => 'Примечание',
            
        ];
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
//           if($this->staff && $this->staff->area)
            return $this->staff->area->name;
//           elseif($this->staff && $this->comp)
//               return $this->staff->comp->name;
        else
            return '';
    }
    
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

    public function getGenderName()
    {
        if($this->gender == 0) 
            return '';
        elseif ($this->gender == '1')
            return 'Мужской';
        else
            return 'Женский';
    }

    public function getTypeName()
    {
        if($this->norm_type) {
            if($this->norm_type == 0)
                return 'По профессиям';
            elseif($this->norm_type == 1)
                return 'Индивидуально';}
            else
                return '';
    }
    
}
