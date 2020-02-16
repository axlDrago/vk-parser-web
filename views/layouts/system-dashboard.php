<?php

/* @var $this \yii\web\View */
/* @var $content string */

use yii\helpers\Html;
use app\assets\AppAsset;
use app\widgets\Sidenav;

AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" href="/images/logo.ico" type="image/x-icon" />
    <?php $this->registerCsrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body>
<?php $this->beginBody() ?>

<!-----------------NavBar---------------->

<div class="navbar-fixed">
    <nav>
<!--        <div class="nav-wrapper deep-orange darken-1">-->
        <div class="nav-wrapper white">
            <div class="container">
                <a href="/site/index" class="brand-logo center"><img alt='' class="nav__logo_size" src="/images/navbar/logo-system.png"></a>
                <ul class="right hide-on-med-and-down">
                    <li class="nav__btn">

                        <?php

                        if (Yii::$app->user->isGuest === true) {
                            echo '<a class="nav__text_size nav__text_colorVK" href="/site/login">Вход/Регистрация</a>';
                        }
                        else {
                            echo
                                "<a class='nav__text_size nav__text_colosVK'>"
                                . Html::beginForm(['/site/logout'], 'post')
                                . Html::submitButton(
                                    'Выход (' . Yii::$app->user->identity->username . ')',
                                    ['class' => 'btn nav__btn_logout grey lighten-5']
                                )
                                . Html::endForm()
                                . '</a>';
                        }
                        ?>

                    </li>
                </ul>
                <a href="#" data-target="slide-out" class="sidenav-trigger show-on-large">
                    <i class="material-icons icon-black large">arrow_drop_down_circle</i>
                </a>
            </div>
        </div>
    </nav>
</div>

<!-----------------SideNav---------------->

<?= Sidenav::widget() ?>

<!-----------------Body---------------->

<main class="grey lighten-3">
    <?= $content ?>
</main>

<!-----------------Foo---------------->
<footer class="page-footer grey lighten-4 z-depth-1">
    <div class="container ">
        <div class="row grey-text">
            <div class="col s6 m3">
                <img class="materialize-logo" src="/images/logo.ico" alt="Parser-new">
                <p class="black-text">Made with love</p>
            </div>
           <div class="col s6 m3">
                <h5>Помощь</h5>
                <ul>
                    <li><a href="https://vk.com/id460226102">Менеджер</a></li>
                    <li><a href="https://vk.com/id460226102">Техподдержка</a></li>
                    <li><a href="/site/contact#!">Обратная связь</a></li>
                </ul>
            </div>
        </div>
    </div>
</footer>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
