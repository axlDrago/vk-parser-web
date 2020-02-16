<ul id="slide-out" class="sidenav">
    <li><div class="user-view">
            <div class="background">
                <img src="/images/sidenav/office.jpg">
            </div>
            <a href="#user"><img class="circle" src="/images/sidenav/avatar.png"></a>
            <a href="#name"><span class="white-text name"><?= $username ?></span></a>
            <a href="#email"><span class="white-text email"><?= $email ?></span></a>
        </div></li>
    <li><a href="/system/index"><i class="material-icons">account_box</i>Мой Профиль</a></li>
    <li><div class="divider"></div></li>
    <li><a href="/system/parsing/"><i class="material-icons">play_for_work</i>Начать работу</a></li>
<!--    <li><div class="divider"></div></li>-->
<!--    <li><a class="waves-effect" href="/system/chat"><i class="material-icons">markunread</i>Сообщения</a></li>-->
    <li><div class="divider"></div></li>
    <li><a class="waves-effect" href="#"><i class="material-icons">help</i>Помощь</a></li>
    <li><div class="divider"></div></li>
    <li>
        <?php

        use yii\helpers\Html;

        if (Yii::$app->user->isGuest === true)
        {
            echo '<a class="waves-effect" href="/site/login">Вход/Регистрация</a>';
        }
        else {
            echo Html::a('<i class="material-icons">exit_to_app</i>Выход', ['/site/logout'], [
                'data' => [
                    'method' => 'post',
                ],
            ]);
        } ?>
    </li>
</ul>