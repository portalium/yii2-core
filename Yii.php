<?php

class Yii extends \yii\BaseYii
{
    public static $app;
}

spl_autoload_register(['Yii', 'autoload'], true, true);
Yii::$classMap = require(PORTALIUM_YII_VENDOR . '/classes.php');
Yii::$container = new yii\di\Container();