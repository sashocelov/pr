<?php

/* @var $this \yii\web\View */
/* @var $content string */


use yii\helpers\Html;
use yii\web\View;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use app\assets\AppAsset;
use yii\helpers\Url;
use app\components\common;

AppAsset::register($this);

?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php 
        $this->head();
        $controller = Yii::$app->controller;
        $default_controller = Yii::$app->defaultRoute;
        $isHome = (($controller->id === $default_controller) && ($controller->action->id === $controller->defaultAction)) ? true : false;
        $this->registerJs("
            var strUrl = '".Yii::getAlias('@web')."';
            if ($('.bg').length > 0 && $('.bg').data('img') !== null) {
                $('body').css({'background-image' : $('.bg').data('img')});
            }
            ", VIEW::POS_HEAD, 'params');

    ?>
</head>
<body>
<?php $this->beginBody() ?>


    <?php
    
        NavBar::begin([
            // 'brandLabel'    => Yii::$app->params['place']['owner'],
            // 'brandUrl'      => Yii::$app->homeUrl,
            'options'       => [
                'class' => 'navbar-inverse navbar-fixed-top',
            ],
        ]);
            echo Nav::widget([
                'options' => ['class' => 'navbar-nav navbar-left'],
                'items' => [
                    [
                        'label' => Yii::t('app', 'Рецепция'),
                        'url' => ['/reception'],
                    ],
                    [
                        'label' => Yii::t('app', 'Стаи'),
                        'url' => ['/rooms'],
                    ],
                    [
                        'label' => Yii::t('app', 'Типове стаи'),
                        'url' => ['/roomtypes'],
                    ],
                    [
                        'label' => Yii::t('app', 'Статуси на стаи'),
                        'url' => ['/roomstatuses'],
                    ],
                    (
                        '<li>'
                        . Html::beginForm(['/site/logout'], 'post')
                        . Html::submitButton(
                            'Logout',
                            ['class' => 'btn btn-link']
                        )
                        . Html::endForm()
                        . '</li>'
                    )
                ],
            ]);
        NavBar::end();
    ?>

    <div class="container-full">
        <?= $content ?>
    </div>


<footer class="footer">
    <div class="container">
        &copy; Tundle Software Solutions <?= date('Y') ?>
    </div>
</footer>
<div class="event_execution_container">
</div>

<div id="message-mask" class="hidden"></div>
<div id="info-message" class="hidden">
    <div class="close-block">X</div>
    <div class="message-submit"></div>          
</div>



<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
