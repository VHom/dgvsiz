<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "complist".
 *
 * @property int $id
 * @property int $branch_id
 * @property string $code
 * @property string $name
 *
 * @property Arealist[] $arealists
 * @property Branchlist $branch
 * @property Stafflist[] $stafflists
 */
class Complist extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'complist';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['branch_id'], 'integer'],
            [['code', 'name'], 'required'],
            [['code'], 'string', 'max' => 20],
            [['name'], 'string', 'max' => 80],
            [['branch_id'], 'exist', 'skipOnError' => true, 'targetClass' => Branchlist::className(), 'targetAttribute' => ['branch_id' => 'id']],
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
            'code' => 'Обозначение',
            'name' => 'Наименование',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getArealists()
    {
        return $this->hasMany(Arealist::className(), ['comp_id' => 'id']);
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
    public function getStafflists()
    {
        return $this->hasMany(Stafflist::className(), ['comp_id' => 'id']);
    }
}
