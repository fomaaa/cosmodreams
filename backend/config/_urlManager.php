<?php
return [
    'class' => yii\web\UrlManager::class,
    'enablePrettyUrl' => true,
    'showScriptName' => false,
    'rules' => [
        ['pattern' => 'api/user/media/<id>', 'route' => 'api/delete-media'],
        ['pattern' => 'api/user/upload', 'route' => 'api/upload-user-data'],
        ['pattern' => 'api/user', 'route' => 'api/user'],

    ]
];
