<?php

namespace app\models\search;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Operjournal as OperjournalModel;

/**
 * Operjournal represents the model behind the search form of `app\models\Operjournal`.
 */
class Operjournal extends OperjournalModel
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'oper_id', 'oper_date', 'oper_val_id'], 'integer'],
            [['oper_name', 'oper_obj', 'oper_val'], 'safe'],
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
        $query = OperjournalModel::find();

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
            'oper_id' => $this->oper_id,
            'oper_date' => $this->oper_date,
            'oper_val_id' => $this->oper_val_id,
        ]);

        $query->andFilterWhere(['like', 'oper_name', $this->oper_name])
            ->andFilterWhere(['like', 'oper_obj', $this->oper_obj])
            ->andFilterWhere(['like', 'oper_val', $this->oper_val]);

        return $dataProvider;
    }
}
