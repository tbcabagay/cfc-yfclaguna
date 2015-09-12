<?php

namespace app\models;

use Yii;
use \yii\web\IdentityInterface;

/**
 * This is the model class for table "user".
 *
 * @property integer $id
 * @property string $auth_key
 * @property string $email
 * @property integer $status
 * @property integer $role
 * @property integer $is_deleted
 * @property string $created_at
 * @property string $updated_at
 *
 * @property UserProfile[] $userProfiles
 */
class User extends \yii\db\ActiveRecord implements IdentityInterface
{
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
            [['status', 'role', 'is_deleted'], 'integer'],
            [['created_at', 'updated_at'], 'safe'],
            [['auth_key'], 'string', 'max' => 32],
            [['email'], 'string', 'max' => 100]
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
            'is_deleted' => 'Is Deleted',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUserProfiles()
    {
        return $this->hasOne(UserProfile::className(), ['user_id' => 'id']);
    }

    /**
     * @inheritdoc
     */
    public static function findIdentity($id)
    {
        return isset(self::$users[$id]) ? new static(self::$users[$id]) : null;
    }

    /**
     * @inheritdoc
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        foreach (self::$users as $user) {
            if ($user['accessToken'] === $token) {
                return new static($user);
            }
        }

        return null;
    }

    /**
     * @inheritdoc
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @inheritdoc
     */
    public function getauth_key()
    {
        return $this->auth_key;
    }

    /**
     * @inheritdoc
     */
    public function validateauth_key($auth_key)
    {
        return $this->auth_key === $auth_key;
    }

    public function beforeSave($insert)
    {
        if (parent::beforeSave($insert)) {
            if ($insert) {
                $this->auth_key = \Yii::$app->security->generateRandomString();
            }

        return true;
        }

        return false;
    }
}
