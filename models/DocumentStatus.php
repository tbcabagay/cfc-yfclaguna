<?php

namespace app\models;

use Yii;
use app\models\Provincial;
use app\models\Sector;
use app\models\Cluster;
use app\models\Chapter;
use yii\helpers\ArrayHelper;
use yii\helpers\BaseFileHelper;

/**
 * This is the model class for table "document_status".
 *
 * @property integer $id
 * @property integer $document_id
 * @property integer $from_id
 * @property string $from_label
 * @property integer $to_id
 * @property string $to_label
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
    const SCENARIO_DO_RELEASE = 'do-release';
    const FILE_NEW = 1;
    const FILE_RECEIVE = 2;
    const FILE_RELEASE = 3;
    const FILE_DENY = 4;
    const FILE_TERMINAL = 5;
    const FILE_PENDING = 6;
    const ACTION_APPROVE = 1;
    const ACTION_DENY = 2;

    public $from = null;
    public $to = null;
    public $attachment_file;
    private $attachment_path;

    public function scenarios()
    {
        $scenarios = parent::scenarios();
        $scenarios[self::SCENARIO_DO_RELEASE] = ['remarks', 'action', 'attachment_file'];
        return $scenarios;
    }

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
            [['document_id', 'from_id', 'from_label', 'to_id', 'to_label'], 'required'],
            [['remarks', 'action'], 'required', 'on' => self::SCENARIO_DO_RELEASE],
            [['attachment_file'], 'file', /*'extensions' => ['png', 'jpg', 'bmp', 'txt', 'pdf', 'doc', 'docx'],*/ 'on' => self::SCENARIO_DO_RELEASE],
            [['document_id', 'from_id', 'to_id', 'received_by', 'released_by', 'action', 'time_difference'], 'integer'],
            [['received_at', 'released_at'], 'safe'],
            [['from_label', 'to_label'], 'string', 'max' => 20],
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
            'from_id' => 'From ID',
            'from_label' => 'From Label',
            'to_id' => 'To ID',
            'to_label' => 'To Label',
            'remarks' => 'Remarks',
            'received_by' => 'Received By',
            'received_at' => 'Received At',
            'released_by' => 'Released By',
            'released_at' => 'Released At',
            'action' => 'Action',
            'attachment' => 'Attachment',
            'attachment_file' => 'Attachment',
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

    public function afterFind()
    {
        $this->from = $this->findDivision($this->from_id, $this->from_label);
        $this->to = $this->findDivision($this->to_id, $this->to_label);

        return parent::afterFind();
    }

    public function getActionTypes()
    {
        return [
            self::ACTION_APPROVE => 'Approve',
            self::ACTION_DENY => 'Deny',
        ];
    }

    public function upload()
    {
        if ($this->scenario == self::SCENARIO_DO_RELEASE) {
            if ($this->attachment_file !== null) {
                $createPath = BaseFileHelper::createDirectory($this->attachment_path, 0754);

                if ($createPath) {
                    $this->attachment_file->saveAs($this->attachment);
                    return true;
                }
            }
        }

        return false;
    }

    public function beforeSave($insert)
    {
        if (parent::beforeSave($insert)) {
            if ($this->scenario == self::SCENARIO_DO_RELEASE) {
                if ($this->attachment_file !== null) {
                    $this->attachment_path = \Yii::getAlias('@app') . DIRECTORY_SEPARATOR . 'uploads' . DIRECTORY_SEPARATOR . 'document-status' . DIRECTORY_SEPARATOR . \Yii::$app->user->identity->id . DIRECTORY_SEPARATOR . time();
                    $this->attachment = $this->attachment_path . DIRECTORY_SEPARATOR . $this->attachment_file->baseName . '.' . $this->attachment_file->extension;
                }
            }

            return true;
        }

        return false;
    }

    protected function findDivision($id, $label)
    {
        $model = null;

        if ($label == 'provincial') {
            $model = Provincial::findOne($id);
        } else if ($label == 'sector') {
            $model = Sector::findOne($id);
        } else if ($label == 'cluster') {
            $model = Cluster::findOne($id);
        } else if ($label == 'chapter') {
            $model = Chapter::findOne($id);
        }

        if ($model !== null) {
            return $model->label;
        }
    }

    public function dateDiff($old_date, $accuracy = 2, $now = null)
    {
        $periods = [
            'second' => 1,
            'minute' => 60,
            'hour' => 3600,
            'day' => 86400,
            'week' => 604800,
            'month' => 2630880,
            'year' => 31570560,
            'decade' => 315705600
        ];
        $periods = array_reverse($periods);

        if ($now === null)
            $now = time();

        $old_date = strtotime($old_date);
        $now = strtotime($now);
     
        if (!is_int($accuracy) || $accuracy < 1 || $accuracy > count($periods))
            throw new InvalidArgumentException("Date Accuracy should be an integer between 1 and 6");
     
        $difference = $now - $old_date;

        if ($difference < 0)
            throw new InvalidArgumentException('The previous date cannot be greater than todays date');

        $result = '';
        $i = 0;

        foreach ($periods as $k => $v) {
            $tmp = floor($difference / $v);

            if ($tmp > 1) {
                $result .= ' ' . $tmp . ' ' . $k . 's';
                $i++;
            }
            else if ($tmp == 1) {
                $result .= $tmp . $k;
                $i++;
            }

            $difference = $difference % $v;

            if($i == $accuracy)
                break;
        }

        return $result;
    }

    public function getAction($id)
    {
        if ((int)$id === self::ACTION_APPROVE) {
            return '<span class="label label-success">APPROVE</span>';
        } else if ((int)$id === self::ACTION_DENY) {
            return '<span class="label label-danger">DENY</span>';
        }
    }
}
