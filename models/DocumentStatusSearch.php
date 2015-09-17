<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\DocumentStatus;

/**
 * DocumentStatusSearch represents the model behind the search form about `app\models\DocumentStatus`.
 */
class DocumentStatusSearch extends DocumentStatus
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'document_id', 'from_id', 'to_id', 'received_by', 'released_by', 'action', 'time_difference'], 'integer'],
            [['from_label', 'to_label', 'remarks', 'received_at', 'released_at', 'attachment'], 'safe'],
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
        $query = DocumentStatus::find();

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
            'document_id' => $this->document_id,
            'from_id' => $this->from_id,
            'to_id' => $this->to_id,
            'received_by' => $this->received_by,
            'received_at' => $this->received_at,
            'released_by' => $this->released_by,
            'released_at' => $this->released_at,
            'action' => $this->action,
            'time_difference' => $this->time_difference,
        ]);

        $query->andFilterWhere(['like', 'from_label', $this->from_label])
            ->andFilterWhere(['like', 'to_label', $this->to_label])
            ->andFilterWhere(['like', 'remarks', $this->remarks])
            ->andFilterWhere(['like', 'attachment', $this->attachment]);

        return $dataProvider;
    }

    public function receive()
    {
        $query = DocumentStatus::find()
            ->joinWith(['document', 'document.user'])
            ->where('(document.status=:status_new OR document.status=:status_release) AND document_status.to_id=:to_id AND document_status.to_label=:to_label')
            ->addParams([
                ':status_new' => parent::FILE_NEW,
                ':status_release' => parent::FILE_RECEIVE,
                'to_id' => \Yii::$app->user->identity->division_id,
                'to_label' => \Yii::$app->user->identity->division_label,
            ]);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        return $dataProvider;
    }

    public function release()
    {
        $query = DocumentStatus::find()
            ->joinWith(['document', 'document.user'])
            ->where('document.status=:status AND document_status.to_id=:to_id AND document_status.to_label=:to_label')
            ->addParams([
                ':status' => parent::FILE_RELEASE,
                'to_id' => \Yii::$app->user->identity->division_id,
                'to_label' => \Yii::$app->user->identity->division_label,
            ]);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        return $dataProvider;
    }
}
