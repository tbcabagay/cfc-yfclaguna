<?php

$params = require(__DIR__ . '/params.php');

$config = [
    'id' => 'basic',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'components' => [
        'request' => [
            // !!! insert a secret key in the following (if it is empty) - this is required by cookie validation
            'cookieValidationKey' => 'xM8D4V9Ca_Ija6VSiz_8nUgb6jhHqkP0',
        ],
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'user' => [
            'identityClass' => 'app\models\User',
            'enableAutoLogin' => true,
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
        'mailer' => [
            'class' => 'yii\swiftmailer\Mailer',
            'useFileTransport' => false,
            'transport' => [
                'class' => 'Swift_SmtpTransport',
                'host' => 'smtp.gmail.com',
                'username' => 'yfc.laguna.mailer@gmail.com',
                'password' => 'yfclagunamailer',
                'port' => '587',
                'encryption' => 'tls',
            ],
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
        'authClientCollection' => [
            'class' => 'yii\authclient\Collection',
            'clients' => [
                'google' => [
                    'class' => 'yii\authclient\clients\GoogleOAuth',
                    'clientId' => '1033242369377-fmp3ths9tj1kd4bjh8qkjvq76jsf27f4.apps.googleusercontent.com',
                    'clientSecret' => 'zgOh_GQpPEfhKbm8dpRk9Sv3',
                    'returnUrl' => 'http://cfc-yfclaguna.org/site/auth?authclient=google',
                ],
            ],
        ],
        'authManager' => [
            'class' => 'yii\rbac\PhpManager',
        ],
        'formatter' => [
            'defaultTimeZone' => 'Asia/Manila',
        ],
        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'enableStrictParsing' => false,
            //'suffix' => '.html',
        ],
    ],
    'modules' => [
        'markdown' => [
            'class' => 'kartik\markdown\Module',
            'smartyPants' => false,
        ],
        'qux' => [
            'class' => 'app\modules\qux\Module',
            'layoutPath' => '@app/modules/qux/views/layouts',
            'layout' => 'main',
        ],
        'gridview' => [
            'class' => '\kartik\grid\Module',
        ],
        'admin' => [
            'class' => 'mdm\admin\Module',
            'controllerMap' => [
                'assignment' => [
                    'class' => 'mdm\admin\controllers\AssignmentController',
                    'idField' => 'user_id',
                    'searchClass' => 'app\models\UserSearch',
                ],
            ],
            'layout' => 'left-menu',
        ],
    ],
    'params' => $params,
];

if (YII_ENV_DEV) {
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
