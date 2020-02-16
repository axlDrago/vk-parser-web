<?php

namespace app\models;

use Yii;
use yii\base\Model;

/**
 * ResetPasswordForm
 *
 */
class ResetPasswordForm extends Model
{
    public $email;
    public $password;

    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            ['email', 'email'],
            ['email', 'required'],
            ['email', 'validateEmail'],
            ['password', 'string', 'min' => 6],
            ['password', 'match', 'pattern' => '/^[a-zA-Z0-9]+$/', 'message' => 'Можно использовать только латинские буквы или цифры'],
        ];
    }

    public function validateEmail (){
        if(User::findByEmail($this->email) == null) {
            $this->addError( 'email','Эл. почта не найдена');
        }
    }

    /**
     * generate Token reset password
     * @throws \yii\base\Exception
     */
    public function sendToken (){
        if($this->validate()){
            $token = Yii::$app->security->generateRandomString();

            Yii::$app->mailer->compose('user/mesResetPassword', ['token' => $token])
                ->setFrom(Yii::$app->params['serverEmail'])
                ->setTo($this->email)
                ->setSubject('Сброс пароля')
                ->send();

            $user = User::findOne(['email' => $this->email]);
            $user->updated_at = date('r');
            $user->reset_token = $token;
            $user->save();
        }
    }

    public function resetPassword(){
        $user = User::find()->where(['reset_token' => Yii::$app->request->get('token')]) -> one();
        $user->reset_token = null;
        $user->updated_at = date('r');
        $user->password_hash = Yii::$app->security->generatePasswordHash($this->password);
        $user->save();
    }
}
