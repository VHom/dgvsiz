<?php

namespace app\models\search;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Storejournal as StorejournalModel;

/**
 * Storejournal represents the model behind the search form of `app\models\Storejournal`.
 */
class Storejournal extends StorejournalModel
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'comp_id', 'store_id', 'nomen_id', 'stoper_id', 'stoper_type', 'inordspec_id', 
                'invoicespec_id', 'drafspec_id', 'oper_id', 'oper_date', 'quant'], 'integer'],
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
        $query = StorejournalModel::find();

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
            'comp_id' => $this->comp_id,
            'store_id' => $this->store_id,
            'nomen_id' => $this->nomen_id,
            'stoper_id' => $this->stoper_id,
            'stoper_type' => $this->stoper_type,
            'inordspec_id' => $this->inordspec_id,
            'invoicespec_id' => $this->invoicespec_id,
            'drafspec_id' => $this->drafspec_id,
            'oper_id' => $this->oper_id,
            'oper_date' => $this->oper_date,
            'quant' => $this->quant,
        ]);

        return $dataProvider;
    }
}
