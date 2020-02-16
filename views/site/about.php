<?php

/* @var $this yii\web\View */

use yii\helpers\Html;

$this->title = 'Возможности';
$this->params['breadcrumbs'][] = $this->title;
?>
<main>
<div class="container site-about">
    <h1><?= Html::encode($this->title) ?></h1>

    <h6>
        Parser-new разрабатывается для загрузки товаров и картинок в ВК группы.
        На данный момент парсер  <span class="red-text"> бесплатный</span> и позволяет
        загружать картинки и описание к ним только с личных стен и со стен сообществ.
    </h6>

</div>
</main>
