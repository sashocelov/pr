<?php
    use yii\helpers\Html;
    use yii\bootstrap\ActiveForm;
?>
<html>
    <head>
        <meta charset="UTF-8">
        <meta name="robots" content="noindex">
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <link rel="stylesheet" href="<?= Yii::$app->homeUrl; ?>css/login.css">
    </head>
    <body>
        <div class="wrapper">
            <div class="login animated slideInDown">
                <div class="topbar-login">
                    <div class="close">
                        <a href="#0">
                        <i class="fa fa-close"></i></a>
                    </div>
                </div>
                <div class="login-header">
                    <i class="fa fa-asterisk logo"></i>
                    <h1>Welcome</h1>
                    <h3>Lets get you logged in!</h3>
                    <hr>
                </div>
                <div class="content">
                <?php $form = ActiveForm::begin([
                    'id' => 'login-form',
                    'options' => ['class' => 'form-horizontal'],
                    'fieldConfig' => [
                        // 'template' => "{label}\n<div class=\"col-lg-3\">{input}</div>\n<div class=\"col-lg-8\">{error}</div>",
                        // 'labelOptions' => ['class' => 'col-lg-1 control-label'],
                    ],
                ]); ?>
                    <div class="input-group">
                        <?= $form->field($model, 'username')->textInput(['autofocus' => true, 'required' => true, 'id' => 'username', 'placeholder' => Yii::t('app', 'Потребителско име')])->label(Yii::t('app', 'Потребителско име')); ?>
                    </div>
                    <div class="input-group">
                        <?= $form->field($model, 'password')->passwordInput(['required' => true, 'placeholder' => Yii::t('app', 'Парола')])->label(Yii::t('app', 'Парола')); ?>
                    </div>
                    <div class="input-group">
                        <?= Html::submitButton(Yii::t('app', 'Вход'), ['class' => 'login-btn', 'name' => 'login-button']) ?> 
                    </div>
                <?php ActiveForm::end(); ?>
                </div>
            </div>
        </div>
        <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
        <script type="text/javascript">
            $(function() {
                $( ".login-btn" ).click(function() {
                  $('.login').fadeOut('slow');
                });
            
            
                $(".wrapper" ).click(function() {
                  $('.login').fadeIn(300);
                });
            });
        </script>
    </body>
</html>