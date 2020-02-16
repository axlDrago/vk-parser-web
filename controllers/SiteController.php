<?php

namespace app\controllers;

use app\models\GetAccessTokenVK;
use app\models\SignupForm;
use app\models\ResetPasswordForm;
use app\models\User;
use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\ContactForm;
use VK\OAuth\VKOAuth;

class SiteController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout'],
                'rules' => [
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
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
        if(Yii::$app->request->get('code')
            && Yii::$app->request->get('state') === 'secret_state_code')
        {
            $model = new GetAccessTokenVK();
            $model->getToken();

            return $this->redirect('/system/');
        }

        return $this->render('index');
    }

    /**
     * Login action.
     *
     * @return Response|string
     */
    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->redirect('/system');
        }

        $model->password = '';


        return $this->render('login', [
            'model' => $model,
        ]);
    }

    /**
     * Logout action.
     *
     * @return Response
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    /**
     * Displays contact page.
     *
     * @return Response|string
     */
    public function actionContact()
    {
        $model = new ContactForm();
        if ($model->load(Yii::$app->request->post()) && $model->contact(Yii::$app->params['adminEmail'])) {
            Yii::$app->session->setFlash('contactFormSubmitted');

            return $this->refresh();
        }
        return $this->render('contact', [
            'model' => $model,
        ]);
    }

    /**
     * Displays about page.
     *
     * @return string
     */
    public function actionAbout()
    {
        return $this->render('about');
    }

    public function actionSignup () {
        $model = new SignupForm();

        if ($model->load(Yii::$app->request->post()) && $model->signup()) {
            return $this->goHome();
        }

            return $this->render('signup', [
            'model' => $model
        ]);
    }

    /**
     * Reset password
     *
     * @return string
     */
    public function actionResetPassword() {
        if(!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new ResetPasswordForm();

        if ($model->load(Yii::$app->request->post()) && $model->validate())
        {
            $model->sendToken();
            $model->email = '';
            return $this->render('user/resetPasswordSend');
        }

        if(Yii::$app->request->get('token'))
        {
            if(User::findOne(['reset_token' => Yii::$app->request->get('token')])){
                if ($model->load(Yii::$app->request->post()))
                {
                    $model->resetPassword();
                    return $this->redirect(['login']);
                }
                return $this->render('user/resetPasswordTokenSuccess', ['model' => $model]);
            } else {
                return $this->render('user/resetPasswordTokenErr');
            }
        }

        return $this->render('user/resetPassword', [
                'model' => $model
            ]);
    }

    public function actionAlert()
    {
        return $this->render('alert');
    }

}
