<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "document_status".
 *
 * @property integer $id
 * @property integer $document_id
 * @property integer $division_id
 * @property string $division_label
 * @property string $remarks
 * @property integer $received_by
 * @property string $received_at
 * @property integer $released_by
 * @property string $released_at
 * @property integer $action
 * @property string $attachment
 * @property integer $time_difference
 *
 * @property User $releasedBy
 * @property Document $document
 * @property User $receivedBy
 */
class DocumentStatus extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'document_status';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['document_id', 'division_id', 'division_label', 'remarks', 'attachment'], 'required'],
            [['document_id', 'division_id', 'received_by', 'released_by', 'action', 'time_difference'], 'integer'],
            [['received_at', 'released_at'], 'safe'],
            [['division_label'], 'string', 'max' => 15],
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
            'document_id' => 'Document ID',
            'division_id' => 'Division ID',
            'division_label' => 'Division Label',
            'remarks' => 'Remarks',
            'received_by' => 'Received By',
            'received_at' => 'Received At',
            'released_by' => 'Released By',
            'released_at' => 'Released At',
            'action' => 'Action',
            'attachment' => 'Attachment',
            'time_difference' => 'Time Difference',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getReleasedBy()
    {
        return $this->hasOne(User::className(), ['id' => 'released_by']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDocument()
    {
        return $this->hasOne(Document::className(), ['id' => 'document_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getReceivedBy()
    {
        return $this->hasOne(User::className(), ['id' => 'received_by']);
    }
}
