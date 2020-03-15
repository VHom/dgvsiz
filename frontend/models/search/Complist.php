<?php

namespace app\models\search;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Complist as ComplistModel;

/**
 * Complist represents the model behind the search form of `app\models\Complist`.
 */
class Complist extends ComplistModel
{
    /**
     * {@inheritdoc}
     */
    
    public $BranchName;
    
    public function rules()
    {
        return [
            [['id', 'branch_id'], 'integer'],
            [['code', 'name'], 'safe'],
            [['BranchName'], 'safe'],
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
        $query = ComplistModel::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);
//Нстройка параметров сортировки
        $dataProvider->setSort([
            'attributes' => [
                'id',
                'BranchName' => [
                    'asc' => ['branchlist.name' => SORT_ASC],
                    'desc' => ['branchlist.name' => SORT_DESC],
                    'default' => SORT_ASC
                ],
                'code' => [
                    'asc' => ['complist.code' => SORT_ASC],
                    'DESC' => ['complist.code' => SORT_DESC],
                    'default' => SORT_ASC
                ],
                'name' => [
                    'asc' => ['complist.name' => SORT_ASC],
                    'DESC' => ['complist.name' => SORT_DESC],
                    'default' => SORT_ASC
                ]
            ]
        ]);
        
        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'branch_id' => $this->branch_id,
        ]);

        $query->andFilterWhere(['like', 'complist.code', $this->code])
            ->andFilterWhere(['like', 'complist.name', $this->name]);
        
        $query->joinWith(['branch'=> function($q) {
            $q->where('branchlist.name LIKE "%'.$this->BranchName.'%"');
        }
        ]);

        return $dataProvider;
    }
}
