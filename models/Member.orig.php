<?php

namespace app\models;

use Yii;
use app\models\Service;
use app\models\Cluster;
use yii\helpers\ArrayHelper;
use yii\helpers\BaseFileHelper;
use yii\web\IdentityInterface;

/**
 * This is the model class for table "member".
 *
 * @property integer $id
 * @property string $auth_key
 * @property integer $service_id
 * @property integer $cluster_id
 * @property string $username
 * @property string $password_hash
 * @property string $family_name
 * @property string $given_name
 * @property string $address
 * @property string $email
 * @property string $birthday
 * @property integer $status
 * @property string $joined_at
 * @property string $venue
 * @property string $image
 *
 * @property Cluster $cluster
 * @property Service $service
 */
class Member extends \yii\db\ActiveRecord implements IdentityInterface
{
    const SCENARIO_ADMIN_REGISTER = 'admin_register';
    const SCENARIO_REGISTER = 'register';
    const STATUS_INACTIVE = 1;
    const STATUS_ACTIVE = 2;
    const STATUS_DELETE = 3;

    public $image_file;
    public $image_path;
    public $confirm_password;
    public $password;

    public function scenarios()
    {
        $scenarios = parent::scenarios();
        $scenarios[self::SCENARIO_ADMIN_REGISTER] = ['username', 'password', 'service_id', 'cluster_id', 'family_name', 'given_name', 'address', 'email', 'birthday', 'joined_at', 'venue', 'image_file'];
        $scenarios[self::SCENARIO_REGISTER] = ['username', 'confirm_password', 'password', 'service_id', 'cluster_id', 'family_name', 'given_name', 'address', 'email', 'birthday', 'image_file'];
        return $scenarios;
    }
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'member';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['auth_key', 'service_id', 'cluster_id', 'username', 'password', 'password_hash', 'family_name', 'given_name', 'address', 'email', 'birthday', 'status'], 'required'],
            [['service_id', 'cluster_id', 'status'], 'integer'],
            [['email', 'username'], 'unique'],
            [['email'], 'email'],
            [['confirm_password'], 'compare', 'compareAttribute' => 'password', 'message' => 'Confirm password did not match'],
            [['birthday', 'joined_at'], 'safe'],
            [['auth_key'], 'string', 'max' => 32],
            [['username'], 'string', 'max' => 50],
            [['password', 'password_hash', 'confirm_password', 'family_name', 'given_name'], 'string', 'max' => 100],
            [['image_file'], 'file', 'skipOnEmpty' => false, 'extensions' => ['png', 'jpg', 'bmp'], 'on' => [self::SCENARIO_ADMIN_REGISTER, self::SCENARIO_REGISTER]],
            [['address'], 'string', 'max' => 300],
            [['email'], 'string', 'max' => 255],
            [['venue'], 'string', 'max' => 200],
            [['image'], 'string', 'max' => 500]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'service_id' => 'Service',
            'cluster_id' => 'Area',
            'auth_key' => 'Auth Key',
            'username' => 'Username',
            'password_hash' => 'password_hash',
            'family_name' => 'Family Name',
            'given_name' => 'Given Name',
            'address' => 'Address',
            'email' => 'Email',
            'birthday' => 'Birthday',
            'status' => 'Status',
            'joined_at' => 'Joined At',
            'venue' => 'Venue',
            'image' => 'Image',
            'image_file' => 'Photo',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCluster()
    {
        return $this->hasOne(Cluster::className(), ['id' => 'cluster_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getService()
    {
        return $this->hasOne(Service::className(), ['id' => 'service_id']);
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

    public function getServiceList()
    {
        $model = Service::find()->orderBy('name ASC')->all();
        return ArrayHelper::map($model, 'id', 'name');        
    }

    public function getClusterList()
    {
        $model = Cluster::find()->orderBy('label ASC')->all();
        return ArrayHelper::map($model, 'id', 'label');        
    }

    public function beforeSave($insert)
    {
        if (parent::beforeSave($insert)) {
            if ($insert) {
                if ($this->scenario == self::SCENARIO_ADMIN_REGISTER)
                    $this->status = self::STATUS_ACTIVE;
                else if ($this->scenario == self::SCENARIO_REGISTER)
                    $this->status = self::STATUS_INACTIVE;

                $this->password_hash = Yii::$app->security->generatePasswordHash($password);
                $this->auth_key = Yii::$app->security->generateRandomString();
                $this->image_path = \Yii::getAlias('@app') . DIRECTORY_SEPARATOR . 'uploads' . DIRECTORY_SEPARATOR . 'member' . DIRECTORY_SEPARATOR . time();
                $this->image = $this->image_path . DIRECTORY_SEPARATOR . $this->image_file->baseName . '.' . $this->image_file->extension;
            }

            return true;
        }

        return false;
    }

    public function upload()
    {
        //if ($this->validate()) {
            $createPath = BaseFileHelper::createDirectory($this->image_path, 0754);

            if ($createPath) {
                $this->image_file->saveAs($this->image);
                return true;
            }

            return false;
        //}
    }

    public static function findByUsername($username)
    {
        return static::findOne(['username' => $username, 'status' => self::STATUS_ACTIVE]);
    }

    public function validatePassword($password_hash)
    {
        return $password_hash == $this->password_hash;
    }
}
