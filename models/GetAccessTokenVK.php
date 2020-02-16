<?php

namespace app\models;

use VK\OAuth\Scopes\VKOAuthUserScope;
use VK\OAuth\VKOAuth;
use VK\OAuth\VKOAuthDisplay;
use VK\OAuth\VKOAuthResponseType;
use Yii;
use yii\base\Model;
use VK\Client\VKApiClient;

/**
 *  GetAccessTokenVK
 */
class GetAccessTokenVK extends Model
{
    public $access_token;

    /**
     * Получение токена ВК
     * @throws \VK\Exceptions\VKClientException
     * @throws \VK\Exceptions\VKOAuthException
     */
    public function getToken() {
        $params = Yii::$app->params;
        $oauth = new VKOAuth();
        $client_id = $params['client_id'];
        $client_secret = $params['client_secret'];
        $redirect_uri = $params['redirect_uri'];;
        $code = Yii::$app->request->get('code');

        $response = $oauth->getAccessToken($client_id, $client_secret, $redirect_uri, $code);
        $this->access_token = $response['access_token'];

        $this->saveUserData();
    }

    /**
     * Сохранение данных пользователя в БД
     */
    public function saveUserData(){
        $id = Yii::$app->session['__id'];

        $response = $this->getUserDataVk()[0];

        $vk = Vk::find()
            ->joinWith('user')
            ->where(['user_id'=>$id])
            ->one();
        $vk->access_token = $this->access_token;
        $vk->name = $response['first_name'];
        $vk->lastname = $response['last_name'];
        $vk->avatar_link = $response['photo_max'];
        $vk->save();

        Yii::$app->session['access_token'] = $this->access_token;
    }

    /**
     * Получение данных пользователя из ВК
     */
    public function getUserDataVk() {
        $vk = new VKApiClient();
        $response = $vk->users()->get($this->access_token, array(
            'fields' => array('firts_name', 'last_name', 'photo_max'),
        ));

        return $response;
    }


    /**
     * получение Code
     * @return string
     */
    public function getVkCode() {
        $params = Yii::$app->params;
        $oauth = new VKOAuth();
        $client_id = $params['client_id'];
        $redirect_uri = $params['redirect_uri'];
        $display = VKOAuthDisplay::PAGE;
        $scope = array(VKOAuthUserScope::WALL, VKOAuthUserScope::GROUPS, VKOAuthUserScope::PHOTOS, VKOAuthUserScope::OFFLINE);
        $state = 'secret_state_code';

        $browser_url = $oauth->getAuthorizeUrl(VKOAuthResponseType::CODE, $client_id, $redirect_uri, $display, $scope, $state);

        return $browser_url;
    }
}
