<?php
namespace portalium\base;

use Yii;
use yii\base\Application;
use yii\web\HttpException;
use portalium\site\models\Setting;

class Module extends \yii\base\Module
{
    public $apiRules = [];

    public function init()
    {
        parent::init();

        $this->controllerNamespace = $this->controllerNamespace  . '\\' . Yii::$app->id;
        if(Yii::$app instanceof \portalium\web\Application)
            Yii::$app->language = (Yii::$app->session->get('lang') != "") ? Yii::$app->session->get('lang') : Setting::findOne(['name' => 'app::language'])->value ;
        
        static::moduleInit();
    }

    public static function moduleInit()
    {
    }

    public function portaliumBootstrap(Application $app)
    {
    }

    public function registerComponents()
    {
        return [];
    }

    public static function registerTranslation($prefix, $basePath, array $fileMap)
    {
        if (!isset(Yii::$app->i18n->translations[$prefix])) {
            Yii::$app->i18n->translations[$prefix] = [
                'class' => 'yii\i18n\PhpMessageSource',
                'basePath' => $basePath,
                'fileMap' => $fileMap,
            ];
        }
    }

    public static function coreT($category, $message, array $params = [], $language = null)
    {
        static::moduleInit();
        return Yii::t($category, $message, $params, $language);
    }
}
