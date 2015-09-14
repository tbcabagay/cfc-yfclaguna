<?php

namespace app\models;

use Yii;
use yii\web\IdentityInterface;

/**
 * This is the model class for table "user".
 *
 * @property integer $id
 * @property string $auth_key
 * @property string $email
 * @property integer $status
 * @property string $role
 * @property string $created_at
 * @property string $updated_at
 *
 * @property Auth[] $auths
 * @property UserProfile[] $userProfiles
 */
class User extends \yii\db\ActiveRecord implements IdentityInterface
{
    const SCENARIO_REGISTER = 'register';
    const STATUS_ACTIVE = 1;
    const STATUS_DELETE = 0;

    public function scenarios()
    {
        $scenarios = parent::scenarios();
        $scenarios[self::SCENARIO_REGISTER] = ['email', 'role'];
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
            [['auth_key', 'email', 'status', 'role', 'created_at'], 'required'],
            [['email'], 'email'],
            [['email'], 'unique'],
            [['status'], 'integer'],
            [['created_at', 'updated_at'], 'safe'],
            [['auth_key'], 'string', 'max' => 32],
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
    public function getAuths()
    {
        return $this->hasOne(Auth::className(), ['user_id' => 'id']);
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
            }

            return true;
        }

        return false;
    }
}
