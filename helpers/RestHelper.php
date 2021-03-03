<?php

namespace portalium\helpers;

use Yii;
use yii\base\Model;
use yii\base\InvalidParamException;

class RestHelper
{
    public static function modelError(Model $model)
    {
        if (!$model->hasErrors()) {
            throw new InvalidParamException('The model as thrown an unknown Error.');
        }

        Yii::$app->response->setStatusCode(422, 'Data Validation Failed.');
        $result = [];
        foreach ($model->getFirstErrors() as $key => $message) {
            $result[] = [
                'key' => $key,
                'message' => $message,
            ];
        }

        return $result;
    }

    public static function error(array $errors)
    {
        Yii::$app->response->setStatusCode(422, 'Data Validation Failed.');
        $result = [];
        foreach ($errors as $key => $value) {
            $messages = (array) $value;

            foreach ($messages as $message) {
                $result[] = ['key' => $key, 'message' => $message];
            }
        }

        return $result;
    }
}
