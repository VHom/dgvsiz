<?php

namespace app\models\search;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\NormCardspec as NormCardspecModel;

/**
 * NormCardspec represents the model behind the search form of `app\models\NormCardspec`.
 */
class NormCardspec extends NormCardspecModel
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'card_id', 'quant', 'quant_fct', 'date_in', 'date_out', 
                'nomen_id', 'invoice_id', 'analog_id'], 'integer'],
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
        $query = NormCardspecModel::find();
//                ->where('actual=:act',[':act'=> NormCardspecModel::CARDSPECYES]);

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
            'card_id' => $this->card_id,
            'quant' => $this->quant,
            'quant_fct' => $this->quant_fct,
            'date_in' => $this->date_in,
            'date_out' => $this->date_out,
            'nomen_id' => $this->nomen_id,
            'invoice_id' => $this->invoice_id,
            'analog_id' => $this->analog_id,
        ]);

        return $dataProvider;
    }
}
