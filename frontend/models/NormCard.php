<?php

namespace app\models;

use Yii;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "norm_card".
 *
 * @property int $id
 * @property int $pers_id Сотрудник
 * @property int $norm_id Нормы сотрудника
 * @property INT $ACTUAL Актуальность
 * @property string $prim Примечание
 *
 * @property Normlist $norm
 * @property Perslist $pers
 * @property NormCardspec[] $normCardspecs
 */
class NormCard extends \yii\db\ActiveRecord
{
    const NORMCARDYES = 0;
    const NORMCARDNO = 1;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'norm_card';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['pers_id', 'norm_id', 'actual'], 'integer'],
            [['prim'], 'string', 'max' => 240],
            [['norm_id'], 'exist', 'skipOnError' => true, 'targetClass' => Normlist::className(), 'targetAttribute' => ['norm_id' => 'id']],
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
            'pers_id' => 'Сотрудник',
            'PersName' => 'Сотрудник',
            'norm_id' => 'Норма',
            'TypeName' => 'Тип нормы',
            'gender' => 'Пол',
            'GenderName' => 'Пол',
            'prof_id' =>  'Должность',
            'ProfName' => 'Должность',
            'StaffName' => 'Подразделение',
            'actual' => 'Актуальность',
            'prim'=> 'Примечание',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getNorm()
    {
        return $this->hasOne(Normlist::className(), ['id' => 'norm_id']);
    }

    public function getGenderName()
    {
        if($this->norm)
            return $this->norm->GenderName;
        else
            return '';
    }

    public function getProfName()
    {
        if($this->norm)
            return $this->norm->ProfName;
        else
            return '';
    }

    public function getStaffName()
    {
        if($this->norm)
            return $this->norm->StaffName;
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
            return $this->pers->abbr_name;
        else
            return '';
    }

    public function getTypeName()
    {
        if($this->norm)
            return $this->norm->TypeName;
        else
            return '';
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getNormCardspecs()
    {
        return $this->hasMany(NormCardspec::className(), ['card_id' => 'id']);
    }

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

    public static function CardStaff($pers_id)
    {
        $model = Perslist::findOne($pers_id);
        if($norm = \app\models\Normlist::find()
            ->where('prof_id=:prof and staff_id=:staff and actual=:type', [
                ':prof' => $model->prof_id,
                ':staff' => $model->staff_id,
                ':type' => \app\models\Normlist::PROF])
            ->one()) {
            if ($norm) {
                $card = new \app\models\NormCard();
                $card->pers_id = $model->id;
                $card->norm_id = $norm->id;
                $card->save();
                foreach (\app\models\NormlistSpec::find()
                             ->where('norm_id=:card', [':card' => $card->norm_id])
                             ->all() as $rec) {
                    //Запись спецификации нормы
                    $spec = new \app\models\NormCardspec();
                    $spec->card_id = $card->id;
                    $spec->nomen_id = $rec->nomen_id;
                    $spec->quant = $rec->quant;
                    $spec->period = $rec->period;
                    $spec->save();
                }
            }
            return true;
        }
        else
            return false;
    }
}
