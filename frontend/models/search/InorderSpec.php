<?php

namespace app\models\search;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\InorderSpec as InorderSpecModel;

/**
 * InorderSpec represents the model behind the search form of `app\models\InorderSpec`.
 */
class InorderSpec extends InorderSpecModel
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'inorder_id', 'nomen_id', 'comp_id', 'store_id', 'quant', 'placed','actual'], 'integer'],
            [['sertif'], 'safe'],
            [['price'], 'number'],
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
        $query = InorderSpecModel::find()->andWhere('actual = :act',[':act'=> InorderSpecModel::SPECATC]);

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
            'inorder_id' => $this->inorder_id,
            'nomen_id' => $this->nomen_id,
            'comp_id' => $this->comp_id,
            'store_id' => $this->store_id,
            'quant' => $this->quant,
            'placed' => $this->placed,
            'price' => $this->price,
        ]);

        $query->andFilterWhere(['like', 'sertif', $this->sertif]);

        return $dataProvider;
    }
}
