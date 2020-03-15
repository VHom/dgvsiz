<?php

namespace app\models\search;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Arealist as ArealistModel;

/**
 * Arealist represents the model behind the search form of `app\models\Arealist`.
 */
class Arealist extends ArealistModel
{
    /**
     * {@inheritdoc}
     */
    public $CompName;

    public function rules()
    {
        return [
            [['id', 'comp_id'], 'integer'],
            [['code', 'name'], 'safe'],
            [['CompName'], 'safe'],
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
        $query = ArealistModel::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

//Нстройка параметров сортировки
        $dataProvider->setSort([
            'attributes' => [
                'id',
                'CompName' => [
                    'asc' => ['complist.name' => SORT_ASC],
                    'desc' => ['complist.name' => SORT_DESC],
                    'default' => SORT_ASC
                ],
                'code' => [
                    'asc' => ['arealist.code' => SORT_ASC],
                    'DESC' => ['arealist.code' => SORT_DESC],
                    'default' => SORT_ASC
                ],
                'name' => [
                    'asc' => ['arealist.name' => SORT_ASC],
                    'DESC' => ['arealist.name' => SORT_DESC],
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
            'comp_id' => $this->comp_id,
        ]);

        $query->andFilterWhere(['like', 'arealist.code', $this->code])
            ->andFilterWhere(['like', 'arealist.name', $this->name]);

        $query->joinWith(['comp'=> function($q) {
            $q->where('complist.name LIKE "%'.$this->CompName.'%"');
        }
        ]);
        return $dataProvider;
    }
}
