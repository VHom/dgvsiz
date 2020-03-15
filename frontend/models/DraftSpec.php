<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "draft_spec".
 *
 * @property int $id
 * @property int $draft_id Накладная ВХО
 * @property int $remain_id Номенклатура склада
 * @property int $quant Количество
 * @property int $amout Степень износа
 * @property int $placed Размещение: 0-на складе, 1-нет
 *
 * @property Draft $draft
 * @property Storemain $remain
 * @property Storejournal[] $storejournals
 */
class DraftSpec extends \yii\db\ActiveRecord
{
    public $nomen_id;
    public $OutStoreName;
    public $InStoreName;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'draft_spec';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['draft_id', 'remain_id', 'quant', 'amout', 'placed'], 'integer'],
            [['nomen_id', 'outStoreName', 'InStoreName'], 'safe'],
            [['draft_id'], 'exist', 'skipOnError' => true, 'targetClass' => Draft::className(), 'targetAttribute' => ['draft_id' => 'id']],
            [['remain_id'], 'exist', 'skipOnError' => true, 'targetClass' => Storemain::className(), 'targetAttribute' => ['remain_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'draft_id' => 'Накладная',
            'remain_id' => 'Номенклатура',
            'NomenName' => 'Номенклатура',
            'quant' => 'Кол-во',
            'amout' => 'Износ',
            'placed' => 'Placed',
            'MeasName' => 'Ед. изм.',
            'nomen_id' => 'Номенклатура',
            'OutStoreName' => 'Откуда',
            'InStoreName' => 'Куда',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDraft()
    {
        return $this->hasOne(Draft::className(), ['id' => 'draft_id']);
    }

/*    public function getOutStoreName()
    {
        if($this->draft)
            return $this->draft->OutStoreName;
        else
            return '';
            
    }

    public function getInStoreName()
    {
        if($this->draft)
            return $this->draft->InStoreName;
        else
            return '';
            
    }
*/
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRemain()
    {
        return $this->hasOne(Storemain::className(), ['id' => 'remain_id']);
    }

    public function getNomenName()
    {
        if($this->remain)
            return $this->remain->NomenName;
        else
            return '';
    }

    public function getMeasName()
    {
        if($this->remain)
            return $this->remain->MeasName;
        else
            return '';
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getStorejournals()
    {
        return $this->hasMany(Storejournal::className(), ['drafspec_id' => 'id']);
    }
}
