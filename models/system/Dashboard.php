<?php

namespace app\models\system;

use app\models\Vk;
use Yii;
use yii\base\Model;
use app\models\User;

/**
 * Dashboard is the model profile user
 */
class Dashboard extends Model
{
    /*
     * Метод проверки оплаченного периода
     */
    public function getPaidTo() {
        $vip = 'выключен';
        $date = Yii::$app->session['paidTo'];
        $paidTo = date("H:m d.m.y", strtotime($date));
        if(strtotime(date('r')) < strtotime($date)) {
            $vip = 'включен';
        }

        return array('vip' => $vip, 'paidTo' => $paidTo);
    }

    public function getAuthVk() {
        $id = Yii::$app->session['__id'];
        $vk = Vk::findOne(['user_id' => $id]);

        return $vk;
    }

}
