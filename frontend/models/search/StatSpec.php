<?php

namespace app\models\search;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\StatSpec as StatSpecModel;

/**
 * StatSpec represents the model behind the search form of `app\models\StatSpec`.
 */
class StatSpec extends StatSpecModel
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'staff_id', 'sign_choice', 'nomen_type', 'nomen_id', 'date_end', 'quant', 'pers_id', 'prof_id', 'nomen_fact_id', 'remain_id', 'quant_fact'], 'integer'],
            [['amort'], 'safe'],
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
        $query = StatSpecModel::find();

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
            'staff_id' => $this->staff_id,
            'sign_choice' => $this->sign_choice,
            'nomen_type' => $this->nomen_type,
            'nomen_id' => $this->nomen_id,
            'date_end' => $this->date_end,
            'quant' => $this->quant,
            'pers_id' => $this->pers_id,
            'prof_id' => $this->prof_id,
            'nomen_fact_id' => $this->nomen_fact_id,
            'remain_id' => $this->remain_id,
            'quant_fact' => $this->quant_fact,
        ]);

        $query->andFilterWhere(['like', 'amort', $this->amort]);

        return $dataProvider;
    }
}
