<?php


namespace portalium\console\controllers;

class MigrateController extends \yii\console\controllers\MigrateController
{
    public $noIndex = false;
    /**
     * {@inheritdoc}
     */
    public function options($actionID)
    {
        return array_merge(
            parent::options($actionID),
            ['noIndex']
        );
    }

    public function optionAliases()
    {
        return array_merge(parent::optionAliases(), [
            'N' => 'noIndex',
        ]);
    }
}
