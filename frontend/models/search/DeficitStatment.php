<?php

namespace app\models\search;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\DeficitStatment as DeficitStatmentModel;

/**
 * DeficitStatment represents the model behind the search form of `app\models\DeficitStatment`.
 */
class DeficitStatment extends DeficitStatmentModel
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'staff_id', 'date_report', 'oper_date', 'oper_id', 'status'], 'integer'],
            [['amort'], 'safe'],
            [['number_report', 'prim'], 'string'],
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
        $query = DeficitStatmentModel::find();

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
            'date_report' => $this->date_report,
            'oper_date' => $this->oper_date,
            'oper_id' => $this->oper_id,
            'status' => $this->status,
        ]);

        $query->andFilterWhere(['like', 'number_report', $this->number_report]);
        $query->andFilterWhere(['like', 'prim', $this->prim]);

        return $dataProvider;
    }
}
