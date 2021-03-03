<?php

namespace portalium\web;

use Yii;
use portalium\traits\ApplicationTrait;

class Application extends \yii\web\Application
{
    use ApplicationTrait;

    public function coreComponents()
    {
        return array_merge($this->portaliumCoreComponents(), [
            'request' => ['class' => 'portalium\web\Request'],
            'errorHandler' => ['class' => 'portalium\web\ErrorHandler'],
            'urlManager' => ['class' => 'portalium\web\UrlManager'],
        ]);
    }
}