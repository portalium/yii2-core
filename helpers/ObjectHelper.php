<?php

namespace portalium\helpers;

use ReflectionClass;
use yii\base\Controller;
use luya\base\Module;
use yii\base\InvalidParamException;

class ObjectHelper
{
    public static function getConstants($keyword, $object)
    {
        $len = strlen($keyword);

        $reflection = new ReflectionClass($object);
        $constants = $reflection->getConstants();

        $list = [];
        foreach($constants as $name => $value) {
            if (substr($name,0,$len) != $keyword) continue;
            $list[ $value ] = $value;
        }
        return $list;
    }

    public static function getActions(Controller $controller)
    {
        $actions = array_keys($controller->actions());
        $reflection = new ReflectionClass($controller);
        foreach ($reflection->getMethods() as $method) {
            $name = $method->getName();
            if ($name !== 'actions' && $method->isPublic() && !$method->isStatic() && strncmp($name, 'action', 6) === 0) {
                $actions[] = Inflector::camel2id(substr($name, 6), '-', true);
            }
        }
        sort($actions);
        return array_unique($actions);
    }

    public static function getControllers(Module $module)
    {
        // Not yet implemented
    }
}
