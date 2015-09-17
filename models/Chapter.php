<?php

namespace app\models;

use Yii;
use app\models\Cluster;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "chapter".
 *
 * @property integer $id
 * @property integer $cluster_id
 * @property string $label
 *
 * @property Cluster $cluster
 */
class Chapter extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'chapter';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['cluster_id', 'label'], 'required'],
            [['cluster_id'], 'integer'],
            [['label'], 'string', 'max' => 30]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'cluster_id' => 'Cluster ID',
            'label' => 'Label',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCluster()
    {
        return $this->hasOne(Cluster::className(), ['id' => 'cluster_id']);
    }

    public function getClusterList()
    {
        $model = Cluster::find()->orderBy('label ASC')->all();
        return ArrayHelper::map($model, 'id', 'label');
    }
}
