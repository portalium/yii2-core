<?php

namespace portalium\db;

use Yii;



class Migration extends \yii\db\Migration
{
    public function createIndex($name, $table, $columns, $unique = false)
    {
        if (!Yii::$app->param->get('noIndex')) {
            parent::createIndex($name, $table, $columns, $unique);
        }else{
            return;
        }
    }
}
