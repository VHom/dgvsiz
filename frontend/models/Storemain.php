<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "storemain".
 *
 * @property int $id
 * @property int $store_id Склад
 * @property int $nomen_id Номенклатур
 * @property int $size_id Размер
 * @property int $height_id Рост
 * @property int $full_id Полнота
 * @property int $shirt_id Размер по вороту
 * @property int $shoes_id Размер обуви
 * @property int $glove_id Размер перчаток
 * @property int $head_id Размер головы
 * @property string $rem_cost Остаточная стоимость
 * @property string $amout Износ
 * @property int $quant Количество
 * @property string $sertif Сертификат
 * @property int $is_siz Тип номенклатуры
 * @property int $actual Актуальность (0-актуально,1- не актуально)
 * @property int $remain_id Ссылка на комплект
 *
 * @property DraftSpec[] $draftSpecs
 * @property InvoiceSpec[] $invoiceSpecs
 * @property NormCardspec[] $normCardspecs
 * @property Sizelist $head
 * @property Sizelist $full
 * @property Sizelist $glove
 * @property Sizelist $height
 * @property Sizelist $shirt
 * @property Sizelist $shoes
 * @property Sizelist $size
 * @property Storelist $store
 */
class Storemain extends \yii\db\ActiveRecord
{
    public $card_id;
    public $cardspec_id;

