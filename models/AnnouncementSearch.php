<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Announcement;

/**
 * AnnouncementSearch represents the model behind the search form about `app\models\Announcement`.
 */
class AnnouncementSearch extends Announcement
{

    public $user;
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'user_id', 'status'], 'integer'],
            [['title', 'content', 'created_at', 'user'], 'safe'],
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
        $query = Announcement::find()
            ->joinWith(['user', 'user.userProfiles'])
            ->where(['announcement.status' => parent::STATUS_ACTIVE]);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $dataProvider->sort->attributes['user'] = [
            'asc' => ['user_profile.family_name' => SORT_ASC],
            'desc' => ['user_profile.family_name' => SORT_DESC],
        ];

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
        ]);

        $query->andFilterWhere(['like', 'announcement.title', $this->title])
            ->orFilterWhere(['like', 'user_profile.given_name', $this->user])
            ->orFilterWhere(['like', 'user_profile.family_name', $this->user])
            ->andFilterWhere(['like', 'announcement.created_at', $this->created_at]);

        return $dataProvider;
    }

    public function latest()
    {
        $query = Announcement::find()
            ->where(['status' => parent::STATUS_ACTIVE])
            ->orderBy('created_at DESC');

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => 1,
            ],
        ]);

        return $dataProvider;
    }
}
