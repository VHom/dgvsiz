<?php

namespace app\models\search;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\FilterStrem as FilterStremModel;

/**
 * FilterStrem represents the model behind the search form of `app\models\FilterStrem`.
 */
class FilterStrem extends FilterStremModel
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'nomen_id', 'is_siz', 'store_id', 'size_id', 'heigth_id', 'full_id', 'shirt_id', 'glove_id', 'head_id'], 'integer'],
            [['amort'], 'number'],
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
        $query = FilterStremModel::find();

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
            'nomen_id' => $this->nomen_id,
            'is_siz' => $this->is_siz,
            'store_id' => $this->store_id,
            'size_id' => $this->size_id,
            'heigth_id' => $this->heigth_id,
            'full_id' => $this->full_id,
            'shirt_id' => $this->shirt_id,
            'glove_id' => $this->glove_id,
            'amort' => $this->amort,
            'head_id' => $this->head_id,
        ]);

        return $dataProvider;
    }
}
