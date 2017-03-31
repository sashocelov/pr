<?php
if (YII_ENV_DEV) {
	return [
	    'class' => 'yii\db\Connection',
	    'dsn' => 'mysql:host=localhost;dbname=splitmp3_tundle_ss',
	    'username' => 'root',
	    'password' => '',
	    'charset' => 'utf8',
	];
} else {
	return [
	    'class' => 'yii\db\Connection',
	    'dsn' => 'mysql:host=localhost;dbname=splitmp3_tundle_ss',
	    'username' => 'splitmp3_tundle',
	    'password' => 'T^Z!#f%B#rQT',
	    'charset' => 'utf8',
	];
}