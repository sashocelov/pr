<?php
if (YII_ENV_DEV) {
	return [
	    'class' => 'yii\db\Connection',
	    'dsn' => 'mysql:host=localhost;dbname=splitmp3_wec',
	    'username' => 'root',
	    'password' => '',
	    'charset' => 'utf8',
	];
} else {
	return [
	    'class' => 'yii\db\Connection',
	    'dsn' => 'mysql:host=localhost;dbname=splitmp3_wec',
	    'username' => 'splitmp3_wec',
	    'password' => 'ld?teyHfb=KG',
	    'charset' => 'utf8',
	];
}