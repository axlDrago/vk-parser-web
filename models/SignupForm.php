<?php

namespace app\models;

use Yii;
use yii\base\Model;

/**
 * LoginForm is the model behind the login form.
 *
 * @property User|null $user This property is read-only.
 *
 */
class SignupForm extends Model
{
    public $username;
    public $email;
    public $password;

    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            // username and password are both required
            [['username', 'password', 'email'], 'required'],
            ['email', 'email'],
            ['email', 'validateEmail'],
            [['username', 'password'], 'match', 'pattern' => '/^[a-zA-Z0-9]+$/', 'message' => 'Можно использовать только латинские буквы или цифры'],
            ['password', 'string', 'min'=> 6],
            ['username', 'validateLogin']
        ];
    }

    /**
     * Validates the login.
     *
     * @param string $attribute the attribute currently being validated
     * @param array $params the additional name-value pairs given in the rule
     */
    public function validateLogin($attribute, $params)
    {
        if(User::findByUsername($this->username) !== null) {
            $this->addError( $attribute, 'Имя занято');
        }
    }

    public function validateEmail($attribute, $params)
    {
        if(User::findByEmail($this->email) !== null) {
            $this->addError( $attribute, 'Адрес эл. почты уже зарегистрирован');
        }
    }

    public function sendSuccessMessages ($username, $password, $email) {
        Yii::$app->mailer->compose('user/successMessageReg', ['username'=>$username, 'password' => $password, 'email'=> $email])
            ->setFrom(Yii::$app->params['serverEmail'])
            ->setTo($email)
            ->setSubject('Успешная регистрация')
            ->send();
    }

    public function signup () {
        $free = 259200; //бесплатный период 3 дня в секундах
        $free = 2629743; //бесплатный период 1 месяц в секундах
        $date = date("r");
        if ($this->validate()) {
            $user = new User();
            $user->username = $this->username;
            $user->email = $this->email;
            $user->password_hash = $user->setPassword($this->password);
            $user->created_at = $date;
            $user->paid_to = date("r", strtotime($date) + $free);
            $user->save();

            $vk = new Vk();
            $vk->user_id = $user->id;
            $vk->save();

            $this->sendSuccessMessages($this->username, $this->password, $this->email);

            User::setSession($this->username);
            return Yii::$app->user->login(User::findByUsername($this->username),  0);
        }
        return false;
    }
}
