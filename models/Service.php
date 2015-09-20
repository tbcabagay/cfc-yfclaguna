<?php

namespace app\models;

use Yii;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "service".
 *
 * @property integer $id
 * @property string $name
 *
 * @property Member[] $members
 * @property User[] $users
 */
class Service extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'service';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['name'], 'string', 'max' => 30]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUsers()
    {
        return $this->hasMany(User::className(), ['service_id' => 'id']);
    }

    public function getList()
    {
        $model = self::find()->orderBy('name ASC')->all();
        return ArrayHelper::map($model, 'id', 'name');
    }

    public function getServiceName($id) {
        $model = self::findOne($id);
        if ($model)
            return $model->name;
        return null;
    }
}
