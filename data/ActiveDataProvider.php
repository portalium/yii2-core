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
        if(!Yii::$app->request->get('per-page') && isset($this->pagination->pageSize)  && $this->pagination != false && $this->pagination->pageSize == 20) {
            $sessionPageSize = Yii::$app->session->get('pageSize');
            $this->pagination->pageSize = !$sessionPageSize ? Yii::$app->setting->getValue('theme::page_size') : $sessionPageSize;
        }
        if ($this->pagination != false && $this->pagination->getPageSize() && isset($_GET['per-page'])) {
            $this->pagination->pageSize = isset(Yii::$app->request->queryParams['per-page']) ? Yii::$app->request->queryParams['per-page'] : $this->pagination->pageSize;
            Yii::$app->session->set('pageSize', $this->pagination->pageSize);
        }
        return parent::prepareModels();
    }
}
