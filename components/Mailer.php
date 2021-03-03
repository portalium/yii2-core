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

        $settings  = ArrayHelper::map(Setting::find()->asArray()->all(),'name','value');

        $transport = [
            'class' => 'Swift_SmtpTransport',
            'host' => $settings['smtp::server'],
            'username' => $settings['smtp::username'],
            'password' => $settings['smtp::password'],
            'port' => $settings['smtp::port'],
            'encryption' => $settings['smtp::encryption'],
        ];

        $this->setTransport($transport);
    }
}
