<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "user_profile".
 *
 * @property integer $id
 * @property integer $user_id
 * @property string $family_name
 * @property string $given_name
 * @property string $image
 * @property string $address
 * @property string $birthday
 * @property string $joined_at
 * @property string $venue
 *
 * @property User $user
 */
class UserProfile extends \yii\db\ActiveRecord
{
    const SCENARIO_GUEST_REGISTER = 'guest_register';
    const SCENARIO_AUTH_REGISTER = 'auth_register';
    const STATUS_ACTIVE = 1;
    const STATUS_INACTIVE = 2;
    const STATUS_DELETE = 3;

    public function scenarios()
    {
        $scenarios = parent::scenarios();
        $scenarios[self::SCENARIO_GUEST_REGISTER] = ['user_id', 'family_name', 'given_name', 'address', 'birthday'];
        $scenarios[self::SCENARIO_AUTH_REGISTER] = ['user_id', 'family_name', 'given_name', 'image'];

        return $scenarios;
    }

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'user_profile';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['address', 'birthday', 'user_id', 'family_name', 'given_name', 'image'], 'required'],
            [['user_id'], 'integer'],
            [['birthday', 'joined_at'], 'safe'],
            [['family_name', 'given_name'], 'string', 'max' => 100],
            [['image', 'address'], 'string', 'max' => 300],
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
            'user_id' => 'User ID',
            'family_name' => 'Family Name',
            'given_name' => 'Given Name',
            'image' => 'Image',
            'address' => 'Address',
            'birthday' => 'Birthday',
            'joined_at' => 'Joined At',
            'venue' => 'Venue',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }

    public function beforeSave($insert)
    {
        if (parent::beforeSave($insert)) {
            if ($this->isNewRecord) {
                if ($this->scenario == self::SCENARIO_GUEST_REGISTER)
                    $this->image = '@web/images/blank.png';
            }

            return true;
        }

        return false;
    }
}
