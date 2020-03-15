<?php

namespace app\models\search;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Helpdesk as HelpdeskModel;

/**
 * Helpdesk represents the model behind the search form of `app\models\Helpdesk`.
 */
class Helpdesk extends HelpdeskModel
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'help_id', 'date', 'author', 'state', 'state_date', 'help_number'], 'integer'],
            [['content', 'sort_field'], 'safe'],
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
        $query = HelpdeskModel::find();

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
            'help_id' => $this->help_id,
            'date' => $this->date,
            'author' => $this->author,
            'state' => $this->state,
            'state_date' => $this->state_date,
            'help_number' => $this->help_number,
        ]);

        $query->andFilterWhere(['like', 'content', $this->content])
            ->andFilterWhere(['like', 'sort_field', $this->sort_field]);

        return $dataProvider;
    }
}
