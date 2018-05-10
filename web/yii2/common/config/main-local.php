<?php
return [
    'components' => [
        'db' => [
            'class' => 'yii\db\Connection',
            'dsn' => 'mysql:host=172.26.249.246;dbname=zhoubao',
            'username' => 'md',
            'password' => 'maida6868',
            'charset' => 'utf8',
        ],
        'mailer' => [
            'class' => 'yii\swiftmailer\Mailer',
            'viewPath' => '@common/mail',
            // send all mails to a file by default. You have to set
            // 'useFileTransport' to false and configure a transport
            // for the mailer to send real emails.
            'useFileTransport' => true,
        ],
        /*'urlManager' => [
            //开启url美化
            'enablePrettyUrl' => true,
            //隐藏index.php
            'showScriptName' => false,
            //禁用严格匹配模式
            'enableStrictParsing' => false,
            //url后缀名称
            'suffix'=>'.html',
            //url规则
            'rules' => [
                //post后面跟上数字的url，则将数字赋给id参数，然后传递给 post/view，实际上访问的是 post/view?id=XXX
                'post/<id:\d+>'=>'post/view'
            ],
        ],*/

    ],
];
