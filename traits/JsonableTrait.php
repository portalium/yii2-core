<?php


namespace portalium\traits;

use yii\helpers\Json;

trait JsonableTrait
{
    public function toJson() {
        return Json::encode(array_filter($this->toArray()));
    }

    public static function fromJson($json, $appends = []) {
        $schema = Json::decode($json);

        foreach ($appends as $key => $append) {
            $schema[$key] = $append;
        }

        $class = __CLASS__;
        return new $class($schema);
    }
}
