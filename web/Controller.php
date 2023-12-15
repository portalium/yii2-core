<?php

namespace portalium\web;

use Yii;
use portalium\base\Module;
use yii\filters\AccessControl;

abstract class Controller extends \yii\web\Controller
{
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                    [
                        'actions' => ['*'],
                        'allow' => false,
                        'roles' => ['?']
                    ],
                ],
            ],
        ];
    }

    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
        ];
    }

    public function beforeAction($action)
    {
        if (Yii::$app->getModule('site')) {
            $rootModules = Yii::$app->setting->getConfig('site::actions_permissions');
            $currentModuleId = strtolower(Yii::$app->controller->module->id);
            $currentControllerId = ucfirst(Yii::$app->controller->id);
            $currentActionId = ucfirst(Yii::$app->controller->action->id);
            if ($rootModules !== null && is_array($rootModules))
                foreach ($rootModules as $rootModule => $modules) {
                    if (isset($modules[$currentModuleId][$currentControllerId][$currentActionId])) {
                        $requiredPermission = $modules[$currentModuleId][$currentControllerId][$currentActionId];
                        if (!Yii::$app->user->can($requiredPermission)) {
                            throw new \yii\web\ForbiddenHttpException(Yii::t('site', 'You are not allowed to perform this action.'));
                        }
                    }
                }
        }

        return parent::beforeAction($action);
    }

    public function getViewPath()
    {
        if ($this->module instanceof Module) {
            return '@portalium/' . $this->module->id . '/views/' . Yii::$app->id . DIRECTORY_SEPARATOR . $this->id;
        }

        return parent::getViewPath();
    }
}
