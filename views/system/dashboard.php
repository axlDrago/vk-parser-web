<?php

/* @var $this yii\web\View */

use yii\helpers\Html;

$this->title = 'Профиль';
?>
<div class="container">
    <div class="row">
        <div class="col s12 m5">
            <div class="card-panel teal lighten-1 center-align hoverable">
                <span class="white-text">
                    <!-- <h5>VIP статус: <?= $vip ?></h5> -->
                    <h5>VIP статус: Включен</h5>
                    <!-- <p>Оплачено до: <h6><?= $paidTo ?></h6></p> -->
                    <p>Оплачено до: <h6>До выхода приложения из тестового периода</h6></p>
                    <a class="disabled waves-effect waves-light btn grey lighten-3 black-text z-depth-3">Продлить</a>
                </span>
            </div>
        </div>
        <div  class="col s12 m5">
            <div style='min-height: 210px' class="card-panel grey lighten-4 center-align hoverable">
                <h5>Приступить к работе</h5>
                <p></p>

                 <?php if($name === null): ?>

					<?php
                        echo Html::a('Авторизовать страницу', ['/system/authvk'], [
                            'data' => [
                                'method' => 'post',
                            ],
                            'class' => ['waves-effect waves-light btn red lighten-4 black-text z-depth-3']                        
                    ]);
                    ?>

                <?php else: ?>

                <a href="/system/parsing/" class="waves-effect waves-light btn teal lighten-1 black-text z-depth-3 white-text">Начать работу</a>

                <?php endif; ?>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col s12 m5">
            <div style='min-height: 190px' class="card blue-grey darken-1 hoverable center-align">
                <div class="card-content white-text">

                    <?php if($name === null): ?>

                    <span class="card-title">Авторизовать страницу VK</span>
                    <p>Для скачивания товаров, изображений из ВКонтакте необходимо добавить свою страницу.</p>
                    <div class="card-action">
                        <?php
                        echo Html::a('Авторизовать страницу', ['/system/authvk'], [
                            'data' => [
                                'method' => 'post',
                            ],
                        ]);
                        ?>
                    </div>

                <?php else: ?>

                <div class="row ">
                    <div class="col s12 m12 l12 xl4 center-align">
                        <img style="max-width: 110px" src="<?= $avatar_link ?>" alt="">
                    </div>

                    <div class="col s12 xl8 center-align">
                        <span class="card-title">Страница авторизована</span>
                        <p>Имя: <?=$name?></p>
                        <p>Фамилия: <?=$lastname?></p>
                    </div>

                    <div class="center-align">
                        <?php
                        echo Html::a('<p class="center-align">Повторная Авторизация</p>', ['/system/authvk'], [
                            'data' => [
                                'method' => 'post',
                            ],
                            'class' => 'btn',
                        ]);
                        ?>
                    </div>
                </div>

                <?php endif; ?>

                </div>
            </div>
        </div>

        <div class="col s12 m5">
            <div style='min-height: 190px' class="card blue-grey darken-1 hoverable center-align">
                <div class="card-content white-text ">
                    <span class="card-title">Групповой парсинг</span>
                    <p>Функция для совместной работы нескольких администраторов в одной группе.</p>
                </div>
                <div class="card-action">
                    <a href="#">В разработке</a>
                </div>
            </div>
        </div>

        <div class="col s12 m5">
            <div style='min-height: 190px' class="card blue-grey darken-1 hoverable center-align">
                <div class="card-content white-text ">
                    <span class="card-title">Авторизовать страницу Instagram</span>
                    <p>Для скачивания товаров, изображений из Instagram необходимо добавить свою страницу.</p>
                </div>
                <div class="card-action">
                    <a href="#">В разработке</a>
                </div>
            </div>
        </div>

    </div>
</div>
