<?php

namespace app\models\search;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Nomenkind as NomenkindModel;

/**
 * Nomenkind represents the model behind the search form of `app\models\Nomenkind`.
 */
class Nomenkind extends NomenkindModel
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'is_siz'], 'integer'],
            [['name', 'size_gr', 'height_gr', 'full_gr', 'shirt_gr', 'shoes_gr', 'glove_gr', 'head_gr'], 'integer'],
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
        $query = NomenkindModel::find()->where('actual=:act',[':act'=> NomenkindModel::ACTUALYES]);

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
            'is_siz' => $this->is_siz,
            'size_gr' => $this->size_gr,
            'height_gr' => $this->height_gr,
            'full_gr' => $this->full_gr,
            'shirt_gr' => $this->shirt_gr,
            'shoes_gr' => $this->shoes_gr,
            'glove_gr' => $this->glove_gr,
            'head_gr' => $this->head_gr,
        ]);

/*        $query->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'size_gr', $this->size_gr])
            ->andFilterWhere(['like', 'height_gr', $this->height_gr])
            ->andFilterWhere(['like', 'full_gr', $this->full_gr])
            ->andFilterWhere(['like', 'shirt_gr', $this->shirt_gr])
            ->andFilterWhere(['like', 'shoes_gr', $this->shoes_gr])
            ->andFilterWhere(['like', 'glove_gr', $this->glove_gr]);*/

        return $dataProvider;
    }
}
