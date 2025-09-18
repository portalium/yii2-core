<?php

namespace portalium\rest;

use Exception;
use portalium\traits\RestBehaviorsTrait;
use Yii;
use yii\rest\ActiveController as RestActiveController;
use yii\web\ForbiddenHttpException;

abstract class ActiveController extends RestActiveController
{
    use RestBehaviorsTrait;

    public function checkAccess($action, $model = null, $params = []) {}
    public function beforeAction($action)
    {
        $beforeAction = parent::beforeAction($action);
        if (Yii::$app->getModule('site')) {
            $rootModules = Yii::$app->setting->getConfig('site::actions_permissions');
            $currentModuleId = strtolower(Yii::$app->controller->module->id);
            $currentControllerId = ucfirst(Yii::$app->controller->id);
            $currentActionId = ucfirst(Yii::$app->controller->action->id);
            if (str_contains($currentActionId, '-'))
                $currentActionId = str_replace('-', '', ucwords($currentActionId, '-'));

            if ($rootModules !== null && is_array($rootModules))
                foreach ($rootModules as $rootModule => $modules) {
                    if (isset($modules[$currentModuleId][$currentControllerId][$currentActionId])) {
                        $requiredPermissions = $modules[$currentModuleId][$currentControllerId][$currentActionId];
                        $isAccess = null;
                        foreach ($requiredPermissions as $requiredPermission) {
                            if (!Yii::$app->workspace->can($currentModuleId, $requiredPermission) && !Yii::$app->user->can($requiredPermission)) {
                                $isAccess = false;
                                if (!Yii::$app->request->isAjax) {
                                } else {
                                    Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
                                }
                            } else {
                                $isAccess = true;
                                break;
                            }
                        }
                        if ($isAccess === false) {
                            Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
                            $responseMessage = Yii::$app->session->get('responseMessage', Yii::t('yii', 'You are not allowed to perform this action.'));
                            $responseCode = Yii::$app->session->get('responseCode', 0);
                            Yii::$app->session->remove('responseMessage');
                            Yii::$app->session->remove('responseCode');
                            throw new ForbiddenHttpException($responseMessage, $responseCode);
                        }
                    }
                }
        }
        return $beforeAction;
    }
}
