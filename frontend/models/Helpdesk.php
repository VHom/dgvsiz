<?php

namespace app\models;

use Yii;
use yii\web\NotFoundHttpException;

/**
 * This is the model class for table "helpdesk".
 *
 * @property int $id
 * @property int $help_id
 * @property int $date Дата сообщения
 * @property string $author Автор запроса
 * @property string $content Содержание сообщения
 * @property int $state Состояние запроса (0-открыт,1-закрыт)
 * @property int $state_date Дата смены состояния
 * @property string $sort_field
 * @property int $help_number
 */
class Helpdesk extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'helpdesk';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['help_id', 'date', 'state', 'state_date', 'help_number', 'author'], 'integer'],
            [['content'], 'required'],
            [['sort_field'], 'string', 'max' => 45],
            [['content'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'Номер сообщения',
            'help_id' => 'Help ID',
            'date' => 'Дата',
            'author' => 'Автор',
            'AuthorName' => 'Автор',
            'content' => 'Содержание',
            'state' => 'Состояние',
            'state_date' => 'Дата смены состояния',
            'sort_field' => 'Sort Field',
            'help_number' => 'Help Number',
            'helpNumb' => 'Номер обращения',
            'status' => 'Состояние',
            'helpdesksCount' => 'Ответы',
            'currentAuthor' => 'Автор последнего сообщения',
        ];
    }

    public function getAuth()
    {
        return $this->hasOne(User::className(), ['id' => 'author']);
    }

    public function getAuthorName()
    {
        if($this->auth) {
//            throw new NotFoundHttpException('qq '.$this->auth->id);
            $usr = Userlist::find()
                ->leftJoin('user', 'user.id=userlist.user_id')
                ->where('user.id=:user', [':user' => $this->auth->id])
                ->one();
            return $usr->family_name . ' ' . $usr->first_name . ' ' . $usr->second_name;
        } else
            return '';
    }
    public function getHelpNumb()
    {
        if ($this->help_id)
            return '    '.$this->sort_field;
        else
            return $this->id;
    }

    static public function getStatuses()
    {
        return ['Открыт','Закрыт','Запрос уточнения','Предоставлено уточнение','Аннулирован'];
    }

    static public function getDepStatuses()
    {
        return [1 => 'Закрыт',2 => 'Запрос уточнения',3 => 'Предоставлено уточнение', 4 => 'Аннулирован'];
    }

    static public function getActiveStatuses()
    {
        return [2 => 'Запрос уточнения',3 => 'Предоставлено уточнение'];
    }

    static public function getEndedStatuses()
    {
        return [1 => 'Закрыт',4 => 'Аннулирован'];
    }

    static public function getDefStatuses()
    {
        return [0 => 'Открыт'];
    }


    public function getStatus()
    {
        return $this->statuses[$this->state];
    }

    public function getCurrentAuthor()
    {
        $author = $this->author;
        if ($this->helpdesks)
        {
            foreach($this->helpdesks as $rec)
                $author = $rec->author;
        }
        return $author;
    }

    public function getDefValues()
    {
        if (!$this->author)
            $this->author = Yii::$app->user->identity->username;

        if (!$this->date)
            $this->date = time()+3600;

        if (!$this->state)
            $this->state = 0;

        if (!$this->state_date)
            $this->state_date = time()+3600;

        if ($this->help_id && !$this->help_number)
        {
            if ($help_numb = Helpdesk::find()
                ->where('help_id = :p_id',[':p_id' => $this->help_id])
                ->max('help_number'))
                $this->help_number = $help_numb+1;
            else
                $this->help_number = 1;
        }
    }

    public function getHelpdesks()
    {
        return $this->hasMany(Helpdesk::className(), ['help_id' => 'id']);
    }

    public function getHelpdesksCount()
    {
        return $this->hasMany(Helpdesk::className(), ['help_id' => 'id'])->count();
    }


    public function beforeSave($insert)
    {
        $this->defValues;
        return parent::beforeSave($insert);
    }

    public function afterSave($insert, $changedAttributes)
    {
        if ($this->help_id && !$this->sort_field)
            $this->sort_field = $this->id.' '.$this->help_number;
        return parent::afterSave($insert, $changedAttributes);
    }
}
