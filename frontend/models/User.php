<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "user".
 *
 * @property int $id
 * @property string $username
 * @property string $auth_key
 * @property string $password_hash
 * @property string $password_reset_token
 * @property int $status
 * @property int $create_at
 * @property int $update_at
 * @property string $email
 * @property int $pers_id
 *
 * @property Perslist $pers
 */
class User extends \yii\db\ActiveRecord
{
    public $newPass1;
    public $newPass2;


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'user';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['username', 'password_hash', 'create_at'], 'required'],
            [['status', 'create_at', 'update_at', 'pers_id'], 'integer'],
            [['username', 'password_hash', 'password_reset_token'], 'string', 'max' => 255],
            [['auth_key'], 'string', 'max' => 32],
            [['email'], 'string', 'max' => 50],
            [['newPass1', 'newPass2'], 'safe'],
            [['pers_id'], 'exist', 'skipOnError' => true, 'targetClass' => Perslist::className(), 'targetAttribute' => ['pers_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'username' => 'Логин',
            'auth_key' => 'Auth Key',
            'password_hash' => 'Password Hash',
            'password_reset_token' => 'Password Reset Token',
            'status' => 'Status',
            'create_at' => 'Create At',
            'update_at' => 'Update At',
            'email' => 'Email',
            'pers_id' => 'Pers ID',
            'newPass1' => 'Введите новый пароль',
            'newPass2' => 'Повторите новый пароль',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPers()
    {
        return $this->hasOne(Perslist::className(), ['id' => 'pers_id']);
    }
    
    /**
     * Generates password hash from password and sets it to the model
     *
     * @param string $password
     */
    public function setPassword($password)
    {
        $this->password_hash = Yii::$app->security->generatePasswordHash($password);
    }

    /**
     * Generates "remember me" authentication key
     */
    public function generateAuthKey()
    {
        $this->auth_key = Yii::$app->security->generateRandomString();
    }


}
