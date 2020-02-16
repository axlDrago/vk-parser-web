<?php

use yii\helpers\Html;
use app\assets\AppAsset;

AppAsset::register($this);

$this -> beginPage()

?>

<!DOCTYPE html>

<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" href="/images/logo.ico" type="image/x-icon" />
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>

<body>
<?php $this->beginBody()?>

<!-----------------NavBar---------------->

<div class="navbar-fixed">
    <nav>
        <div class="nav-wrapper nav__color">
            <div class="container">
                <a href="/site/index" class="brand-logo center"><img alt='' class="nav__logo_size" src="/images/navbar/logo.png"></a>
                <a href="#" data-target="mobile-demo" class="sidenav-trigger"><i class="large material-icons">menu</i></a>
                <ul class="right hide-on-med-and-down">
                    <li class="nav__btn">

                    <?php

                        if (Yii::$app->user->isGuest === true) {
                            echo '<a class="nav__text_size nav__text_colorVK" href="/site/login">Вход/Регистрация</a>';
                        }
                        else {
                            echo
                            "<a class='nav__text_size nav__text_colosrVK'>"
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
            </div>
        </div>
    </nav>
</div>



<ul class="sidenav" id="mobile-demo">
    <li><a href="#">О нас</a></li>
    <li><div class="divider"></div></li>
    <li><a href="#">Инструкция</a></li>
    <li><div class="divider"></div></li>
    <li><a href="#">Цены</a></li>
    <li><div class="divider"></div></li>
    <li>
        <?php
        if (Yii::$app->user->isGuest === true) {
            echo '<a href="/site/login">Вход/Регистрация</a>';
        }
        else {
            echo Html::a('Выход', ['/site/logout'], [
                'data' => [
                    'method' => 'post',
                ],
            ]);
        }
    ?>
    </li>
</ul>

<!-----------------Main-Section--------->
<main>
    <?= $content ?>
</main>

<!----------------Footer------------>

<footer class="page-footer nav__color">
    <div class="container">
        <div class="row">
            <div class="col s12 m4 l4 xl4">
                <img style="max-width: 75%" class="materialize-logo" src="/images/navbar/logo.png" alt="Parser-new">
                <p>Made with love</p>
            </div>
            <div class="col m4 l4 s12 xl4 center-align">
                <h5 class="white-text">Мы ВКонтакте:</h5>
                <ul>
                    <li><a class="grey-text text-lighten-3" href="#!">Менеджер</a></li>
                    <li><a class="grey-text text-lighten-3" href="#!">Техподдержка</a></li>
                </ul>
            </div>
            <div class="col m4 l4 s12 xl4 right-align">
                <h5 class="white-text">Служба поддержки:</h5>
                <ul>
                    <li><a class="grey-text text-lighten-3" href="#!">Менеджер</a></li>
                    <li><a class="grey-text text-lighten-3" href="#!">Техподдержка</a></li>
                    <li><a class="grey-text text-lighten-3" href="/site/contact">Обратная связь</a></li>
                </ul>
            </div>
        </div>
    </div>
    <div class="footer-copyright">
        <div class="container">
            © 2019 Copyright
        </div>
    </div>
</footer>

<?php $this->endBody()?>
</body>
</html>
<?php $this->endPage()?>