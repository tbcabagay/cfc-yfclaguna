<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Document;

/**
 * DocumentSearch represents the model behind the search form about `app\models\Document`.
 */
class DocumentSearch extends Document
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'user_id', 'status', 'is_deleted', 'time_difference'], 'integer'],
            [['title', 'remarks', 'attachment', 'created_at'], 'safe'],
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
        $query = Document::find()
            ->joinWith(['user', 'user.userProfiles'])
            ->where('user.division_id=:division_id AND user.division_label=:division_label')
            ->addParams([
                'division_id' => \Yii::$app->user->identity->division_id,
                'division_label' => \Yii::$app->user->identity->division_label,
            ]);

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
            'user_id' => $this->user_id,
        ]);

        $query->andFilterWhere(['like', 'document.title', $this->title])
            ->andFilterWhere(['like', 'document.remarks', $this->remarks])
            ->andFilterWhere(['like', 'document.created_at', $this->created_at]);

        return $dataProvider;
    }
}
