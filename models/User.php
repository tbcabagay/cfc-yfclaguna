<?php

namespace app\models;
use yii\helpers\ArrayHelper;

use Yii;

/**
 * This is the model class for table "user".
 *
 * @property integer $id
 * @property string $auth_key
 * @property integer $division_id
 * @property string $division_label
 * @property integer $service_id
 * @property integer $cluster_id
 * @property string $username
 * @property string $password_hash
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
class User extends \yii\db\ActiveRecord implements \yii\web\IdentityInterface
{
    const SCENARIO_ADMIN_REGISTER = 'admin_register';
    const SCENARIO_GUEST_REGISTER = 'guest_register';
    const SCENARIO_ADMIN_USER_REGISTER = 'admin_user_register';
    const SCENARIO_MEMBER_CREATE = 'member_create';
    const SCENARIO_ACTIVATE = 'activate';
    const STATUS_ACTIVE = 1;
    const STATUS_INACTIVE = 2;
    const STATUS_DELETE = 3;

    public $confirm_password;
    public $password;
    public $captcha;
    public $full_name;
    public $profile_image;
    public $division;
    public $cluster;

    public function scenarios()
    {
        $scenarios = parent::scenarios();

        $scenarios[self::SCENARIO_GUEST_REGISTER] = ['service_id', 'cluster_id', 'username', 'password', 'confirm_password', 'email', 'captcha'];
        $scenarios[self::SCENARIO_MEMBER_CREATE] = ['service_id', 'cluster_id', 'username', 'password', 'confirm_password', 'email'];
        $scenarios[self::SCENARIO_ADMIN_USER_REGISTER] = ['email', /*'role',*/ 'division_id', 'division_label', 'service_id'];
        $scenarios[self::SCENARIO_ACTIVATE] = ['status'];

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
            [['username', 'password', 'confirm_password', 'cluster_id' ,'auth_key', 'division_id', 'division_label', 'service_id', 'email', 'status', 'role', 'created_at'], 'required'],
            [['division_id', 'service_id', 'cluster_id', 'status'], 'integer'],
            [['created_at', 'updated_at'], 'safe'],
            [['username', 'email'], 'unique'],
            ['email', 'email'],
            ['captcha', 'captcha'],
            [['confirm_password'], 'compare', 'compareAttribute' => 'password', 'message' => 'Passwords do not match'],
            [['auth_key'], 'string', 'max' => 32],
            [['division_label'], 'string', 'max' => 20],
            [['username'], 'string', 'max' => 50],
            [['password_hash'], 'string', 'max' => 100],
            [['email'], 'string', 'max' => 255],
            [['role'], 'string', 'max' => 15]
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
            'division_id' => 'Division',
            'division_label' => 'Division Area',
            'service_id' => 'Service',
            'cluster_id' => 'Area',
            'username' => 'Username',
            'password_hash' => 'Password Hash',
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
        return $this->hasMany(UserProfile::className(), ['user_id' => 'id']);
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

    public static function findByUsername($username)
    {
        return static::findOne(['username' => $username, 'status' => self::STATUS_ACTIVE]);
    }

    public static function findByEmail($email)
    {
        return static::findOne(['email' => $email, 'status' => self::STATUS_ACTIVE]);
    }

    public function validatePassword($password)
    {
        return Yii::$app->security->validatePassword($password, $this->password_hash);
    }

    public function afterFind()
    {
        $this->division = $this->findDivision($this->division_id, $this->division_label);
        $this->cluster = Cluster::getClusterType($this->cluster_id);

        $model = UserProfile::find()->where(['user_id' => $this->id])->limit(1)->one();

        if ($model !== null) {
            $this->full_name = $model->given_name . ' ' . $model->family_name;
            $this->profile_image = $model->image;
        }
        return parent::afterFind();
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
                if ($this->scenario == self::SCENARIO_ADMIN_REGISTER || $this->scenario == self::SCENARIO_ADMIN_USER_REGISTER || $this->scenario == self::SCENARIO_MEMBER_CREATE)
                    $this->status = self::STATUS_ACTIVE;
                else if ($this->scenario == self::SCENARIO_GUEST_REGISTER)
                    $this->status = self::STATUS_INACTIVE;

                $this->password_hash = Yii::$app->security->generatePasswordHash($this->password);
                $this->auth_key = Yii::$app->security->generateRandomString();
                $this->created_at = new \yii\db\Expression('NOW()');
            }

            return true;
        }

        return false;
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
