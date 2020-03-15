<?php

namespace app\models\search;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Invoice as InvoiceModel;

/**
 * Invoice represents the model behind the search form of `app\models\Invoice`.
 */
class Invoice extends InvoiceModel
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'store_id', 'pers_id', 'comp_id', 'doc_date', 'oper_id', 'oper_date'], 'integer'],
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
        $query = InvoiceModel::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        $date_int = strtotime($this->doc_date);
        if($this->doc_date) $query->andFilterWhere(['doc_date'=>$date_int]);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'store_id' => $this->store_id,
            'pers_id' => $this->pers_id,
            'comp_id' => $this->comp_id,
            'doc_date' => $this->doc_date,
            'oper_id' => $this->oper_id,
            'oper_date' => $this->oper_date,
        ]);

        $query->andFilterWhere(['like', 'doc_numb', $this->doc_numb])
            ->andFilterWhere(['like', 'note', $this->note]);

        return $dataProvider;
    }
}
