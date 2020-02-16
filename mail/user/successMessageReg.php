<?php
use yii\helpers\Html;

/* @var $this \yii\web\View view component instance */
/* @var $message \yii\mail\MessageInterface the message being composed */
/* @var $content string main view render result */
?>
<?php $this->beginPage() ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=<?= Yii::$app->charset ?>" />
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>

<body style="font-family: 'Malgun Gothic', Arial, sans-serif; margin: 0; padding: 0; width: 100%; -webkit-text-size-adjust: none; -webkit-font-smoothing: antialiased;">
<?php $this->beginBody() ?>

<table width="100%" bgcolor="#FFFFFF" border="0" cellspacing="0" cellpadding="0" id="background" style="height: 100% !important; margin: 0; padding: 0; width: 100% !important;">
    <tr>
        <td align="center" valign="top">
            <table width="600" border="0" bgcolor="#F6F6F6" cellspacing="0" cellpadding="20" id="preheader">
                <tr>
                    <td valign="top">
                        <table width="100%" border="0" cellspacing="0" cellpadding="0">
                            <tr>
                                <td valign="top" width="600">
                                    <div class="logo">
                                        <a href="javascript:void(0)" onclick="myEvent();" onmouseover="this.style.color='#666666'" onmouseout="this.style.color='#514F4E'" style="color: #514F4E; font-size: 18px; font-weight: bold; text-align: left; text-decoration: none;">parser-new.ru</a>
                                    </div>
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
            </table>
            <!-- // END #preheader -->

            <table width="600" border="0" bgcolor="#FFFFFF" cellspacing="0" cellpadding="0" id="header_container">
                <tr>
                    <td align="center" valign="top">
                        <table width="100%" border="0" bgcolor="#474544" cellspacing="0" cellpadding="0" id="header">
                            <tr>
                                <td valign="top" class="header_content">
                                    <h1 style="color: #F4F4F4; font-size: 24px; text-align: center;">Спасибо что присоединились!</h1>
                                </td>
                            </tr>
                        </table>
                        <!-- // END #header -->
                    </td>
                </tr>
            </table>
            <!-- // END #header_container -->


            <table width="600" border="0" cellspacing="0" cellpadding="20" id="body_info_container">
                <tr>
                    <td align="center" valign="top" class="body_info_content">
                        <table width="100%" border="0" cellspacing="0" cellpadding="20">
                            <tr>
                                <td valign="top">
                                    <h2 style="color: #474544; font-size: 20px; text-align: center;">Данные для входа</h2>
                                    <p style="color: #666666; font-size: 14px; line-height: 22px; text-align: left;"><b>Логин:</b> <?= $username ?></p>
                                    <p style="color: #666666; font-size: 14px; line-height: 22px; text-align: left;"><b>Em@il</b>:</b> <?= $email ?></p>
                                    <p style="color: #666666; font-size: 14px; line-height: 22px; text-align: left;"><b>Пароль:</b> <?= $password ?></p>
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
            </table>

            <table width="600" border="0" bgcolor="#F2F2F2" cellspacing="0" cellpadding="20" id="body_item_container">
                <tr>
                    <td align="center" valign="top" class="body_item_content">
                        <table width="100%" border="0" cellspacing="0" cellpadding="20">
                            <tr>
                                <td align="center" valign="top">
                                    <h2 style="color: #474544; font-size: 20px; text-align: center;">Не передавайте эти данные третьим лицам!</h2>
                                </td>
                            </tr>

                        </table>
                    </td>
                </tr>
            </table>


        </td>
    </tr>
</table>
<!-- // END #background -->
<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>


<style type="text/css">
    @media only screen and (max-width: 480px) {
        table {
            display: block !important;
            width: 100% !important;
        }

        td {
            width: 480px !important;
        }
    }</style>
