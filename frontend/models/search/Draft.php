<?php

namespace app\models\search;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Draft as DraftModel;

/**
 * Draft represents the model behind the search form of `app\models\Draft`.
 */
class Draft extends DraftModel
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'out_store', 'in_store', 'oper_id', 'comp_id', 'oper_date', 'doc_date'], 'integer'],
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
        $query = DraftModel::find();

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
            'out_store' => $this->out_store,
            'in_store' => $this->in_store,
            'oper_id' => $this->oper_id,
            'comp_id' => $this->comp_id,
            'oper_date' => $this->oper_date,
            'doc_date' => $this->doc_date,
        ]);

        $query->andFilterWhere(['like', 'doc_numb', $this->doc_numb])
            ->andFilterWhere(['like', 'note', $this->note]);

        return $dataProvider;
    }
}
