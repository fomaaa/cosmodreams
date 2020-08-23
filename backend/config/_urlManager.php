<?php
return [
    'class' => yii\web\UrlManager::class,
    'enablePrettyUrl' => true,
    'showScriptName' => false,
    'rules' => [
        ['pattern' => 'api/user/upload', 'route' => 'api/upload-user-data'],

    ]
];
