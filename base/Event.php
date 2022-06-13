<?php

namespace portalium\base;


class Event extends \yii\base\Event {
    public $payload;
    public static function trigger($class, $eventName, $event = null) {
        
        if(is_array($class)) {
            foreach($class as $c) {
                parent::trigger($c, $eventName, $event);
            }
        }
        else {
            parent::trigger($class, $eventName, $event);
        }
    }
}