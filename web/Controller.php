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

    public function getViewPath()
    {
        if ($this->module instanceof Module) {
            return '@portalium/' . $this->module->id . '/views/' . Yii::$app->id . DIRECTORY_SEPARATOR . $this->id;
        }

        return parent::getViewPath();
    }
}
