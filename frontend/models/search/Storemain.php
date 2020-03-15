<?php

namespace app\models\search;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Storemain as StoremainModel;

/**
 * Storemain represents the model behind the search form of `app\models\Storemain`.
 */
class Storemain extends StoremainModel
{
//    public $NomenName;
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'store_id', 'nomen_id', 'size_id', 'height_id', 'full_id', 'shirt_id', 'shoes_id', 
                'glove_id', 'head_id', 'quant', 'is_siz'], 'integer'],
            [['rem_cost', 'amout'], 'number'],
            [['sertif'], 'safe'],
//            [['NomenName'], 'safe'],
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
        $query = StoremainModel::find()->where('actual = 0');

        // add conditions that should always apply here
        $user_id = \Yii::$app->user->id;
        if($filter = \app\models\FilterStrem::find()
                ->where('user_id=:usr',[':usr'=>$user_id])->one())
        {
//    throw new \yii\web\NotFoundHttpException('ww '.$user_id.' - '.$filter->nomen_id);
            if($filter->nomen_id)
            {
                $query->andWhere('nomen_id=:nomen',[':nomen'=>$filter->nomen_id]);
            }
            if($filter->store_id)
            {
                $query->andWhere('store_id=:store',[':store'=>$filter->store_id]);
            }
            if($filter->is_siz)
            {
                $query->andWhere('is_siz=:siz',[':siz'=>$filter->is_siz]);
            }
            if($filter->amort)
            {
                $query->andWhere('amout=:amort',[':amort'=>$filter->amort]);
            }
        }

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

/*        $dataProvider->setSort([
            'attributes' => [
                'id',
                'NomenName' => [
                    'asc' => ['nomen.name' => SORT_ASC],
                    'desc' => ['nomen.name' => SORT_DESC],
                    'default' => SORT_ASC
                ],
            ]
        ]);*/
        
        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'store_id' => $this->store_id,
            'nomen_id' => $this->nomen_id,
            'size_id' => $this->size_id,
            'height_id' => $this->height_id,
            'full_id' => $this->full_id,
            'shirt_id' => $this->shirt_id,
            'shoes_id' => $this->shoes_id,
            'glove_id' => $this->glove_id,
            'head_id' => $this->head_id,
            'rem_cost' => $this->rem_cost,
            'amout' => $this->amout,
            'quant' => $this->quant,
            'is_siz' => $this->is_siz,
        ]);

        $query->andFilterWhere(['like', 'sertif', $this->sertif]);
        
/*        if($this->NomenName) {
            $query->joinWith(['nomen'=> function($q) {
                $q->where('nomen.name LIKE "%'.$this->NomenName.'%"');
                }
            ]);
       }*/ 
        return $dataProvider;
    }
}
