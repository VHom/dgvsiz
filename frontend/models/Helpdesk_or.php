<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "helpdesk".
 *
 * @property int $id
 * @property int $help_id
 * @property int $date Дата сообщения
 * @property int $author Автор сообщения
 * @property string $content Содержание сообщения
 * @property int $state Статус сообщения: 0-открыт, 1-закрыт
 * @property int $state_date Дата смены сообщения
 * @property string $sort_field
 * @property int $help_number
 *
 * @property User $author0
 */
class Helpdesk extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'helpdesk';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['help_id', 'date', 'author', 'state', 'state_date', 'help_number'], 'integer'],
            [['content'], 'string', 'max' => 255],
            [['sort_field'], 'string', 'max' => 45],
            [['author'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['author' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'help_id' => 'Help ID',
            'date' => 'Date',
            'author' => 'Author',
            'content' => 'Content',
            'state' => 'State',
            'state_date' => 'State Date',
            'sort_field' => 'Sort Field',
            'help_number' => 'Help Number',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAuthor0()
    {
        return $this->hasOne(User::className(), ['id' => 'author']);
    }
}
