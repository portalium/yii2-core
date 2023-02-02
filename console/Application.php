<?php

namespace portalium\console;

use portalium\traits\ApplicationTrait;

class Application extends \yii\console\Application
{
    use ApplicationTrait;

    public function coreCommands()
    {
        return [
            'asset' => 'portalium\console\controllers\AssetController',
            'cache' => 'portalium\console\controllers\CacheController',
            'fixture' => 'portalium\console\controllers\FixtureController',
            'help' => 'portalium\console\controllers\HelpController',
            'message' => 'portalium\console\controllers\MessageController',
            'serve' => 'portalium\console\controllers\ServeController',
            'migrate' => 'portalium\console\controllers\MigrateController'
        ];
    }

    public function coreComponents()
    {
        return array_merge($this->portaliumCoreComponents(), [
            'errorHandler' => ['class' => 'portalium\console\ErrorHandler'],
            'param' => ['class' => 'portalium\components\Param'],
        ]);
    }
}
