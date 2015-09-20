<?php

namespace app\models;

use Yii;
use yii\db\Expression;
use yii\helpers\BaseFileHelper;

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
    const SCENARIO_CREATE = 'create';
    const SCENARIO_UPDATE = 'update';
    const FILE_NEW = 1;
    const FILE_RECEIVE = 2;
    const FILE_RELEASE = 3;
    const FILE_DENY = 4;
    const FILE_TERMINAL = 5;
    const FILE_PENDING = 6;

    public $attachment_file;
    private $attachment_path;

    public function scenarios()
    {
        $scenarios = parent::scenarios();
        $scenarios[self::SCENARIO_CREATE] = ['title', 'remarks', 'attachment_file'];
        $scenarios[self::SCENARIO_UPDATE] = ['title', 'remarks', 'attachment_file'];
        return $scenarios;
    }

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
            [['user_id', 'title', 'remarks', 'attachment', 'status', 'is_deleted', 'created_at'], 'required'],
            [['user_id', 'status', 'is_deleted', 'time_difference'], 'integer'],
            [['created_at'], 'safe'],
            [['attachment_file'], 'file', 'skipOnEmpty' => false, /*'extensions' => ['png', 'jpg', 'bmp', 'txt', 'pdf', 'doc', 'docx'],*/ 'on' => self::SCENARIO_CREATE],
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
            'attachment_file' => 'Attachment',
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

    public function beforeSave($insert)
    {
        if (parent::beforeSave($insert)) {
            if ($this->isNewRecord) {
                $this->user_id = \Yii::$app->user->identity->id;
                /*if (\Yii::$app->user->identity->role == 'subadmin')
                    $this->status = self::FILE_PENDING;
                else*/

                $this->status = self::FILE_NEW;
                $this->is_deleted = false;
                $this->created_at = new Expression('NOW()');
            }

            if ($this->attachment_file !== null) {
                $this->attachment_path = \Yii::getAlias('@app') . DIRECTORY_SEPARATOR . 'uploads' . DIRECTORY_SEPARATOR . 'document' . DIRECTORY_SEPARATOR . \Yii::$app->user->identity->id . DIRECTORY_SEPARATOR . time();
                $this->attachment = $this->attachment_path . DIRECTORY_SEPARATOR . $this->attachment_file->baseName . '.' . $this->attachment_file->extension;
            }

            return true;
        }

        return false;
    }

    public function upload()
    {
        if ($this->validate()) {
            if ($this->attachment_file !== null) {
                if (!file_exists($this->attachment_path))
                    $createPath = BaseFileHelper::createDirectory($this->attachment_path, 0754);

                if ($createPath)
                    $this->attachment_file->saveAs($this->attachment);
            }

            return true;
        }

        return false;
    }

    public function findToDivision()
    {
        $model = null;
        $result = [];

        $id = \Yii::$app->user->identity->division_id;
        $label = \Yii::$app->user->identity->division_label;

        if ($label === 'chapter') {
            $model = Chapter::find()
                ->joinWith(['cluster'])
                ->where(['chapter.id' => $id])
                ->limit(1)
                ->one();

            $result = [
                'id' => $model->cluster->id,
                'name' => $model->cluster->label,
                'label' => 'cluster',
            ];
        } else if ($label === 'cluster') {
            $model = Cluster::find()
                ->joinWith(['sector'])
                ->where(['cluster.id' => $id])
                ->limit(1)
                ->one();

                $result = [
                'id' => $model->sector->id,
                'name' => $model->sector->label,
                'label' => 'sector',
            ];
        } else if ($label === 'sector') {
            $model = Sector::find()
                ->joinWith(['provincial'])
                ->where(['sector.id' => $id])
                ->limit(1)
                ->one();

                $result = [
                'id' => $model->provincial->id,
                'name' => $model->provincial->label,
                'label' => 'provincial',
            ];
        }

        return $result;
    }

    public function getStatus($id)
    {
        if ($id == self::FILE_DENY) {
            return '<span class="label label-danger">DENIED</span>';
        } else if ($id == self::FILE_TERMINAL) {
            return '<span class="label label-success">TERMINAL</span>';
        } else if ($id == self::FILE_PENDING) {
            return '<span class="label label-warning">PENDING</span>';
        } else {
            return '<span class="label label-default">IN TRANSITION</span>';
        }
    }

    /*public function deleteFile()
    {
        if (empty($this->attachment) || !file_exists($this->attachment))
            return false;

        if (is_file($this->attachment) && !unlink($this->attachment))
            return false;

        $uploadDir = \Yii::getAlias('@app') . '/uploads/create/' . $this->id;
        if (is_dir($uploadDir) && !rmdir($uploadDir))
            return false;

        return true;
    }*/
}
