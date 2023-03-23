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
                        'roles' => ['?'],
                        'denyCallback' => function () {
                            Yii::$app->response->redirect(['/site/auth/login']);
                        },
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

    public function getViewPath()
    {
        if ($this->module instanceof Module) {
            return '@portalium/' . $this->module->id . '/views/' . Yii::$app->id . DIRECTORY_SEPARATOR . $this->id;
        }

        return parent::getViewPath();
    }

    public function beforeAction($action)
    {
        if (Yii::$app->user->isGuest && $this->id != 'auth') {
            return $this->redirect(['/site/auth/login']);
        }
        
        return parent::beforeAction($action);
    }
}
