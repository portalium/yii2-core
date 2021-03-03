<?php

namespace portalium\console;

use portalium\traits\ErrorHandlerTrait;

class ErrorHandler extends \yii\console\ErrorHandler
{
    use ErrorHandlerTrait;

    public $errorAction;
}