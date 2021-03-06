<?php

namespace app\models;

use Yii;
use yii\db\Expression;

/**
 * This is the model class for table "announcement".
 *
 * @property integer $id
 * @property integer $user_id
 * @property string $title
 * @property string $content
 * @property integer $status
 * @property string $created_at
 *
 * @property User $user
 * @property Comment[] $comments
 */
class Announcement extends \yii\db\ActiveRecord
{

    const SCENARIO_CREATE = 'create';
    const STATUS_ACTIVE = 1;
    const STATUS_DELETE = 2;

    public function scenarios()
    {
        $scenarios = parent::scenarios();
        $scenarios[self::SCENARIO_CREATE] = ['title', 'content'];
        return $scenarios;
    }

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'announcement';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'title', 'content', 'status', 'created_at'], 'required'],
            [['user_id', 'status'], 'integer'],
            [['content'], 'string'],
            [['created_at'], 'safe'],
            [['title'], 'string', 'max' => 100]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_id' => 'User ID',
            'title' => 'Title',
            'content' => 'Content',
            'status' => 'Status',
            'created_at' => 'Created At',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getComments()
    {
        return $this->hasMany(Comment::className(), ['announcement_id' => 'id']);
    }

    public function beforeSave($insert)
    {
        if (parent::beforeSave($insert)) {
            if ($insert) {
                $this->user_id = \Yii::$app->user->identity->id;
                $this->status = self::STATUS_ACTIVE;
                $this->created_at = new Expression('NOW()');
            }
            return true;
        }

        return false;
    }
}
