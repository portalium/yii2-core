<?php

namespace portalium\base;

class Exception extends \yii\base\Exception
{
    public function getName()
    {
        return 'Portalium Exception';
    }
}