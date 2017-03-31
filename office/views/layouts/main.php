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
    <?php $this->head(); ?>
</head>
<body>
<?php $this->beginBody() ?>


    <?php
    
        NavBar::begin([
            'brandLabel'    => 'Начало',
            'brandUrl'      => Yii::$app->homeUrl,
            'options'       => [
                'class' => 'navbar-inverse navbar-fixed-top',
            ],
        ]);
            echo Nav::widget([
                'options' => ['class' => 'navbar-nav navbar-left'],
                'items' => [
                    [
                        'label' => Yii::t('app', 'Групи'),
                        'url' => ['/groups'],
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
        &copy; Администрация на Tundle Software Solutions <?= date('Y') ?>
    </div>
</footer>

<div id="message-mask" class="hidden"></div>
<div id="info-message" class="hidden">
    <div class="close-block">X</div>
    <div class="message-submit"></div>          
</div>



<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
