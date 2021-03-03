<?php

namespace portalium\web;

class Request extends \yii\web\Request
{
    public $web;
    public $aliasUrl;

    public function getBaseUrl()
    {
        return str_replace($this->web, "", parent::getBaseUrl()) . $this->aliasUrl;
    }
}
