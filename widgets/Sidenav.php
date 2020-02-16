<?php
namespace app\widgets;

use yii;
use app\models\User;
use yii\base\Widget;

class Sidenav extends Widget
{
    /**
     * {@inheritdoc}
     */
    public function run()
    {
        $session = Yii::$app->session;

        return $this->render('sidenav', [
            'username' => $session['username'],
            'email' => $session['email'],
        ]);
    }
}
