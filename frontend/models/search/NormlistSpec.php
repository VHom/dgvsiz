<?php

namespace app\models\search;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\NormlistSpec as NormlistSpecModel;

/**
 * NormlistSpec represents the model behind the search form of `app\models\NormlistSpec`.
 */
class NormlistSpec extends NormlistSpecModel
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'norm_id', 'quant', 'period', 'nomen_id', 'kind_id'], 'integer'],
            [['code', 'doc_osn'], 'safe'],
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
        $query = NormlistSpecModel::find(); //->where('actual=:act',[':act'=> NormlistSpecModel::ACTUALYES]);

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
            'norm_id' => $this->norm_id,
            'quant' => $this->quant,
            'period' => $this->period,
            'nomen_id' => $this->nomen_id,
            'kind_id' => $this->kind_id,
        ]);

        $query->andFilterWhere(['like', 'code', $this->code])
            ->andFilterWhere(['like', 'doc_osn', $this->doc_osn]);

        return $dataProvider;
    }
}
