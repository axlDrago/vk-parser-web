<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model app\models\LoginForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = 'Войти';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-login container">
    <div class="row">
        <div class="col l12 m12 s12 offset-xl3 xl6">
            <h1><?= Html::encode($this->title) ?></h1>

            <p>Пожалуйста, заполните следующие поля для входа:</p>
            <?php $form = ActiveForm::begin([
                'id' => 'login-form',
                'layout' => 'horizontal',
                'fieldConfig' => [
                    'template' => "{label}\n<div class=\"col s12 m12 l12 xl12\">{input}</div>\n<div class=\"col s8\">{error}</div>",
                    'labelOptions' => ['class' => 'col s1 control-label'],
                ],
            ]); ?>
                    <div class="row">
                <?= $form->field($model, 'username')->textInput(['autofocus' => true]) ?>
                    </div>
                    <div class="row">
                <?= $form->field($model, 'password')->passwordInput() ?>
                    </div>
                    <div class="row center-align">
                        <a href="reset-password">Забыли пароль?</a>
                    </div>
                <div class="form-group">
                    <div class="col s12 l12 m12 xl12">
                        <?= Html::submitButton('Вход', ['class' => 'btn-large waves-effect waves-light col offset-xl2 l8 xl8 m12 s12', 'name' => 'signin-button']) ?>
                    </div>
                </div>

            <?php ActiveForm::end(); ?>
        </div>
    </div>
    <div class="row">
        <div class="col l12 m12 s12 xl12 center-align">
            <p>Еще не зарегистрированы?</p>
            <a href="signup" class="btn-small waves-effect waves-light red lighten-2">Создать аккаунт</a>
        </div>
    </div>
</div>
