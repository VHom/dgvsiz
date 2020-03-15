<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "deficit_spec".
 *
 * @property int $id
 * @property int $statement_id Заявка
 * @property int $nomen_id Номенклатура по норме
 * @property int $quant Норма
 * @property int $kind_id Разметочная таблица
 * @property string $def_name Дефицит - наименование
 * @property int $def_quant Дефицит - количество
 * @property int $quant_store Количество остатков на складах
 * @property int $nomen_store Номенклатура на складе
 * @property string $store_note Примечание по остаткам на складах
 * @property int $quant_fact Количество по факту
 * @property int $nomen_fact Номенклатура по факту
 * @property string $analog_note Примечание по допустимых заменах
 * @property int $sign_choice Признак выбора
 * @property int $nomen_deficit Номенклатура дефицита
 * @property int $quant_deficit Дефицит
 * @property int $date_end Срок
 *
 * @property Nomenkind $kind
 * @property Nomenclature $nomen
 * @property DeficitStatment $statement
 * @property Storemain $storefact
 * @property Storemain $storeord
 * @property Storemain $deficit 
 */
class DeficitSpec extends \yii\db\ActiveRecord
{
    const ACTUAL_YES = 0;
    const ACTUAL_NO = 1;

    public $staff_id;
    public $date_end_temp;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'deficit_spec';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['statement_id', 'nomen_id'], 'required'],
            [['statement_id', 'nomen_id', 'quant', 'kind_id', 'def_quant', 'nomen_store', 
                 'quant_store', 'quant_fact', 'nomen_fact', 'sign_choice', 'nomen_deficit', 
                 'quant_deficit', 'date_end'], 'integer'],
            [['def_name', 'store_note', 'analog_note'], 'string', 'max' => 240],
            [['staff_id', 'date_end_temp'], 'safe'],
            [['kind_id'], 'exist', 'skipOnError' => true, 'targetClass' => Nomenkind::className(), 'targetAttribute' => ['kind_id' => 'id']],
            [['nomen_id'], 'exist', 'skipOnError' => true, 'targetClass' => Nomenclature::className(), 'targetAttribute' => ['nomen_id' => 'id']],
            [['statement_id'], 'exist', 'skipOnError' => true, 'targetClass' => DeficitStatment::className(), 'targetAttribute' => ['statement_id' => 'id']],
            [['nomen_fact'], 'exist', 'skipOnError' => true, 'targetClass' => Storemain::className(), 'targetAttribute' => ['nomen_fact' => 'id']],
            [['nomen_store'], 'exist', 'skipOnError' => true, 'targetClass' => Storemain::className(), 'targetAttribute' => ['nomen_store' => 'id']],
            [['nomen_deficit'], 'exist', 'skipOnError' => true, 'targetClass' => Nomenclature::className(), 'targetAttribute' => ['nomen_deficit' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'statement_id' => 'Дефицитная ведомость',
            'nomen_id' => 'Номенклатура по норме',
            'NomenName' => 'Номенклатура по норме',
            'quant' => 'Норма',
            'date_end' => 'Срок',
            'kind_id' => 'Группа',
            'def_quant' => 'Дефицит',
            'nomen_store' => 'Номенклатура на складе',
            'store_note' => 'Примечание по складу',
            'nomen_fact' => 'Номенклатура по факту',
            'NomenFact' => 'Номенклатура по факту',
            'quant_fact' => 'Факт',
            'NomenStore' => 'Номенклатура на складе',
            'quant_store' => 'Наличие',
            'nomen_deficit' => 'Номенклатура дефицита',
            'NomenDeficit' => 'Номенклатура дефицита',
            'quant_deficit' => 'Дефицит',
            'analog_note' => 'Примечание по аналогам',
            'DeficitName' => 'Номенклатура дефицит',
            'sign_choice' => 'Выбор',
            'def_name' => 'Номенклатура дефицита',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getKind()
    {
        return $this->hasOne(Nomenkind::className(), ['id' => 'kind_id']);
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
    public function getStatement()
    {
        return $this->hasOne(DeficitStatment::className(), ['id' => 'statement_id']);
    }
    
    public function getStorefact()
    {
        return $this->hasOne(Storemain::className(), ['id' => 'nomen_store']);
    }
    
    public function getNomenFact()
    {
        if($this->storefact)
            return $this->storefact->nomen->name;
    }

    public function getStoreord()
    {
        return $this->hasOne(Storemain::className(), ['id' => 'nomen_fact']);
    }
    
    public function getNomenStore()
    {
        if($this->storeord)
            return $this->storeord->nomen->name;
        else
            return '';
    }

    public function getDeficit()
    {
        return $this->hasOne(Nomenclature::className(), ['id' => 'nomen_deficit']);
    }
    
    public function getDeficitName()
    {
        if($this->deficit)
            return $this->deficit->name;
    }

    public static function DateReport($doc_date,$period)
    {
//Определение даты окончания срока использования                    
        $date_test = date('Y-m-d',$doc_date);
        $tYear = substr($date_test, 0,4);
        $tMonth = substr($date_test,5,2);
        $tDay = substr($date_test,8,2);
        $nYear = floor(($tMonth + $period) / 12);
//                        throw new NotFoundHttpException('aa = '.$nYear.' - '.$tMonth.' - '.$period.' - '.$tMonth);
        $nMonth = $tMonth  + ($period - (12 * $nYear));
        if($nMonth>12)
            $nMonth = $nMonth - 12;
        else if($nMonth == 0) 
        {
            $nMonth = 12;
            $nYear = $nYear -1;
        }
        $tYear = $nYear + $tYear;
        $test = $tYear.'-'.$nMonth.'-'.$tDay;
        $_date_test = Yii::$app->formatter->asDate($test,'php:d.m.Y');
        return Yii::$app->formatter->asDatetime($_date_test, 'php:d.m.Y');
    }
    
/* Формирование строки размеров по сотруднику и номенклатуре по антропологическим параметрам*/    
    public static function DeficitNomenSize($pers_id,$nomen_id)
    {
        $kind = Nomenkind::find()
                ->leftJoin('nomenclature','nomenclature.kind_id=nomenkind.id')
                ->where('nomenclature.id=:nomen',[':nomen'=>$nomen_id])
                ->one();
        $nomen = Nomenclature::findOne($nomen_id);
        $nomen_size = $nomen->name;
        if($kind->size_gr == 1)
        {
            $anthrop = PersAnthrop::find()
                    ->where('pers_id=:pers and name=:tsize',
                            [':pers'=>$pers_id, ':tsize'=>"Размер"])
                    ->one();
            $nomen_size = $nomen_size.' " Размер: " '.$anthrop->val;
        }   
        if($kind->height_gr == 1)
        {
            $anthrop = PersAnthrop::find()
                    ->where('pers_id=:pers and name=:tsize',
                            [':pers'=>$pers_id, ':tsize'=>"Рост"])
                    ->one();
            $nomen_size = $nomen_size. ' " Рост: " '.$anthrop->val;
        }   
        if($kind->full_gr == 1)
        {
            $anthrop = PersAnthrop::find()
                    ->where('pers_id=:pers and name=:tsize',
                            [':pers'=>$pers_id, ':tsize'=>"Полнота"])
                    ->one();
            $nomen_size = $nomen_size. ' " Полнота: " '.$anthrop->val;
        }   
        if($kind->shirt_gr == 1)
        {
            $anthrop = PersAnthrop::find()
                    ->where('pers_id=:pers and name=:tsize',
                            [':pers'=>$pers_id, ':tsize'=>"Размер по вороту"])
                    ->one();
            $nomen_size = $nomen_size. ' " Размер по вороту: " '.$anthrop->val;
        }   
        if($kind->shoes_gr == 1)
        {
            $anthrop = PersAnthrop::find()
                    ->where('pers_id=:pers and name=:tsize',
                            [':pers'=>$pers_id, ':tsize'=>"Размер обуви"])
                    ->one();
            $nomen_size = $nomen_size. ' " Размер обуви: " '.$anthrop->val;
        }   
        if($kind->glove_gr == 1)
        {
            $anthrop = PersAnthrop::find()
                    ->where('pers_id=:pers and name=:tsize',
                            [':pers'=>$pers_id, ':tsize'=>"Размер перчаток"])
                    ->one();
            $nomen_size = $nomen_size. ' " Размер перчаток: " '.$anthrop->val;
        }   
        if($kind->head_gr == 1)
        {
            $anthrop = PersAnthrop::find()
                    ->where('pers_id=:pers and name=:tsize',
                            [':pers'=>$pers_id, ':tsize'=>"Размер головы"])
                    ->one();
            $nomen_size = $nomen_size. ' " Размер головы: " '.$anthrop->val;
        }   
        return $nomen_size;
    }
    
/* Расчет остатков на складе по номенклатуре и размерам */
    public static function RemainQuant($pers_id,$nomen_id)
    {
        $kind = Nomenkind::find()
                ->leftJoin('nomenclature','nomenclature.kind_id=nomenkind.id')
                ->where('nomenclature.id=:nomen',[':nomen'=>$nomen_id])
                ->one();
            $stoquant = 0;
            if($kind->head_gr == 1)
            {
                $size = Sizelist::find ()
                    ->leftJoin('pers_anthrop','pers_anthrop.name=sizelis.groupname and pers_anthrop.val=sizelist.size')
                    ->where('pers_anthrop.pers_id=:pers and pers_anthrop.name=:name',
                        [':pers'=>$pers_id,':name'=>'Размер головы'])
                    ->one();
                $query = Storemain::find()
                    ->where('nomen_id=:nomen and actual=:act and head_id=:head',
                            [':nomen'=>$nomen_id,':act'=> NormCardspec::CARDSPECYES,':head'=>$size->id]); //головной убор
            }
           else if($kind->glove_gr == 1)
           {
                $size = Sizelist::find ()
                    ->leftJoin('pers_anthrop','pers_anthrop.name=sizelis.groupname and pers_anthrop.val=sizelist.size')
                    ->where('pers_anthrop.pers_id=:pers and pers_anthrop.name=:name',
                        [':pers'=>$pers_id,':name'=>'Размер перчаток'])
                    ->one();
                $query = Storemain::find()
                    ->where('nomen_id=:nomen and actual=:act and glove_id=:glove',
                            [':nomen'=>$nomen_id,':act'=> NormCardspec::CARDSPECYES,':glove'=>$size->id]); //перчатки
           }
           else if($kind->shoes_gr == 1)
           {
                $size = Sizelist::find ()
                    ->leftJoin('pers_anthrop','pers_anthrop.name=sizelis.groupname and pers_anthrop.val=sizelist.size')
                    ->where('pers_anthrop.pers_id=:pers and pers_anthrop.name=:name',
                        [':pers'=>$pers_id,':name'=>'Размер обуви'])
                    ->one();
                $query = Storemain::find()
                    ->where('nomen_id=:nomen and actual=:act and shoes_id=:shoes',
                            [':nomen'=>$nomen_id,':act'=> NormCardspec::CARDSPECYES,':shoes'=>$size->id]); //перчатки
           }
           else if($kind->size_gr == 1) { 
            $size = Sizelist::find ()
                ->leftJoin('pers_anthrop','pers_anthrop.name=sizelist.group_name and pers_anthrop.val=sizelist.size')
                ->where('pers_anthrop.pers_id=:pers and pers_anthrop.name=:name',
                    [':pers'=>$pers_id,':name'=>'Размер'])
                ->one();
            $tsize = $size->id;
            if($kind->height_gr == 1){
                $size = Sizelist::find ()
                    ->leftJoin('pers_anthrop','pers_anthrop.name=sizelist.group_name and pers_anthrop.val=sizelist.size')
                    ->where('pers_anthrop.pers_id=:pers and pers_anthrop.name=:name',
                        [':pers'=>$pers_id,':name'=>'Рост'])
                    ->one();
                $theight = $size->id;
                if($kind->full_gr == 1){
                    $size = Sizelist::find ()
                        ->leftJoin('pers_anthrop','pers_anthrop.name=sizelist.group_name and pers_anthrop.val=sizelist.size')
                        ->where('pers_anthrop.pers_id=:pers and pers_anthrop.name=:name',
                            [':pers'=>$pers_id,':name'=>'Полнота'])
                        ->one();
                    $tfull = $size->id;
                    if($kind->shirt_gr == 1){
                        $size = Sizelist::find ()
                                ->leftJoin('pers_anthrop','pers_anthrop.name=sizelist.group_name and pers_anthrop.val=sizelist.size')
                                ->where('pers_anthrop.pers_id=:pers and pers_anthrop.name=:name',
                                    [':pers'=>$pers_id,':name'=>'Размер по вороту'])
                                ->one();
                        $tshirt = $size->id;
                        $query = Storemain::find()
                            ->where('nomen_id=:nomen and actual=:act and shirt_id=:shirt and size_id=:size'
                                    . ' and height_id=:height and full_id=:full',
                                    [':nomen'=>$nomen_id,':act'=> NormCardspec::CARDSPECYES,
                                        ':shirt'=>$size->id,':size'=>$tsize,':height'=>$theight,':full'=>$tfull]); //рубашка
                    } else {
                        $query = Storemain::find()
                            ->where('nomen_id=:nomen and actual=:act and size_id=:size'
                                    . ' and height_id=:height and full_id=:full and full_id is null',
                                    [':nomen'=>$nomen_id,':act'=> NormCardspec::CARDSPECYES,
                                        ':size'=>$tsize,':height'=>$theight,':full'=>$tfull]); //костюм
                        }
                } else {
                    $query = Storemain::find()
                        ->where('nomen_id=:nomen and actual=:act and size_id=:size'
                                . ' and height_id is null and full_id is null and height_id=:height',
                                [':nomen'=>$nomen_id,':act'=> NormCardspec::CARDSPECYES,
                                    ':size'=>$tsize,':height'=>$theight]); //рубашка
                    }
            } else {
                $query = Storemain::find()
                    ->where('nomen_id=:nomen and actual=:act and size_id=:size',
                            [':nomen'=>$nomen_id,':act'=> NormCardspec::CARDSPECYES,':size'=>$tsize]); //блузка
            }
        } else if($kind->shirt_gr == 1) 
            {
                $query = app\models\Storemain::find()
                    ->where('nomen_id=:nomen and shirt_id=:shirt and size_id is null and height_id is null and full_id is null',
                        [':nomen'=>$nomen_id,':shirt'=>$tshirt]);
            } else {
                    $query = Storemain::find ()
                        ->where('nomen_id=:nomen and size_id is null and height_id is null and full_id is null '
                            . 'and shirt_id is null and head_id is null and glove_id is null and shoes_id is null',
                                [':nomen'=>$nomen_id]);
            }
        foreach ($query->all() as $storem)
        {
            $stoquant =+ $storem->quant;
        }
        if($stoquant != 0)
            return $stoquant;
        else
            return '';
    }
/* Формирование строки размеров по сотруднику и номенклатуре по антропологическим параметрам*/    
    public static function DeficitNomenSizeFact($remain_id)
    {
        $nomen = Nomenclature::find()
                ->leftJoin('storemain','storemain.nomen_id=nomenclature.id')
                ->where('storemain.id=:remain',[':remain'=>$remain_id])
                ->one();
        $nomen_size = $nomen->name;
        $remain = Storemain::findOne($remain_id);
        if($remain->size_id)
        {
            $size = search\Sizelist::findOne ($remain->size_id);
            $nomen_size = $nomen_size. ' " Размер: " '.$size->size;
        }
        if($remain->height_id)
        {
            $size = search\Sizelist::findOne ($remain->height_id);
            $nomen_size = $nomen_size. ' " Рост: " '.$size->size;
        }   
        if($remain->full_id)
        {
            $size = search\Sizelist::findOne ($remain->full_id);
            $nomen_size = $nomen_size. ' " Полнота: " '.$size->size;
        }   
        if($remain->shirt_id)
        {
            $size = search\Sizelist::findOne ($remain->shirt_id);
            $nomen_size = $nomen_size. ' " Размер по вороту: " '.$size->size;
        }   
        if($remain->shoes_id)
        {
            $size = search\Sizelist::findOne ($remain->shoes_id);
            $nomen_size = $nomen_size. ' " Размер обуви: " '.$size->size;
        }   
        if($remain->glove_id)
        {
            $size = search\Sizelist::findOne ($remain->glove_id);
            $nomen_size = $nomen_size. ' " Размер перчаток: " '.$size->size;
        }   
        if($remain->head_id)
        {
            $size = search\Sizelist::findOne ($remain->head_id);
            $nomen_size = $nomen_size. ' " Размер головы: " '.$size->size;
        }   
        return $nomen_size;
    }
    
//Номенклатрура с размерами из расходной накладной    
    public static function DeficitRemainSize($invoice_id,$nomen_id)
    {
        $kind = Nomenkind::find()
                ->leftJoin('nomenclature','nomenclature.kind_id=nomenkind.id')
                ->where('nomenclature.id=:nomen',[':nomen'=>$nomen_id])
                ->one();
        $nomen = Nomenclature::findOne($nomen_id);
        $nomen_size = $nomen->name;
        if($kind->size_gr == 1)
        {
            $anthrop = PersAnthrop::find()
                    ->where('pers_id=:pers and name=:tsize',
                            [':pers'=>$pers_id, ':tsize'=>"Размер"])
                    ->one();
            $nomen_size = $nomen_size.' " Размер: " '.$anthrop->val;
        }   
        if($kind->height_gr == 1)
        {
            $anthrop = PersAnthrop::find()
                    ->where('pers_id=:pers and name=:tsize',
                            [':pers'=>$pers_id, ':tsize'=>"Рост"])
                    ->one();
            $nomen_size = $nomen_size. ' " Рост: " '.$anthrop->val;
        }   
        if($kind->full_gr == 1)
        {
            $anthrop = PersAnthrop::find()
                    ->where('pers_id=:pers and name=:tsize',
                            [':pers'=>$pers_id, ':tsize'=>"Полнота"])
                    ->one();
            $nomen_size = $nomen_size. ' " Полнота: " '.$anthrop->val;
        }   
        if($kind->shirt_gr == 1)
        {
            $anthrop = PersAnthrop::find()
                    ->where('pers_id=:pers and name=:tsize',
                            [':pers'=>$pers_id, ':tsize'=>"Размер по вороту"])
                    ->one();
            $nomen_size = $nomen_size. ' " Размер по вороту: " '.$anthrop->val;
        }   
        if($kind->shoes_gr == 1)
        {
            $anthrop = PersAnthrop::find()
                    ->where('pers_id=:pers and name=:tsize',
                            [':pers'=>$pers_id, ':tsize'=>"Размер обуви"])
                    ->one();
            $nomen_size = $nomen_size. ' " Размер обуви: " '.$anthrop->val;
        }   
        if($kind->glove_gr == 1)
        {
            $anthrop = PersAnthrop::find()
                    ->where('pers_id=:pers and name=:tsize',
                            [':pers'=>$pers_id, ':tsize'=>"Размер перчаток"])
                    ->one();
            $nomen_size = $nomen_size. ' " Размер перчаток: " '.$anthrop->val;
        }   
        if($kind->head_gr == 1)
        {
            $anthrop = PersAnthrop::find()
                    ->where('pers_id=:pers and name=:tsize',
                            [':pers'=>$pers_id, ':tsize'=>"Размер головы"])
                    ->one();
            $nomen_size = $nomen_size. ' " Размер головы: " '.$anthrop->val;
        }   
        return $nomen_size;
    }
    
}
