<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Sector;

/**
 * SectorSearch represents the model behind the search form about `app\models\Sector`.
 */
class SectorSearch extends Sector
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'provincial_id'], 'integer'],
            [['label'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
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
        $query = Sector::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
            'provincial_id' => $this->provincial_id,
        ]);

        $query->andFilterWhere(['like', 'label', $this->label]);

        return $dataProvider;
    }
}