    const REMACTUAL = 0;
    const REMNOACTUAL = 1;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'storemain';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['store_id', 'nomen_id', 'size_id', 'height_id', 'full_id', 'actual',
              'shirt_id', 'shoes_id', 'glove_id', 'quant', 'head_id', 'is_siz', 'remain_id'], 'integer'],
            [['rem_cost', 'amout'], 'number'],
            [['card_id'], 'safe'],
            [['sertif'], 'string', 'max' => 240],
            [['head_id'], 'exist', 'skipOnError' => true, 'targetClass' => Sizelist::className(), 'targetAttribute' => ['head_id' => 'id']],
            [['full_id'], 'exist', 'skipOnError' => true, 'targetClass' => Sizelist::className(), 'targetAttribute' => ['full_id' => 'id']],
            [['glove_id'], 'exist', 'skipOnError' => true, 'targetClass' => Sizelist::className(), 'targetAttribute' => ['glove_id' => 'id']],
            [['height_id'], 'exist', 'skipOnError' => true, 'targetClass' => Sizelist::className(), 'targetAttribute' => ['height_id' => 'id']],
            [['nomen_id'], 'exist', 'skipOnError' => true, 'targetClass' => Nomenclature::className(), 'targetAttribute' => ['nomen_id' => 'id']],
            [['remain_id'], 'exist', 'skipOnError' => true, 'targetClass' => Storemain::className(), 'targetAttribute' => ['remain_id' => 'id']],
            [['shirt_id'], 'exist', 'skipOnError' => true, 'targetClass' => Sizelist::className(), 'targetAttribute' => ['shirt_id' => 'id']],
            [['shoes_id'], 'exist', 'skipOnError' => true, 'targetClass' => Sizelist::className(), 'targetAttribute' => ['shoes_id' => 'id']],
            [['size_id'], 'exist', 'skipOnError' => true, 'targetClass' => Sizelist::className(), 'targetAttribute' => ['size_id' => 'id']],
            [['store_id'], 'exist', 'skipOnError' => true, 'targetClass' => Storelist::className(), 'targetAttribute' => ['store_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'Id',
            'store_id' => 'Склад',
            'StoreName' => 'Склад',
            'nomen_id' => 'Номенклатура',
            'NomenName' => 'Номенклатура',
            'NomenSize' => 'Номенклатура',
            'NomenSize' => 'Номенклатура с размерами',
            'FullNomenName' => 'Номенклатура',
            'size_id' => 'Размер одежды',
            'SizeName' => 'Размер одежды',
            'height_id' => 'Рост',
            'HeightName' => 'Рост',
            'full_id' => 'Полнота',
            'FullName' => 'Полнота',
            'shirt_id' => 'Размер по вороту',
            'ShirtName' => 'Размер по вороту',
            'shoes_id' => 'Размер обуви',
            'ShoesName' => 'Размер обуви',
            'glove_id' => 'Размер перчаток',
            'GloveName' => 'Размер перчаток',
            'head_id' => 'Размер головы',
            'HeadName' => 'Размер головы',
            'rem_cost' => 'Rem Cost',
            'amout' => 'Износ',
            'quant' => 'Кол-во',
            'sertif' => 'Сертификат',
            'is_siz' => 'Тип',
            'IsSiz' => 'Тип',
            'card_id' => 'card_id',
            'actual' => 'Актуальность',
            'FullSize' => 'Размеры',
            'remain_id' => 'Комплект',
        ];
    }

    public function getIsSiz()
    {
        if($this->is_siz == 0)
            return 'СИЗ';
        elseif($this->is_siz == 1)
            return 'ФО';
        else
            return '';
    }
    
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getShirtGr()
    {
        return $this->hasOne(Sizelist::className(), ['id' => 'shirt_id']);
    }

    public function getShirtName()
    {
        if($this->shirtGr)
            return $this->shirtGr->size;
        else
            return '';
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getFullGr()
    {
        return $this->hasOne(Sizelist::className(), ['id' => 'full_id']);
    }

    public function getFullName()
    {
        if($this->fullGr)
            return $this->fullGr->size;
        else
            return '';
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getGloveGr()
    {
        return $this->hasOne(Sizelist::className(), ['id' => 'glove_id']);
    }

    public function getGloveName()
    {
        if($this->gloveGr)
            return $this->gloveGr->size;
        else
            return '';
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getHeightGr()
    {
        return $this->hasOne(Sizelist::className(), ['id' => 'height_id']);
    }

    public function getHeightName()
    {
        IF($this->heightGr)
            return $this->heightGr->size;
        else
            return '';
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRemain()
    {
        return $this->hasOne(Storemain::className(), ['id' => 'remain_id']);
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

    public function getFullNomenName()
    {
        if($this->nomen) {
//            return $this->nomen->name;
            $fullname = $this->nomen->name;
            if($this->size_id)
                $fullname = $fullname.' размер:'.$this->SizeName;
            if($this->height_id)
                $fullname = $fullname.' рост:'.$this->HeightName;
            if($this->full_id)
                $fullname = $fullname.' полнота:'.$this->FullName;
            if($this->shirt_id)
                $fullname = $fullname.' по вороту:'.$this->ShirtName;
           if($this->head_id)
                $fullname = $fullname.'головной убор:'.$this->HeadName;
             if($this->shoes_id)
                $fullname = $fullname.' размер:'.$this->ShoesName;
            if($this->glove_id)
                $fullname = $fullname.' перчатки:'.$this->GloveName;
            $fullname = $fullname.' износ:'.$this->amout.'%'.' Остаток:'.$this->quant.' '.$this->MeasName;
           return $fullname;
        }
         else
            return '';
    }
    
    public function getNomenSize()
    {
        if($this->nomen) {
            $fullname = $this->nomen->name;
            if($this->size_id)
                $fullname = $fullname.' размер:'.$this->SizeName;
            if($this->height_id)
                $fullname = $fullname.' рост:'.$this->HeightName;
            if($this->full_id)
                $fullname = $fullname.' полнота:'.$this->FullName;
            if($this->shirt_id)
                $fullname = $fullname.' по вороту:'.$this->ShirtName;
           if($this->head_id)
                $fullname = $fullname.'головной убор:'.$this->HeadName;
             if($this->shoes_id)
                $fullname = $fullname.' размер:'.$this->ShoesName;
            if($this->glove_id)
                $fullname = $fullname.' перчатки:'.$this->GloveName;
           return $fullname;
        }
         else
            return '';
    }

    public function getFullSize()
    {
        if($this->nomen) {
            $fullname = '';
            if($this->size_id)
                $fullname = $fullname.' размер:'.$this->SizeName;
            if($this->height_id)
                $fullname = $fullname.' рост:'.$this->HeightName;
            if($this->full_id)
                $fullname = $fullname.' полнота:'.$this->FullName;
            if($this->shirt_id)
                $fullname = $fullname.' по вороту:'.$this->ShirtName;
           if($this->head_id)
                $fullname = $fullname.'головной убор:'.$this->HeadName;
             if($this->shoes_id)
                $fullname = $fullname.' размер:'.$this->ShoesName;
            if($this->glove_id)
                $fullname = $fullname.' перчатки:'.$this->GloveName;
           return $fullname;
        }
         else
            return '';
    }

    public function getMeasName()
    {
        if($this->nomen)
            return $this->nomen->MeasName;
        else
            return '';
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getShoesGr()
    {
        return $this->hasOne(Sizelist::className(), ['id' => 'shoes_id']);
    }

    public function getShoesName()
    {
        if($this->shoesGr)
            return $this->shoesGr->size;
        else
            return '';
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getHeadGr()
    {
        return $this->hasOne(Sizelist::className(), ['id' => 'head_id']);
    }

    public function getHeadName()
    {
        if($this->headGr)
            return $this->headGr->size;
        else
            return '';
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSizeGr()
    {
        return $this->hasOne(Sizelist::className(), ['id' => 'size_id']);
    }

    public function getSizeName()
    {
        if($this->sizeGr)
            return $this->sizeGr->size;
        elseif ($this->headGr)
            return $this->headGr->size;
        elseif ($this->shirtGr)
            return $this->shirtGr->size;
        elseif ($this->shoesGr)
            return $this->shoesGr->size;
        elseif ($this->gloveGr)
            return $this->gloveGr->size;
        else
            return '';
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getStore()
    {
        return $this->hasOne(Storelist::className(), ['id' => 'store_id']);
    }
    
    public function getStoreName()
    {
        if($this->store)
            return $this->store->name;
        else
            return '';
    }

    public static function RemainTest($id,$store_id)
    {
        $model = InorderSpec::findOne($id);
        $kind = \app\models\Nomenkind::find()
                ->leftJoin('nomenclature','nomenclature.kind_id=nomenkind.id')
                ->where('nomenclature.id=:nomen',[':nomen'=>$model->nomen_id])
                ->one();
        $remstore = -1;
        if($kind->head_gr) {
            if($remain = \app\models\Storemain::find()
                    ->where('nomen_id=:nomen and store_id=:store and amout =0 and head_id=:head and is_siz=:siz',
                        [':nomen'=>$model->nomen_id,':store'=>$store_id,':siz'=>$model->is_siz,
                                        ':head'=>$model->head_id])
                    ->one()) 
                $remstore = $remain->quant; 
            }
            elseif($kind->glove_gr) {
                if($remain = \app\models\Storemain::find()
                        ->where('nomen_id=:nomen and store_id=:store and amout =0  and is_siz=:siz '
                                . 'and glove_id=:glove',
                                [':nomen'=>$model->nomen_id,':store'=>$store_id,':siz'=>$model->is_siz,
                                    ':glove'=>$model->glove_id])
                        ->one()) 
                    $remstore = $remain->quant; 
            }
            elseif($kind->shoes_gr) {
                if($remain = \app\models\Storemain::find()
                        ->where('nomen_id=:nomen and store_id=:store and amout =0 and is_siz=:siz'
                                . ' and shoes_id=:shoes',
                               [':nomen'=>$model->nomen_id,':store'=>$store_id,':siz'=>$model->is_siz,
                                    ':shoes'=>$model->shoes_id])
                        ->one()) 
                    $remstore = $remain->quant; 
//                throw new \yii\web\NotFoundHttpException('qq - '.$remstore);
            }
            elseif($kind->size_gr && $kind->full_gr && $kind->height_gr && $kind->shirt_gr) {
                if($remain = \app\models\Storemain::find()
                        ->where('nomen_id=:nomen and store_id=:store and amout =0 '
                                . 'and size_id=:size and height_id=:heignt and full_id=:full and is_siz=:siz'
                                . 'and shirt_id=:shirt',
                                [':nomen'=>$model->nomen_id,':store'=>$store_id,':siz'=>$model->is_siz,
                                    ':size'=>$model->size_id, ':height'=>$model->height_id,
                                    ':full'=>$model->full_id, ':shirt'=>$model->shirt_id])
                        ->one()) 
                    $remstore = $remain->quant; 
            }
            elseif($kind->size_gr && $kind->full_gr && $kind->height_gr) {
                if($remain = \app\models\Storemain::find()
                        ->where('nomen_id=:nomen and store_id=:store and amout =0 and is_siz=:siz '
                                . 'and size_id=:size and height_id=:height and full_id=:full',
                                [':nomen'=>$model->nomen_id,':store'=>$store_id,':siz'=>$model->is_siz,
                                    ':size'=>$model->size_id, ':height'=>$model->height_id,':full'=>$model->full_id])
                        ->one()) 
                    $remstore = $remain->quant; 
            }
            elseif($kind->size_gr && $kind->full_gr) {
                if($remain = \app\models\Storemain::find()
                        ->where('nomen_id=:nomen and store_id=:store and amout =0 and is_siz=:siz '
                                . 'and size_id=:size and full_id=:full',
                                [':nomen'=>$model->nomen_id,':store'=>$store_id,':siz'=>$model->is_siz,
                                    ':size'=>$model->size_id,':full'=>$model->full_id])
                        ->one()) 
                    $remstore = $remain->quant; 
            }
            elseif($kind->size_gr) {
                if($remain = \app\models\Storemain::find()
                        ->where('nomen_id=:nomen and store_id=:store and amout =0 and is_siz=:siz '
                                . 'and size_id=:size',
                                [':nomen'=>$model->nomen_id,':store'=>$store_id,':siz'=>$model->is_siz,
                                    ':size'=>$model->size_id])
                        ->one()) 
                    $remstore = $remain->quant; 
        }
        return $remstore;
    }
    public static function RemainId($id,$store_id)
    {
        $model = InorderSpec::findOne($id);
        $kind = \app\models\Nomenkind::find()
                ->leftJoin('nomenclature','nomenclature.kind_id=nomenkind.id')
                ->where('nomenclature.id=:nomen',[':nomen'=>$model->nomen_id])
                ->one();
        $remain_id = 0;
        if($kind) {
        if($kind->head_gr != 0) {
            if($remain = \app\models\Storemain::find()
                    ->where('nomen_id=:nomen and store_id=:store and amout =0 and head_id=:head and is_siz=:siz',
                        [':nomen'=>$model->nomen_id,':store'=>$model->store_id,':siz'=>$model->is_siz,
                                        ':head'=>$model->head_id])
                    ->one()) 
                $remain_id = $remain->id; 
            }
            elseif($kind->glove_gr != 0) {
                if($remain = \app\models\Storemain::find()
                        ->where('nomen_id=:nomen and store_id=:store and amout =0  and is_siz=:siz '
                                . 'and glove_id=:glove',
                                [':nomen'=>$model->nomen_id,':store'=>$model->store_id,':siz'=>$model->is_siz,
                                    ':glove'=>$model->glove_id])
                        ->one()) 
                    $remain_id = $remain->id; 
            }
            elseif($kind->shoes_gr != 0) {
                if($remain = \app\models\Storemain::find()
                        ->where('nomen_id=:nomen and store_id=:store and amout =0 and is_siz=:siz'
                                . ' and shoes_id=:shoes',
                               [':nomen'=>$model->nomen_id,':store'=>$model->store_id,':siz'=>$model->is_siz,
                                    ':shoes'=>$model->shoes_id])
                        ->one()) 
//                throw new \yii\web\NotFoundHttpException('qq - '.$remain->id);
                    $remain_id = $remain->id; 
            }
            elseif($kind->size_gr != 0 && $kind->full_gr != 0 && $kind->height_gr != 0 && $kind->shirt_gr != 0) {
                if($remain = \app\models\Storemain::find()
                        ->where('nomen_id=:nomen and store_id=:store and amout =0 and is_siz=:siz '
                                . 'and size_id=:size and height_id=:height and full_id=:full '
                                . 'and shirt_id=:shirt',
                                [':nomen'=>$model->nomen_id,':store'=>$model->store_id,':siz'=>$model->is_siz,
                                    ':size'=>$model->size_id, ':height'=>$model->height_id,
                                    ':full'=>$model->full_id, ':shirt'=>$model->shirt_id])
                        ->one()) 
                    $remain_id = $remain->id; 
            }
            elseif($kind->size_gr != 0 && $kind->full_gr != 0 && $kind->height_gr != 0) {
                if($remain = \app\models\Storemain::find()
                        ->where('nomen_id=:nomen and store_id=:store and amout =0 and is_siz=:siz '
                                . 'and size_id=:size and height_id=:height and full_id=:full',
                                [':nomen'=>$model->nomen_id,':store'=>$model->store_id,':siz'=>$model->is_siz,
                                    ':size'=>$model->size_id, ':height'=>$model->height_id,':full'=>$model->full_id])
                        ->one()) 
                    $remain_id = $remain->id; 
            }
            elseif($kind->size_gr != 0 && $kind->full_gr != 0) {
                if($remain = \app\models\Storemain::find()
                        ->where('nomen_id=:nomen and store_id=:store and amout =0 and is_siz=:siz '
                                . 'and size_id=:size and full_id=:full',
                                [':nomen'=>$model->nomen_id,':store'=>$model->store_id,':siz'=>$model->is_siz,
                                    ':size'=>$model->size_id,':full'=>$model->full_id])
                        ->one()) 
                    $remain_id = $remain->id; 
            }
            elseif($kind->size_gr != 0) {
                if($remain = \app\models\Storemain::find()
                        ->where('nomen_id=:nomen and store_id=:store and amout =0 and is_siz=:siz '
                                . 'and size_id=:size',
                                [':nomen'=>$model->nomen_id,':store'=>$model->store_id,':siz'=>$model->is_siz,
                                    ':size'=>$model->size_id])
                        ->one()) 
                    $remain_id = $remain->id; 
            } else {
                if($remain = \app\models\Storemain::find()
                        ->where('nomen_id=:nomen and store_id=:store and amout =0 ',
                                [':nomen'=>$model->nomen_id,':store'=>$model->store_id])
                        ->one()) 
                    $remain_id = $remain->id; 
            }
        }
            
        return $remain_id;
    }
}
