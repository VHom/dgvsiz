<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "norm_cardspec".
 *
 * @property int $id
 * @property int $card_id Карточка сотрудника
 * @property int $invoice_id Расходная накладная
 * @property int $quant Количество по норме
 * @property int $date_in Дата выдачи
 * @property int $date_out Дата окончания
 * @property int $nomen_id Номенклатура по норме
 * @property int $quant_fct Количество получено
 * @property int $amort Степень износа
 * @property int $period Срок носки
 * @property int $analog_id Номенклатура по факту
 * @property string $prim Примечание
 * @property int $active Признак активной строки
 *
 * @property NormCard $card
 * @property Nomenclature $nomen
 */
class NormCardspec extends \yii\db\ActiveRecord
{
    const CARDSPECYES = 0;//актуальна
    const CARDSPECNO = 1;//не актуальна
    const CARDSPECUND = 2;//не определена

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'norm_cardspec';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['card_id', 'quant', 'date_in', 'date_out', 'nomen_id', 'quant_fct', 'period', 'invoice_id',
                'analog_id', 'actual', 'active'], 'integer'],
            [['prim'], 'string', 'max' => 240],
            [['card_id'], 'exist', 'skipOnError' => true, 'targetClass' => NormCard::className(), 'targetAttribute' => ['card_id' => 'id']],
            [['nomen_id'], 'exist', 'skipOnError' => true, 'targetClass' => Nomenclature::className(), 'targetAttribute' => ['nomen_id' => 'id']],
            [['invoice_id'], 'exist', 'skipOnError' => true, 'targetClass' => Invoice::className(), 'targetAttribute' => ['invoice_id' => 'id']],
            [['analog_id'], 'exist', 'skipOnError' => true, 'targetClass' => Storemain::className(), 'targetAttribute' => ['analog_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'card_id' => 'Карточка сотрудника',
            'quant' => 'Норма',
            'quant_fct' => 'Факт',
            'date_in' => 'Дата выдачи',
            'date_out' => 'Срок',
            'DateOut' => 'Срок',
            'nomen_id' => 'Номенклатура по норме',
            'NomenName' => 'Номенклатура',
            'analog_id' => 'Номенклатура по факту',
            'AnalogName' => 'Допустимая замена',
            'PersName' => 'Сотрудник',
            'amort' => 'Износ',
            'period' => 'Период',
            'invoice_id' => 'Расходная накладная',
            'actual' => 'Статус',
            'prim' => 'Примечание',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCard()
    {
        return $this->hasOne(NormCard::className(), ['id' => 'card_id']);
    }

    public function getPersName()
    {
        if($this->card)
            return $this->card->PersName;
        else
            return '';
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
            return '';
    }

    public function getAnalog()
    {
        return $this->hasOne(Storemain::className(), ['id' => 'analog_id']);
    }
    
    public function getAnalogName()
    {
        if($this->analog)
            return $this->analog->NomenNameSize;
        else
            return '';
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getInvoice()
    {
        return $this->hasOne(Invoice::className(), ['id' => 'invoice_id']);
    }
    
    public function getDateOut()
    {
        if($this->date_in)
            return NormCardspec::DateEnd ($this->date_in, $this->period);
        else
            return NULL;
    }


//    public static function CulcAmort($card_id,)
    
    public static function DateEnd($tdate,$tperiod)
    {
//        throw new \yii\web\NotFoundHttpException('qq '.$tdate.' - '.$tperiod);
        $date_test = date('Y-m-d',$tdate);
        $tYear = substr($date_test, 0,4);
        $tMonth = substr($date_test,5,2);
        $tDay = substr($date_test,8,2);
        $nYear = floor(($tMonth + $tperiod) / 12);
        $nMonth = $tMonth  + ($tperiod - (12 * $nYear));
        if($nMonth>12)
            $nMonth = $nMonth - 12;
        else if($nMonth == 0) 
            {
                $nMonth = 12;
                $nYear = $nYear -1;
            }
        $tYear = $nYear + $tYear;
        $test = $tYear.'-'.$nMonth.'-'.$tDay;
        $date_test = Yii::$app->formatter->asDate($test,'php:d.m.Y');
//        throw new \yii\web\NotFoundHttpException('qq '.$test.' - '.$date_test);
        return $date_test;
    }
    
}
