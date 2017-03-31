<?php

// comment out the following two lines when deployed to production
defined('YII_DEBUG') or define('YII_DEBUG', true);

if ($_SERVER['HTTP_HOST'] == 'localhost' || $_SERVER['REMOTE_ADDR'] == '127.0.0.1' || strpos( $_SERVER['REMOTE_ADDR'], '192.168') !== FALSE) {
	defined('YII_ENV') or define('YII_ENV', 'dev');
} else {
	defined('YII_ENV') or define('YII_ENV', 'production');
}
require(__DIR__ . '/../vendor/autoload.php');
require(__DIR__ . '/../vendor/yiisoft/yii2/Yii.php');

$config = require(__DIR__ . '/../config/web.php');

(new yii\web\Application($config))->run();
