<?php
    $strMessage = Yii::$app->session->getFlash('error');
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
                <?php if ($strMessage) : ?>
                    <div class="message"><?= $strMessage; ?></div>
                <?php endif; ?>
                <?= $content; ?>
            </div>
        </div>
        <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
        <script type="text/javascript">
            $(function() {
                $( ".login-btn" ).click(function() {
                  $('.login').fadeOut('slow');
                });
            
                if ($('.bg').length > 0 && $('.bg').data('bg') != "") {
                    $('body').css({'background-image' : 'url('+$('.bg').data('bg')+')'});
                }

                $(".wrapper" ).click(function() {
                  $('.login').fadeIn(300);
                });
            });
        </script>
    </body>
</html>