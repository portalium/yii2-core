<?php

namespace portalium\components;

use yii\helpers\ArrayHelper;
use yii\swiftmailer\Mailer as SwiftMailer;
use portalium\site\models\Setting;

class Mailer extends SwiftMailer
{
    public function init()
    {
        parent::init();
    }
}
