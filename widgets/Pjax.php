<?php
namespace portalium\widgets;

use Yii;

class Pjax extends \yii\widgets\Pjax
{
    public $history = false;
    public $timeout = false;
    
    public function init()
    {
        parent::init();

        if (!$this->timeout)
            Yii::$app->view->registerJs('$.pjax.defaults.timeout = false;');

        if (!$this->history)
            Yii::$app->view->registerJs('$.pjax.defaults.history = false;');

    }
}