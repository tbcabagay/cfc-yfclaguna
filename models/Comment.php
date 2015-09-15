<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "comment".
 *
 * @property integer $id
 * @property integer $announcement_id
 * @property integer $user_id
 * @property string $content
 * @property integer $status
 * @property string $created_at
 *
 * @property User $user
 * @property Announcement $announcement
 */
class Comment extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'comment';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['announcement_id', 'user_id', 'content', 'status', 'created_at'], 'required'],
            [['announcement_id', 'user_id', 'status'], 'integer'],
            [['content'], 'string'],
            [['created_at'], 'safe']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'announcement_id' => 'Announcement ID',
            'user_id' => 'User ID',
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
    public function getAnnouncement()
    {
        return $this->hasOne(Announcement::className(), ['id' => 'announcement_id']);
    }
}
