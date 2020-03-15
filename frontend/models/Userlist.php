<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "userlist".
 *
 * @property int $id
 * @property int $user_id
 * @property int $role_id
 * @property string $family_name
 * @property string $first_name
 * @property string $second_name
 * @property int $staff_id
 * @property int $prof_id 
 * @property int $pers_id Сотрудник
 * @property int $actual Актуальность (блокировка) 0-актуальна, 1-заблокирована
 * @property int $rename Возможность изменения пароля 0-нет, 1-да
 *
 * @property Rolelist $role
 * @property Stafflist $staff
 * @property Proflist $prof
 * @property User $user
 */
class Userlist extends \yii\db\ActiveRecord
{
    public $login;
    public $pass1;
    public $pass2;
    public $gender;
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'userlist';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['user_id', 'role_id', 'staff_id', 'prof_id', 'actual', 'rename', 'pers_id'], 'integer'],
            [['login', 'pass1', 'pass2', 'gender'], 'safe'],
            [['family_name', 'first_name', 'second_name'], 'string', 'max' => 40],
            [['PersName'], 'safe'],
//            [['role_id'], 'exist', 'skipOnError' => true, 'targetClass' => Rolelist::className(), 'targetAttribute' => ['role_id' => 'id']],
//            [['staff_id'], 'exist', 'skipOnError' => true, 'targetClass' => Stafflist::className(), 'targetAttribute' => ['staff_id' => 'id']],
//            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['user_id' => 'id']],
//            [['pers_id'], 'exist', 'skipOnError' => true, 'targetClass' => Perslist::className(), 'targetAttribute' => ['pers_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_id' => 'User ID',
            'role_id' => 'Роль',
            'RoleName' => 'Роль',
            'family_name' => 'Фамилия',
            'first_name' => 'Имя',
            'second_name' => 'Отчество',
            'staff_id' => 'Подразделение',
            'StaffName' => 'Подразделение',
            'prof_id' => 'Должность',
            'ProfName' => 'Должность',
            'actual' => 'Актуальность',
            'Realy' => 'Актуальность',
            'rename' => 'Изменение пароля',
            'login' => 'Логин',
            'pass1' => 'Пароль',
            'pass2' => 'Повторите',
            'gender' => 'Пол',
            'GenderName' => 'Пол',
            'pers_id' => 'Сотрудник',
            'PersName' => 'Сотрудник',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRole()
    {
        return $this->hasOne(Rolelist::className(), ['id' => 'role_id']);
    }

    public function getRoleName()
    {
        if($this->role) {
            return $this->role->name;
        } else 
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
        if($this->pers) {
            return $this->pers->family_name.' '.$this->pers->first_name.' '.$this->pers->second_name;
        } else 
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
        {
            return $this->staff->AreaName;
        } else {
            return '';
        }
    }
    public function getProf()
    {
        return $this->hasOne(Proflist::className(), ['id' => 'prof_id']);
    }

    public function getProfName()
    {
        if($this->prof)
        {
            return $this->prof->name;
        } else {
            return '';
        }
    }
    
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }

    public function getGenderName()
    {
        if($this->user->pers->gender == 1)
            return 'Мужской';
        elseif($this->user->pers->gender == 2)
            return 'Женский';
        else
            return '';
    }

    
    public function getRealy()
    {
        if($this->actual)
        {
            if($this->actual == 0)
                return 'Актуален';
                elseif ($this->actual == 1) 
                    return 'Заблокирован';
        } else
            return 'Актуален';
    }
}
