<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "operjournal".
 *
 * @property int $id
 * @property int $oper_id Исполнитель
 * @property int $oper_date Дата операции
 * @property string $oper_name Выполняемая операция
 * @property string $oper_obj Корректируемая таблица (модель)
 * @property string $oper_val Измененное (старое) значение
 * @property int $oper_val_id Идентификатор записи корректируемой таблицы
 *
 * @property User $oper
 */
class Operjournal extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'operjournal';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['oper_id', 'oper_date', 'oper_val_id'], 'integer'],
            [['oper_name', 'oper_val'], 'string', 'max' => 45],
            [['oper_obj'], 'string', 'max' => 160],
            [['oper_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['oper_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'oper_id' => 'Oper ID',
            'oper_date' => 'Дата',
            'oper_name' => 'Операция',
            'oper_obj' => 'Модель',
            'ModelName' => 'Модель',
            'oper_val' => 'Старое значение',
            'oper_val_id' => 'Oper Val ID',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOper()
    {
        return $this->hasOne(User::className(), ['id' => 'oper_id']);
    }
    
    public function getModelName()
    {
        if($this->oper_obj) {
            if($this->oper_obj == 'app\models\NormCardspec')
                return 'Нормы спецификации карточки сотрудника';
            elseif ($this->oper_obj == 'app\models\NormCard') 
                return 'Нормы карточки сотрудника';
            elseif ($this->oper_obj == 'app\models\Normlist') 
                return 'Нормы по профессии';
            elseif ($this->oper_obj == 'app\models\NormlistSpec') 
                return 'Спецификация норм по профессии';
            elseif ($this->oper_obj == 'app\models\Sizelist')    
                return 'Перечень размеров';
            elseif ($this->oper_obj == 'app\models\Nomenkind')    
                return 'Размерные группы';
        }
    }

        public static function Operjournal_insert($operobj,$opername,$old_value)
    {
        
        $model = new Operjournal();
        $model->oper_id = Yii::$app->user->id;
        $model->oper_date = time();
        $model->oper_obj = get_class($operobj);
        $model->oper_name = $opername;
        $model->oper_val = $old_value;
        $model->oper_val_id = $operobj->id;
//        throw new \yii\web\NotFoundHttpException('qq '.$model->oper_id.' - '.$model->oper_obj.' - '.$model->oper_val_id);
        $model->save(false);
    }
}
