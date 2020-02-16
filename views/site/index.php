<?php

/* @var $this yii\web\View */

$this->title = 'Parser-new';
?>
<div class="main-section">
    <div class="row">

            <?php if(Yii::$app->user->isGuest == true): ?>
        <div onclick="location.href='/site/login'" class="col s12 m6 l8 main-section__cont">
            <?php else: ?>
        <div onclick="location.href='/system'" class="col s12 m6 l8 main-section__cont">
            <?php endif; ?>

            <div class="main-section__cont_big z-depth-2">
                <div class="main-section__cont_text">Войти в систему</div>
            </div>
        </div>
        <div onclick="location.href='/site/contact'" class="col s12 m6 l4 main-section__cont">
            <div class="main-section__cont_small z-depth-2">
                <div class="main-section__cont_text">Написать менеджеру</div>
            </div>
        </div>
        <div onclick="location.href='/site/about'" class="col s12 m6 l4 main-section__cont">
            <div class="main-section__cont_small z-depth-2">
                <div class="main-section__cont_text">Возможности</div>
            </div>
        </div>

        <div class="col s12 m6 l4 main-section__cont">
            <div class="z-depth-2 main-section__cont_small">
                <div class="main-section__cont_text">Промокоды</div>
            </div>
        </div>

        <div onclick="location.href='/site/alert'" class="col s12 m6 l4 main-section__cont">
            <div class="z-depth-2 main-section__cont_small">
                <div class="main-section__cont_text red-text">Внимание!</div>
            </div>
        </div>
        <div class="col s12 m6 l4 main-section__cont">
            <div class="z-depth-2 main-section__cont_small">
                <div class="main-section__cont_text">Инструкция</div>
            </div>
        </div>
    </div>
</div>