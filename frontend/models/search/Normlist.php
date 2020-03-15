<?php

namespace app\models\search;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Normlist as NormlistModel;

/**
 * Normlist represents the model behind the search form of `app\models\Normlist`.
 */
class Normlist extends NormlistModel
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'staff_id', 'norm_type', 'gender', 'prof_id'], 'integer'],
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
        $query = NormlistModel::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query->where('actual=:act',[':act'=> NormlistModel::ACTUALYES]),
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
            'norm_type' => $this->norm_type,
            'gender' => $this->gender,
            'prof_id' => $this->prof_id,
        ]);

        $query->andFilterWhere(['like', 'code', $this->code]);
        $query->andFilterWhere(['like', 'doc_osn', $this->doc_osn]);

        return $dataProvider;
    }
}
