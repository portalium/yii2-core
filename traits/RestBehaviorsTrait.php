<?php

namespace portalium\traits;

use Yii;
use yii\filters\Cors;
use yii\web\Response;
use yii\base\Model;
use yii\filters\auth\CompositeAuth;
use yii\filters\auth\QueryParamAuth;
use yii\filters\auth\HttpBearerAuth;
use yii\filters\ContentNegotiator;
use portalium\helpers\RestHelper;

trait RestBehaviorsTrait
{
    public function behaviors()
    {
        $behaviors = parent::behaviors();

        $behaviors['contentNegotiator'] = [
            'class' => ContentNegotiator::className(),
            'formats' => [
                'application/json' => Response::FORMAT_JSON,
            ],
        ];

        $behaviors['authenticator'] = [
            'class' => CompositeAuth::className(),
            'authMethods' => [
                HttpBearerAuth::className(),
                QueryParamAuth::className(),
            ],
        ];

        $behaviors['corsFilter'] = [
            'class' => Cors::className(),
        ];

        return $behaviors;
    }

    public function modelError(Model $model)
    {
        return RestHelper::modelError($model);
    }

    public function error(array $errors)
    {
        return RestHelper::error($errors);
    }

}
