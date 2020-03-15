<?php

namespace app\models\search;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\NormCard as NormCardModel;

/**
 * NormCard represents the model behind the search form of `app\models\NormCard`.
 */
class NormCard extends NormCardModel
{
    public $PersName;

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'pers_id', 'norm_id'], 'integer'],
            [['PersName'], 'safe'],
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
        $query = NormCardModel::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query->where('actual=:act', [':act' => NormCardModel::NORMCARDYES]),
        ]);

        $dataProvider->setSort([
            'attributes' => [
                'PersName' => [
                    'asc' => ['perslist.abbr_name' => SORT_ASC],
                    'desc' => ['perslist.abbr_name' => SORT_DESC],
                    'default' => SORT_ASC
                ]
            ]
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
            'pers_id' => $this->pers_id,
            'norm_id' => $this->norm_id,
        ]);
        $query->joinWith(['pers'=>function($q) {
            $q->where('perslist.abbr_name LIKE "%'. $this->PersName . '%"');
        }]);

        return $dataProvider;
    }
}
