<?php

namespace app\models;

use Yii;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "stafflist".
 *
 * @property int $id
 * @property int $branch_id Филиал
 * @property int $comp_id Организация
 * @property int $area_id Подразделение
 * @property int $prof_id Должность
 *
 * @property Arealist $area
 * @property Branchlist $branch
 * @property Complist $comp
 * @property Proflist $prof
 */
class Stafflist extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'stafflist';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['branch_id', 'comp_id', 'area_id', 'prof_id'], 'integer'],
            [['area_id'], 'exist', 'skipOnError' => true, 'targetClass' => Arealist::className(), 'targetAttribute' => ['area_id' => 'id']],
            [['branch_id'], 'exist', 'skipOnError' => true, 'targetClass' => Branchlist::className(), 'targetAttribute' => ['branch_id' => 'id']],
            [['comp_id'], 'exist', 'skipOnError' => true, 'targetClass' => Complist::className(), 'targetAttribute' => ['comp_id' => 'id']],
//            [['prof_id'], 'exist', 'skipOnError' => true, 'targetClass' => Proflist::className(), 'targetAttribute' => ['prof_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'branch_id' => 'Филиал',
            'BranchName' => 'Филиал',
            'comp_id' => 'Организация',
            'CompName' => 'Организация',
            'area_id' => 'Подразделение',
            'AreaName' => 'Подразделение',
//            'prof_id' => 'Должность',
//            'ProfName' => 'Должность',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getArea()
    {
        return $this->hasOne(Arealist::className(), ['id' => 'area_id']);
    }

    public function getAreaName()
    {
        if($this->area) // && $this->branch_id && $this->comp_id)
        {
            return /*$this->branch->name.' '. $this->comp->name.' '.*/$this->area->name;
        } else {
            return '';
        }
    }
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getBranch()
    {
        return $this->hasOne(Branchlist::className(), ['id' => 'branch_id']);
    }

    public function getBranchName()
    {
        if($this->branch)
        {
            return $this->branch->name;
        } else {
            return '';
        }
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getComp()
    {
        return $this->hasOne(Complist::className(), ['id' => 'comp_id']);
    }

    public function getCompName()
    {
        if($this->comp)
        {
            return $this->comp->name;
        } else {
            return '';
        }
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProf()
    {
        return $this->hasOne(Proflist::className(), ['id' => 'prof_id']);
    }
    
    public function getProfName()
    {
        if($this->prof)
        {
            return $this->prof->prof_name;
        } else {
            return '';
        }
    }

    public static function getAreaArray()
    {
//        $areaarray = [];
        $arealist = Stafflist::find()->select(['stafflist.id',Arealist::tableName().'.name'])
        ->joinWith('area')
        ->orderBy(['name'=>SORT_ASC])->all();
//        $areaarray =  (array) $arealist;
        return $arealist;
    }

    public function getAreas()
    {
        return $this->areaArray[$this->staff_id];
    }

}
