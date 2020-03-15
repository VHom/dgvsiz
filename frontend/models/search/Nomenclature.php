<?php

namespace app\models\search;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Nomenclature as NomenclatureModel;

/**
 * Nomenclature represents the model behind the search form of `app\models\Nomenclature`.
 */
class Nomenclature extends NomenclatureModel
{
    public $KindName;
    public $GenderName;

    public $sex;
    /**
     * {@inheritdoc}
     */
    
    public function rules()
    {
        return [
            [['id', 'meas_id', 'gender', 'kind_id'], 'integer'],
            [['code', 'name', 'gost', 'sertif'], 'safe'],
            [['KindName', 'GenderName'], 'safe'],
            [['price'], 'number'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    
    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = NomenclatureModel::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $dataProvider->setSort([
            'attributes' => [
                'id',
                'KindName' => [
                    'asc' => ['nomenkind.name' => SORT_ASC],
                    'desc' => ['nomenkind.name' => SORT_DESC],
                    'default' => SORT_ASC
                ],
                'name' => [
                    'name' => ['nomenclature.name' => SORT_ASC],
                    'name' => ['nomenclature.name' => SORT_DESC],
                    'default' => SORT_ASC
                ],
                'GenderName' => [
                    'asc' => ['nomenclature.gender' => SORT_ASC],
                    'desc' => ['nomenclature.gender' => SORT_DESC],
                    'default' => SORT_ASC
                ],
            ]
        ]);
        
        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        if(strtolower($this->GenderName) == 'мужской')
            $sex = 1;
        elseif(strtolower($this->GenderName) == 'женский')
            $sex = 2;
        else
            $sex = null;

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'price' => $this->price,
//            'nomen_gr' => $this->nomen_gr,
            'meas_id' => $this->meas_id,
            'gender' => $sex, //$this->gender,
        ]);

        $query->andFilterWhere(['like', 'nomenclature.code', $this->code])
            ->andFilterWhere(['like', 'nomenclature.name', $this->name])
            ->andFilterWhere(['like', 'nomenclature.gost', $this->gost])
            ->andFilterWhere(['like', 'nomenclature.sertif', $this->sertif]);

        $query->joinWith(['kind'=> function($q) {
            $q->where('nomenkind.name LIKE "%'.$this->KindName.'%"');
        }
        ]);
        
        return $dataProvider;
    }
}
