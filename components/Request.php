<?php

namespace portalium\components;

class Request extends \yii\web\Request
{
    public $web;
    public $aliasUrl;
    public $csrfParam;
    public $cookieValidationKey;

    public function getBaseUrl()
    {
        return str_replace($this->web, "", parent::getBaseUrl()) . $this->aliasUrl;
    }
}