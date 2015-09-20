<?php

namespace app\models;

use Yii;
use app\models\Provincial;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "sector".
 *
 * @property integer $id
 * @property integer $provincial_id
 * @property string $label
 *
 * @property Cluster[] $clusters
 * @property Provincial $provincial
 */
class Sector extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'sector';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['provincial_id', 'label'], 'required'],
            [['provincial_id'], 'integer'],
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
            'provincial_id' => 'Provincial ID',
            'label' => 'Label',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getClusters()
    {
        return $this->hasMany(Cluster::className(), ['sector_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProvincial()
    {
        return $this->hasOne(Provincial::className(), ['id' => 'provincial_id']);
    }

    public function getList()
    {
        $model = self::find()->orderBy('label ASC')->all();
        return ArrayHelper::map($model, 'id', 'label');
    }
}
