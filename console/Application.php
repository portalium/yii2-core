<?php

namespace portalium\console;

use portalium\traits\ApplicationTrait;

class Application extends \yii\console\Application
{
    use ApplicationTrait;

    public function coreCommands()
    {
        return [
            'asset' => 'yii\console\controllers\AssetController',
            'cache' => 'yii\console\controllers\CacheController',
            'fixture' => 'yii\console\controllers\FixtureController',
            'help' => 'yii\console\controllers\HelpController',
            'message' => 'yii\console\controllers\MessageController',
            'serve' => 'yii\console\controllers\ServeController',
            'migrate' => 'yii\console\controllers\MigrateController',
        ];
    }

    public function coreComponents()
    {
        return array_merge($this->portaliumCoreComponents(), [
            'errorHandler' => ['class' => 'portalium\console\ErrorHandler'],
        ]);
    }
}
