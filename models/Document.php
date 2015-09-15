<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "document".
 *
 * @property integer $id
 * @property integer $user_id
 * @property string $title
 * @property string $remarks
 * @property string $attachment
 * @property integer $status
 * @property integer $is_deleted
 * @property string $created_at
 * @property integer $time_difference
 *
 * @property User $user
 * @property DocumentStatus[] $documentStatuses
 */
class Document extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'document';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'title', 'remarks', 'attachment', 'status', 'is_deleted'], 'required'],
            [['user_id', 'status', 'is_deleted', 'time_difference'], 'integer'],
            [['created_at'], 'safe'],
            [['title'], 'string', 'max' => 100],
            [['remarks', 'attachment'], 'string', 'max' => 500]
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
            'remarks' => 'Remarks',
            'attachment' => 'Attachment',
            'status' => 'Status',
            'is_deleted' => 'Is Deleted',
            'created_at' => 'Created At',
            'time_difference' => 'Time Difference',
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
    public function getDocumentStatuses()
    {
        return $this->hasMany(DocumentStatus::className(), ['document_id' => 'id']);
    }
}
