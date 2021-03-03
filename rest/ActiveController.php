<?php

namespace portalium\rest;

use portalium\traits\RestBehaviorsTrait;
use yii\rest\ActiveController as RestActiveController;

abstract class ActiveController extends RestActiveController
{
    use RestBehaviorsTrait;

    public function checkAccess($action, $model = null, $params = [])
    {
    }
}
