<?php

namespace app\models\search;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\DeficitSpec as DeficitSpecModel;

/**
 * DeficitSpec represents the model behind the search form of `app\models\DeficitSpec`.
 */
class DeficitSpec extends DeficitSpecModel
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'statement_id', 'nomen_id', 'kind_id', 'quant_fact', 'quant_store', 'quant'], 'integer'],
            [['def_name', 'store_note', 'analog_note'], 'safe'],
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
        $query = DeficitSpecModel::find();

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
            'nomen_id' => $this->nomen_id,
            'kind_id' => $this->kind_id,
            'quant' => $this->quant,
            'quant_store' => $this->quant_store,
            'quant_fact' => $this->quant_fact,
        ]);

        $query->andFilterWhere(['like', 'def_name', $this->def_name])
            ->andFilterWhere(['like', 'store_note', $this->store_note])
            ->andFilterWhere(['like', 'analog_note', $this->analog_note]);

        return $dataProvider;
    }
}
