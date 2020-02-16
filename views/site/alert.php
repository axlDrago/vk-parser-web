<?php

/* @var $this yii\web\View */

use yii\helpers\Html;

$this->title = 'Внимание!';
$this->params['breadcrumbs'][] = $this->title;
?>
<main>
<div class="container site-about">
    <h1><?= Html::encode($this->title) ?></h1>

    <h6>
        Parser-new находится <span class="red-text"> в разработке</span> и доступен для
        <span class="red-text">бесплатного использования</span>.
        Обо всех ошибках и необходимых новых функциях просим <a href="/site/contact">сообщать нам</a>.
        <br>
        <br>
        Активным пользователям буду разосланы коды для  <span class="red-text">бесплатного доступа</span>.

    </h6>

</div>
</main>
