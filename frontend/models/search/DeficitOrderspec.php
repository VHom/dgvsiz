<?php

namespace app\models\search;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\DeficitOrderspec as DeficitOrderspecModel;

/**
 * DeficitOrderspec represents the model behind the search form of `app\models\DeficitOrderspec`.
 */
class DeficitOrderspec extends DeficitOrderspecModel
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'statement_id', 'quant', 'status', 'type', 'oper_id'], 'integer'],
            [['nomen_name', 'prim', 'oper_date'], 'safe'],
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
        $query = DeficitOrderspecModel::find();

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
            'statement_id' => $this->statement_id,
            'quant' => $this->quant,
            'status' => $this->status,
            'type' => $this->type,
            'oper_id' => $this->oper_id,
        ]);

        $query->andFilterWhere(['like', 'nomen_name', $this->nomen_name])
            ->andFilterWhere(['like', 'prim', $this->prim])
            ->andFilterWhere(['like', 'oper_date', $this->oper_date]);

        return $dataProvider;
    }
}
