<?php


namespace portalium\traits;

use yii\helpers\Json;

trait JsonableTrait
{
    /**
     * Convert the object to an array.
     * @return array
     */
    public function toJson() {
        return Json::encode(array_filter($this->toArray()));
    }

    /**
     * Convert the object to an array.
     * @return array
     */
    public static function fromJson($json, $appends = []) {
        $schema = Json::decode($json);

        foreach ($appends as $key => $append) {
            $schema[$key] = $append;
        }

        $class = __CLASS__;
        return new $class($schema);
    }

    /**
     * Check if a value is a valid JSON string.
     * @param mixed $value
     * @return bool
     */
    public static function isJson($value)
    {
        $value = strval($value);
        json_decode($value);
        return json_last_error() === JSON_ERROR_NONE;
    }
}
