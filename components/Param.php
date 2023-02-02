<?php

namespace portalium\components;

use Yii;

class Param
{
	public static function all()
	{
		$rawParams = [];
        if (isset($_SERVER['argv'])) {
            $rawParams = $_SERVER['argv'];
            array_shift($rawParams);
        }

        $params = [];
        foreach ($rawParams as $param) {
            if (preg_match('/^--(\w+)(=(.*))?$/', $param, $matches)) {
                $name = $matches[1];
                $params[$name] = isset($matches[3]) ? $matches[3] : true;
            } else {
                $params[] = $param;
            }
        }
        return $params;
    }

    public static function get($name)
    {
        $params = self::all();
        return isset($params[$name]) ? $params[$name] : null;
    }
}
