<?php

namespace portalium\base;

use Yii;
use yii\base\BootstrapInterface;

abstract class Bootstrap implements BootstrapInterface
{
    private $modules;

    public function getModules()
    {
        return $this->modules;
    }

    public function bootstrap($app)
    {
        $this->findModules($app);
        $this->beforeRun($app);
        $this->registerModules($app);
        $this->run($app);
    }

    public function findModules($app)
    {
        if ($this->modules === null) {
            foreach ($app->getModules() as $id => $obj) {
                $moduleObject = Yii::$app->getModule($id);
                if ($moduleObject instanceof \portalium\base\Module) {
                    $this->modules[$id] = $moduleObject;
                }
            }

            if ($this->modules === null) {
                $this->modules = [];
            }
        }
    }

    private function registerModules($app)
    {
        foreach ($this->getModules() as $id => $module) {
            Yii::setAlias('@portalium/'.$id, $module->getBasePath());

            foreach ($module->registerComponents() as $componentId => $definition) {
                if (!$app->has($componentId)) {
                    $app->set($componentId, $definition);
                }
            }

            $module->portaliumBootstrap($app);
        }
    }

    abstract public function beforeRun($app);

    abstract public function run($app);
}
