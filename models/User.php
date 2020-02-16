<?php

namespace app\models;
use Yii;
use yii\db\ActiveRecord;

class User extends ActiveRecord implements \yii\web\IdentityInterface
{
    /**
     * {@inheritdoc}
     */
    public static function findIdentity($id)
    {
        return static::findOne(['id' => $id]);
    }

    /**
     * {@inheritdoc}
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        return static::findOne(['reset_token' => $token]);
    }

    /**
     * Finds user by username
     *
     * @param string $username
     * @return static|null
     */
    public static function findByUsername($username)
    {
        return static::findOne(['username' => $username]);
    }

    /**
     * Finds user by email
     *
     * @param string $email
     * @return static|null
     */
    public static function findByEmail($email)
    {
        return static::findOne(['email' => $email]);
    }

    public function findResetToken($token) {
        return static::findOne(['reset_token' => $token]);
    }

    /**
     * {@inheritdoc}
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * {@inheritdoc}
     */
    public function getAuthKey()
    {
//        return $this->authKey;
    }

    /**
     * {@inheritdoc}
     */
    public function validateAuthKey($authKey)
    {
        return $this->authKey === $authKey;
    }

    /**
     * Validates password
     *
     * @param string $password password to validate
     * @return bool if password provided is valid for current user
     */
    public function validatePassword($password)
    {
//        $hash = \Yii::$app->getSecurity()->generatePasswordHash($password);
        return \Yii::$app->security->validatePassword($password, $this->password_hash);
    }

    public function setPassword($password)
    {
//        $this->password_hash = \Yii::$app->security->generatePasswordHash($password);
        return \Yii::$app->security->generatePasswordHash($password);
    }

    static function setSession($username){
        $user = User::findByUsername($username);
        $session = Yii::$app->session;
        $session['username'] = $user->username;
        $session['email'] = $user->email;
        $session['paidTo'] = $user->paid_to;
    }


    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }

}
