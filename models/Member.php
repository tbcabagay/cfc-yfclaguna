<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "member".
 *
 * @property integer $id
 * @property integer $service_id
 * @property integer $cluster_id
 * @property string $username
 * @property string $password
 * @property string $family_name
 * @property string $given_name
 * @property string $address
 * @property string $email
 * @property string $birthday
 * @property integer $status
 * @property string $joined_at
 * @property string $venue
 *
 * @property Cluster $cluster
 * @property Service $service
 */
class Member extends \yii\db\ActiveRecord
{
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
            [['service_id', 'cluster_id', 'username', 'password', 'family_name', 'given_name', 'address', 'email', 'birthday', 'status'], 'required'],
            [['service_id', 'cluster_id', 'status'], 'integer'],
            [['birthday', 'joined_at'], 'safe'],
            [['username'], 'string', 'max' => 50],
            [['password', 'family_name', 'given_name'], 'string', 'max' => 100],
            [['address'], 'string', 'max' => 300],
            [['email'], 'string', 'max' => 255],
            [['venue'], 'string', 'max' => 200]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'service_id' => 'Service ID',
            'cluster_id' => 'Cluster ID',
            'username' => 'Username',
            'password' => 'Password',
            'family_name' => 'Family Name',
            'given_name' => 'Given Name',
            'address' => 'Address',
            'email' => 'Email',
            'birthday' => 'Birthday',
            'status' => 'Status',
            'joined_at' => 'Joined At',
            'venue' => 'Venue',
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
}
