<?php

namespace portalium\data;

use Yii;

class ActiveDataProvider extends \yii\data\ActiveDataProvider
{
    public function init()
    {
        parent::init();
    }

    protected function prepareModels()
    {
        if ($this->pagination != false && $this->pagination->getPageSize() && isset($_GET['per-page'])) {
            $this->pagination->pageSize = isset(Yii::$app->request->queryParams['per-page']) ? Yii::$app->request->queryParams['per-page'] : $this->pagination->pageSize;
        }
        return parent::prepareModels();
    }
}
