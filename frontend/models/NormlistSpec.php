<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "normlist_spec".
 *
 * @property int $id
 * @property int $norm_id Норма
 * @property int $quant Количество
 * @property int $period Срок носки
 * @property string $code Статья
 * @property int $nomen_id Номенклатура
 * @property string $doc_osn Документ-основание для изменения норм по профессиям (по должности)
 * @property int $kind_id Тип номенклатуры (для указания размеров)
 * @property int $actual Актуадьность
 * @property string $prim Примечание
 *
 * @property Nomenkind $kind
 * @property Nomenclature $nomen
 * @property Normlist $norm
 */
class NormlistSpec extends \yii\db\ActiveRecord
{
    const ACTUALYES = 0;
    const ACTUALNO = 1;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'normlist_spec';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['norm_id', 'quant', 'nomen_id', 'kind_id'], 'required'],
            [['norm_id', 'quant', 'period', 'nomen_id', 'kind_id', 'actual'], 'integer'],
            [['code', 'doc_osn'], 'string', 'max' => 45],
            [['prim'], 'string', 'max' => 240],
            [['kind_id'], 'exist', 'skipOnError' => true, 'targetClass' => Nomenkind::className(), 'targetAttribute' => ['kind_id' => 'id']],
            [['nomen_id'], 'exist', 'skipOnError' => true, 'targetClass' => Nomenclature::className(), 'targetAttribute' => ['nomen_id' => 'id']],
            [['norm_id'], 'exist', 'skipOnError' => true, 'targetClass' => Normlist::className(), 'targetAttribute' => ['norm_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'norm_id' => 'Норма',
            'quant' => 'Кол-во',
            'period' => 'Срок носки',
            'code' => 'Статья',
            'nomen_id' => 'Номенклатура',
            'NomenName' => 'Номенклатура',
            'doc_osn' => 'Документ основание',
            'kind_id' => 'Размерная группа',
            'KindName' => 'Размерная группа',
            'actual' => 'Актуальность',
            'prim' => 'Примечание',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getKind()
    {
        return $this->hasOne(Nomenkind::className(), ['id' => 'kind_id']);
    }

    public function getKindName()
    {
        if($this->kind)
            return $this->kind->name;
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

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getNorm()
    {
        return $this->hasOne(Normlist::className(), ['id' => 'norm_id']);
    }
}
