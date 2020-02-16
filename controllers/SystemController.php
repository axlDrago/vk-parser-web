<?php

namespace app\controllers;

use app\models\GetAccessTokenVK;
use app\models\system\Dashboard;
use app\models\system\Parsing;
use VK\OAuth\VKOAuth;
use Yii;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\web\Controller;
use yii\web\Response;
use VK\OAuth\VKOAuthDisplay;
use VK\OAuth\Scopes\VKOAuthUserScope;
use VK\OAuth\VKOAuthResponseType;



class SystemController extends Controller
{
    public $layout = 'system-dashboard';

    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'allow' => true,
                        'matchCallback' => function(){
                            if ( Yii::$app->user->isGuest) {
                                return false;
                            }
                            return true;
                        }
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'authvk' => ['post'],
                    'get-album' => ['post'],
                    'start-parsing' => ['post'],
                    'send-photo' => ['post'],
                    'get-group' => ['post'],
                ],
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function actions()
    {

        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    /**
     * Displays homepage.
     *
     * @return string
     */

    public function actionIndex()
    {
        $model = new Dashboard();

        return $this->render('dashboard', [
            'model' => $model,
            'paidTo' => $model->getPaidTo()['paidTo'],
            'vip' => $model->getPaidTo()['vip'],
            'name' => $model->getAuthVk()['name'],
            'lastname' => $model->getAuthVk()['lastname'],
            'avatar_link' => $model->getAuthVk()['avatar_link'],
        ]);
    }


    /**
     * Чат
     * @return string
     */
    public function actionChat()
    {
        return $this->render('chat');
    }

    /**
     * Получение code для VK
     */
    public function actionAuthvk()
    {
        $model = new GetAccessTokenVK();
        $this->redirect($model -> getVkCode());
    }

    /**
     * System
     */
    public function actionParsing()
    {
        return $this->render('parsing');
    }


    /**
     * Контролер получения альбомов
     * @return false|string
     */
    public function actionGetAlbum ()
    {
        $model = new Parsing();
        return $model -> getAlbum();
    }

    public function actionGetGroup()
    {
        $model = new Parsing();
        return $model->getGroup();
    }

    public function actionStartParsing()
    {
        $model = new Parsing();
        return $model -> startParsing();
    }

    public function actionSendPhoto()
    {
        $model = new Parsing();
        return $model->sendPhoto();
    }
}
