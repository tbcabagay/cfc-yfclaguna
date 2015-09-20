<?php

namespace app\models;

use Yii;
use app\models\Sector;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "cluster".
 *
 * @property integer $id
 * @property integer $sector_id
 * @property string $label
 *
 * @property Chapter[] $chapters
 * @property Sector $sector
 * @property Member[] $members
 */
class Cluster extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'cluster';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['sector_id', 'label'], 'required'],
            [['sector_id'], 'integer'],
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
            'sector_id' => 'Sector ID',
            'label' => 'Label',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getChapters()
    {
        return $this->hasMany(Chapter::className(), ['cluster_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSector()
    {
        return $this->hasOne(Sector::className(), ['id' => 'sector_id']);
    }

    public function getList()
    {
        $model = self::find()->orderBy('label ASC')->all();
        return ArrayHelper::map($model, 'id', 'label');
    }

    public static function getClusterType($id)
    {
        $model = static::findOne($id);
        return $model->label;
    }
}
