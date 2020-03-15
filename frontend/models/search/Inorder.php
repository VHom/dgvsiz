<?php

namespace app\models\search;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Inorder as InorderModel;

/**
 * Inorder represents the model behind the search form of `app\models\Inorder`.
 */
class Inorder extends InorderModel
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'store_id', 'supplier_id', 'comp_id', 'accepted_id', 'doc_date',
                'doc_type', 'income_date', 'pers_id'], 'integer'],
            [['doc_numb', 'note'], 'safe'],
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
        $query = InorderModel::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
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
            'store_id' => $this->store_id,
            'supplier_id' => $this->supplier_id,
            'comp_id' => $this->comp_id,
            'accepted_id' => $this->accepted_id,
            'doc_date' => $this->doc_date,
            'doc_type' => $this->doc_type,
            'income_date' => $this->income_date,
            'pers_id' => $this->pers_id,
        ]);

        $query->andFilterWhere(['like', 'doc_numb', $this->doc_numb])
            ->andFilterWhere(['like', 'note', $this->note]);

        return $dataProvider;
    }
}
