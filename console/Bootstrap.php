<?php

namespace portalium\console;

use Yii;
use yii\helpers\Inflector;
use portalium\base\Bootstrap as BaseBootstrap ;
use portalium\helpers\FileHelper;


class Bootstrap extends BaseBootstrap
{
    public function beforeRun($app)
    {
        Yii::setAlias('@web', $app->basePath);
    }

    public function run($app)
    {
        foreach ($app->getApplicationModules() as $id => $module) {
            $folder = $module->basePath . DIRECTORY_SEPARATOR . 'commands';
            if (file_exists($folder) && is_dir($folder)) {
                foreach (FileHelper::findFiles($folder) as $file) {
                    $module->controllerNamespace = $module->namespace . '\commands';

                    $className = '\\'.$module->getNamespace().'\\commands\\' . pathinfo($file, PATHINFO_FILENAME);

                    $command = str_replace('-controller', '', $module->id . '/' . Inflector::camel2id(pathinfo($file, PATHINFO_FILENAME)));

                    Yii::$app->controllerMap[$command] = ['class' => $className];
                }
            }
        }
    }
}
