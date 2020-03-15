<?php

namespace app\models\search;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Userlist as UserlistModel;

/**
 * Userlist represents the model behind the search form of `app\models\Userlist`.
 */
class Userlist extends UserlistModel
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'user_id', 'role_id', 'staff_id', 'actual', 'rename'], 'integer'],
            [['family_name', 'first_name', 'second_name'], 'safe'],
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
        $query = UserlistModel::find()
                ->leftJoin('user','user.id=userlist.user_id')
                ->where('user.username<>"supervisor"');

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
            'user_id' => $this->user_id,
            'role_id' => $this->role_id,
            'staff_id' => $this->staff_id,
            'actual' => $this->actual,
            'rename' => $this->rename,
        ]);

        $query->andFilterWhere(['like', 'family_name', $this->family_name])
            ->andFilterWhere(['like', 'first_name', $this->first_name])
            ->andFilterWhere(['like', 'second_name', $this->second_name]);

        return $dataProvider;
    }
}
