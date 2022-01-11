<?php

namespace portalium\web;

use portalium\base\Bootstrap as BaseBootstrap;

class Bootstrap extends BaseBootstrap
{
    private $rules = [];

    public function beforeRun($app)
    {
        foreach ($this->getModules() as $id => $module) {
            foreach (($app->id == 'api') ? $module->apiRules : $module->urlRules as $rule) {
                    $this->rules[] = $rule;
            }

            $module->registerEvents();
        }
    }

    public function run($app)
    {
        $app->getUrlManager()->addRules($this->rules);
    }
}
