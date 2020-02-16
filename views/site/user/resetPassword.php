<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model app\models\LoginForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = 'Восстановление пароля';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-login container">
    <div class="row">
        <div class="col l12 m12 s12 offset-xl3 xl6">
            <h4><?= Html::encode($this->title) ?></h4>

            <p>Введите эл. почту указанную при регистрации:</p>
            <?php $form = ActiveForm::begin([
                'id' => 'reset-password-form',
                'layout' => 'horizontal',
                'fieldConfig' => [
                    'template' => "<div class=\"col s12 m12 l12 xl12\">{input}</div>\n<div class=\"col s8\">{error}</div>",
                    'labelOptions' => ['class' => 'col s1 control-label'],
                ],
            ]); ?>
                    <div class="row">
                <?= $form->field($model, 'email')->textInput(['autofocus' => false]) ?>
                    </div>

                <div class="form-group">
                    <div class="col s12 l12 m12 xl12">
                        <?= Html::submitButton('Восстановить пароль', ['class' => 'btn-large waves-effect waves-light col offset-xl2 l8 xl8 m12 s12', 'name' => 'reset-button']) ?>
                    </div>
                </div>

            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>
