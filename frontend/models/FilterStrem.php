<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "filter_strem".
 *
 * @property int $id
 * @property int $nomen_id
 * @property int $is_siz 1-ФО, 2-СИЗ
 * @property int $store_id
 * @property int $size_id
 * @property int $heigth_id
 * @property int $full_id
 * @property int $shirt_id
 * @property int $glove_id
 * @property string $amort Износ
 * @property int $head_id
 * @property int $user_id
 *
 * @property Sizelist $full
 * @property Sizelist $glove
 * @property Sizelist $head
 * @property Sizelist $heigth
 * @property Nomenclature $nomen
 * @property Sizelist $shirt
 * @property Sizelist $size
 * @property Storelist $store
 * @property User $user 
 */
class FilterStrem extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'filter_strem';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['nomen_id', 'is_siz', 'store_id', 'size_id', 'heigth_id', 
              'full_id', 'shirt_id', 'glove_id', 'head_id', 'user_id'], 'integer'],
            [['amort'], 'number'],
            [['full_id'], 'exist', 'skipOnError' => true, 'targetClass' => Sizelist::className(), 'targetAttribute' => ['full_id' => 'id']],
            [['glove_id'], 'exist', 'skipOnError' => true, 'targetClass' => Sizelist::className(), 'targetAttribute' => ['glove_id' => 'id']],
            [['head_id'], 'exist', 'skipOnError' => true, 'targetClass' => Sizelist::className(), 'targetAttribute' => ['head_id' => 'id']],
            [['heigth_id'], 'exist', 'skipOnError' => true, 'targetClass' => Sizelist::className(), 'targetAttribute' => ['heigth_id' => 'id']],
            [['nomen_id'], 'exist', 'skipOnError' => true, 'targetClass' => Nomenclature::className(), 'targetAttribute' => ['nomen_id' => 'id']],
            [['shirt_id'], 'exist', 'skipOnError' => true, 'targetClass' => Sizelist::className(), 'targetAttribute' => ['shirt_id' => 'id']],
            [['size_id'], 'exist', 'skipOnError' => true, 'targetClass' => Sizelist::className(), 'targetAttribute' => ['size_id' => 'id']],
            [['store_id'], 'exist', 'skipOnError' => true, 'targetClass' => Storelist::className(), 'targetAttribute' => ['store_id' => 'id']],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['user_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'nomen_id' => 'Номенклатура',
            'is_siz' => 'Тип',
            'store_id' => 'Склад',
            'size_id' => 'Размер',
            'heigth_id' => 'Рост',
            'full_id' => 'Полнота',
            'shirt_id' => 'Ворот',
            'glove_id' => 'Перчатки',
            'amort' => 'Износ',
            'head_id' => 'Голова',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getFull()
    {
        return $this->hasOne(Sizelist::className(), ['id' => 'full_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getGlove()
    {
        return $this->hasOne(Sizelist::className(), ['id' => 'glove_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getHead()
    {
        return $this->hasOne(Sizelist::className(), ['id' => 'head_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getHeigth()
    {
        return $this->hasOne(Sizelist::className(), ['id' => 'heigth_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getNomen()
    {
        return $this->hasOne(Nomenclature::className(), ['id' => 'nomen_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getShirt()
    {
        return $this->hasOne(Sizelist::className(), ['id' => 'shirt_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSize()
    {
        return $this->hasOne(Sizelist::className(), ['id' => 'size_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getStore()
    {
        return $this->hasOne(Storelist::className(), ['id' => 'store_id']);
    }
}
