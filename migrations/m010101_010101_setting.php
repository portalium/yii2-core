<?php

use portalium\content\models\Content;
use yii\db\Migration;


class m010101_010101_setting extends Migration
{
    public function up()
    {
        $this->createTable('setting', [
            'id' => $this->primaryKey(),
            'module' => $this->string(64)->notNull(),
            'name' => $this->string(64)->notNull(),
            'label' => $this->string(64)->notNull(),
			'value' => $this->text(),
            'type' => $this->tinyInteger(1)->notNull(),
            'config' => $this->text(),
        ]);
    }

    public function down()
    {
        $this->dropTable('setting');
    }
}
