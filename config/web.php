<?php

$params = require(__DIR__ . '/params.php');

$config = [
// set target language to be Russian
    'language' => 'bg-BG',
    
    // set source language to be English
    'sourceLanguage' => 'bg-BG',
    
    'id' => 'basic',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'modules' => [
        'reception' => [
            'class' => 'app\modules\reception\Module',
        ],
        'offers' => [
            'class' => 'app\modules\offers\Module',
        ],
    ],
    'components' => [
        'session' => array(
            'timeout' => 86400,
        ),
        'request' => [
            // !!! insert a secret key in the following (if it is empty) - this is required by cookie validation
            'cookieValidationKey' => '12341234',
        ],
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'user' => [
            'identityClass' => 'app\models\User',
            'enableAutoLogin' => false,
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
        'mailer' => [
            'class' => 'yii\swiftmailer\Mailer',
            // send all mails to a file by default. You have to set
            // 'useFileTransport' to false and configure a transport
            // for the mailer to send real emails.
            'useFileTransport' => true,
        ],
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],
        'db' => require(__DIR__ . '/db.php'),
        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'rules' => [
                'logingr'       => 'site/logingroup',
                'loginpl'       => 'site/loginplace',
                'login'         => 'site/login',
                'logout'        => 'site/logout',
                'logoutplace'   => 'site/logoutplace',
                'logoutgroup'   => 'site/logoutgroup',
                // '<controller:\w+>/<action:\w+>/' => '<controller>/<action>',
                // '<controller:\w+>/<action:\w+>/' => '<controller>/<action>',
                // '<controller:\w+>/<action:\w+>/<id:\d+>' => '<controller>/<action>',
                // '<controller:\w+>/<action:\w+>/<itemId:\d+>/<type:\w+>' => '<controller>/<action>',
            ],
        ],
    ],
    'params' => $params,
];

if (true || YII_ENV_DEV) {
    // configuration adjustments for 'dev' environment
    $config['bootstrap'][] = 'debug';
    $config['modules']['debug'] = [
        'class' => 'yii\debug\Module',
    ];

    $config['bootstrap'][] = 'gii';
    $config['modules']['gii'] = [
        'class' => 'yii\gii\Module',
    ];
}

return $config;
