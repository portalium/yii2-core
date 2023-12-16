<?php

namespace portalium\components;

use yii\helpers\ArrayHelper;
use portalium\site\models\Setting;
use yii\symfonymailer\Mailer as SymfonymailerMailer;

class Mailer extends SymfonymailerMailer
{
    public function init()
    {
        parent::init();
    }
}
