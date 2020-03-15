<?php

namespace app\models\search;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Sizelist as SizelistModel;

/**
 * Sizelist represents the model behind the search form of `app\models\Sizelist`.
 */
class Sizelist extends SizelistModel
{
    public $TypeName;
    public $typegroup;
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'group_type', 'min_val', 'max_val'], 'integer'],
            [['group_name', 'size'], 'safe'],
            [['TypeName'], 'safe'],
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
        $query = SizelistModel::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query->where('actual=:act',[':act'=> SizelistModel::ACTUALYES]),
        ]);

        $dataProvider->setSort([
            'attributes' => [
                'TypeName' => [
                    'asc' => ['group_type' => SORT_ASC],
                    'desc' => ['group_type' => SORT_DESC],
                    'default' => SORT_ASC,
                ],
                'group_name' => [
                    'asc' => ['group_name' => SORT_ASC],
                    'desc' => ['group_name' => SORT_DESC],
                    'default' => SORT_ASC,
                ],
                'size' => [
                    'asc' => ['size' => SORT_ASC],
                    'desc' => ['size' => SORT_DESC],
                    'default' => SORT_ASC,
                ],
                'min_val' => [
                    'asc' => ['min_val' => SORT_ASC],
                    'desc' => ['min_val' => SORT_DESC],
                    'default' => SORT_ASC,
                ],
                'max_val' => [
                    'asc' => ['max_val' => SORT_ASC],
                    'desc' => ['max_val' => SORT_DESC],
                    'default' => SORT_ASC,
                ],
            ]
        ]);
        
        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }
        if($this->TypeName)
        {
            if($this->TypeName == 'СИЗ')
                $typegroup = 0;
            elseif($this->TypeName == 'ФО')
                $typegroup = 1;
            else
                $typegroup =2;
            $query->andFilterWhere(['group_type' => $typegroup]);
        }
        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
//            'group_type' => $typegroup, //$this->group_type,
            'min_val' => $this->min_val,
            'max_val' => $this->max_val,
            
        ]);
        
        $query->andFilterWhere(['like', 'group_name', $this->group_name])
            ->andFilterWhere(['like', 'size', $this->size]);
        
        return $dataProvider;
    }
}
