<?php

namespace portalium\traits;

use Yii;
use portalium\base\Module;

trait ApplicationTrait
{
    public $corsConfig = [
        'class' => 'yii\filters\Cors',
        'cors' => [
            'Origin' => ['*'],
            'Access-Control-Request-Method' => ['GET', 'POST', 'PUT', 'PATCH', 'DELETE', 'HEAD', 'OPTIONS'],
            'Access-Control-Request-Headers' => ['*'],
            'Access-Control-Allow-Credentials' => null,
            'Access-Control-Max-Age' => 86400,
            'Access-Control-Expose-Headers' => [
                'X-Pagination-Current-Page',
                'X-Pagination-Page-Count',
                'X-Pagination-Per-Page',
                'X-Pagination-Total-Count',
                'X-Cruft-Length',
            ],
        ],
    ];

    public function init()
    {
        parent::init();
        Yii::trace('initialize Portalium Application', __METHOD__);
    }

    public function portaliumCoreComponents()
    {
        return array_merge(parent::coreComponents(), [
            'mailer' => [
                'class' => 'portalium\components\Mailer',
            ],
        ]);
    }

    public function getApplicationModules()
    {
        $modules = [];

        foreach ($this->getModules() as $id => $obj) {
            if ($obj instanceof Module) {
                $modules[$id] = $obj;
            }
        }

        return $modules;
    }
}
