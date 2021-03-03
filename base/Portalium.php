<?php

namespace portalium\base;

use Yii;
use ReflectionClass;
use yii\helpers\ArrayHelper;
use portalium\web\Application as WebApplication;
use portalium\console\Application as ConsoleApplication;

abstract class Portalium
{
    public $app;

    private $isCli;
    private $baseYiiFile;
    private $appConfig;
    private $configFiles = [];

    public function setConfigFiles(array $files)
    {
        $this->configFiles = $files;
    }

    public function getConfigFiles()
    {
        return $this->configFiles;
    }

    public function setBaseYiiFile($yiiFile)
    {
        $this->baseYiiFile = $yiiFile;
    }

    public function getBaseYiiFile()
    {
        return $this->baseYiiFile;
    }

    public function consoleApplication()
    {
        $config = $this->getAppConfig();
        $config['defaultRoute'] = 'help';
        $this->requireYii();
        $mConfig = ArrayHelper::merge($config, [
            'bootstrap' => ['portalium\console\Bootstrap'],
            'components' => [
                'urlManager' => [
                    'class' => 'portalium\web\UrlManager',
                    'enablePrettyUrl' => true,
                    'showScriptName' => false
                ],
            ],
        ]);
        $this->app = new ConsoleApplication($mConfig);

        exit($this->app->run());
    }

    public function webApplication()
    {
        $config = $this->getAppConfig();
        $this->requireYii();
        $mConfig = ArrayHelper::merge($config, [
            'bootstrap' => ['portalium\web\Bootstrap']
        ]);
        $this->app = new WebApplication($mConfig);

        return $this->app->run();
    }

    public function getAppConfig()
    {
        if ($this->appConfig === null) {
            foreach($this->configFiles as $file){
                if (file_exists($file)) {
                    $config = require $file;
                }

                if (!is_array($config)) {
                    throw new Exception("Config file '".$file."' found but no array returning.");
                }

                $this->appConfig = ArrayHelper::merge($this->appConfig, $config);
            }
        }

        return $this->appConfig;
    }

    public function getCorePath()
    {
        $reflector = new ReflectionClass(get_class($this));
        return dirname($reflector->getFileName());
    }

    public function getSapiName()
    {
        return strtolower(php_sapi_name());
    }

    public function getIsCli()
    {
        if ($this->isCli === null) {
            $this->isCli = $this->getSapiName() === 'cli';
        }

        return $this->isCli;
    }

    public function setIsCli($cli)
    {
        $this->isCli = $cli;
    }

    public function isCli()
    {
        return $this->getIsCli();
    }

    public function run()
    {
        if ($this->getIsCli()) {
            return $this->consoleApplication();
        }

        return $this->webApplication();
    }

    private function requireYii()
    {
        if (file_exists($this->baseYiiFile)) {
            defined('PORTALIUM_YII_VENDOR') ?: define('PORTALIUM_YII_VENDOR', dirname($this->baseYiiFile));

            $baseYiiFolder = PORTALIUM_YII_VENDOR . DIRECTORY_SEPARATOR;

            $yiiFile = $this->getCorePath() . DIRECTORY_SEPARATOR .  'Yii.php';

            if (file_exists($yiiFile)) {
                require_once($baseYiiFolder . 'BaseYii.php');
                require_once($yiiFile);
            } else {
                require_once($baseYiiFolder . 'Yii.php');
            }

            Yii::setAlias('@portalium', $this->getCorePath());

            return true;
        }

        throw new Exception("YiiBase file does not exits '".$this->baseYiiFile."'.");
    }
}
