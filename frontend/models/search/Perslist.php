<?php

namespace app\models\search;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Perslist as PerslistModel;
use yii\web\NotFoundHttpException;
use yii\web\ServerErrorHttpException;


/**
 * Perslist represents the model behind the search form of `app\models\Perslist`.
 */
class Perslist extends PerslistModel
{
    public $GenderName;
    public $StaffName;

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'gender', 'sec_empl', 'start_date', 'end_date', 'decret_start', 'decret_end', 'staff_id', 'prof_id'], 'integer'],
            [['tabnum', 'abbr_name', 'family_name', 'first_name', 'second_name', 'GenderName', 'StaffName'], 'safe'],
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
        $query = PerslistModel::find()
        ->where(['not',['tabnum'=>null]]);
        $query->leftJoin('proflist','proflist.id=perslist.prof_id')
            ->where('proflist.code <> "Сисадм" and proflist.code <> "Супервизор"');

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $dataProvider->setSort([
            'attributes'=>[
                'id',
                'tabnum',
                'abbr_name',
                'GenderName'=>[
                    'asc'=>['gender'=>SORT_DESC],
                    'desc'=>['gender'=>SORT_ASC],
                    'default'=>SORT_ASC
                ]
            ]
        ]);
        $this->load($params);
        $date_int = strtotime($this->start_date);
//throw new NotFoundHttpException('qq '.$this->start_date.' - '.$qq);

        if($this->start_date) $query->andFilterWhere(['start_date'=>$date_int]);
        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }
        if($gender = $this->gender!=0) $query->andFilterWhere(['gender' => $this->gender]);
//        throw new NotFoundHttpException($this->gender.' - '.$gender);
        $query->andFilterWhere([
            'id' => $this->id,
            'sec_empl' => $this->sec_empl,
//            'start_date' => $this->start_date,
            'end_date' => $this->end_date,
            'decret_start' => $this->decret_start,
            'decret_end' => $this->decret_end,
            'staff_id' => $this->staff_id,
            'prof_id' => $this->prof_id,
        ]);

        $query->andFilterWhere(['like', 'tabnum', $this->tabnum])
            ->andFilterWhere(['like', 'abbr_name', $this->abbr_name])
            ->andFilterWhere(['like', 'family_name', $this->family_name])
            ->andFilterWhere(['like', 'first_name', $this->first_name])
            ->andFilterWhere(['like', 'second_name', $this->second_name]);

        return $dataProvider;
    }
}
