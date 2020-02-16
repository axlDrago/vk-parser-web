<?php

namespace app\models;

use Yii;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "vk".
 *
 * @property int $id
 * @property int $user_id
 * @property string $access_token
 * @property string $name
 * @property string $lastname
 * @property string $avatar_link
 *
 * @property User $user
 */
class Vk extends ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'vk';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['user_id'], 'required'],
            [['user_id'], 'integer'],
            [['access_token', 'name', 'lastname', 'avatar_link'], 'string', 'max' => 255],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['user_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_id' => 'User ID',
            'access_token' => 'Access Token',
            'name' => 'Name',
            'lastname' => 'Lastname',
            'avatar_link' => 'Avatar Link',
        ];
    }

    /**
     *
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }
}
