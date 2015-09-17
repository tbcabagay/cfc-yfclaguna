<?php

namespace app\models;

use Yii;
use app\models\Service;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "user".
 *
 * @property integer $id
 * @property string $auth_key
 * @property integer $division_id
 * @property string $division_label
 * @property integer $service_id
 * @property string $email
 * @property integer $status
 * @property string $role
 * @property string $created_at
 * @property string $updated_at
 *
 * @property Announcement[] $announcements
 * @property Auth[] $auths
 * @property Comment[] $comments
 * @property Document[] $documents
 * @property DocumentStatus[] $documentStatuses
 * @property DocumentStatus[] $documentStatuses0
 * @property Service $service
 * @property UserProfile[] $userProfiles
 */
class User extends \yii\db\ActiveRecord  implements \yii\web\IdentityInterface
{
    const SCENARIO_REGISTER = 'register';
    const STATUS_ACTIVE = 1;
    const STATUS_DELETE = 0;

    public $division;

    public function scenarios()
    {
        $scenarios = parent::scenarios();
        $scenarios[self::SCENARIO_REGISTER] = ['email', /*'role',*/ 'division_id', 'division_label', 'service_id'];
        return $scenarios;
    }

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'user';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['auth_key', 'division_id', 'division_label', 'service_id', 'email', 'status', 'role', 'created_at'], 'required'],
            [['division_id', 'service_id', 'status'], 'integer'],
            [['email'], 'email'],
            [['email'], 'unique'],
            [['created_at', 'updated_at'], 'safe'],
            [['auth_key'], 'string', 'max' => 32],
            [['role'], 'string', 'max' => 15],
            [['division_label'], 'string', 'max' => 20],
            [['email'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'auth_key' => 'Auth Key',
            'division_id' => 'Division ID',
            'division_label' => 'Division Label',
            'service_id' => 'Service ID',
            'email' => 'Email',
            'status' => 'Status',
            'role' => 'Role',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAnnouncements()
    {
        return $this->hasMany(Announcement::className(), ['user_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAuths()
    {
        return $this->hasMany(Auth::className(), ['user_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getComments()
    {
        return $this->hasMany(Comment::className(), ['user_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDocuments()
    {
        return $this->hasMany(Document::className(), ['user_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDocumentStatuses()
    {
        return $this->hasMany(DocumentStatus::className(), ['released_by' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDocumentStatuses0()
    {
        return $this->hasMany(DocumentStatus::className(), ['received_by' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getService()
    {
        return $this->hasOne(Service::className(), ['id' => 'service_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUserProfiles()
    {
        return $this->hasOne(UserProfile::className(), ['user_id' => 'id']);
    }

    /**
     * Finds an identity by the given ID.
     *
     * @param string|integer $id the ID to be looked for
     * @return IdentityInterface|null the identity object that matches the given ID.
     */
    public static function findIdentity($id)
    {
        return static::findOne($id);
    }

    /**
     * Finds an identity by the given token.
     *
     * @param string $token the token to be looked for
     * @return IdentityInterface|null the identity object that matches the given token.
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        return static::findOne(['access_token' => $token]);
    }

    /**
     * @return int|string current user ID
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return string current user auth key
     */
    public function getAuthKey()
    {
        return $this->auth_key;
    }

    /**
     * @param string $authKey
     * @return boolean if auth key is valid for current user
     */
    public function validateAuthKey($authKey)
    {
        return $this->getAuthKey() === $authKey;
    }

    public function getRoleTypes()
    {
        $items = ['' => 'Choose...'];
        $roles = \Yii::$app->authManager->getRoles();

        foreach ($roles as $role) {
            $items[$role->name] = $role->name;
        }

        return $items;
    }

    public function getStatusTypes()
    {
        return [
            self::STATUS_ACTIVE => 'STATUS_ACTIVE',
            self::STATUS_DELETE => 'STATUS_DELETE',
        ];
    }

    public function filterStatus($id)
    {
        if ($id === self::STATUS_ACTIVE)
            return 'STATUS_ACTIVE';
        else if ($id === self::STATUS_DELETE)
            return 'STATUS_DELETE';
    }

    public function beforeSave($insert)
    {
        if (parent::beforeSave($insert)) {
            if ($this->isNewRecord) {
                $this->status = self::STATUS_ACTIVE;
                $this->created_at = new \yii\db\Expression('NOW()');
                $this->auth_key = \Yii::$app->security->generateRandomString();
                $this->role = 'admin';
            }

            return true;
        }

        return false;
    }

    public function getServiceList()
    {
        $model = Service::find()->orderBy('name ASC')->all();
        return ArrayHelper::map($model, 'id', 'name');        
    }

    public function getDivisionList()
    {
        $model = [
            'provincial' => 'Provincial',
            'sector' => 'Sector',
            'cluster' => 'Cluster',
            'chapter' => 'Chapter',
        ];

        return $model;
    }

    public static function findByEmail($email)
    {
        return static::find()
            ->where(['email' => $email])
            ->limit(1)
            ->one();
    }

    public function afterFind()
    {
        $this->division = $this->findDivision($this->division_id, $this->division_label);

        return parent::afterFind();
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
}
